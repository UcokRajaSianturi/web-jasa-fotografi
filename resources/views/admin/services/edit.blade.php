@extends('layouts.admin')

@section('title', 'Edit Layanan ' . $service->name)
@section('page_title', 'Edit Layanan Dokumentasi')

@section('content')
<div class="max-w-4xl space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.services.index') }}" class="inline-flex items-center gap-1.5 text-xs text-slate-500 hover:text-brand-600 font-semibold transition">
            <i class="fa-solid fa-arrow-left text-[10px]"></i>
            <span>Kembali ke Daftar Layanan</span>
        </a>
    </div>

    <div class="bg-white p-8 rounded-3xl border border-slate-200/90 shadow-sm">
        <form action="{{ route('admin.services.update', $service->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Name -->
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Paket Layanan <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" required value="{{ old('name', $service->name) }}" 
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:ring-2 focus:ring-brand-500">
                    @error('name') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Category -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Kategori Layanan <span class="text-rose-500">*</span></label>
                    <select name="category" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:ring-2 focus:ring-brand-500 bg-white">
                        <option value="wisuda" {{ old('category', $service->category) == 'wisuda' ? 'selected' : '' }}>Foto Wisuda</option>
                        <option value="umkm" {{ old('category', $service->category) == 'umkm' ? 'selected' : '' }}>Foto Produk UMKM</option>
                        <option value="acara" {{ old('category', $service->category) == 'acara' ? 'selected' : '' }}>Dokumentasi Acara</option>
                        <option value="video_promosi" {{ old('category', $service->category) == 'video_promosi' ? 'selected' : '' }}>Video Promosi</option>
                    </select>
                </div>

                <!-- Duration -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Durasi Sesi / Pengerjaan <span class="text-rose-500">*</span></label>
                    <input type="text" name="duration" required value="{{ old('duration', $service->duration) }}" 
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:ring-2 focus:ring-brand-500">
                </div>

                <!-- Price -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Tarif Asli (Rp) <span class="text-rose-500">*</span></label>
                    <input type="number" name="price" required min="0" step="1000" value="{{ old('price', (int)$service->price) }}" 
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:ring-2 focus:ring-brand-500">
                </div>

                <!-- Discount Price -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Tarif Promo / Diskon (Rp, Opsional)</label>
                    <input type="number" name="discount_price" min="0" step="1000" value="{{ old('discount_price', $service->discount_price ? (int)$service->discount_price : '') }}" 
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:ring-2 focus:ring-brand-500">
                </div>

                <!-- Thumbnail URL -->
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 mb-1">URL Gambar Thumbnail (Unsplash/Direct Image URL)</label>
                    <input type="url" name="thumbnail" value="{{ old('thumbnail', $service->thumbnail) }}" 
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:ring-2 focus:ring-brand-500">
                </div>

                <!-- Short Description -->
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Ringkasan Singkat (1 Kalimat)</label>
                    <input type="text" name="short_description" value="{{ old('short_description', $service->short_description) }}" 
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:ring-2 focus:ring-brand-500">
                </div>

                <!-- Full Description -->
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Deskripsi Lengkap Layanan <span class="text-rose-500">*</span></label>
                    <textarea name="description" rows="4" required 
                              class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:ring-2 focus:ring-brand-500">{{ old('description', $service->description) }}</textarea>
                </div>

                <!-- Features Raw -->
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Fasilitas / Fitur Paket (1 baris per fasilitas)</label>
                    <textarea name="features_raw" rows="4" 
                              class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:outline-none focus:ring-2 focus:ring-brand-500 font-mono">{{ old('features_raw', !empty($service->features) ? implode("\n", $service->features) : '') }}</textarea>
                    <p class="text-[11px] text-slate-400 mt-1">Tulis tiap poin fasilitas dalam baris baru.</p>
                </div>

                <!-- Checkboxes -->
                <div class="sm:col-span-2 flex items-center gap-6 pt-2">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_popular" value="1" {{ old('is_popular', $service->is_popular) ? 'checked' : '' }} class="rounded text-brand-600 focus:ring-brand-500">
                        <span class="text-xs font-bold text-slate-700">Tandai sebagai Paket Populer</span>
                    </label>

                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $service->is_active) ? 'checked' : '' }} class="rounded text-brand-600 focus:ring-brand-500">
                        <span class="text-xs font-bold text-slate-700">Status Aktif (Tampil di Website)</span>
                    </label>
                </div>
            </div>

            <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.services.index') }}" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold shadow-md shadow-brand-500/20 transition">
                    Perbarui Layanan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
