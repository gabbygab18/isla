<?php

namespace Tests\Feature;

use App\Models\Service;
use App\Models\Setting;
use App\Models\User;
use Database\Seeders\IslaSeeder;
use Database\Seeders\NavItemSeeder;
use Database\Seeders\SettingsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(SettingsSeeder::class);
        $this->seed(NavItemSeeder::class);
        $this->seed(IslaSeeder::class);
        $this->admin = User::create([
            'name' => 'Admin', 'email' => 'admin@isla.com.au', 'password' => Hash::make('secret'),
        ]);
    }

    public function test_admin_area_requires_authentication(): void
    {
        $this->get('/admin')->assertRedirect('/admin/login');
    }

    public function test_admin_can_log_in_and_see_dashboard(): void
    {
        $this->post('/admin/login', ['email' => 'admin@isla.com.au', 'password' => 'secret'])
            ->assertRedirect('/admin');

        $this->actingAs($this->admin)->get('/admin')->assertOk()->assertSee('Dashboard');
    }

    public function test_admin_can_create_a_service_that_appears_on_the_site(): void
    {
        $this->actingAs($this->admin)->post('/admin/services', [
            'title'   => 'Data Entry',
            'icon'    => 'i-receipt',
            'summary' => 'Clean data.',
            'body'    => 'Keeps datasets tidy.',
            'deliverables_text' => "Weekly reports\nData cleanup",
            'is_active' => '1',
        ])->assertRedirect('/admin/services');

        $this->assertDatabaseHas('services', ['slug' => 'data-entry']);
        $this->get('/services')->assertSee('Data Entry');
        $this->get('/services/data-entry')->assertOk();
    }

    public function test_admin_can_update_settings_and_they_show_publicly(): void
    {
        $this->actingAs($this->admin)->post('/admin/settings', [
            'settings' => ['hero_subtitle' => 'A brand new subtitle line.'],
        ])->assertRedirect();

        $this->assertSame('A brand new subtitle line.', Setting::get('hero_subtitle'));
        $this->get('/')->assertSee('A brand new subtitle line.');
    }

    public function test_navigation_is_dynamic(): void
    {
        $this->get('/')->assertSee('How it Works');
    }

    public function test_each_section_has_its_own_page(): void
    {
        foreach (['/services', '/who-we-work-with', '/how-it-works', '/why-isla', '/pricing', '/faq', '/contact'] as $url) {
            $this->get($url)->assertOk();
        }
    }
}
