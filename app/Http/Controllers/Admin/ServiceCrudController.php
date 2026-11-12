<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ServiceCrudController extends Controller
{
    public function index(Request $request): View
    {
        $category = $request->query('category', 'all');
        $search = $request->query('q');

        $query = Service::withCount('orders');

        if ($category !== 'all') {
            $query->where('category', $category);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $services = $query->latest()->paginate(10);

        return view('admin.services.index', compact('services', 'category', 'search'));
    }

    public function create(): View
    {
        return view('admin.services.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'in:wisuda,umkm,acara,video_promosi'],
            'short_description' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'discount_price' => ['nullable', 'numeric', 'min:0'],
            'duration' => ['required', 'string', 'max:100'],
            'features_raw' => ['nullable', 'string'],
            'thumbnail' => ['nullable', 'url', 'max:500'],
            'is_popular' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        // Parse features line by line
        $features = [];
        if (!empty($validated['features_raw'])) {
            $lines = explode("\n", str_replace("\r", "", $validated['features_raw']));
            foreach ($lines as $line) {
                $trimmed = trim($line);
                if ($trimmed !== '') {
                    $features[] = $trimmed;
                }
            }
        }

        Service::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']) . '-' . Str::random(5),
            'category' => $validated['category'],
            'short_description' => $validated['short_description'] ?? null,
            'description' => $validated['description'],
            'price' => $validated['price'],
            'discount_price' => $validated['discount_price'] ?? null,
            'duration' => $validated['duration'],
            'features' => $features,
            'thumbnail' => $validated['thumbnail'] ?: 'https://images.unsplash.com/photo-1542038784456-1ea8e935640e?auto=format&fit=crop&w=800&q=80',
            'is_popular' => $request->boolean('is_popular'),
            'is_active' => $request->has('is_active') ? $request->boolean('is_active') : true,
        ]);

        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil ditambahkan!');
    }

    public function edit(int $id): View
    {
        $service = Service::findOrFail($id);
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $service = Service::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'in:wisuda,umkm,acara,video_promosi'],
            'short_description' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'discount_price' => ['nullable', 'numeric', 'min:0'],
            'duration' => ['required', 'string', 'max:100'],
            'features_raw' => ['nullable', 'string'],
            'thumbnail' => ['nullable', 'url', 'max:500'],
            'is_popular' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $features = [];
        if (!empty($validated['features_raw'])) {
            $lines = explode("\n", str_replace("\r", "", $validated['features_raw']));
            foreach ($lines as $line) {
                $trimmed = trim($line);
                if ($trimmed !== '') {
                    $features[] = $trimmed;
                }
            }
        }

        $service->update([
            'name' => $validated['name'],
            'category' => $validated['category'],
            'short_description' => $validated['short_description'] ?? null,
            'description' => $validated['description'],
            'price' => $validated['price'],
            'discount_price' => $validated['discount_price'] ?? null,
            'duration' => $validated['duration'],
            'features' => $features,
            'thumbnail' => $validated['thumbnail'] ?: $service->thumbnail,
            'is_popular' => $request->boolean('is_popular'),
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil diperbarui!');
    }

    public function destroy(int $id): RedirectResponse
    {
        $service = Service::findOrFail($id);
        $name = $service->name;
        $service->delete();

        return redirect()->route('admin.services.index')->with('success', "Layanan '{$name}' berhasil dihapus.");
    }

    public function toggleStatus(int $id): RedirectResponse
    {
        $service = Service::findOrFail($id);
        $service->update(['is_active' => !$service->is_active]);

        $statusStr = $service->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Status layanan '{$service->name}' berhasil {$statusStr}.");
    }
}
