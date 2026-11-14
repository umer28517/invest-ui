<?php

namespace Tests\Feature;

use App\Models\Package;
use App\Models\Setting;
use App\Models\User;
use App\Models\WithdrawalRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminCommissionSettingsWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_settings_page_with_tabs(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'is_active' => true]);

        $response = $this->actingAs($admin)->get(route('admin.settings.index'));

        $response->assertOk();
        $response->assertSeeText('System Settings');
        $response->assertSeeText('General Settings');
        $response->assertSeeText('Security');
        $response->assertSeeText('Password');
        $response->assertSeeText('Commission');
        $response->assertSeeText('Daily Referral Commission (%)');
        $response->assertSeeText('Withdrawal Fee Percentage (%)');
    }

    public function test_admin_can_update_commission_percentages_and_credentials(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'is_active' => true]);

        $response = $this->actingAs($admin)->post(route('admin.settings.update'), [
            'referral_commission_percent' => 8.50,
            'withdrawal_fee_percent' => 3.00,
            'binance_api_key' => 'bnc_merchant_test_12345',
            'binance_api_secret' => 'bnc_secret_test_67890',
            'binance_environment' => 'live',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('status');

        $this->assertEquals('8.50', Setting::get('referral_commission_percent'));
        $this->assertEquals('3.00', Setting::get('withdrawal_fee_percent'));
        $this->assertEquals('bnc_merchant_test_12345', Setting::get('binance_api_key'));
        $this->assertEquals('bnc_secret_test_67890', Setting::get('binance_api_secret'));
        $this->assertEquals('live', Setting::get('binance_environment'));
    }

    public function test_withdrawal_deducts_configured_fee_percentage(): void
    {
        // Set withdrawal fee to 5%
        Setting::set('withdrawal_fee_percent', '5.00');

        $user = User::factory()->create([
            'role' => 'user',
            'balance' => 300.00,
            'locked_principal' => 0.00,
            'locked_until' => null,
        ]);

        // User requests $100 cashout
        $response = $this->actingAs($user)->post(route('wallet.cashout'), [
            'amount' => 100.00,
            'payout_method' => 'Binance Pay ID',
            'destination_account' => '829104812',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('status');

        $withdrawal = WithdrawalRequest::first();
        $this->assertNotNull($withdrawal);
        $this->assertEquals(100.00, (float) $withdrawal->amount);
        $this->assertEquals(5.00, (float) $withdrawal->fee_percent);
        $this->assertEquals(5.00, (float) $withdrawal->fee_amount);
        $this->assertEquals(95.00, (float) $withdrawal->net_amount);

        // User balance had $100 deducted (now $200)
        $user->refresh();
        $this->assertEquals(200.00, (float) $user->balance);
    }

    public function test_daily_roi_batch_credits_daily_referral_percentage_to_referrer(): void
    {
        // Set referral commission to 10%
        Setting::set('referral_commission_percent', '10.00');

        $admin = User::factory()->create(['role' => 'admin']);

        // Referrer user A
        $referrer = User::factory()->create([
            'role' => 'user',
            'balance' => 100.00,
            'referral_code' => 'UPLINE_A_CODE',
            'is_active' => true,
        ]);

        // Downline user B referred by user A
        $downline = User::factory()->create([
            'role' => 'user',
            'balance' => 500.00,
            'active_daily_rate' => 2.00, // 2% daily yield
            'referred_by' => 'UPLINE_A_CODE',
            'is_active' => true,
        ]);

        // Trigger 24h ROI batch
        // Downline earns: 2% of $500 = $10.00 daily profit
        // Referrer earns: 10% of $10.00 = $1.00 daily referral commission
        $response = $this->actingAs($admin)->post(route('admin.daily-roi.trigger'));
        $response->assertRedirect();

        $downline->refresh();
        $this->assertEquals(510.00, (float) $downline->balance);

        $referrer->refresh();
        // Referrer balance had $1.00 added ($100 + $1 = $101.00)
        $this->assertEquals(101.00, (float) $referrer->balance);

        // Verify referrer received notification
        $this->assertDatabaseHas('user_notifications', [
            'user_id' => $referrer->id,
            'type' => 'bonus',
        ]);
    }

    public function test_referral_registration_and_instant_deposit_commission(): void
    {
        // 1. Set referral commission to 7%
        Setting::set('referral_commission_percent', '7.00');

        $admin = User::factory()->create(['role' => 'admin']);

        // 2. Existing referrer
        $referrer = User::factory()->create([
            'role' => 'user',
            'balance' => 200.00,
            'referral_code' => 'SPONSOR99',
            'is_active' => true,
        ]);

        // 3. New user registers with referral code
        $registerResponse = $this->post(route('register'), [
            'name' => 'Downline Investor',
            'email' => 'downline@example.com',
            'phone' => '+1234567890',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'referral_code' => 'SPONSOR99',
        ]);
        $registerResponse->assertRedirect(route('dashboard'));

        $newUser = User::where('email', 'downline@example.com')->first();
        $this->assertNotNull($newUser);
        $this->assertEquals('SPONSOR99', $newUser->referred_by);

        // 4. Package created
        $package = Package::create([
            'name' => 'Elite Growth Tier',
            'daily_commission_percent' => 3.5,
            'investment_amount' => 1000.00,
            'is_active' => true,
        ]);

        // 5. New user submits a deposit of $1000
        $deposit = \App\Models\DepositRequest::create([
            'user_id' => $newUser->id,
            'package_id' => $package->id,
            'amount' => 1000.00,
            'daily_rate' => $package->daily_commission_percent,
            'payment_method' => 'Binance Pay',
            'binance_pay_id' => 'PAY12345678',
            'transaction_proof' => 'TxID-ABC1234',
            'status' => 'pending',
        ]);

        // 6. Admin approves the deposit
        $approvalResponse = $this->actingAs($admin)->post(route('admin.deposits.approve', $deposit));
        $approvalResponse->assertRedirect();

        // 7. Referrer receives 7% of $1000 ($70.00) immediately
        $referrer->refresh();
        $this->assertEquals(270.00, (float) $referrer->balance);

        // Referrer receives an instant bonus notification
        $this->assertDatabaseHas('user_notifications', [
            'user_id' => $referrer->id,
            'type' => 'bonus',
        ]);
    }

    public function test_home_page_displays_dynamic_packages_and_stats(): void
    {
        Setting::set('referral_commission_percent', '6.50');

        $pkg1 = Package::create([
            'name' => 'Dynamic Alpha Plan',
            'daily_commission_percent' => 2.2,
            'investment_amount' => 250.00,
            'is_active' => true,
        ]);

        $pkg2 = Package::create([
            'name' => 'Dynamic Omega Plan',
            'daily_commission_percent' => 4.8,
            'investment_amount' => 5000.00,
            'is_active' => true,
        ]);

        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertSeeText('Dynamic Alpha Plan');
        $response->assertSeeText('Dynamic Omega Plan');
        $response->assertSeeText('+2.20%');
        $response->assertSeeText('+4.80%');
        $response->assertSeeText('6.5%');
    }
}
