<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderCrudController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->query('status', 'all');
        $serviceId = $request->query('service_id');
        $search = $request->query('q');

        $query = Order::with(['service', 'payment', 'user']);

        if ($status !== 'all' && in_array($status, ['pending', 'confirmed', 'processing', 'completed', 'cancelled'])) {
            $query->where('status', $status);
        }

        if ($serviceId) {
            $query->where('service_id', $serviceId);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('order_code', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%");
            });
        }

        $orders = $query->latest()->paginate(10);
        $services = Service::all();

        return view('admin.orders.index', compact('orders', 'status', 'serviceId', 'search', 'services'));
    }

    public function show(int $id): View
    {
        $order = Order::with(['service', 'payment', 'user'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, int $id): RedirectResponse
    {
        $order = Order::with('payment')->findOrFail($id);

        $validated = $request->validate([
            'status' => ['required', 'string', 'in:pending,confirmed,processing,completed,cancelled'],
        ]);

        $order->update(['status' => $validated['status']]);

        // If completed or confirmed and payment was unpaid, admin can also sync or leave as is
        if ($validated['status'] === 'completed' && $order->payment && $order->payment->status === 'unpaid') {
            $order->payment->update([
                'status' => 'paid',
                'paid_at' => now(),
                'payment_reference' => 'ADMIN-VERIFIED-' . date('YmdHis'),
            ]);
        }

        return back()->with('success', "Status pesanan {$order->order_code} berhasil diperbarui menjadi {$order->status_label}.");
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $order = Order::findOrFail($id);

        $validated = $request->validate([
            'booking_date' => ['required', 'date'],
            'booking_time' => ['required', 'string', 'max:100'],
            'location' => ['required', 'string', 'max:500'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'additional_fee' => ['nullable', 'numeric', 'min:0'],
        ]);

        $additionalFee = (float)($validated['additional_fee'] ?? 0);
        $totalAmount = $order->package_price + $additionalFee - $order->discount_amount;

        $order->update([
            'booking_date' => $validated['booking_date'],
            'booking_time' => $validated['booking_time'],
            'location' => $validated['location'],
            'notes' => $validated['notes'],
            'additional_fee' => $additionalFee,
            'total_amount' => $totalAmount,
        ]);

        if ($order->payment && $order->payment->status === 'unpaid') {
            $order->payment->update(['amount' => $totalAmount]);
        }

        return back()->with('success', "Data pesanan {$order->order_code} berhasil diperbarui.");
    }

    public function destroy(int $id): RedirectResponse
    {
        $order = Order::findOrFail($id);
        $code = $order->order_code;
        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', "Pesanan {$code} berhasil dihapus.");
    }
}
