<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(Request $request): View
    {
        $category = $request->query('category', 'all');
        $search = $request->query('q');

        $query = Service::query()->where('is_active', true);

        if ($category !== 'all' && in_array($category, ['wisuda', 'umkm', 'acara', 'video_promosi'])) {
            $query->where('category', $category);
        }

        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        }

        $services = $query->orderBy('is_popular', 'desc')->paginate(9);

        return view('services.index', compact('services', 'category', 'search'));
    }

    public function show(string $slug): View
    {
        $service = Service::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $relatedServices = Service::where('category', $service->category)
            ->where('id', '!=', $service->id)
            ->where('is_active', true)
            ->take(3)
            ->get();

        return view('services.show', compact('service', 'relatedServices'));
    }
}
