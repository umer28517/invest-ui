<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    /**
     * Display the settings and configuration page with tabs.
     */
    public function index(): View
    {
        $depositFee = Setting::get('deposit_fee_percent', '2.00');
        $withdrawalFee = Setting::get('withdrawal_fee_percent', '2.00');
        $binanceApiKey = Setting::get('binance_api_key', '');
        $binanceApiSecret = Setting::get('binance_api_secret', '');
        $binanceEnvironment = Setting::get('binance_environment', 'sandbox');

        return view('admin.profile.index', compact(
            'depositFee',
            'withdrawalFee',
            'binanceApiKey',
            'binanceApiSecret',
            'binanceEnvironment'
        ));
    }

    /**
     * Update platform commission percentages and credentials.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'deposit_fee_percent' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'withdrawal_fee_percent' => ['required', 'numeric', 'min:0', 'max:100'],
            'referral_commission_percent' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'binance_api_key' => ['nullable', 'string', 'max:255'],
            'binance_api_secret' => ['nullable', 'string', 'max:255'],
            'binance_environment' => ['nullable', 'string', 'in:sandbox,live'],
        ]);

        if ($request->filled('deposit_fee_percent')) {
            Setting::set('deposit_fee_percent', number_format((float) $validated['deposit_fee_percent'], 2, '.', ''));
        }
        if ($request->filled('referral_commission_percent')) {
            Setting::set('referral_commission_percent', number_format((float) $validated['referral_commission_percent'], 2, '.', ''));
        }
        Setting::set('withdrawal_fee_percent', number_format((float) $validated['withdrawal_fee_percent'], 2, '.', ''));
        Setting::set('binance_api_key', $validated['binance_api_key'] ?? '');
        Setting::set('binance_api_secret', $validated['binance_api_secret'] ?? '');
        Setting::set('binance_environment', $validated['binance_environment'] ?? 'sandbox');

        return back()->with('status', 'Platform transaction fee percentages and API credentials updated successfully!');
    }
}
