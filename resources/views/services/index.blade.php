@extends('layouts.app')

@section('title', 'Katalog Paket Jasa Dokumentasi - LensCraft Studio')

@section('content')
<div class="bg-slate-50 py-12 border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center max-w-2xl mx-auto mb-10">
            <span class="text-brand-600 font-bold text-xs uppercase tracking-wider">Katalog Lengkap</span>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-2">Pilihan Paket Jasa Dokumentasi</h1>
            <p class="text-slate-600 text-sm mt-2">Temukan paket foto wisuda, foto produk UMKM, dokumentasi acara, dan video promosi terbaik sesuai kebutuhan dan anggaran Anda.</p>
        </div>

        <!-- Filter and Search Bar -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm max-w-4xl mx-auto mb-12">
            <form action="{{ route('services.index') }}" method="GET" class="flex flex-col md:flex-row items-center gap-3">
                <!-- Search Input -->
                <div class="relative flex-1 w-full">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama layanan atau fasilitas..." 
                           class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500">
                </div>

                <!-- Category Selector -->
                <div class="w-full md:w-56">
                    <select name="category" onchange="this.form.submit()" 
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 bg-white">
                        <option value="all" {{ $category === 'all' ? 'selected' : '' }}>Semua Kategori</option>
                        <option value="wisuda" {{ $category === 'wisuda' ? 'selected' : '' }}>Foto Wisuda</option>
                        <option value="umkm" {{ $category === 'umkm' ? 'selected' : '' }}>Foto Produk UMKM</option>
                        <option value="acara" {{ $category === 'acara' ? 'selected' : '' }}>Dokumentasi Acara</option>
                        <option value="video_promosi" {{ $category === 'video_promosi' ? 'selected' : '' }}>Video Promosi</option>
                    </select>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full md:w-auto px-6 py-2.5 rounded-xl bg-brand-600 hover:bg-brand-700 text-white text-sm font-bold shadow-md shadow-brand-500/20 transition">
                    Filter
                </button>

                @if(request('q') || $category !== 'all')
                    <a href="{{ route('services.index') }}" class="px-3 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold transition" title="Reset filter">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <!-- Services Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($services as $service)
                <div class="bg-white rounded-3xl overflow-hidden border border-slate-200 shadow-sm hover:shadow-xl hover:-translate-y-1 transition duration-300 flex flex-col justify-between group">
                    <div>
                        <!-- Thumbnail & Badges -->
                        <div class="relative h-56 overflow-hidden bg-slate-100">
                            <img src="{{ $service->thumbnail }}" alt="{{ $service->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            
                            <div class="absolute top-4 left-4 flex items-center gap-2">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-bold bg-white/95 text-slate-800 shadow-sm backdrop-blur-sm">
                                    {{ $service->category_label }}
                                </span>
                                @if($service->is_popular)
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-[11px] font-bold bg-brand-600 text-white shadow-sm">
                                        <i class="fa-solid fa-fire text-[10px]"></i> Populer
                                    </span>
                                @endif
                            </div>

                            <div class="absolute bottom-4 right-4 bg-slate-900/80 backdrop-blur-sm text-white px-2.5 py-1 rounded-lg text-xs font-semibold flex items-center gap-1.5">
                                <i class="fa-regular fa-clock text-[11px]"></i>
                                <span>{{ $service->duration }}</span>
                            </div>
                        </div>

                        <!-- Content Info -->
                        <div class="p-6">
                            <h3 class="text-xl font-extrabold text-slate-900 group-hover:text-brand-600 transition">
                                <a href="{{ route('services.show', $service->slug) }}">{{ $service->name }}</a>
                            </h3>
                            <p class="text-xs text-slate-500 mt-2 line-clamp-2 leading-relaxed">
                                {{ $service->short_description ?? $service->description }}
                            </p>

                            <!-- Features List -->
                            @if(!empty($service->features))
                                <ul class="mt-5 space-y-2.5 pt-4 border-t border-slate-100">
                                    @foreach(array_slice($service->features, 0, 4) as $feature)
                                        <li class="flex items-start gap-2.5 text-xs text-slate-600">
                                            <i class="fa-solid fa-circle-check text-emerald-500 mt-0.5 shrink-0 text-[11px]"></i>
                                            <span>{{ $feature }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>

                    <!-- Footer Pricing & Action -->
                    <div class="p-6 pt-0 border-t border-slate-100/80 bg-slate-50/50 mt-4 rounded-b-3xl">
                        <div class="flex items-baseline justify-between pt-4 mb-4">
                            <div>
                                <p class="text-[11px] text-slate-400 font-medium">Harga Paket</p>
                                <div class="flex items-baseline gap-2">
                                    <span class="text-xl font-extrabold text-slate-900">{{ $service->formatted_effective_price }}</span>
                                    @if($service->discount_price && $service->discount_price > 0)
                                        <span class="text-xs text-slate-400 line-through">{{ $service->formatted_price }}</span>
                                    @endif
                                </div>
                            </div>
                            <span class="text-xs text-emerald-600 font-bold bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200">
                                Tersedia
                            </span>
                        </div>

                        <div class="grid grid-cols-2 gap-2">
                            <a href="{{ route('services.show', $service->slug) }}" 
                               class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl bg-white hover:bg-slate-100 text-slate-700 text-xs font-bold border border-slate-200 transition">
                                Detail Paket
                            </a>
                            <a href="{{ route('bookings.create', $service->slug) }}" 
                               class="inline-flex items-center justify-center gap-1.5 px-4 py-2.5 rounded-xl bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold shadow-md shadow-brand-500/20 transition">
                                <span>Pesan Sekarang</span>
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-16 text-center bg-white rounded-3xl border border-slate-200 p-8">
                    <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto text-2xl mb-4">
                        <i class="fa-solid fa-box-open"></i>
                    </div>
                    <h4 class="text-lg font-bold text-slate-900">Layanan tidak ditemukan</h4>
                    <p class="text-sm text-slate-500 mt-1">Tidak ada paket yang sesuai dengan kriteria pencarian Anda.</p>
                    <a href="{{ route('services.index') }}" class="inline-flex items-center gap-2 mt-4 px-4 py-2 rounded-xl bg-brand-600 text-white text-xs font-bold">
                        Reset Filter
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-12">
            {{ $services->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection
