<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Admin;

class ExampleTest extends TestCase
{
    public function test_email_verification_route()
    {
        // Giả lập admin đã đăng nhập
        $admin = Admin::factory()->create(); // Thay User bằng Admin
        $admin->markEmailAsVerified();

        $response = $this->actingAs($admin)->get('/email/verify/'.$admin->id.'/'.$admin->email_verification_hash);
        $response->assertRedirect('/admin/dashboard');
    }

    public function test_send_verification_link()
    {
        $admin = Admin::factory()->create(); // Thay User bằng Admin

        $response = $this->actingAs($admin)->post('/email/verification-notification');
        $response->assertRedirect();
    }
}
