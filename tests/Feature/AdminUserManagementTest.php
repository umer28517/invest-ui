<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminUserManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_admin_dashboard_with_users_tab(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'is_active' => true]);
        $investor = User::factory()->create(['role' => 'user', 'name' => 'Investor Alex']);

        $response = $this->actingAs($admin)->get('/admin/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Investor Alex');
        $response->assertSee('User Management');
    }

    public function test_admin_users_list_only_shows_regular_users_and_excludes_admins(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'is_active' => true]);
        $otherAdmin = User::factory()->create(['role' => 'admin', 'name' => 'Other Root Admin', 'is_active' => true]);
        $investor = User::factory()->create(['role' => 'user', 'name' => 'Investor Alex', 'is_active' => true]);

        $response = $this->actingAs($admin)->get(route('admin.users.index'));

        $response->assertStatus(200);
        $response->assertSee('Investor Alex');
        $response->assertDontSee('Other Root Admin');
    }

    public function test_admin_can_toggle_user_status_deactivate(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'is_active' => true]);
        $user = User::factory()->create(['role' => 'user', 'is_active' => true]);

        $response = $this->actingAs($admin)->post(route('admin.users.toggle-status', $user));

        $response->assertSessionHas('status');
        $this->assertFalse($user->fresh()->is_active);
    }

    public function test_admin_can_toggle_user_status_activate(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'is_active' => true]);
        $user = User::factory()->create(['role' => 'user', 'is_active' => false]);

        $response = $this->actingAs($admin)->post(route('admin.users.toggle-status', $user));

        $response->assertSessionHas('status');
        $this->assertTrue($user->fresh()->is_active);
    }

    public function test_admin_cannot_deactivate_self(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'is_active' => true]);

        $response = $this->actingAs($admin)->post(route('admin.users.toggle-status', $admin));

        $response->assertSessionHas('error');
        $this->assertTrue($admin->fresh()->is_active);
    }

    public function test_deactivated_user_cannot_login(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
            'is_active' => false,
            'password' => bcrypt('secret123'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'secret123',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('email');
    }

    public function test_regular_user_cannot_toggle_user_status(): void
    {
        $user1 = User::factory()->create(['role' => 'user', 'is_active' => true]);
        $user2 = User::factory()->create(['role' => 'user', 'is_active' => true]);

        $response = $this->actingAs($user1)->post(route('admin.users.toggle-status', $user2));

        $response->assertStatus(403);
        $this->assertTrue($user2->fresh()->is_active);
    }

    public function test_admin_can_delete_user(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'is_active' => true]);
        $user = User::factory()->create(['role' => 'user', 'is_active' => true]);

        $response = $this->actingAs($admin)->delete(route('admin.users.destroy', $user));

        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('status');
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function test_admin_cannot_delete_self(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'is_active' => true]);

        $response = $this->actingAs($admin)->delete(route('admin.users.destroy', $admin));

        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('users', ['id' => $admin->id]);
    }

    public function test_regular_user_cannot_delete_user(): void
    {
        $user1 = User::factory()->create(['role' => 'user', 'is_active' => true]);
        $user2 = User::factory()->create(['role' => 'user', 'is_active' => true]);

        $response = $this->actingAs($user1)->delete(route('admin.users.destroy', $user2));

        $response->assertStatus(403);
        $this->assertDatabaseHas('users', ['id' => $user2->id]);
    }

    public function test_admin_can_view_user_dossier_audit_history_page(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'is_active' => true]);
        $investor = User::factory()->create([
            'role' => 'user', 
            'name' => 'Elena Morales',
            'balance' => 1500.00,
            'active_daily_rate' => 2.50,
            'locked_until' => now()->addDays(25),
        ]);

        $response = $this->actingAs($admin)->get(route('admin.users.show', $investor));

        $response->assertStatus(200);
        $response->assertSee('Elena Morales');
        $response->assertSee('Daily Profit Logs');
        $response->assertSee('Cashouts');
        $response->assertSee('1,500.00');
    }
}
