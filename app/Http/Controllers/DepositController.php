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

        $deposit = DepositRequest::create([
            'user_id' => $user->id,
            'package_id' => $package->id,
            'amount' => $validated['amount'],
            'daily_rate' => $package->daily_commission_percent,
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
