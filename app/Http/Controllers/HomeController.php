<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(Request $request): View
    {
        $selectedCategory = $request->query('category', 'all');
        $search = $request->query('q');

        $query = Service::query()->where('is_active', true);

        if ($selectedCategory !== 'all' && in_array($selectedCategory, ['wisuda', 'umkm', 'acara', 'video_promosi'])) {
            $query->where('category', $selectedCategory);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $services = $query->orderBy('is_popular', 'desc')->latest()->get();

        $stats = [
            'total_services' => Service::where('is_active', true)->count(),
            'total_orders' => Order::where('status', 'completed')->count() + 150, // base stats
            'happy_clients' => User::where('role', 'customer')->count() + 230,
            'satisfaction_rate' => '99.4%',
        ];

        return view('home', compact('services', 'selectedCategory', 'search', 'stats'));
    }
}
