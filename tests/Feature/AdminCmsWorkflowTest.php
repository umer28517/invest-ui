<?php

namespace Tests\Feature;

use App\Models\SiteContent;
use App\Models\User;
use App\Services\CmsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminCmsWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_cms_page_with_tabs(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'is_active' => true]);

        $response = $this->actingAs($admin)->get(route('admin.cms.index'));

        $response->assertOk();
        $response->assertSee('Platform Copy & Content CMS', false);
        $response->assertSeeText('Home Page');
        $response->assertSee('Login & Register', false);
        $response->assertSeeText('Investor Dashboard');
    }

    public function test_regular_user_cannot_access_cms_page(): void
    {
        $user = User::factory()->create(['role' => 'user', 'is_active' => true]);

        $response = $this->actingAs($user)->get(route('admin.cms.index'));

        $response->assertForbidden();
    }

    public function test_admin_can_update_content_and_it_reflects_on_live_pages(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'is_active' => true]);
        $investor = User::factory()->create(['role' => 'user', 'is_active' => true, 'balance' => 500.00]);

        // Seed initial items
        (new \Database\Seeders\SiteContentSeeder())->run();

        // 1. Admin updates home hero title, login title, and dashboard balance title
        $response = $this->actingAs($admin)->post(route('admin.cms.update'), [
            'contents' => [
                'home.hero.title' => 'Decentralized Next-Gen Capital',
                'auth.login.title' => 'VIP Member Portal',
                'dashboard.balance.title' => 'Active Yield Treasury',
            ],
        ]);

        $response->assertRedirect(route('admin.cms.index'));
        $response->assertSessionHas('status');

        // 2. Check Home Page reflects custom CMS text
        $homeResponse = $this->get(route('home'));
        $homeResponse->assertOk();
        $homeResponse->assertSeeText('Decentralized Next-Gen Capital');

        // 3. Logout admin and check Login Page reflects custom CMS text
        auth()->logout();
        $loginResponse = $this->get(route('login'));
        $loginResponse->assertOk();
        $loginResponse->assertSeeText('VIP Member Portal');

        // 4. Check Investor Dashboard reflects custom CMS text
        $dashResponse = $this->actingAs($investor)->get(route('dashboard'));
        $dashResponse->assertOk();
        $dashResponse->assertSeeText('Active Yield Treasury');
    }

    public function test_error_handling_bulletproof_fallback_when_content_is_missing_or_empty(): void
    {
        $investor = User::factory()->create(['role' => 'user', 'is_active' => true]);

        // Clear all CMS content from database completely
        SiteContent::truncate();
        CmsService::clearCache();

        // 1. Home page must not crash (200 OK) and must show standard fallback text
        $homeResponse = $this->get(route('home'));
        $homeResponse->assertOk();
        $homeResponse->assertSeeText('Grow your money');
        $homeResponse->assertSeeText('Total Capital Managed');

        // 2. Login page must not crash (200 OK) and must show standard fallback text
        $loginResponse = $this->get(route('login'));
        $loginResponse->assertOk();
        $loginResponse->assertSeeText('Investor Sign In');

        // 3. Investor dashboard must not crash (200 OK) and must show standard fallback text
        $dashResponse = $this->actingAs($investor)->get(route('dashboard'));
        $dashResponse->assertOk();
        $dashResponse->assertSeeText('Total Active Balance');

        // 4. Direct cms helper call with non-existent key returns default safely
        $safeResult = cms('completely.random.nonexistent.key', 'My Unbreakable Default');
        $this->assertEquals('My Unbreakable Default', $safeResult);

        // 5. Direct cms helper call with empty string in database returns default safely
        SiteContent::create([
            'key' => 'test.blank.key',
            'group' => 'home',
            'section' => 'test',
            'label' => 'test',
            'value' => '   ', // whitespace only
            'default_value' => 'Default Fallback',
        ]);
        CmsService::clearCache();
        $this->assertEquals('Default Fallback', cms('test.blank.key', 'Default Fallback'));
    }

    public function test_admin_can_reset_content_to_defaults(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'is_active' => true]);
        (new \Database\Seeders\SiteContentSeeder())->run();

        // Customize hero title
        $this->actingAs($admin)->post(route('admin.cms.update'), [
            'contents' => [
                'home.hero.title' => 'Temporary Modified Title',
            ],
        ]);
        $this->assertEquals('Temporary Modified Title', cms('home.hero.title'));

        // Reset all defaults
        $response = $this->actingAs($admin)->post(route('admin.cms.reset'));
        $response->assertRedirect(route('admin.cms.index'));

        // Value in DB is now null, so cms helper returns original default
        $this->assertEquals('Sustainable Wealth Generation through Automated', cms('home.hero.title', 'Sustainable Wealth Generation through Automated'));
    }
}
