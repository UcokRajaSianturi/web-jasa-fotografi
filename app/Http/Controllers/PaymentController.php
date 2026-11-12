<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function show(int $orderId): View|RedirectResponse
    {
        $order = Order::with(['service', 'payment', 'user'])->findOrFail($orderId);

        // Authorization check: only owner or admin can view payment
        if (!Auth::user()->isAdmin() && $order->user_id !== Auth::id()) {
            abort(403, 'Akses tidak diizinkan.');
        }

        $payment = $order->payment;
        if (!$payment) {
            $payment = Payment::create([
                'order_id' => $order->id,
                'payment_gateway' => 'midtrans_simulation',
                'payment_method' => 'qris',
                'amount' => $order->total_amount,
                'status' => 'unpaid',
            ]);
        }

        // If already paid, directly can redirect to invoice or show paid view
        return view('payments.show', compact('order', 'payment'));
    }

    public function process(Request $request, int $orderId): RedirectResponse
    {
        $order = Order::with('payment')->findOrFail($orderId);

        if (!Auth::user()->isAdmin() && $order->user_id !== Auth::id()) {
            abort(403, 'Akses tidak diizinkan.');
        }

        $payment = $order->payment;
        if (!$payment) {
            abort(404, 'Pembayaran tidak ditemukan.');
        }

        $method = $request->input('payment_method', $payment->payment_method);

        // Update payment to paid
        $payment->update([
            'payment_method' => $method,
            'status' => 'paid',
            'payment_reference' => 'MIDTRANS-SIM-' . strtoupper(bin2hex(random_bytes(5))),
            'paid_at' => now(),
            'payload' => array_merge($payment->payload ?? [], [
                'settlement_time' => now()->toIso8601String(),
                'status' => 'settlement',
                'gateway_response' => 'Transaction successfully simulated and paid.',
            ]),
        ]);

        // Update order status to confirmed
        $order->update([
            'status' => 'confirmed',
        ]);

        return redirect()->route('invoices.show', $order->id)
            ->with('success', 'Pembayaran sebesar ' . $payment->formatted_amount . ' berhasil diselesaikan! Invoice telah diterbitkan.');
    }

    public function changeMethod(Request $request, int $orderId): RedirectResponse
    {
        $order = Order::with('payment')->findOrFail($orderId);

        if (!Auth::user()->isAdmin() && $order->user_id !== Auth::id()) {
            abort(403, 'Akses tidak diizinkan.');
        }

        $validated = $request->validate([
            'payment_method' => ['required', 'string', 'in:qris,bca_va,mandiri_va,bni_va,credit_card'],
        ]);

        if ($order->payment && $order->payment->status === 'unpaid') {
            $order->payment->update([
                'payment_method' => $validated['payment_method'],
            ]);
        }

        return back()->with('info', 'Metode pembayaran berhasil diubah ke: ' . strtoupper($validated['payment_method']));
    }
}
