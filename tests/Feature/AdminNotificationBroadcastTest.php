<?php

namespace Tests\Feature;

use App\Models\BroadcastNotification;
use App\Models\User;
use App\Models\UserNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminNotificationBroadcastTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_notifications_page(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'is_active' => true]);

        $response = $this->actingAs($admin)->get(route('admin.notifications.index'));

        $response->assertStatus(200);
        $response->assertSeeText('Broadcast Notifications Terminal');
        $response->assertSeeText('Compose New Broadcast');
    }

    public function test_admin_can_broadcast_notification_to_all_investors(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'is_active' => true]);
        $investor1 = User::factory()->create(['role' => 'user', 'is_active' => true]);
        $investor2 = User::factory()->create(['role' => 'user', 'is_active' => true]);

        $response = $this->actingAs($admin)->post(route('admin.notifications.store'), [
            'title' => 'Weekend Flash Bonus +2%',
            'type' => 'bonus',
            'body' => '<p>Enjoy a <strong>+2% bonus</strong> credited to your daily balance.</p>',
        ]);

        $response->assertRedirect(route('admin.notifications.index'));
        $response->assertSessionHas('status');

        $this->assertDatabaseHas('broadcast_notifications', [
            'title' => 'Weekend Flash Bonus +2%',
            'type' => 'bonus',
            'recipients_count' => 2,
        ]);

        // Verify both investors received user notifications
        $this->assertDatabaseHas('user_notifications', [
            'user_id' => $investor1->id,
            'title' => 'Weekend Flash Bonus +2%',
        ]);
        $this->assertDatabaseHas('user_notifications', [
            'user_id' => $investor2->id,
            'title' => 'Weekend Flash Bonus +2%',
        ]);

        // Verify admin did not get a user notification since they are admin
        $this->assertDatabaseMissing('user_notifications', [
            'user_id' => $admin->id,
        ]);
    }

    public function test_investor_can_view_and_mark_notifications_as_read(): void
    {
        $investor = User::factory()->create(['role' => 'user', 'is_active' => true]);
        
        $notif = UserNotification::create([
            'user_id' => $investor->id,
            'title' => 'Daily Yield Processed',
            'type' => 'announcement',
            'body' => '<p>Your 2.5% yield is in your balance.</p>',
            'is_read' => false,
        ]);

        $response = $this->actingAs($investor)->get(route('notifications.index'));
        $response->assertStatus(200);
        $response->assertSeeText('Daily Yield Processed');

        // Mark single as read
        $readResponse = $this->actingAs($investor)->post(route('notifications.mark-read', $notif));
        $readResponse->assertSessionHas('status');
        $this->assertTrue($notif->fresh()->is_read);

        // Mark all as read test
        UserNotification::create([
            'user_id' => $investor->id,
            'title' => 'Second Alert',
            'type' => 'alert',
            'body' => '<p>Second alert.</p>',
            'is_read' => false,
        ]);

        $allReadResponse = $this->actingAs($investor)->post(route('notifications.mark-all-read'));
        $allReadResponse->assertSessionHas('status');
        $this->assertEquals(0, $investor->unreadNotificationsCount());
    }

    public function test_admin_can_delete_broadcast_notification(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'is_active' => true]);
        $broadcast = BroadcastNotification::create([
            'title' => 'Temporary Notice',
            'type' => 'system',
            'body' => '<p>Testing delete.</p>',
            'created_by' => $admin->id,
            'recipients_count' => 0,
        ]);

        $response = $this->actingAs($admin)->delete(route('admin.notifications.destroy', $broadcast));
        $response->assertRedirect(route('admin.notifications.index'));
        $response->assertSessionHas('status');

        $this->assertDatabaseMissing('broadcast_notifications', ['id' => $broadcast->id]);
    }

    public function test_regular_user_cannot_broadcast_notifications(): void
    {
        $user = User::factory()->create(['role' => 'user', 'is_active' => true]);

        $response = $this->actingAs($user)->post(route('admin.notifications.store'), [
            'title' => 'Malicious title',
            'type' => 'alert',
            'body' => 'Should be forbidden',
        ]);

        $response->assertStatus(403);
    }
}
