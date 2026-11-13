<?php

namespace App\Http\Controllers;

use App\Models\DepositRequest;
use App\Models\Package;
use App\Models\UserNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DepositController extends Controller
{
    /**
     * Submit a new deposit request after paying via Binance.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'package_id' => ['required', 'exists:packages,id'],
            'amount' => ['required', 'numeric', 'min:1'],
            'payment_method' => ['nullable', 'string', 'max:100'],
            'binance_pay_id' => ['nullable', 'string', 'max:100'],
            'transaction_proof' => ['nullable', 'string', 'max:255'],
        ]);

        $package = Package::findOrFail($validated['package_id']);
        $user = $request->user();
        $amount = (float) $validated['amount'];
        $min = (float) $package->effective_min_investment;
        $max = (float) $package->effective_max_investment;

        // Verify deposit amount is within package price range
        if ($amount < $min || ($max > $min && $amount > $max)) {
            $rangeMsg = "The investment amount for {$package->name} must be within the allowed range of \${$min} to \${$max} USD (you specified \${$amount} USD).";
            return back()->withErrors(['amount' => $rangeMsg])->with('error', $rangeMsg);
        }

        // Single Package Policy: Each user can only activate one package at a time
        if ($user->active_package_id !== null || $user->deposits()->whereIn('status', ['pending', 'approved'])->exists()) {
            return back()->with('error', 'Single Package Policy: You already have an active package investment or pending deposit. Each user can only activate one package at a time.');
        }

        $deposit = DepositRequest::create([
            'user_id' => $user->id,
            'package_id' => $package->id,
            'amount' => $amount,
            'daily_rate' => $package->effective_min_daily_profit,
            'payment_method' => $validated['payment_method'] ?? 'Binance Pay',
            'binance_pay_id' => $validated['binance_pay_id'] ?? null,
            'transaction_proof' => $validated['transaction_proof'] ?? null,
            'status' => 'pending',
        ]);

        // Send confirmation notification to investor
        UserNotification::create([
            'user_id' => $user->id,
            'title' => "Deposit Request Submitted (\${$deposit->amount})",
            'type' => 'announcement',
            'body' => "<p>Your deposit of <strong>\${$deposit->amount} USD</strong> for the <strong>{$package->name}</strong> (+{$package->daily_commission_percent}%/day) package has been received and is pending operator approval. Daily compounding begins immediately upon approval.</p>",
            'is_read' => false,
        ]);

        return redirect()->route('dashboard')->with('status', "Deposit request for {$package->name} (\${$deposit->amount} USD) submitted successfully! Awaiting admin verification.");
    }
}
