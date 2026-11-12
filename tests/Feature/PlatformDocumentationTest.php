<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Service;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlatformDocumentationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_homepage_loads_successfully_with_services(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('LensCraft');
        $response->assertSee('Wisuda');
        $response->assertSee('Foto Produk UMKM');
        $response->assertSee('Dokumentasi Acara');
        $response->assertSee('Video Promosi');
    }

    public function test_catalog_and_service_detail_can_be_viewed(): void
    {
        $service = Service::first();
        $this->assertNotNull($service, 'Seeded service should exist');

        $response = $this->get('/layanan/' . $service->slug);
        $response->assertStatus(200);
        $response->assertSee($service->name);
    }

    public function test_customer_can_create_booking_and_payment_record_is_created(): void
    {
        $user = User::where('role', 'customer')->first();
        $service = Service::first();

        $bookingData = [
            'service_id' => $service->id,
            'customer_name' => 'Budi Santoso',
            'customer_email' => 'budi@example.com',
            'customer_phone' => '08123456789',
            'booking_date' => now()->addDays(5)->toDateString(),
            'booking_time' => '10:00 - 12:00 WIB',
            'location' => 'Gedung Wisuda Kampus Merdeka',
            'notes' => 'Tolong bawa lensa telephoto',
            'payment_method' => 'qris',
        ];

        $response = $this->actingAs($user)->post('/pesan', $bookingData);

        $order = Order::where('customer_email', 'budi@example.com')->latest('id')->first();
        $this->assertNotNull($order);
        $this->assertEquals('pending', $order->status);

        $response->assertRedirect(route('payments.show', $order->id));

        $payment = Payment::where('order_id', $order->id)->first();
        $this->assertNotNull($payment);
        $this->assertEquals('unpaid', $payment->status);
        $this->assertEquals('qris', $payment->payment_method);
    }

    public function test_payment_simulation_marks_payment_as_paid_and_order_as_confirmed(): void
    {
        $user = User::where('role', 'customer')->first();
        $service = Service::first();

        $order = Order::create([
            'user_id' => $user->id,
            'service_id' => $service->id,
            'customer_name' => $user->name,
            'customer_email' => $user->email,
            'customer_phone' => '08123456789',
            'booking_date' => now()->addDays(2)->toDateString(),
            'booking_time' => '10:00 - 12:00 WIB',
            'location' => 'Studio Foto',
            'package_price' => $service->effective_price,
            'additional_fee' => 0,
            'discount_amount' => 0,
            'total_amount' => $service->effective_price,
            'status' => 'pending',
        ]);

        Payment::create([
            'order_id' => $order->id,
            'payment_gateway' => 'midtrans_simulation',
            'payment_method' => 'qris',
            'amount' => $order->total_amount,
            'status' => 'unpaid',
        ]);

        $response = $this->actingAs($user)->post("/pembayaran/{$order->id}/proses", [
            'payment_method' => 'qris',
        ]);

        $response->assertRedirect(route('invoices.show', $order->id));

        $order->refresh();
        $this->assertEquals('confirmed', $order->status);
        $this->assertEquals('paid', $order->payment->status);
        $this->assertNotNull($order->payment->paid_at);
    }

    public function test_invoice_and_printable_views_load_successfully(): void
    {
        $user = User::where('role', 'customer')->first();
        $order = Order::where('user_id', $user->id)->first();

        $response = $this->actingAs($user)->get("/invoice/{$order->id}");
        $response->assertStatus(200);
        $response->assertSee($order->order_code);
        $response->assertSee('Invoice Resmi Layanan');

        $printResponse = $this->actingAs($user)->get("/invoice/{$order->id}/cetak");
        $printResponse->assertStatus(200);
        $printResponse->assertSee($order->order_code);
    }

    public function test_admin_can_access_dashboard_and_financial_reports(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->get('/admin/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Ringkasan & Analitik Studio');
        $response->assertSee('Total Pendapatan');

        $reportResponse = $this->actingAs($admin)->get('/admin/laporan-keuangan');
        $reportResponse->assertStatus(200);
        $reportResponse->assertSee('Laporan Keuangan & Arus Kas');
        $reportResponse->assertSee('Ekspor ke Excel (.csv)');
    }

    public function test_super_admin_can_access_dashboard(): void
    {
        $superAdmin = User::where('role', 'super_admin')->first();
        $this->assertNotNull($superAdmin);

        $response = $this->actingAs($superAdmin)->get('/admin/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Super Administrator');
    }

    public function test_financial_report_csv_export(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->get('/admin/laporan-keuangan/ekspor-excel');
        $response->assertStatus(200);
        $this->assertTrue(str_contains($response->headers->get('content-type') ?? '', 'text/csv'));
    }

    public function test_non_admin_cannot_access_admin_dashboard(): void
    {
        $customer = User::where('role', 'customer')->first();

        $response = $this->actingAs($customer)->get('/admin/dashboard');
        $response->assertRedirect(route('home'));
        $response->assertSessionHas('error');
    }
}
