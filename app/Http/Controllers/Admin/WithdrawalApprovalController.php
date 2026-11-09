<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserNotification;
use App\Models\WithdrawalRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class WithdrawalApprovalController extends Controller
{
    /**
     * Approve and settle a withdrawal request.
     */
    public function approve(WithdrawalRequest $withdrawal): RedirectResponse
    {
        if (! $withdrawal->isPending()) {
            return back()->with('error', 'This withdrawal request has already been processed.');
        }

        $withdrawal->update([
            'status' => 'approved',
            'approved_at' => now(),
        ]);

        $user = $withdrawal->user;
        $user->withdrawn_total = round((float) $user->withdrawn_total + (float) $withdrawal->amount, 2);
        $user->save();

        // Notify user
        $payoutAmount = $withdrawal->net_amount > 0 ? $withdrawal->net_amount : $withdrawal->amount;
        $feeNotice = $withdrawal->fee_amount > 0 ? " (Net payout: \${$payoutAmount} after \${$withdrawal->fee_amount} fee)" : "";

        UserNotification::create([
            'user_id' => $user->id,
            'title' => "Cashout Paid (\${$payoutAmount} USD)",
            'type' => 'bonus',
            'body' => "<p>Your withdrawal of <strong>\${$withdrawal->amount} USD</strong>{$feeNotice} has been approved and transferred via {$withdrawal->payout_method} to <code>{$withdrawal->destination_account}</code>. Thank you for investing with Verdant.</p>",
            'is_read' => false,
        ]);

        return back()->with('status', "Cashout #{$withdrawal->id} for {$user->name} (\${$withdrawal->amount}) APPROVED and paid.");
    }

    /**
     * Reject a withdrawal request and refund user balance.
     */
    public function reject(Request $request, WithdrawalRequest $withdrawal): RedirectResponse
    {
        if (! $withdrawal->isPending()) {
            return back()->with('error', 'This withdrawal request has already been processed.');
        }

        $withdrawal->update([
            'status' => 'rejected',
            'rejected_at' => now(),
        ]);

        // Refund held balance back to user
        $user = $withdrawal->user;
        $user->balance = round((float) $user->balance + (float) $withdrawal->amount, 2);
        $user->save();

        UserNotification::create([
            'user_id' => $user->id,
            'title' => "Cashout Rejected (\${$withdrawal->amount} USD Refunded)",
            'type' => 'alert',
            'body' => "<p>Your cashout request of \${$withdrawal->amount} USD could not be processed. The full amount has been refunded back to your active compounding balance.</p>",
            'is_read' => false,
        ]);

        return back()->with('status', "Cashout #{$withdrawal->id} was REJECTED and \${$withdrawal->amount} refunded to {$user->name}.");
    }
}
