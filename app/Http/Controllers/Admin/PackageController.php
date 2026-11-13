<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PackageController extends Controller
{
    /**
     * Display the package management page.
     */
    public function index(): View
    {
        $packages = Package::latest()->get();
        return view('admin.packages.index', compact('packages'));
    }

    /**
     * Store a newly created package.
     */
    public function store(Request $request): RedirectResponse
    {
        if (!$request->has('investment_amount') && $request->filled('min_investment')) {
            $request->merge(['investment_amount' => $request->input('min_investment')]);
        }
        if (!$request->has('daily_commission_percent') && $request->filled('min_daily_profit_percent')) {
            $request->merge(['daily_commission_percent' => $request->input('min_daily_profit_percent')]);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'investment_amount' => ['required', 'numeric', 'min:1'],
            'min_investment' => ['nullable', 'numeric', 'min:1'],
            'max_investment' => ['nullable', 'numeric', 'min:1'],
            'daily_commission_percent' => ['required', 'numeric', 'min:0.01', 'max:100'],
            'min_daily_profit_percent' => ['nullable', 'numeric', 'min:0.01', 'max:100'],
            'max_daily_profit_percent' => ['nullable', 'numeric', 'min:0.01', 'max:100'],
            'referral_commission_percent' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'min_trade_profit_percent' => ['nullable', 'numeric', 'min:0.01', 'max:100'],
            'max_trade_profit_percent' => ['nullable', 'numeric', 'min:0.01', 'max:100'],
            'min_withdrawal_limit' => ['required', 'numeric', 'min:1'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $validated['min_investment'] = $request->filled('min_investment') ? (float) $request->input('min_investment') : (float) $validated['investment_amount'];
        $validated['max_investment'] = $request->filled('max_investment') ? (float) $request->input('max_investment') : (float) ($validated['min_investment'] * 2);
        $validated['min_daily_profit_percent'] = $request->filled('min_daily_profit_percent') ? (float) $request->input('min_daily_profit_percent') : (float) $validated['daily_commission_percent'];
        $validated['max_daily_profit_percent'] = $request->filled('max_daily_profit_percent') ? (float) $request->input('max_daily_profit_percent') : (float) $validated['daily_commission_percent'];
        $validated['referral_commission_percent'] = $request->filled('referral_commission_percent') ? (float) $request->input('referral_commission_percent') : 5.00;
        $validated['min_trade_profit_percent'] = $request->filled('min_trade_profit_percent') ? (float) $request->input('min_trade_profit_percent') : (float) $validated['min_daily_profit_percent'];
        $validated['max_trade_profit_percent'] = $request->filled('max_trade_profit_percent') ? (float) $request->input('max_trade_profit_percent') : (float) $validated['max_daily_profit_percent'];
        $validated['is_active'] = $request->boolean('is_active', true);

        $package = Package::create($validated);

        return redirect()->route('admin.packages.index')->with('status', "Package '{$package->name}' created successfully.");
    }

    /**
     * Update an existing package.
     */
    public function update(Request $request, Package $package): RedirectResponse
    {
        if (!$request->has('investment_amount') && $request->filled('min_investment')) {
            $request->merge(['investment_amount' => $request->input('min_investment')]);
        }
        if (!$request->has('daily_commission_percent') && $request->filled('min_daily_profit_percent')) {
            $request->merge(['daily_commission_percent' => $request->input('min_daily_profit_percent')]);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'investment_amount' => ['required', 'numeric', 'min:1'],
            'min_investment' => ['nullable', 'numeric', 'min:1'],
            'max_investment' => ['nullable', 'numeric', 'min:1'],
            'daily_commission_percent' => ['required', 'numeric', 'min:0.01', 'max:100'],
            'min_daily_profit_percent' => ['nullable', 'numeric', 'min:0.01', 'max:100'],
            'max_daily_profit_percent' => ['nullable', 'numeric', 'min:0.01', 'max:100'],
            'referral_commission_percent' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'min_trade_profit_percent' => ['nullable', 'numeric', 'min:0.01', 'max:100'],
            'max_trade_profit_percent' => ['nullable', 'numeric', 'min:0.01', 'max:100'],
            'min_withdrawal_limit' => ['required', 'numeric', 'min:1'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $validated['min_investment'] = $request->filled('min_investment') ? (float) $request->input('min_investment') : (float) $validated['investment_amount'];
        $validated['max_investment'] = $request->filled('max_investment') ? (float) $request->input('max_investment') : (float) ($validated['min_investment'] * 2);
        $validated['min_daily_profit_percent'] = $request->filled('min_daily_profit_percent') ? (float) $request->input('min_daily_profit_percent') : (float) $validated['daily_commission_percent'];
        $validated['max_daily_profit_percent'] = $request->filled('max_daily_profit_percent') ? (float) $request->input('max_daily_profit_percent') : (float) $validated['daily_commission_percent'];
        $validated['referral_commission_percent'] = $request->filled('referral_commission_percent') ? (float) $request->input('referral_commission_percent') : (float) ($package->referral_commission_percent ?? 5.00);
        $validated['min_trade_profit_percent'] = $request->filled('min_trade_profit_percent') ? (float) $request->input('min_trade_profit_percent') : (float) ($package->min_trade_profit_percent ?? $validated['min_daily_profit_percent']);
        $validated['max_trade_profit_percent'] = $request->filled('max_trade_profit_percent') ? (float) $request->input('max_trade_profit_percent') : (float) ($package->max_trade_profit_percent ?? $validated['max_daily_profit_percent']);
        $validated['is_active'] = $request->boolean('is_active', true);

        $package->update($validated);

        return redirect()->route('admin.packages.index')->with('status', "Package '{$package->name}' updated successfully.");
    }

    /**
     * Remove the specified package.
     */
    public function destroy(Package $package): RedirectResponse
    {
        $name = $package->name;
        $package->delete();

        return redirect()->route('admin.packages.index')->with('status', "Package '{$name}' deleted successfully.");
    }
}
