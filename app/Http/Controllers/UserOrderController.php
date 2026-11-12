<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserOrderController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->query('status', 'all');

        $query = Order::with(['service', 'payment'])
            ->where('user_id', Auth::id());

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $orders = $query->latest()->paginate(10);

        $counts = [
            'all' => Order::where('user_id', Auth::id())->count(),
            'pending' => Order::where('user_id', Auth::id())->where('status', 'pending')->count(),
            'confirmed' => Order::where('user_id', Auth::id())->where('status', 'confirmed')->count(),
            'processing' => Order::where('user_id', Auth::id())->where('status', 'processing')->count(),
            'completed' => Order::where('user_id', Auth::id())->where('status', 'completed')->count(),
            'cancelled' => Order::where('user_id', Auth::id())->where('status', 'cancelled')->count(),
        ];

        return view('user.orders.index', compact('orders', 'status', 'counts'));
    }

    public function show(int $id): View
    {
        $order = Order::with(['service', 'payment'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('user.orders.show', compact('order'));
    }

    public function cancel(int $id): RedirectResponse
    {
        $order = Order::where('user_id', Auth::id())
            ->where('status', 'pending')
            ->findOrFail($id);

        $order->update(['status' => 'cancelled']);

        if ($order->payment) {
            $order->payment->update(['status' => 'failed']);
        }

        return back()->with('success', 'Pesanan berhasil dibatalkan.');
    }
}
