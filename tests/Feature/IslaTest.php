<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use Database\Seeders\IslaSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IslaTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(IslaSeeder::class);
    }

    public function test_home_page_renders_all_sections(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('Delegate the admin.', false)
            ->assertSee('What your assistant can take off your plate')
            ->assertSee('Pay for hours, not for guesswork');
    }

    public function test_each_section_has_a_working_detail_page(): void
    {
        $this->get('/who-we-work-with/ndis-disability-support')->assertOk()->assertSee('NDIS & Disability Support', false);
        $this->get('/services/admin-scheduling')->assertOk()->assertSee('Admin & Scheduling', false);
        $this->get('/pricing/growth')->assertOk()->assertSee('Growth');
        $this->get('/faq/fees')->assertOk()->assertSee('What are the fees, exactly?', false);
    }

    public function test_unknown_slug_returns_404(): void
    {
        $this->get('/services/not-a-real-service')->assertNotFound();
    }

    public function test_enquiry_form_stores_a_message(): void
    {
        $response = $this->post('/contact', [
            'full_name'     => 'Jane Doe',
            'business_name' => 'Bright Clinic',
            'email'         => 'jane@example.com',
            'phone'         => '0400111222',
            'sector'        => 'Healthcare & Allied Health',
            'message'       => 'We need help with scheduling.',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('contact_messages', [
            'email'  => 'jane@example.com',
            'sector' => 'Healthcare & Allied Health',
        ]);
        $this->assertSame(1, ContactMessage::count());
    }

    public function test_enquiry_form_validates_required_fields(): void
    {
        $this->post('/contact', [])
            ->assertSessionHasErrors(['full_name', 'email', 'message']);
    }
}
