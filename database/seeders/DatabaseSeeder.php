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

        // Default Investment Packages
        \App\Models\Package::create([
            'name' => 'Sprout Starter',
            'investment_amount' => 100.00,
            'daily_commission_percent' => 1.80,
            'min_withdrawal_limit' => 10.00,
            'description' => 'Low-barrier daily fixed return plan designed for novice investors.',
            'is_active' => true,
        ]);

        \App\Models\Package::create([
            'name' => 'Seedling Growth',
            'investment_amount' => 500.00,
            'daily_commission_percent' => 2.20,
            'min_withdrawal_limit' => 10.00,
            'description' => 'Balanced compounding plan for consistent weekly yield accumulation.',
            'is_active' => true,
        ]);

        \App\Models\Package::create([
            'name' => 'Bloom Signature',
            'investment_amount' => 1000.00,
            'daily_commission_percent' => 2.50,
            'min_withdrawal_limit' => 10.00,
            'description' => 'Our flagship daily compounding package with enhanced affiliate matching.',
            'is_active' => true,
        ]);

        \App\Models\Package::create([
            'name' => 'Forest Premier',
            'investment_amount' => 5000.00,
            'daily_commission_percent' => 3.50,
            'min_withdrawal_limit' => 10.00,
            'description' => 'High-yield capital tier with dedicated priority liquidity settlement.',
            'is_active' => true,
        ]);

        \App\Models\Package::create([
            'name' => 'Evergreen Institutional',
            'investment_amount' => 20000.00,
            'daily_commission_percent' => 4.20,
            'min_withdrawal_limit' => 10.00,
            'description' => 'Institutional escrow vault backing with maximum automated daily distributions.',
            'is_active' => true,
        ]);
    }
}
