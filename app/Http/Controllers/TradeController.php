<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\TradeSession;
use App\Models\UserNotification;
use App\Models\YieldDistribution;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TradeController extends Controller
{
    /**
     * Start a 30-minute balance-freezing trade session.
     */
    public function execute(Request $request): RedirectResponse
    {
        $user = $request->user();

        // 1. Auto-settle any pending completed trades first
        $this->autoSettleIfCompleted($user);

        // 2. Eligibility checks
        $hasActivePackage = $user->active_package_id !== null || $user->deposits()->where('status', 'approved')->exists();
        if (! $hasActivePackage) {
            return back()->with('error', 'Active Package Required: You must have an active investment package to initiate a trade session.');
        }

        if ((float) $user->balance <= 0) {
            return back()->with('error', 'Insufficient Balance: You need a positive active balance to execute a trade.');
        }

        if ($user->isTradeRunning()) {
            $mins = ceil(now()->diffInSeconds($user->trade_active_until) / 60);
            return back()->with('error', "Trade In Progress: Your balance is currently frozen for another {$mins} minute(s).");
        }

        if ($user->next_trade_available_at !== null && now()->lessThan($user->next_trade_available_at)) {
            $hoursLeft = ceil(now()->diffInSeconds($user->next_trade_available_at) / 3600);
            return back()->with('error', "24h Trade Cooling: Your next trade window unlocks in {$hoursLeft} hour(s).");
        }

        // 3. Determine user's active tier package & trade rate
        $tierInfo = $user->getEffectiveTier();
        $package = $tierInfo['package'] ?? $user->activePackage ?? Package::first();
        $rate = $package ? $package->generateRandomTradeRate() : 2.00;

        $frozenAmount = (float) $user->balance;

        // 4. Freeze balance for 30 minutes
        $completesAt = now()->addMinutes(30);
        $user->frozen_balance = $frozenAmount;
        $user->trade_active_until = $completesAt;
        $user->save();

        TradeSession::create([
            'user_id' => $user->id,
            'package_id' => $package?->id,
            'amount' => $frozenAmount,
            'rate_percent' => $rate,
            'profit_earned' => 0.00,
            'started_at' => now(),
            'completes_at' => $completesAt,
            'status' => 'running',
        ]);

        UserNotification::create([
            'user_id' => $user->id,
            'title' => "🚀 Trade Executed: \${$frozenAmount} USD Frozen",
            'type' => 'announcement',
            'body' => "<p>Your trade has been executed! Your balance of <strong>\${$frozenAmount} USD</strong> is frozen for <strong>30 minutes</strong> in live algorithmic arbitrage. Estimated return: <strong>+{$rate}%</strong>.</p>",
            'is_read' => false,
        ]);

        return back()->with('status', "30-Minute Trade session initiated! Your balance of \${$frozenAmount} is frozen for 30 minutes. Expected yield: +{$rate}%.");
    }

    /**
     * Claim / manually settle completed trade.
     */
    public function settle(Request $request): RedirectResponse
    {
        $user = $request->user();
        $settled = $this->autoSettleIfCompleted($user);

        if ($settled) {
            return back()->with('status', "Trade settled successfully! Yield compounded directly to your balance.");
        }

        if ($user->isTradeRunning()) {
            $mins = ceil(now()->diffInSeconds($user->trade_active_until) / 60);
            return back()->with('error', "Trade is still running. Please wait {$mins} minute(s) for the 30-minute cycle to conclude.");
        }

        return back()->with('info', "No active trade session ready for settlement.");
    }

    /**
     * Auto-settle trade if 30 minutes have elapsed.
     */
    public function autoSettleIfCompleted($user): bool
    {
        $runningTrade = TradeSession::where('user_id', $user->id)
            ->where('status', 'running')
            ->latest()
            ->first();

        if (! $runningTrade) {
            if ($user->frozen_balance > 0 && ! $user->isTradeRunning()) {
                $user->frozen_balance = 0.00;
                $user->trade_active_until = null;
                $user->save();
            }
            return false;
        }

        // Check if 30 minutes have passed
        if (now()->greaterThanOrEqualTo($runningTrade->completes_at)) {
            $profit = round(((float) $runningTrade->amount * (float) $runningTrade->rate_percent) / 100, 2);

            $runningTrade->update([
                'profit_earned' => $profit,
                'settled_at' => now(),
                'status' => 'settled',
            ]);

            // Unfreeze balance and credit profit
            $user->frozen_balance = 0.00;
            $user->trade_active_until = null;
            $user->next_trade_available_at = now()->addHours(24);
            $user->balance = round((float) $user->balance + $profit, 2);
            $user->save();

            // Record in yield distribution history for reporting
            YieldDistribution::create([
                'user_id' => $user->id,
                'starting_balance' => (float) $runningTrade->amount,
                'rate_percent' => (float) $runningTrade->rate_percent,
                'profit_earned' => $profit,
                'new_balance' => (float) $user->balance,
            ]);

            UserNotification::create([
                'user_id' => $user->id,
                'title' => "🎉 Trade Session Settled: +\${$profit} USD",
                'type' => 'bonus',
                'body' => "<p>Your 30-minute trade session has completed! Yield of <strong>+{$runningTrade->rate_percent}%</strong> (<strong>+\${$profit} USD</strong>) has been credited to your active compounding balance.</p>",
                'is_read' => false,
            ]);

            return true;
        }

        return false;
    }
}
