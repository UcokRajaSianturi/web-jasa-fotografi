@extends('layouts.admin')

@section('title', 'Kelola Layanan Dokumentasi')
@section('page_title', 'Manajemen Layanan & Paket')

@section('content')
<div class="space-y-6">
    
    <!-- Top Bar with Search & Add Button -->
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
        <!-- Search and Filter Form -->
        <form action="{{ route('admin.services.index') }}" method="GET" class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
            <div class="relative flex-1 sm:w-64">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama paket..." 
                       class="w-full pl-9 pr-3 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:ring-2 focus:ring-brand-500">
            </div>

            <select name="category" onchange="this.form.submit()" 
                    class="px-3 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:ring-2 focus:ring-brand-500 bg-white">
                <option value="all" {{ $category === 'all' ? 'selected' : '' }}>Semua Kategori</option>
                <option value="wisuda" {{ $category === 'wisuda' ? 'selected' : '' }}>Foto Wisuda</option>
                <option value="umkm" {{ $category === 'umkm' ? 'selected' : '' }}>Foto Produk UMKM</option>
                <option value="acara" {{ $category === 'acara' ? 'selected' : '' }}>Dokumentasi Acara</option>
                <option value="video_promosi" {{ $category === 'video_promosi' ? 'selected' : '' }}>Video Promosi</option>
            </select>
        </form>

        <a href="{{ route('admin.services.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold shadow-md shadow-brand-500/20 transition whitespace-nowrap">
            <i class="fa-solid fa-plus text-[10px]"></i>
            <span>Tambah Layanan Baru</span>
        </a>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-slate-50 text-slate-400 font-bold uppercase tracking-wider border-b border-slate-200">
                        <th class="py-3 px-6">Foto</th>
                        <th class="py-3 px-6">Nama Paket Layanan</th>
                        <th class="py-3 px-6">Kategori</th>
                        <th class="py-3 px-6">Durasi</th>
                        <th class="py-3 px-6">Tarif Paket</th>
                        <th class="py-3 px-6 text-center">Pesanan</th>
                        <th class="py-3 px-6 text-center">Status</th>
                        <th class="py-3 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($services as $service)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-4 px-6">
                                <img src="{{ $service->thumbnail }}" alt="{{ $service->name }}" class="w-12 h-12 rounded-xl object-cover">
                            </td>
                            <td class="py-4 px-6 max-w-xs">
                                <div class="flex items-center gap-2">
                                    <p class="font-bold text-slate-900">{{ $service->name }}</p>
                                    @if($service->is_popular)
                                        <span class="px-1.5 py-0.5 rounded text-[9px] font-black bg-amber-100 text-amber-700">POPULER</span>
                                    @endif
                                </div>
                                <p class="text-slate-400 text-[11px] truncate mt-0.5">{{ $service->short_description }}</p>
                            </td>
                            <td class="py-4 px-6">
                                <span class="px-2.5 py-1 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-700">
                                    {{ $service->category_label }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-slate-600 font-medium">
                                {{ $service->duration }}
                            </td>
                            <td class="py-4 px-6">
                                <p class="font-extrabold text-slate-900">{{ $service->formatted_effective_price }}</p>
                                @if($service->discount_price && $service->discount_price > 0)
                                    <p class="text-[10px] text-slate-400 line-through">{{ $service->formatted_price }}</p>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-center font-bold text-slate-700">
                                {{ $service->orders_count }}
                            </td>
                            <td class="py-4 px-6 text-center">
                                <form action="{{ route('admin.services.toggle', $service->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold cursor-pointer transition {{ $service->is_active ? 'bg-emerald-100 text-emerald-800 hover:bg-emerald-200' : 'bg-rose-100 text-rose-800 hover:bg-rose-200' }}">
                                        {{ $service->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </button>
                                </form>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('services.show', $service->slug) }}" target="_blank" 
                                       class="p-1.5 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition" title="Preview Halaman">
                                        <i class="fa-solid fa-eye text-xs"></i>
                                    </a>
                                    <a href="{{ route('admin.services.edit', $service->id) }}" 
                                       class="p-1.5 rounded-lg text-brand-600 hover:bg-brand-50 transition" title="Edit Layanan">
                                        <i class="fa-solid fa-pen-to-square text-xs"></i>
                                    </a>
                                    <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus layanan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg text-rose-500 hover:bg-rose-50 transition" title="Hapus Layanan">
                                            <i class="fa-solid fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-10 text-slate-400">Belum ada layanan yang ditambahkan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-6 border-t border-slate-100">
            {{ $services->withQueryString()->links() }}
        </div>
    </div>

</div>
@endsection
