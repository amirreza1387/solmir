<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Portfolio;
use App\Models\Service;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class Phase2UxAndFeaturesTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_orders_are_paginated_at_10_per_page(): void
    {
        $user = User::factory()->create();

        Order::factory()->count(15)->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->get('/dashboard/orders');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page
            ->component('Dashboard/Orders/Index')
            ->has('orders.data', 10)
            ->where('orders.total', 15)
            ->where('orders.per_page', 10)
            ->where('orders.current_page', 1)
        );
    }

    public function test_customer_tickets_are_paginated_at_10_per_page(): void
    {
        $user = User::factory()->create();

        Ticket::factory()->count(12)->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->get('/dashboard/tickets');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page
            ->component('Dashboard/Tickets/Index')
            ->has('tickets.data', 10)
            ->where('tickets.total', 12)
            ->where('tickets.per_page', 10)
        );
    }

    public function test_customer_cannot_reply_to_closed_ticket_enforced_by_backend(): void
    {
        $user = User::factory()->create();

        $ticket = Ticket::factory()->create([
            'user_id' => $user->id,
            'status' => 'closed',
        ]);

        $response = $this->actingAs($user)->post("/dashboard/tickets/{$ticket->id}/reply", [
            'message' => 'پاسخ به تیکت بسته شده',
        ]);

        // Policy and controller reject with 403 Forbidden
        $response->assertStatus(403);
        $this->assertDatabaseMissing('ticket_replies', [
            'ticket_id' => $ticket->id,
            'message' => 'پاسخ به تیکت بسته شده',
        ]);
    }

    public function test_order_creation_rejects_oversized_file_above_10mb(): void
    {
        Storage::fake('local');
        $user = User::factory()->create();

        // 11 MB file = 11 * 1024 KB
        $oversizedFile = UploadedFile::fake()->create('large_document.pdf', 11 * 1024, 'application/pdf');

        $response = $this->actingAs($user)->post('/dashboard/orders', [
            'title' => 'پروژه تست حجم فایل',
            'service_type' => 'طراحی وب‌سایت شرکتی',
            'description' => 'توضیحات تست سفارش با فایل حجیم',
            'attachments' => [$oversizedFile],
        ]);

        $response->assertSessionHasErrors('attachments.0');
        $this->assertDatabaseMissing('orders', [
            'title' => 'پروژه تست حجم فایل',
        ]);
    }

    public function test_order_creation_rejects_invalid_file_extension(): void
    {
        Storage::fake('local');
        $user = User::factory()->create();

        $dangerousFile = UploadedFile::fake()->create('malicious.exe', 500, 'application/x-msdownload');

        $response = $this->actingAs($user)->post('/dashboard/orders', [
            'title' => 'پروژه تست پسوند فایل',
            'service_type' => 'طراحی وب‌سایت شرکتی',
            'description' => 'توضیحات تست سفارش با پسوند غیرمجاز',
            'attachments' => [$dangerousFile],
        ]);

        $response->assertSessionHasErrors('attachments.0');
        $this->assertDatabaseMissing('orders', [
            'title' => 'پروژه تست پسوند فایل',
        ]);
    }

    public function test_admin_portfolios_and_services_are_paginated(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        Portfolio::factory()->count(18)->create();
        Service::factory()->count(18)->create();

        $responsePortfolios = $this->actingAs($admin)->get('/admin/portfolios');
        $responsePortfolios->assertStatus(200);
        $responsePortfolios->assertInertia(fn ($page) => $page
            ->component('Admin/Portfolios/Index')
            ->has('portfolios.data', 15)
            ->where('portfolios.total', 18)
        );

        $responseServices = $this->actingAs($admin)->get('/admin/services');
        $responseServices->assertStatus(200);
        $responseServices->assertInertia(fn ($page) => $page
            ->component('Admin/Services/Index')
            ->has('services.data', 15)
            ->where('services.total', 18)
        );
    }

    public function test_not_found_route_renders_custom_error_page_with_404(): void
    {
        $response = $this->get('/this-route-definitely-does-not-exist-404');
        $response->assertStatus(404);
        $response->assertInertia(fn ($page) => $page
            ->component('Error')
            ->where('status', 404)
        );
    }
}
