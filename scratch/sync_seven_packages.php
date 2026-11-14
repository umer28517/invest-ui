<?php

require 'C:/ui/vendor/autoload.php';
$app = require_once 'C:/ui/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Package;
use App\Models\Setting;

// Clear old packages
Package::truncate();

$packages = [
    [
        'name' => 'Level 1',
        'investment_amount' => 200.00,
        'min_investment' => 200.00,
        'max_investment' => 499.00,
        'daily_commission_percent' => 1.75,
        'min_daily_profit_percent' => 1.75,
        'max_daily_profit_percent' => 2.00,
        'min_trade_profit_percent' => 1.75,
        'max_trade_profit_percent' => 2.00,
        'referral_commission_percent' => 3.00,
        'min_withdrawal_limit' => 10.00,
        'description' => 'Level 1: $200 – $499 range with 1.75% – 2.00% daily returns.',
        'is_active' => true,
    ],
    [
        'name' => 'Level 2',
        'investment_amount' => 500.00,
        'min_investment' => 500.00,
        'max_investment' => 999.00,
        'daily_commission_percent' => 2.00,
        'min_daily_profit_percent' => 2.00,
        'max_daily_profit_percent' => 2.25,
        'min_trade_profit_percent' => 2.00,
        'max_trade_profit_percent' => 2.25,
        'referral_commission_percent' => 5.00,
        'min_withdrawal_limit' => 10.00,
        'description' => 'Level 2: $500 – $999 range with 2.00% – 2.25% daily returns.',
        'is_active' => true,
    ],
    [
        'name' => 'Level 3',
        'investment_amount' => 1000.00,
        'min_investment' => 1000.00,
        'max_investment' => 1999.00,
        'daily_commission_percent' => 2.25,
        'min_daily_profit_percent' => 2.25,
        'max_daily_profit_percent' => 2.50,
        'min_trade_profit_percent' => 2.25,
        'max_trade_profit_percent' => 2.50,
        'referral_commission_percent' => 7.00,
        'min_withdrawal_limit' => 10.00,
        'description' => 'Level 3: $1,000 – $1,999 range with 2.25% – 2.50% daily returns.',
        'is_active' => true,
    ],
    [
        'name' => 'Level 4',
        'investment_amount' => 2000.00,
        'min_investment' => 2000.00,
        'max_investment' => 2999.00,
        'daily_commission_percent' => 2.50,
        'min_daily_profit_percent' => 2.50,
        'max_daily_profit_percent' => 3.00,
        'min_trade_profit_percent' => 2.50,
        'max_trade_profit_percent' => 3.00,
        'referral_commission_percent' => 9.00,
        'min_withdrawal_limit' => 10.00,
        'description' => 'Level 4: $2,000 – $2,999 range with 2.50% – 3.00% daily returns.',
        'is_active' => true,
    ],
    [
        'name' => 'Level 5',
        'investment_amount' => 3000.00,
        'min_investment' => 3000.00,
        'max_investment' => 4999.00,
        'daily_commission_percent' => 3.00,
        'min_daily_profit_percent' => 3.00,
        'max_daily_profit_percent' => 3.75,
        'min_trade_profit_percent' => 3.00,
        'max_trade_profit_percent' => 3.75,
        'referral_commission_percent' => 11.00,
        'min_withdrawal_limit' => 10.00,
        'description' => 'Level 5: $3,000 – $4,999 range with 3.00% – 3.75% daily returns.',
        'is_active' => true,
    ],
    [
        'name' => 'Level 6',
        'investment_amount' => 5000.00,
        'min_investment' => 5000.00,
        'max_investment' => 9999.00,
        'daily_commission_percent' => 3.75,
        'min_daily_profit_percent' => 3.75,
        'max_daily_profit_percent' => 4.75,
        'min_trade_profit_percent' => 3.75,
        'max_trade_profit_percent' => 4.75,
        'referral_commission_percent' => 14.00,
        'min_withdrawal_limit' => 10.00,
        'description' => 'Level 6: $5,000 – $9,999 range with 3.75% – 4.75% daily returns.',
        'is_active' => true,
    ],
    [
        'name' => 'Level 7',
        'investment_amount' => 10000.00,
        'min_investment' => 10000.00,
        'max_investment' => 20000.00,
        'daily_commission_percent' => 4.75,
        'min_daily_profit_percent' => 4.75,
        'max_daily_profit_percent' => 6.00,
        'min_trade_profit_percent' => 4.75,
        'max_trade_profit_percent' => 6.00,
        'referral_commission_percent' => 18.00,
        'min_withdrawal_limit' => 10.00,
        'description' => 'Level 7: $10,000 – $20,000 range with 4.75% – 6.00% daily returns.',
        'is_active' => true,
    ],
];

foreach ($packages as $pkg) {
    Package::create($pkg);
}

Setting::set('withdrawal_fee_percent', '2.00');
Setting::set('deposit_fee_percent', '2.00');
Setting::where('key', 'referral_commission_percent')->delete();

echo "Successfully seeded 7 packages and set 2% deposit/withdrawal fees.\n";
