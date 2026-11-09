<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeparatePagesNavigationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_all_dedicated_admin_pages(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'is_active' => true,
        ]);

        // 1. Overview
        $this->actingAs($admin)->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSeeText('System Administration Console')
            ->assertSeeText('Escrow Cold Storage');

        // Deposits Management
        $this->actingAs($admin)->get(route('admin.deposits.index'))
            ->assertOk()
            ->assertSeeText('Deposit Requests Management')
            ->assertSeeText('Pending Verification');

        // 2. User Management
        $this->actingAs($admin)->get(route('admin.users.index'))
            ->assertOk()
            ->assertSeeText('Investor')
            ->assertSeeText('User Management')
            ->assertSeeText('Account Control');

        // 3. Package Management
        $this->actingAs($admin)->get(route('admin.packages.index'))
            ->assertOk()
            ->assertSeeText('Investment Packages')
            ->assertSeeText('Daily Commission Rates')
            ->assertSeeText('Create New Package');

        // 4. Reserves & Vaults
        $this->actingAs($admin)->get(route('admin.reserves.index'))
            ->assertOk()
            ->assertSeeText('Cold Storage Escrow Reserves')
            ->assertSeeText('USDT Pool');

        // 5. Admin Profile
        $this->actingAs($admin)->get(route('admin.profile.index'))
            ->assertOk()
            ->assertSeeText('Administrator Profile')
            ->assertSeeText('Operator Details');
    }

    public function test_investor_can_access_all_dedicated_investor_pages(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
            'is_active' => true,
        ]);

        // 1. Dashboard Overview
        $this->actingAs($user)->get(route('dashboard'))
            ->assertOk()
            ->assertSeeText('Total Active Balance')
            ->assertSeeText('24h Daily Yield');

        // 2. Investment Plans
        $this->actingAs($user)->get(route('investments.index'))
            ->assertOk()
            ->assertSeeText('Investment Growth Packages');

        // 3. Wallet & Cashout
        $this->actingAs($user)->get(route('wallet.index'))
            ->assertOk()
            ->assertSeeText('Request Instant Withdrawal')
            ->assertSeeText('$10.00 Minimum');

        // 4. Referral Network
        $this->actingAs($user)->get(route('referrals.index'))
            ->assertOk()
            ->assertSeeText('3-Tier Affiliate Circle')
            ->assertSeeText('Tier 1 • Direct Invites');

        // 5. Profile
        $this->actingAs($user)->get(route('profile.edit'))
            ->assertOk()
            ->assertSeeText('Investor Profile')
            ->assertSeeText('Security Settings');
    }

    public function test_regular_user_cannot_access_dedicated_admin_pages(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
            'is_active' => true,
        ]);

        $this->actingAs($user)->get(route('admin.dashboard'))->assertForbidden();
        $this->actingAs($user)->get(route('admin.users.index'))->assertForbidden();
        $this->actingAs($user)->get(route('admin.packages.index'))->assertForbidden();
        $this->actingAs($user)->get(route('admin.reserves.index'))->assertForbidden();
        $this->actingAs($user)->get(route('admin.profile.index'))->assertForbidden();
    }

    public function test_admin_accessing_user_routes_is_redirected_to_admin_counterparts(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'is_active' => true,
        ]);

        $this->actingAs($admin)->get(route('dashboard'))->assertRedirect(route('admin.dashboard'));
        $this->actingAs($admin)->get(route('investments.index'))->assertRedirect(route('admin.packages.index'));
        $this->actingAs($admin)->get(route('wallet.index'))->assertRedirect(route('admin.reserves.index'));
        $this->actingAs($admin)->get(route('referrals.index'))->assertRedirect(route('admin.users.index'));
    }
}
