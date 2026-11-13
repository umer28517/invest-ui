<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserNotification;
use App\Models\YieldDistribution;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DailyRoiController extends Controller
{
    /**
     * Trigger 24h compounding ROI distribution across all active investors.
     * Computes daily rate on total available balance and adds profit directly to balance.
     */
    public function trigger(Request $request): RedirectResponse
    {
        // Find all active investors with a positive balance and active yield rate
        $eligibleUsers = User::where('role', 'user')
            ->where('is_active', true)
            ->where('balance', '>', 0)
            ->where('active_daily_rate', '>', 0)
            ->get();

        if ($eligibleUsers->isEmpty()) {
            return back()->with('error', 'No active investors with a funded compounding balance found.');
        }

        $totalDistributed = 0;
        $accountsProcessed = 0;

        foreach ($eligibleUsers as $user) {
            $startingBalance = (float) $user->balance;
            
            // Dynamic Effective Rate: Automatically upgrades if balance meets a higher tier threshold
            // and generates a random daily rate within that package's profit range (e.g. 2.0% - 3.0%)
            $effectivePkg = $user->effective_package ?? $user->activePackage;
            if ($effectivePkg && method_exists($effectivePkg, 'generateRandomDailyRate')) {
                $rate = $effectivePkg->generateRandomDailyRate();
            } else {
                $rate = (float) $user->effective_daily_rate;
            }

            if ($rate <= 0) {
                continue;
            }

            // Continuous Compounding formula: Profit = Balance * Rate%
            $profit = round($startingBalance * ($rate / 100), 2);

            if ($profit <= 0) {
                continue;
            }

            // New balance becomes the compounded base for the next day!
            $newBalance = round($startingBalance + $profit, 2);

            $user->balance = $newBalance;
            $user->save();

            // Record in yield log
            YieldDistribution::create([
                'user_id' => $user->id,
                'starting_balance' => $startingBalance,
                'rate_percent' => $rate,
                'profit_earned' => $profit,
                'new_balance' => $newBalance,
            ]);

            // Notify investor of daily compounded dividend
            UserNotification::create([
                'user_id' => $user->id,
                'title' => "Daily Compound Yield Credited: +\${$profit} USD",
                'type' => 'bonus',
                'body' => "<p>Your 24-hour yield of <strong>+{$rate}%</strong> on your active balance of \${$startingBalance} has been compounded! <strong>+\${$profit} USD</strong> was added. Your new compounding balance is <strong>\${$newBalance} USD</strong>.</p>",
                'is_read' => false,
            ]);

            $totalDistributed += $profit;
            $accountsProcessed++;
        }

        $totalFormatted = number_format($totalDistributed, 2);
        return back()->with('status', "24-Hour Yield Distribution Complete! Compounded +\${$totalFormatted} USD across {$accountsProcessed} active investor account(s).");
    }
}
