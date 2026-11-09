<?php

namespace App\Http\Controllers;

use App\Models\UserNotification;
use App\Models\WithdrawalRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WalletController extends Controller
{
    /**
     * Display wallet & cashout view.
     */
    public function index(): View
    {
        $user = auth()->user();
        $withdrawals = $user->withdrawals()->latest()->get();
        $withdrawalFeePercent = (float) \App\Models\Setting::get('withdrawal_fee_percent', 0.00);

        return view('wallet.index', compact('user', 'withdrawals', 'withdrawalFeePercent'));
    }

    /**
     * Submit a cashout request.
     * Enforces the 30-day lock policy and $10 minimum threshold.
     */
    public function requestCashout(Request $request): RedirectResponse
    {
        $user = $request->user();

        // 1. Check withdrawable balance taking into account 30-day principal lock
        $maxWithdrawable = $user->getWithdrawableBalance();

        if ($maxWithdrawable < 10) {
            if ($user->isCapitalLocked()) {
                $daysLeft = $user->daysRemainingLocked();
                $unlockDate = $user->locked_until->format('M d, Y');
                return back()->with('error', "Capital Lock Policy: Your base deposit of \${$user->locked_principal} is locked for 30 days until {$unlockDate} ({$daysLeft} day(s) remaining). Accrued daily profits above the base deposit can be withdrawn anytime once they reach \$10.00 (Current withdrawable profit: \${$maxWithdrawable} USD).");
            }

            return back()->with('error', 'The minimum cashout limit is $10.00 USD. Your current available balance is $' . number_format($maxWithdrawable, 2) . ' USD.');
        }

        // 2. Validate request
        $validated = $request->validate([
            'amount' => ['required', 'numeric', 'min:10', 'max:' . $maxWithdrawable],
            'payout_method' => ['required', 'string', 'in:Binance Pay ID,Binance USDT (BEP-20)'],
            'destination_account' => ['required', 'string', 'max:255'],
        ], [
            'amount.min' => 'The minimum cashout limit is $10.00 USD.',
            'amount.max' => "Maximum withdrawable amount available right now is \${$maxWithdrawable} USD.",
        ]);

        $amount = (float) $validated['amount'];

        // Compute commission fee & net payout amount
        $feePercent = (float) \App\Models\Setting::get('withdrawal_fee_percent', 0.00);
        $feeAmount = round(($amount * $feePercent) / 100, 2);
        $netAmount = round($amount - $feeAmount, 2);

        // Deduct full amount from balance while pending approval
        $user->balance = round((float) $user->balance - $amount, 2);

        // If capital lock period has expired, reduce locked_principal accordingly
        if (! $user->isCapitalLocked() && (float) $user->locked_principal > 0) {
            $user->locked_principal = max(0, round((float) $user->locked_principal - $amount, 2));
        }

        $user->save();

        $withdrawal = WithdrawalRequest::create([
            'user_id' => $user->id,
            'amount' => $amount,
            'fee_percent' => $feePercent,
            'fee_amount' => $feeAmount,
            'net_amount' => $netAmount,
            'payout_method' => $validated['payout_method'],
            'destination_account' => $validated['destination_account'],
            'status' => 'pending',
        ]);

        $feeNotice = $feePercent > 0 ? " (Processing Fee: \${$feeAmount} [{$feePercent}%], Net Payout: \${$netAmount} USD)" : "";

        UserNotification::create([
            'user_id' => $user->id,
            'title' => "Cashout Request Submitted (\${$amount} USD)",
            'type' => 'announcement',
            'body' => "<p>Your cashout request of <strong>\${$amount} USD</strong>{$feeNotice} via {$validated['payout_method']} to <code>{$validated['destination_account']}</code> has been submitted to the operator queue. Verification and transfer will process shortly.</p>",
            'is_read' => false,
        ]);

        return back()->with('status', "Cashout request for \${$amount} USD submitted successfully!{$feeNotice} Operator settlement in progress.");
    }
}
