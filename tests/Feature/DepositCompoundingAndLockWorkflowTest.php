<?php

namespace Tests\Feature;

use App\Models\DepositRequest;
use App\Models\Package;
use App\Models\User;
use App\Models\WithdrawalRequest;
use App\Models\YieldDistribution;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DepositCompoundingAndLockWorkflowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Package::create([
            'name' => 'Sprout Starter',
            'investment_amount' => 100.00,
            'daily_commission_percent' => 2.00,
            'min_withdrawal_limit' => 10.00,
            'duration_days' => 30,
            'description' => 'Starter compounding package',
            'is_active' => true,
        ]);
    }

    public function test_user_can_submit_deposit_request_and_remains_pending_until_admin_approves(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
            'balance' => 0.00,
            'active_daily_rate' => 0.00,
            'locked_until' => null,
        ]);

        $package = Package::first();

        // 1. User submits deposit request
        $response = $this->actingAs($user)->post(route('investments.deposit'), [
            'package_id' => $package->id,
            'amount' => 200.00,
            'payment_method' => 'Binance Pay (QR)',
            'binance_pay_id' => '829104812',
            'transaction_proof' => 'TxID-99882211',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('deposit_requests', [
            'user_id' => $user->id,
            'package_id' => $package->id,
            'amount' => 200.00,
            'status' => 'pending',
            'binance_pay_id' => '829104812',
        ]);

        // User balance is NOT credited yet while pending
        $user->refresh();
        $this->assertEquals(0.00, (float) $user->balance);
        $this->assertNull($user->locked_until);
    }

    public function test_admin_approves_deposit_which_credits_balance_and_enforces_30_day_lock(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'user', 'balance' => 0.00]);
        $package = Package::first();

        $deposit = DepositRequest::create([
            'user_id' => $user->id,
            'package_id' => $package->id,
            'amount' => 200.00,
            'daily_rate' => $package->daily_commission_percent,
            'payment_method' => 'Binance Pay (QR)',
            'binance_pay_id' => '829104812',
            'transaction_proof' => 'TxID-ABC1234',
            'status' => 'pending',
        ]);

        // Admin approves deposit
        $response = $this->actingAs($admin)->post(route('admin.deposits.approve', $deposit->id));
        $response->assertRedirect();

        $deposit->refresh();
        $this->assertEquals('approved', $deposit->status);

        $user->refresh();
        // Balance is now credited
        $this->assertEquals(200.00, (float) $user->balance);
        $this->assertEquals(2.00, (float) $user->active_daily_rate);
        $this->assertEquals($package->id, $user->active_package_id);

        // 30-Day Lock is now enforced
        $this->assertTrue($user->isCapitalLocked());
        $this->assertGreaterThan(25, $user->daysRemainingLocked());
    }

    public function test_user_cannot_withdraw_base_capital_while_under_30_day_lock(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
            'balance' => 200.00,
            'locked_principal' => 200.00,
            'locked_until' => now()->addDays(30),
        ]);

        // Attempting to withdraw base capital
        $response = $this->actingAs($user)->post(route('wallet.cashout'), [
            'amount' => 50.00,
            'payout_method' => 'Binance Pay ID',
            'destination_account' => '829104812',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');

        // Balance untouched, no withdrawal created
        $user->refresh();
        $this->assertEquals(200.00, (float) $user->balance);
        $this->assertEquals(0, WithdrawalRequest::count());
    }

    public function test_user_can_withdraw_accrued_profit_during_30_day_capital_lock(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
            'balance' => 240.00, // $200 base deposit + $40 accrued profit
            'locked_principal' => 200.00,
            'locked_until' => now()->addDays(30),
        ]);

        $this->assertTrue($user->isCapitalLocked());
        $this->assertEquals(40.00, $user->getWithdrawableBalance());

        // User can withdraw up to $40 profit (e.g. $25)
        $response = $this->actingAs($user)->post(route('wallet.cashout'), [
            'amount' => 25.00,
            'payout_method' => 'Binance Pay ID',
            'destination_account' => '829104812',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('status');

        $user->refresh();
        $this->assertEquals(215.00, (float) $user->balance);
        $this->assertEquals(1, WithdrawalRequest::count());

        // But user CANNOT withdraw more than the accrued profit ($15 remaining profit)
        $excessResponse = $this->actingAs($user)->post(route('wallet.cashout'), [
            'amount' => 30.00,
            'payout_method' => 'Binance Pay ID',
            'destination_account' => '829104812',
        ]);
        $excessResponse->assertRedirect();
        $excessResponse->assertSessionHasErrors();
    }

    public function test_automatic_dynamic_tier_upgrade_and_fallback_with_subscribed_floor(): void
    {
        $pkg1 = Package::first(); // $100, 2.0%
        $pkg2 = Package::create([
            'name' => 'Growth Tier',
            'investment_amount' => 500.00,
            'daily_commission_percent' => 3.50,
            'min_withdrawal_limit' => 10.00,
            'duration_days' => 30,
            'description' => 'Growth package',
            'is_active' => true,
        ]);
        $pkg3 = Package::create([
            'name' => 'Apex Tier',
            'investment_amount' => 800.00,
            'daily_commission_percent' => 5.00,
            'min_withdrawal_limit' => 10.00,
            'duration_days' => 30,
            'description' => 'Apex package',
            'is_active' => true,
        ]);

        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create([
            'role' => 'user',
            'balance' => 500.00,
            'active_package_id' => $pkg2->id,
            'active_daily_rate' => 3.50,
            'is_active' => true,
        ]);

        // 1. Initial State: User is at Package 2 (3.5%)
        $this->assertEquals(3.50, $user->effective_daily_rate);
        $this->assertEquals($pkg2->id, $user->effective_package->id);
        $this->assertFalse($user->is_tier_upgraded);

        // 2. Compounding balance grows to $850 (qualifies for Package 3 $800 threshold)
        $user->balance = 850.00;
        $user->save();

        // Dynamically auto-upgrades to Package 3 (5.0%)!
        $this->assertEquals(5.00, $user->effective_daily_rate);
        $this->assertEquals($pkg3->id, $user->effective_package->id);
        $this->assertTrue($user->is_tier_upgraded);

        // 24h ROI batch distribution uses Package 3 rate (5.0%)
        // 5% of $850 = $42.50
        $this->actingAs($admin)->post(route('admin.daily-roi.trigger'));
        $user->refresh();
        $this->assertEquals(892.50, (float) $user->balance);

        // 3. User withdraws some profit and balance drops below $800 to $700
        $user->balance = 700.00;
        $user->save();

        // Tier drops back to Package 2 (3.5%)
        $this->assertEquals(3.50, $user->effective_daily_rate);
        $this->assertEquals($pkg2->id, $user->effective_package->id);
        $this->assertFalse($user->is_tier_upgraded);

        // 4. User balance drops further to $150 (< Package 2 $500)
        $user->balance = 150.00;
        $user->save();

        // Floor rule: Never drops below subscribed package rate (3.5%)! It does NOT drop to Package 1 (2.0%)
        $this->assertEquals(3.50, $user->effective_daily_rate);
        $this->assertEquals($pkg2->id, $user->effective_package->id);
    }

    public function test_24h_daily_roi_compounds_continuously_on_total_available_balance(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create([
            'role' => 'user',
            'balance' => 200.00,
            'active_daily_rate' => 2.00,
            'is_active' => true,
        ]);

        // Day 1: Admin triggers 24h ROI batch
        // 2% of $200.00 = $4.00 profit => new balance becomes $204.00
        $response = $this->actingAs($admin)->post(route('admin.daily-roi.trigger'));
        $response->assertRedirect();

        $user->refresh();
        $this->assertEquals(204.00, (float) $user->balance);
        $this->assertDatabaseHas('yield_distributions', [
            'user_id' => $user->id,
            'starting_balance' => 200.00,
            'rate_percent' => 2.00,
            'profit_earned' => 4.00,
            'new_balance' => 204.00,
        ]);

        // Day 2: Next trigger calculates on new total balance $204.00!
        // 2% of $204.00 = $4.08 profit => new balance becomes $208.08
        $this->actingAs($admin)->post(route('admin.daily-roi.trigger'));

        $user->refresh();
        $this->assertEquals(208.08, (float) $user->balance);
        $this->assertDatabaseHas('yield_distributions', [
            'user_id' => $user->id,
            'starting_balance' => 204.00,
            'rate_percent' => 2.00,
            'profit_earned' => 4.08,
            'new_balance' => 208.08,
        ]);
    }

    public function test_user_can_withdraw_after_30_days_and_admin_settles_cashout(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create([
            'role' => 'user',
            'balance' => 500.00,
            'withdrawn_total' => 0.00,
            'locked_until' => now()->subDay(), // 30 days elapsed!
        ]);

        $this->assertFalse($user->isCapitalLocked());

        // User requests cashout of $100
        $response = $this->actingAs($user)->post(route('wallet.cashout'), [
            'amount' => 100.00,
            'payout_method' => 'Binance Pay ID',
            'destination_account' => '829104812',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('status');

        $user->refresh();
        $this->assertEquals(400.00, (float) $user->balance);

        $withdrawal = WithdrawalRequest::first();
        $this->assertEquals('pending', $withdrawal->status);
        $this->assertEquals(100.00, (float) $withdrawal->amount);

        // Admin settles/approves the cashout
        $response = $this->actingAs($admin)->post(route('admin.withdrawals.approve', $withdrawal->id));
        $response->assertRedirect();

        $withdrawal->refresh();
        $this->assertEquals('approved', $withdrawal->status);

        $user->refresh();
        $this->assertEquals(100.00, (float) $user->withdrawn_total);
    }
}
