<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        // KPI statistics
        $totalRevenue = Payment::where('status', 'paid')->sum('amount');
        $thisMonthRevenue = Payment::where('status', 'paid')
            ->whereMonth('paid_at', Carbon::now()->month)
            ->whereYear('paid_at', Carbon::now()->year)
            ->sum('amount');

        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $confirmedOrders = Order::where('status', 'confirmed')->count();
        $completedOrders = Order::where('status', 'completed')->count();

        $totalCustomers = User::where('role', 'customer')->count();
        $totalServices = Service::count();

        // Recent orders
        $recentOrders = Order::with(['service', 'payment', 'user'])
            ->latest()
            ->take(6)
            ->get();

        // Category breakdown
        $categoryBreakdown = Service::selectRaw('category, count(*) as total_services')
            ->groupBy('category')
            ->pluck('total_services', 'category')
            ->toArray();

        return view('admin.dashboard', compact(
            'totalRevenue',
            'thisMonthRevenue',
            'totalOrders',
            'pendingOrders',
            'confirmedOrders',
            'completedOrders',
            'totalCustomers',
            'totalServices',
            'recentOrders',
            'categoryBreakdown'
        ));
    }
}
