<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class InvoiceController extends Controller
{
    public function show(int $orderId): View
    {
        $order = Order::with(['service', 'payment', 'user'])->findOrFail($orderId);

        if (!Auth::user()->isAdmin() && $order->user_id !== Auth::id()) {
            abort(403, 'Akses tidak diizinkan.');
        }

        return view('invoices.show', compact('order'));
    }

    public function print(int $orderId): View
    {
        $order = Order::with(['service', 'payment', 'user'])->findOrFail($orderId);

        if (!Auth::user()->isAdmin() && $order->user_id !== Auth::id()) {
            abort(403, 'Akses tidak diizinkan.');
        }

        return view('invoices.print', compact('order'));
    }
}
