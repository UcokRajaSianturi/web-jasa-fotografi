<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function create(Request $request, ?string $slug = null): View|RedirectResponse
    {
        $service = null;
        if ($slug) {
            $service = Service::where('slug', $slug)->where('is_active', true)->first();
        }

        if (!$service && $request->has('service_id')) {
            $service = Service::where('id', $request->query('service_id'))->where('is_active', true)->first();
        }

        $allServices = Service::where('is_active', true)->get();

        return view('bookings.create', compact('service', 'allServices'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'service_id' => ['required', 'exists:services,id'],
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_email' => ['required', 'email', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:20'],
            'booking_date' => ['required', 'date', 'after_or_equal:today'],
            'booking_time' => ['required', 'string', 'max:100'],
            'location' => ['required', 'string', 'max:500'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'payment_method' => ['required', 'string', 'in:qris,bca_va,mandiri_va,bni_va,credit_card'],
        ]);

        $service = Service::findOrFail($validated['service_id']);
        $packagePrice = $service->effective_price;
        $totalAmount = $packagePrice;

        $order = Order::create([
            'user_id' => Auth::id(),
            'service_id' => $service->id,
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'customer_phone' => $validated['customer_phone'],
            'booking_date' => $validated['booking_date'],
            'booking_time' => $validated['booking_time'],
            'location' => $validated['location'],
            'notes' => $validated['notes'],
            'package_price' => $packagePrice,
            'additional_fee' => 0,
            'discount_amount' => 0,
            'total_amount' => $totalAmount,
            'status' => 'pending',
        ]);

        $payment = Payment::create([
            'order_id' => $order->id,
            'payment_gateway' => 'midtrans_simulation',
            'payment_method' => $validated['payment_method'],
            'amount' => $totalAmount,
            'status' => 'unpaid',
            'snap_token' => 'SNAP-' . bin2hex(random_bytes(10)),
            'payload' => [
                'created_at' => now()->toIso8601String(),
                'method' => $validated['payment_method'],
            ],
        ]);

        return redirect()->route('payments.show', $order->id)
            ->with('success', 'Pesanan Anda berhasil dibuat! Silakan selesaikan pembayaran.');
    }
}
