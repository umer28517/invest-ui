<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin Account
        User::create([
            'name' => 'System Administrator',
            'email' => 'admin@verdant.com',
            'phone' => '+1 555 019 2831',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
            'referral_code' => 'ADMIN_ROOT',
        ]);

        // Default Investor Account
        User::create([
            'name' => 'Elena Morales',
            'email' => 'user@verdant.com',
            'phone' => '+1 555 782 9102',
            'password' => bcrypt('password'),
            'role' => 'user',
            'referral_code' => 'ELENA_INVEST',
            'referred_by' => 'ADMIN_ROOT',
        ]);

        User::create([
            'name' => 'Marcus Vance',
            'email' => 'marcus.v@example.com',
            'phone' => '+1 415 555 2671',
            'password' => bcrypt('password'),
            'role' => 'user',
            'referral_code' => 'MARCUS_V7',
            'referred_by' => 'ELENA_INVEST',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Aisha Al-Mansoor',
            'email' => 'aisha.m@example.ae',
            'phone' => '+971 50 123 4567',
            'password' => bcrypt('password'),
            'role' => 'user',
            'referral_code' => 'AISHA_DUBAI',
            'referred_by' => 'ELENA_INVEST',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Julian Thorne (Suspended)',
            'email' => 'julian.t@example.com',
            'phone' => '+44 7911 123456',
            'password' => bcrypt('password'),
            'role' => 'user',
            'referral_code' => 'JULIAN_UK',
            'referred_by' => 'ADMIN_ROOT',
            'is_active' => false,
        ]);

        // Default 7 Investment Packages
        $packages = [
            [
                'name' => 'Level 1',
                'investment_amount' => 200.00,
                'min_investment' => 200.00,
                'max_investment' => 499.00,
                'daily_commission_percent' => 1.75,
                'min_daily_profit_percent' => 1.75,
                'max_daily_profit_percent' => 2.00,
                'referral_commission_percent' => 3.00,
                'min_withdrawal_limit' => 10.00,
                'description' => 'Entry tier with $200 – $499 flexible deposit and 1.75% – 2.00% daily returns.',
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
                'referral_commission_percent' => 5.00,
                'min_withdrawal_limit' => 10.00,
                'description' => 'Growth tier with $500 – $999 deposit range and 2.00% – 2.25% daily returns.',
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
                'referral_commission_percent' => 7.00,
                'min_withdrawal_limit' => 10.00,
                'description' => 'Intermediate tier with $1,000 – $1,999 deposit range and 2.25% – 2.50% daily returns.',
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
                'referral_commission_percent' => 9.00,
                'min_withdrawal_limit' => 10.00,
                'description' => 'Advanced plan with $2,000 – $2,999 deposit range and 2.50% – 3.00% daily returns.',
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
                'referral_commission_percent' => 11.00,
                'min_withdrawal_limit' => 10.00,
                'description' => 'Premium tier with $3,000 – $4,999 deposit range and 3.00% – 3.75% daily returns.',
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
                'referral_commission_percent' => 14.00,
                'min_withdrawal_limit' => 10.00,
                'description' => 'Elite tier with $5,000 – $9,999 deposit range and 3.75% – 4.75% daily returns.',
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
                'referral_commission_percent' => 18.00,
                'min_withdrawal_limit' => 10.00,
                'description' => 'Institutional tier with $10,000 – $20,000 deposit range and 4.75% – 6.00% daily returns.',
                'is_active' => true,
            ],
        ];

        foreach ($packages as $pkgData) {
            \App\Models\Package::create($pkgData);
        }
    }
}
