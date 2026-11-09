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
        $referralCommission = Setting::get('referral_commission_percent', '5.00');
        $withdrawalFee = Setting::get('withdrawal_fee_percent', '2.00');
        $binanceApiKey = Setting::get('binance_api_key', '');
        $binanceApiSecret = Setting::get('binance_api_secret', '');
        $binanceEnvironment = Setting::get('binance_environment', 'sandbox');

        return view('admin.profile.index', compact(
            'referralCommission',
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
            'referral_commission_percent' => ['required', 'numeric', 'min:0', 'max:100'],
            'withdrawal_fee_percent' => ['required', 'numeric', 'min:0', 'max:100'],
            'binance_api_key' => ['nullable', 'string', 'max:255'],
            'binance_api_secret' => ['nullable', 'string', 'max:255'],
            'binance_environment' => ['nullable', 'string', 'in:sandbox,live'],
        ]);

        Setting::set('referral_commission_percent', number_format((float) $validated['referral_commission_percent'], 2, '.', ''));
        Setting::set('withdrawal_fee_percent', number_format((float) $validated['withdrawal_fee_percent'], 2, '.', ''));
        Setting::set('binance_api_key', $validated['binance_api_key'] ?? '');
        Setting::set('binance_api_secret', $validated['binance_api_secret'] ?? '');
        Setting::set('binance_environment', $validated['binance_environment'] ?? 'sandbox');

        return back()->with('status', 'Platform commission percentages and API credentials updated successfully!');
    }
}
