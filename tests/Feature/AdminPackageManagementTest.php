<?php

namespace Tests\Feature;

use App\Models\Package;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPackageManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_login_page_does_not_contain_admin_login_link(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertDontSee('/admin/login');
        $response->assertDontSee('System Operator? Go to Admin Console');
    }

    public function test_admin_can_create_new_package_with_dynamic_rates_and_limits(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'is_active' => true]);

        $response = $this->actingAs($admin)->post(route('admin.packages.store'), [
            'name' => 'Diamond Ultra',
            'investment_amount' => 2500.00,
            'daily_commission_percent' => 3.25,
            'min_withdrawal_limit' => 15.00,
            'description' => 'Ultra high yield plan for verified investors.',
            'is_active' => 1,
        ]);

        $response->assertSessionHas('status');
        $this->assertDatabaseHas('packages', [
            'name' => 'Diamond Ultra',
            'investment_amount' => 2500.00,
            'daily_commission_percent' => 3.25,
            'min_withdrawal_limit' => 15.00,
        ]);
    }

    public function test_admin_can_update_existing_package(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'is_active' => true]);
        $package = Package::create([
            'name' => 'Initial Plan',
            'investment_amount' => 200.00,
            'daily_commission_percent' => 1.50,
            'min_withdrawal_limit' => 10.00,
        ]);

        $response = $this->actingAs($admin)->put(route('admin.packages.update', $package), [
            'name' => 'Updated Plan Alpha',
            'investment_amount' => 350.00,
            'daily_commission_percent' => 2.80,
            'min_withdrawal_limit' => 20.00,
            'is_active' => 1,
        ]);

        $response->assertSessionHas('status');
        $this->assertDatabaseHas('packages', [
            'id' => $package->id,
            'name' => 'Updated Plan Alpha',
            'investment_amount' => 350.00,
            'daily_commission_percent' => 2.80,
            'min_withdrawal_limit' => 20.00,
        ]);
    }

    public function test_admin_can_delete_package(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'is_active' => true]);
        $package = Package::create([
            'name' => 'Temporary Plan',
            'investment_amount' => 100.00,
            'daily_commission_percent' => 1.00,
            'min_withdrawal_limit' => 10.00,
        ]);

        $response = $this->actingAs($admin)->delete(route('admin.packages.destroy', $package));

        $response->assertSessionHas('status');
        $this->assertDatabaseMissing('packages', ['id' => $package->id]);
    }

    public function test_regular_user_cannot_create_or_modify_packages(): void
    {
        $user = User::factory()->create(['role' => 'user', 'is_active' => true]);

        $response = $this->actingAs($user)->post(route('admin.packages.store'), [
            'name' => 'Hacked Plan',
            'investment_amount' => 10.00,
            'daily_commission_percent' => 50.00,
            'min_withdrawal_limit' => 1.00,
        ]);

        $response->assertStatus(403);
    }
}
