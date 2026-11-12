@extends('layouts.app')

@section('title', $service->name . ' - LensCraft Studio')

@section('content')
<div class="bg-slate-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumbs -->
        <nav class="flex items-center gap-2 text-xs text-slate-500 mb-8 font-medium">
            <a href="{{ route('home') }}" class="hover:text-brand-600 transition">Beranda</a>
            <i class="fa-solid fa-chevron-right text-[10px]"></i>
            <a href="{{ route('services.index') }}" class="hover:text-brand-600 transition">Katalog Layanan</a>
            <i class="fa-solid fa-chevron-right text-[10px]"></i>
            <span class="text-slate-800 font-bold">{{ $service->name }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            <!-- Left Column: Details -->
            <div class="lg:col-span-8 space-y-8">
                <!-- Main Card with Image -->
                <div class="bg-white rounded-3xl overflow-hidden border border-slate-200 shadow-sm">
                    <div class="relative h-96 w-full bg-slate-100">
                        <img src="{{ $service->thumbnail }}" alt="{{ $service->name }}" class="w-full h-full object-cover">
                        
                        <div class="absolute top-6 left-6 flex items-center gap-2">
                            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold bg-white/95 text-slate-800 shadow-md backdrop-blur-sm">
                                {{ $service->category_label }}
                            </span>
                            @if($service->is_popular)
                                <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-xs font-bold bg-brand-600 text-white shadow-md">
                                    <i class="fa-solid fa-fire text-xs"></i> Terpopuler
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="p-8">
                        <h1 class="text-3xl font-extrabold text-slate-900">{{ $service->name }}</h1>
                        <p class="text-sm text-slate-500 mt-2 font-medium">{{ $service->short_description }}</p>

                        <!-- Key Highlights -->
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 my-6 p-4 rounded-2xl bg-slate-50 border border-slate-100">
                            <div>
                                <p class="text-[11px] text-slate-400 font-medium">Durasi Sesi</p>
                                <p class="text-sm font-bold text-slate-800 flex items-center gap-1.5 mt-0.5">
                                    <i class="fa-regular fa-clock text-brand-600 text-xs"></i>
                                    <span>{{ $service->duration }}</span>
                                </p>
                            </div>
                            <div>
                                <p class="text-[11px] text-slate-400 font-medium">Kategori</p>
                                <p class="text-sm font-bold text-slate-800 flex items-center gap-1.5 mt-0.5">
                                    <i class="fa-solid fa-tag text-brand-600 text-xs"></i>
                                    <span>{{ $service->category_label }}</span>
                                </p>
                            </div>
                            <div>
                                <p class="text-[11px] text-slate-400 font-medium">Ketersediaan</p>
                                <p class="text-sm font-bold text-emerald-600 flex items-center gap-1.5 mt-0.5">
                                    <i class="fa-solid fa-circle-check text-xs"></i>
                                    <span>Slot Buka</span>
                                </p>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="prose prose-slate max-w-none text-slate-600 text-sm leading-relaxed pt-2">
                            <h3 class="text-base font-bold text-slate-900 mb-2">Deskripsi Layanan</h3>
                            <p class="whitespace-pre-line">{{ $service->description }}</p>
                        </div>

                        <!-- Features Included -->
                        <div class="mt-8 pt-6 border-t border-slate-100">
                            <h3 class="text-base font-bold text-slate-900 mb-4">Fasilitas & Output yang Anda Dapatkan:</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @if(!empty($service->features))
                                    @foreach($service->features as $feature)
                                        <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-50 border border-slate-100/80">
                                            <div class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0 text-xs">
                                                <i class="fa-solid fa-check"></i>
                                            </div>
                                            <span class="text-xs font-semibold text-slate-700">{{ $feature }}</span>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Related Services -->
                @if($relatedServices->count() > 0)
                    <div>
                        <h3 class="text-xl font-bold text-slate-900 mb-4">Paket Terkait Lainnya</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            @foreach($relatedServices as $related)
                                <a href="{{ route('services.show', $related->slug) }}" 
                                   class="bg-white p-4 rounded-2xl border border-slate-200 hover:border-brand-500 hover:shadow-md transition group">
                                    <img src="{{ $related->thumbnail }}" alt="{{ $related->name }}" class="w-full h-32 object-cover rounded-xl mb-3">
                                    <h4 class="text-xs font-bold text-slate-900 group-hover:text-brand-600 transition line-clamp-1">{{ $related->name }}</h4>
                                    <p class="text-xs font-extrabold text-brand-600 mt-1">{{ $related->formatted_effective_price }}</p>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Right Column: Sticky Booking Card -->
            <div class="lg:col-span-4">
                <div class="sticky top-28 bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-xl space-y-6">
                    <div>
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Investasi Dokumentasi</span>
                        <div class="flex items-baseline gap-2 mt-1">
                            <span class="text-3xl font-extrabold text-slate-900">{{ $service->formatted_effective_price }}</span>
                            @if($service->discount_price && $service->discount_price > 0)
                                <span class="text-sm text-slate-400 line-through">{{ $service->formatted_price }}</span>
                            @endif
                        </div>
                        <p class="text-xs text-emerald-600 font-semibold mt-1 flex items-center gap-1">
                            <i class="fa-solid fa-circle-check text-xs"></i>
                            <span>Harga nett, tanpa biaya tersembunyi</span>
                        </p>
                    </div>

                    <!-- Booking Benefit Points -->
                    <div class="space-y-3 pt-4 border-t border-slate-100 text-xs text-slate-600">
                        <div class="flex items-center gap-2.5">
                            <i class="fa-solid fa-shield-halved text-brand-600 w-4"></i>
                            <span>Pembayaran aman dengan <strong>Payment Gateway</strong></span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <i class="fa-solid fa-file-invoice text-brand-600 w-4"></i>
                            <span>Faktur & <strong>Invoice Otomatis</strong> resmi diterbitkan</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <i class="fa-solid fa-headset text-brand-600 w-4"></i>
                            <span>Dukungan penyesuaian jadwal sesi foto</span>
                        </div>
                    </div>

                    <!-- Direct Book Button -->
                    <a href="{{ route('bookings.create', $service->slug) }}" 
                       class="w-full inline-flex items-center justify-center gap-2 py-3.5 px-6 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-extrabold text-sm shadow-lg shadow-brand-500/30 transition transform hover:-translate-y-0.5">
                        <i class="fa-solid fa-calendar-check"></i>
                        <span>Pesan Paket Ini Sekarang</span>
                    </a>

                    <!-- Contact via WhatsApp -->
                    <a href="https://wa.me/6281234567890?text=Halo%20LensCraft,%20saya%20ingin%20tanya%20tentang%20paket%20{{ urlencode($service->name) }}" 
                       target="_blank"
                       class="w-full inline-flex items-center justify-center gap-2 py-2.5 px-4 rounded-xl bg-slate-50 hover:bg-slate-100 text-slate-700 text-xs font-bold border border-slate-200 transition">
                        <i class="fa-brands fa-whatsapp text-emerald-500 text-sm"></i>
                        <span>Tanya Dulu via WhatsApp</span>
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
