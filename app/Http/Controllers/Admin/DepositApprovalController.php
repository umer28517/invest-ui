<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DepositRequest;
use App\Models\UserNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DepositApprovalController extends Controller
{
    /**
     * Display a listing of deposit requests with status filters.
     */
    public function index(Request $request)
    {
        $status = $request->query('status', 'all');

        $query = DepositRequest::with(['user', 'package'])->latest();
        if ($status !== 'all') {
            $query->where('status', $status);
        }
        $deposits = $query->paginate(15)->withQueryString();

        $pendingCount = DepositRequest::where('status', 'pending')->count();
        $approvedCount = DepositRequest::where('status', 'approved')->count();
        $rejectedCount = DepositRequest::where('status', 'rejected')->count();
        $totalApprovedVolume = DepositRequest::where('status', 'approved')->sum('amount');

        return view('admin.deposits.index', compact(
            'deposits',
            'status',
            'pendingCount',
            'approvedCount',
            'rejectedCount',
            'totalApprovedVolume'
        ));
    }

    /**
     * Approve a pending deposit request and activate user package + compounding balance.
     */
    public function approve(DepositRequest $deposit): RedirectResponse
    {
        if (! $deposit->isPending()) {
            return back()->with('error', 'This deposit request has already been processed.');
        }

        $deposit->update([
            'status' => 'approved',
            'approved_at' => now(),
        ]);

        $user = $deposit->user;

        // Apply Deposit Fee (default 0.00 in tests, 2.00% when configured)
        $depositFeePercent = (float) \App\Models\Setting::get('deposit_fee_percent', 0.00);
        $depositFee = round(((float) $deposit->amount * $depositFeePercent) / 100, 2);
        $netDeposit = round((float) $deposit->amount - $depositFee, 2);

        // Add deposit to user's compounding balance
        $user->balance = round((float) $user->balance + $netDeposit, 2);
        
        // Track locked base principal and set 45-day lock window
        $user->locked_principal = round((float) $user->locked_principal + $netDeposit, 2);
        $user->locked_until = now()->addDays(45);

        // Ensure user retains their highest tier percentage and never gets downgraded
        if ((float) $deposit->daily_rate >= (float) $user->active_daily_rate) {
            $user->active_daily_rate = $deposit->daily_rate;
            $user->active_package_id = $deposit->package_id;
        }

        $user->save();

        // Notify investor of approval and 45-day lock
        $unlockDate = $user->locked_until->format('M d, Y');
        $feeText = $depositFee > 0 ? " (Deposit Fee: \${$depositFee} [{$depositFeePercent}%], Net Credited: \${$netDeposit} USD)" : "";
        UserNotification::create([
            'user_id' => $user->id,
            'title' => "🎉 Package Activated: {$deposit->package->name} (+{$deposit->daily_rate}%/day)",
            'type' => 'bonus',
            'body' => "<p>Your payment of <strong>\${$deposit->amount} USD</strong>{$feeText} has been approved! Your <strong>{$deposit->package->name}</strong> plan is now active with <strong>+{$deposit->daily_rate}% daily compounding</strong> on your total balance.</p><p class='mt-1 text-xs text-amber-300'>Note: Base deposit of \${$netDeposit} is locked for 45 days until <strong>{$unlockDate}</strong>. All accrued daily profits above base deposit can be withdrawn anytime (\$10 min)!</p>",
            'is_read' => false,
        ]);

        // 1-Time Referral Commission Bonus on Investment / Deposit
        $referralCommissionPercent = (float) ($deposit->package->referral_commission_percent ?? \App\Models\Setting::get('referral_commission_percent', 5.00));
        if ($referralCommissionPercent > 0 && ! empty($user->referred_by)) {
            $referrer = \App\Models\User::where('referral_code', $user->referred_by)
                ->where('is_active', true)
                ->first();

            if ($referrer) {
                $refBonus = round(((float) $deposit->amount * $referralCommissionPercent) / 100, 2);
                if ($refBonus > 0) {
                    $referrer->balance = round((float) $referrer->balance + $refBonus, 2);
                    $referrer->save();

                    UserNotification::create([
                        'user_id' => $referrer->id,
                        'title' => "Referral Deposit Commission: +\${$refBonus} USD",
                        'type' => 'bonus',
                        'body' => "<p>You earned an instant <strong>+\${$refBonus} USD</strong> ({$referralCommissionPercent}%) referral commission from <strong>{$user->name}</strong>'s \${$deposit->amount} USD package investment!</p>",
                        'is_read' => false,
                    ]);
                }
            }
        }

        return back()->with('status', "Deposit #{$deposit->id} for {$user->name} (\${$deposit->amount}) APPROVED successfully! Package activated with 30-day lock.");
    }

    /**
     * Reject a deposit request.
     */
    public function reject(Request $request, DepositRequest $deposit): RedirectResponse
    {
        if (! $deposit->isPending()) {
            return back()->with('error', 'This deposit request has already been processed.');
        }

        $reason = $request->input('reason', 'Payment could not be verified on Binance.');

        $deposit->update([
            'status' => 'rejected',
            'rejection_reason' => $reason,
            'rejected_at' => now(),
        ]);

        // Notify user of rejection
        UserNotification::create([
            'user_id' => $deposit->user_id,
            'title' => "Deposit Request Rejected (\${$deposit->amount})",
            'type' => 'alert',
            'body' => "<p>Your deposit of \${$deposit->amount} USD could not be confirmed. Reason: {$reason}. Please contact administrative support if you have already transferred funds.</p>",
            'is_read' => false,
        ]);

        return back()->with('status', "Deposit #{$deposit->id} has been marked as REJECTED.");
    }
}
