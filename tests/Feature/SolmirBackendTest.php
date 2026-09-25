<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\OrderAttachment;
use App\Models\Portfolio;
use App\Models\Service;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SolmirBackendTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_pages_load_successfully(): void
    {
        Service::factory()->create(['is_active' => true, 'slug' => 'test-service']);
        Portfolio::factory()->create(['slug' => 'test-portfolio']);

        $this->get('/')->assertStatus(200);
        $this->get('/services')->assertStatus(200);
        $this->get('/services/test-service')->assertStatus(200);
        $this->get('/portfolio')->assertStatus(200);
        $this->get('/portfolio/test-portfolio')->assertStatus(200);
        $this->get('/about')->assertStatus(200);
        $this->get('/contact')->assertStatus(200);
    }

    public function test_contact_submission_stores_data(): void
    {
        $response = $this->post('/contact', [
            'name' => 'امیر رضایی',
            'email' => 'amir@example.com',
            'phone' => '۰۹۱۲۳۴۵۶۷۸۹', // Persian digits
            'subject' => 'طراحی فروشگاه اینترنتی',
            'message' => 'سلام، برای راه‌اندازی فروشگاه اینترنتی درخواست مشاوره دارم.',
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('contacts', [
            'email' => 'amir@example.com',
            'phone' => '09123456789', // normalized to English digits
        ]);
    }

    public function test_registration_normalizes_persian_phone_digits(): void
    {
        $response = $this->post('/register', [
            'name' => 'کاربر جدید',
            'email' => 'newuser@solmir.com',
            'phone' => '۰۹۳۵۱۱۱۲۲۳۳',
            'password' => 'Password1234!',
            'password_confirmation' => 'Password1234!',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertDatabaseHas('users', [
            'email' => 'newuser@solmir.com',
            'phone' => '09351112233',
        ]);
    }

    public function test_user_can_login_with_phone_number(): void
    {
        $user = User::factory()->create([
            'phone' => '09129998877',
            'password' => 'secret123',
        ]);

        $response = $this->post('/login', [
            'email' => '۰۹۱۲۹۹۹۸۸۷۷', // logging in with Persian phone digits
            'password' => 'secret123',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    public function test_order_creation_and_authorization(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $this->actingAs($user);

        $response = $this->post('/dashboard/orders', [
            'title' => 'پروژه وب‌سایت املاک',
            'service_type' => 'طراحی وب‌سایت',
            'description' => 'توضیحات کامل نیازمندی‌های سیستم املاک',
            'budget_range' => '۲۰ تا ۴۰ میلیون',
        ]);

        $order = Order::where('title', 'پروژه وب‌سایت املاک')->first();
        $this->assertNotNull($order);
        $response->assertRedirect(route('orders.show', $order));

        // Owner can view order
        $this->actingAs($user)->get("/dashboard/orders/{$order->id}")->assertStatus(200);

        // Another user is forbidden
        $this->actingAs($otherUser)->get("/dashboard/orders/{$order->id}")->assertStatus(403);
    }

    public function test_ticket_workflow_and_reply(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/dashboard/tickets', [
            'title' => 'مشکل در بارگذاری فایل',
            'category' => 'technical',
            'priority' => 'high',
            'message' => 'سلام، هنگام آپلود فایل با خطای حجم روبرو شدم.',
        ]);

        $ticket = Ticket::where('title', 'مشکل در بارگذاری فایل')->first();
        $this->assertNotNull($ticket);
        $response->assertRedirect(route('tickets.show', $ticket));

        $this->assertDatabaseHas('ticket_replies', [
            'ticket_id' => $ticket->id,
            'message' => 'سلام، هنگام آپلود فایل با خطای حجم روبرو شدم.',
        ]);

        // User replies to ticket
        $replyResponse = $this->post("/dashboard/tickets/{$ticket->id}/reply", [
            'message' => 'این هم توضیحات تکمیلی من.',
        ]);

        $replyResponse->assertSessionHas('success');
        $this->assertDatabaseHas('ticket_replies', [
            'ticket_id' => $ticket->id,
            'message' => 'این هم توضیحات تکمیلی من.',
        ]);
    }

    public function test_admin_panel_access_control(): void
    {
        $regularUser = User::factory()->create(['role' => 'user']);
        $adminUser = User::factory()->create(['role' => 'admin']);

        // Regular user denied
        $this->actingAs($regularUser)->get('/admin')->assertStatus(403);

        // Admin allowed
        $this->actingAs($adminUser)->get('/admin')->assertStatus(200);
    }

    public function test_admin_can_manage_services_by_id(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $service = Service::factory()->create(['slug' => 'custom-service']);

        $this->actingAs($admin);

        // Edit service using its integer ID
        $response = $this->get("/admin/services/{$service->id}/edit");
        $response->assertStatus(200);

        // Update service
        $updateResponse = $this->put("/admin/services/{$service->id}", [
            'title' => 'عنوان جدید خدمت',
            'slug' => 'custom-service',
            'description' => 'توضیحات بروزرسانی شده',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $updateResponse->assertRedirect(route('admin.services.index'));
        $this->assertDatabaseHas('services', [
            'id' => $service->id,
            'title' => 'عنوان جدید خدمت',
        ]);
    }

    public function test_security_headers_are_present_on_responses(): void
    {
        $response = $this->get('/');

        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
    }

    public function test_svg_attachment_is_rejected_in_order_creation(): void
    {
        $user = User::factory()->create();
        Storage::fake('local');

        $fakeSvg = UploadedFile::fake()->create('malicious.svg', 10, 'image/svg+xml');

        $response = $this->actingAs($user)->post('/dashboard/orders', [
            'title' => 'سفارش با فایل غیرمجاز',
            'service_type' => 'طراحی سایت',
            'description' => 'توضیحات تست',
            'attachments' => [$fakeSvg],
        ]);

        $response->assertSessionHasErrors('attachments.0');
    }

    public function test_admin_cannot_demote_themselves(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->put("/admin/users/{$admin->id}", [
            'role' => 'user',
        ]);

        $response->assertSessionHas('error');
        $this->assertEquals('admin', $admin->fresh()->role);
    }

    public function test_order_attachment_secure_download_authorization(): void
    {
        $owner = User::factory()->create();
        $stranger = User::factory()->create();

        Storage::fake('local');
        $path = 'order_attachments/test_doc.pdf';
        Storage::disk('local')->put($path, 'sample secret content');

        $order = Order::factory()->create(['user_id' => $owner->id]);
        $attachment = $order->attachments()->create([
            'file_name' => 'test_doc.pdf',
            'file_path' => $path,
            'file_size' => 1234,
            'mime_type' => 'application/pdf',
        ]);

        // Stranger denied
        $this->actingAs($stranger)
            ->get("/dashboard/orders/{$order->id}/attachments/{$attachment->id}")
            ->assertStatus(403);

        // Owner allowed
        $response = $this->actingAs($owner)
            ->get("/dashboard/orders/{$order->id}/attachments/{$attachment->id}");
        $response->assertStatus(200);
        $response->assertHeader('Content-Disposition');
    }

    public function test_customer_cannot_see_admin_notes(): void
    {
        $user = User::factory()->create();
        $order = Order::factory()->create([
            'user_id' => $user->id,
            'admin_notes' => 'INTERNAL_SECRET_ADMIN_NOTE_12345',
        ]);

        $response = $this->actingAs($user)->get("/dashboard/orders/{$order->id}");

        $response->assertStatus(200);
        $response->assertDontSee('INTERNAL_SECRET_ADMIN_NOTE_12345');
        $this->assertArrayNotHasKey('admin_notes', $response->inertiaProps('order'));
    }

    public function test_admin_can_see_admin_notes(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create();
        $order = Order::factory()->create([
            'user_id' => $user->id,
            'admin_notes' => 'INTERNAL_SECRET_ADMIN_NOTE_12345',
        ]);

        $response = $this->actingAs($admin)->get("/admin/orders/{$order->id}");

        $response->assertStatus(200);
        $this->assertEquals('INTERNAL_SECRET_ADMIN_NOTE_12345', $response->inertiaProps('order.admin_notes'));
    }

    public function test_invalid_login_fails_and_rate_limits(): void
    {
        for ($i = 0; $i < 6; $i++) {
            $response = $this->post('/login', [
                'email' => 'wrong@solmir.com',
                'password' => 'wrongpass',
            ]);
            $response->assertSessionHasErrors('email');
        }

        // 7th attempt hits throttle
        $blocked = $this->post('/login', [
            'email' => 'wrong@solmir.com',
            'password' => 'wrongpass',
        ]);
        $blocked->assertStatus(429);
    }

    public function test_password_reset_flow(): void
    {
        $user = User::factory()->create(['email' => 'resetme@solmir.com']);

        // Request reset link
        $response = $this->post('/forgot-password', [
            'email' => 'resetme@solmir.com',
        ]);
        $response->assertSessionHas('status');

        $token = Password::createToken($user);

        // Reset password with valid token
        $resetResponse = $this->post('/reset-password', [
            'token' => $token,
            'email' => 'resetme@solmir.com',
            'password' => 'NewSecurePassword123!',
            'password_confirmation' => 'NewSecurePassword123!',
        ]);

        $resetResponse->assertRedirect('/login');
        $resetResponse->assertSessionHas('success');

        // Confirm new password works
        $loginResponse = $this->post('/login', [
            'email' => 'resetme@solmir.com',
            'password' => 'NewSecurePassword123!',
        ]);
        $loginResponse->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_soft_delete_preserves_historical_orders_and_tickets(): void
    {
        $user = User::factory()->create();
        $order = Order::factory()->create(['user_id' => $user->id]);
        $ticket = Ticket::factory()->create(['user_id' => $user->id]);

        $user->delete();

        // User is soft deleted
        $this->assertSoftDeleted('users', ['id' => $user->id]);

        // Historical orders and tickets are intact and NOT cascade-destroyed
        $this->assertDatabaseHas('orders', ['id' => $order->id]);
        $this->assertDatabaseHas('tickets', ['id' => $ticket->id]);
    }

    public function test_admin_cannot_delete_last_admin(): void
    {
        // Ensure only one admin exists
        User::where('role', 'admin')->delete();
        $soleAdmin = User::factory()->create(['role' => 'admin']);

        // Attempting to delete the sole admin from another context or via self-delete check
        $otherAdminAttempt = User::factory()->create(['role' => 'user']);
        // Acting as sole admin attempting delete on self
        $response = $this->actingAs($soleAdmin)->delete("/admin/users/{$soleAdmin->id}");
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('users', ['id' => $soleAdmin->id]);
    }

    public function test_oversized_attachment_is_rejected(): void
    {
        $user = User::factory()->create();
        Storage::fake('local');

        // 11 MB file exceeds 10 MB (10240 KB) limit
        $oversizedFile = UploadedFile::fake()->create('large_doc.pdf', 11264, 'application/pdf');

        $response = $this->actingAs($user)->post('/dashboard/orders', [
            'title' => 'سفارش فایل حجیم',
            'service_type' => 'طراحی سایت',
            'description' => 'توضیحات تست حجم',
            'attachments' => [$oversizedFile],
        ]);

        $response->assertSessionHasErrors('attachments.0');
    }

    public function test_attachment_filename_is_sanitized(): void
    {
        $user = User::factory()->create();
        Storage::fake('local');

        $dirtyFile = UploadedFile::fake()->create('../../evil<>;"name.pdf', 100, 'application/pdf');

        $response = $this->actingAs($user)->post('/dashboard/orders', [
            'title' => 'سفارش فایل با نام کثیف',
            'service_type' => 'طراحی سایت',
            'description' => 'توضیحات تست پاکسازی',
            'attachments' => [$dirtyFile],
        ]);

        $response->assertSessionHasNoErrors();
        $attachment = OrderAttachment::latest()->first();
        $this->assertNotNull($attachment);
        $this->assertStringNotContainsString('../', $attachment->file_name);
        $this->assertStringNotContainsString('<', $attachment->file_name);
    }

    public function test_cannot_reply_to_closed_ticket(): void
    {
        $user = User::factory()->create();
        $ticket = Ticket::factory()->create([
            'user_id' => $user->id,
            'status' => 'closed',
        ]);

        $response = $this->actingAs($user)->post("/dashboard/tickets/{$ticket->id}/reply", [
            'message' => 'تلاش برای پاسخ به تیکت بسته شده',
        ]);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('ticket_replies', [
            'message' => 'تلاش برای پاسخ به تیکت بسته شده',
        ]);
    }
}
