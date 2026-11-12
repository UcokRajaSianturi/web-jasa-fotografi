@extends('layouts.app')

@section('title', 'LensCraft Studio - Platform Pemesanan Jasa Dokumentasi & Fotografi')

@section('content')
    <!-- Hero Section -->
    <section class="relative bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-amber-50/50 via-slate-50/40 to-white pt-12 pb-24 overflow-hidden border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                
                <!-- Left Column: Copywriting -->
                <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-amber-50 border border-amber-200/80 text-amber-900 text-xs font-bold tracking-wide shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                        <span>Studio Fotografi & Dokumentasi Kreatif</span>
                    </div>

                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-slate-900 tracking-tight leading-[1.15]">
                        Abadikan Setiap Momen Penting dengan <span class="font-serif italic font-normal text-transparent bg-clip-text bg-gradient-to-r from-amber-600 via-amber-500 to-amber-700">Karya Visual Sempurna.</span>
                    </h1>

                    <p class="text-base sm:text-lg text-slate-600 max-w-2xl mx-auto lg:mx-0 leading-relaxed">
                        Layanan dokumentasi lengkap untuk <strong>Wisuda</strong>, <strong>Foto Produk UMKM</strong>, <strong>Dokumentasi Acara</strong>, dan <strong>Video Promosi</strong>. Pemesanan instan dengan Payment Gateway dan cetak invoice otomatis.
                    </p>

                    <!-- CTA Buttons -->
                    <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 pt-2">
                        <a href="{{ route('services.index') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-7 py-3.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-sm shadow-xl shadow-slate-900/20 transition transform hover:-translate-y-0.5 border border-slate-800">
                            <i class="fa-solid fa-calendar-plus text-xs text-amber-400"></i>
                            <span>Pesan Jasa Sekarang</span>
                        </a>

                        <a href="#katalog-layanan" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-7 py-3.5 rounded-xl bg-white hover:bg-slate-50 text-slate-800 font-bold text-sm border border-slate-300 shadow-sm transition">
                            <i class="fa-solid fa-images text-xs text-amber-600"></i>
                            <span>Jelajahi Paket</span>
                        </a>
                    </div>

                    <!-- Trust indicators -->
                    <div class="grid grid-cols-3 gap-6 pt-6 border-t border-slate-200/80 max-w-lg mx-auto lg:mx-0 text-left">
                        <div>
                            <p class="text-2xl sm:text-3xl font-extrabold text-slate-900">{{ $stats['total_orders'] }}+</p>
                            <p class="text-xs font-semibold text-slate-600 mt-0.5">Sesi Dokumentasi</p>
                        </div>
                        <div>
                            <p class="text-2xl sm:text-3xl font-extrabold text-slate-900">{{ $stats['happy_clients'] }}+</p>
                            <p class="text-xs font-semibold text-slate-600 mt-0.5">Pelanggan Puas</p>
                        </div>
                        <div>
                            <p class="text-2xl sm:text-3xl font-extrabold text-brand-600">{{ $stats['satisfaction_rate'] }}</p>
                            <p class="text-xs font-semibold text-slate-600 mt-0.5">Tingkat Kepuasan</p>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Visual Collage -->
                <div class="lg:col-span-5 relative">
                    <div class="relative mx-auto max-w-md lg:max-w-none">
                        <!-- Background glow effect -->
                        <div class="absolute -inset-4 bg-gradient-to-r from-brand-400 to-indigo-400 rounded-3xl opacity-20 blur-2xl"></div>

                        <div class="relative bg-white p-3 rounded-3xl shadow-2xl border border-slate-100">
                            <img src="https://images.unsplash.com/photo-1537633552985-df8429e8048b?auto=format&fit=crop&w=800&q=80" 
                                 alt="Studio Fotografi Profesional" 
                                 class="w-full h-80 object-cover rounded-2xl shadow-inner">

                            <!-- Floating badge 1: Payment Gateway -->
                            <div class="absolute -bottom-6 -left-6 bg-white/95 backdrop-blur-md p-4 rounded-2xl shadow-xl border border-slate-100 flex items-center gap-3">
                                <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-xl shrink-0">
                                    <i class="fa-solid fa-shield-halved"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-600 font-semibold">Integrasi Pembayaran</p>
                                    <p class="text-sm font-bold text-slate-900">QRIS & Virtual Account</p>
                                </div>
                            </div>

                            <!-- Floating badge 2: Cetak Invoice -->
                            <div class="absolute -top-6 -right-6 bg-white/95 backdrop-blur-md p-4 rounded-2xl shadow-xl border border-slate-100 flex items-center gap-3">
                                <div class="w-12 h-12 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center text-xl shrink-0">
                                    <i class="fa-solid fa-file-invoice"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-600 font-semibold">Cetak Otomatis</p>
                                    <p class="text-sm font-bold text-slate-900">Faktur & Invoice Resmi</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 4 Main Categories Highlights -->
    <section class="py-16 bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span class="text-brand-600 font-bold text-xs uppercase tracking-wider">Layanan Unggulan</span>
                <h2 class="text-3xl font-extrabold text-slate-900 mt-2">Solusi Dokumentasi Sesuai Kebutuhan Anda</h2>
                <p class="text-slate-600 text-sm mt-2">Pilih dari 4 kategori layanan utama kami yang didukung tim fotografer dan videografer profesional.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Kategori 1: Foto Wisuda -->
                <a href="{{ route('services.index', ['category' => 'wisuda']) }}" 
                   class="group p-6 rounded-2xl bg-gradient-to-b from-slate-50 to-white border border-slate-200 hover:border-brand-500 hover:shadow-xl hover:shadow-brand-500/10 transition duration-300">
                    <div class="w-14 h-14 rounded-2xl bg-indigo-100 text-indigo-600 flex items-center justify-center text-2xl group-hover:bg-brand-600 group-hover:text-white transition duration-300 mb-5">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 group-hover:text-brand-600 transition">Foto Wisuda</h3>
                    <p class="text-xs text-slate-600 mt-2 leading-relaxed">
                        Abadikan momen kelulusan dengan konsep studio modern atau outdoor kampus bersama keluarga dan teman.
                    </p>
                    <div class="mt-4 flex items-center text-xs font-bold text-brand-600 group-hover:translate-x-1 transition">
                        <span>Lihat Paket Wisuda</span>
                        <i class="fa-solid fa-arrow-right ml-1.5 text-[10px]"></i>
                    </div>
                </a>

                <!-- Kategori 2: Foto Produk UMKM -->
                <a href="{{ route('services.index', ['category' => 'umkm']) }}" 
                   class="group p-6 rounded-2xl bg-gradient-to-b from-slate-50 to-white border border-slate-200 hover:border-brand-500 hover:shadow-xl hover:shadow-brand-500/10 transition duration-300">
                    <div class="w-14 h-14 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center text-2xl group-hover:bg-brand-600 group-hover:text-white transition duration-300 mb-5">
                        <i class="fa-solid fa-bag-shopping"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 group-hover:text-brand-600 transition">Foto Produk UMKM</h3>
                    <p class="text-xs text-slate-600 mt-2 leading-relaxed">
                        Foto katalog marketplace berkualitas tinggi untuk mendongkrak penjualan di Shopee, Tokopedia, dan TikTok Shop.
                    </p>
                    <div class="mt-4 flex items-center text-xs font-bold text-brand-600 group-hover:translate-x-1 transition">
                        <span>Lihat Paket UMKM</span>
                        <i class="fa-solid fa-arrow-right ml-1.5 text-[10px]"></i>
                    </div>
                </a>

                <!-- Kategori 3: Dokumentasi Acara -->
                <a href="{{ route('services.index', ['category' => 'acara']) }}" 
                   class="group p-6 rounded-2xl bg-gradient-to-b from-slate-50 to-white border border-slate-200 hover:border-brand-500 hover:shadow-xl hover:shadow-brand-500/10 transition duration-300">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-2xl group-hover:bg-brand-600 group-hover:text-white transition duration-300 mb-5">
                        <i class="fa-solid fa-champagne-glasses"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 group-hover:text-brand-600 transition">Dokumentasi Acara</h3>
                    <p class="text-xs text-slate-600 mt-2 leading-relaxed">
                        Liputan foto dan video profesional untuk seminar, konferensi, pernikahan, konser, dan gathering perusahaan.
                    </p>
                    <div class="mt-4 flex items-center text-xs font-bold text-brand-600 group-hover:translate-x-1 transition">
                        <span>Lihat Paket Acara</span>
                        <i class="fa-solid fa-arrow-right ml-1.5 text-[10px]"></i>
                    </div>
                </a>

                <!-- Kategori 4: Video Promosi -->
                <a href="{{ route('services.index', ['category' => 'video_promosi']) }}" 
                   class="group p-6 rounded-2xl bg-gradient-to-b from-slate-50 to-white border border-slate-200 hover:border-brand-500 hover:shadow-xl hover:shadow-brand-500/10 transition duration-300">
                    <div class="w-14 h-14 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center text-2xl group-hover:bg-brand-600 group-hover:text-white transition duration-300 mb-5">
                        <i class="fa-solid fa-video"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 group-hover:text-brand-600 transition">Video Promosi</h3>
                    <p class="text-xs text-slate-600 mt-2 leading-relaxed">
                        Konten video reels viral, video profil perusahaan 4K dengan drone, dan iklan brand sinematik.
                    </p>
                    <div class="mt-4 flex items-center text-xs font-bold text-brand-600 group-hover:translate-x-1 transition">
                        <span>Lihat Paket Video</span>
                        <i class="fa-solid fa-arrow-right ml-1.5 text-[10px]"></i>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- Services Catalog Section with Live Category Filter -->
    <section id="katalog-layanan" class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
                <div>
                    <span class="text-brand-600 font-bold text-xs uppercase tracking-wider">Katalog Paket</span>
                    <h2 class="text-3xl font-extrabold text-slate-900 mt-1">Pilihan Paket Dokumentasi</h2>
                    <p class="text-slate-600 text-sm mt-1">Pilih paket terbaik untuk kebutuhan personal maupun bisnis Anda.</p>
                </div>

                <!-- Category Tabs Filter -->
                <div class="flex flex-wrap items-center gap-2 bg-white p-1.5 rounded-xl border border-slate-200 shadow-sm">
                    <a href="{{ route('home', ['category' => 'all']) }}#katalog-layanan" 
                       class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition {{ $selectedCategory === 'all' ? 'bg-brand-600 text-white shadow-sm' : 'text-slate-600 hover:text-brand-600 hover:bg-slate-50' }}">
                        Semua Kategori
                    </a>
                    <a href="{{ route('home', ['category' => 'wisuda']) }}#katalog-layanan" 
                       class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition {{ $selectedCategory === 'wisuda' ? 'bg-brand-600 text-white shadow-sm' : 'text-slate-600 hover:text-brand-600 hover:bg-slate-50' }}">
                        Wisuda
                    </a>
                    <a href="{{ route('home', ['category' => 'umkm']) }}#katalog-layanan" 
                       class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition {{ $selectedCategory === 'umkm' ? 'bg-brand-600 text-white shadow-sm' : 'text-slate-600 hover:text-brand-600 hover:bg-slate-50' }}">
                        Produk UMKM
                    </a>
                    <a href="{{ route('home', ['category' => 'acara']) }}#katalog-layanan" 
                       class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition {{ $selectedCategory === 'acara' ? 'bg-brand-600 text-white shadow-sm' : 'text-slate-600 hover:text-brand-600 hover:bg-slate-50' }}">
                        Dokumentasi Acara
                    </a>
                    <a href="{{ route('home', ['category' => 'video_promosi']) }}#katalog-layanan" 
                       class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition {{ $selectedCategory === 'video_promosi' ? 'bg-brand-600 text-white shadow-sm' : 'text-slate-600 hover:text-brand-600 hover:bg-slate-50' }}">
                        Video Promosi
                    </a>
                </div>
            </div>

            <!-- Services Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($services as $service)
                    <div class="bg-white rounded-3xl overflow-hidden border border-slate-200/90 shadow-sm hover:shadow-xl hover:-translate-y-1 transition duration-300 flex flex-col justify-between group">
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
                                            <i class="fa-solid fa-fire-flame-curved text-[10px]"></i> Terpopuler
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

                                <!-- Features list bullet points -->
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

                        <!-- Card Footer: Pricing & Booking Action -->
                        <div class="p-6 pt-0 border-t border-slate-100/80 bg-slate-50/50 mt-4 rounded-b-3xl">
                            <div class="flex items-baseline justify-between pt-4 mb-4">
                                <div>
                                    <p class="text-[11px] text-slate-400 font-medium">Mulai dari</p>
                                    <div class="flex items-baseline gap-2">
                                        <span class="text-xl font-extrabold text-slate-900">{{ $service->formatted_effective_price }}</span>
                                        @if($service->discount_price && $service->discount_price > 0)
                                            <span class="text-xs text-slate-400 line-through">{{ $service->formatted_price }}</span>
                                        @endif
                                    </div>
                                </div>
                                <span class="text-xs text-emerald-600 font-bold bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200">
                                    Slot Tersedia
                                </span>
                            </div>

                            <div class="grid grid-cols-2 gap-2">
                                <a href="{{ route('services.show', $service->slug) }}" 
                                   class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl bg-white hover:bg-slate-100 text-slate-700 text-xs font-bold border border-slate-200 transition">
                                    Detail Paket
                                </a>
                                <a href="{{ route('bookings.create', $service->slug) }}" 
                                   class="inline-flex items-center justify-center gap-1.5 px-4 py-2.5 rounded-xl bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold shadow-md shadow-brand-500/20 transition">
                                    <span>Pesan</span>
                                    <i class="fa-solid fa-chevron-right text-[10px]"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-16 text-center bg-white rounded-3xl border border-slate-200 p-8">
                        <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto text-2xl mb-4">
                            <i class="fa-solid fa-box-open"></i>
                        </div>
                        <h4 class="text-lg font-bold text-slate-900">Belum ada paket untuk kategori ini</h4>
                        <p class="text-sm text-slate-500 mt-1">Silakan pilih kategori lain atau kembali ke seluruh katalog layanan.</p>
                        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 mt-4 px-4 py-2 rounded-xl bg-brand-600 text-white text-xs font-bold">
                            Tampilkan Semua Paket
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Why Choose Us & Platform Features -->
    <section id="tentang-kami" class="py-20 bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-brand-600 font-bold text-xs uppercase tracking-wider">Mengapa Memilih Kami</span>
                <h2 class="text-3xl font-extrabold text-slate-900 mt-2">Standar Kualitas & Layanan Terdepan</h2>
                <p class="text-slate-600 text-sm mt-2">Platform kami dirancang untuk memberikan kemudahan proses dari pemesanan hingga penyerahan hasil.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Feature 1 -->
                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100 text-center">
                    <div class="w-14 h-14 rounded-2xl bg-brand-100 text-brand-600 flex items-center justify-center text-2xl mx-auto mb-4">
                        <i class="fa-solid fa-bolt"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-900">Pemesanan Praktis Online</h3>
                    <p class="text-xs text-slate-600 mt-2 leading-relaxed">
                        Pilih jadwal, tanggal, dan lokasi secara instan tanpa perlu bolak-balik chat manual yang memakan waktu.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100 text-center">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-2xl mx-auto mb-4">
                        <i class="fa-solid fa-credit-card"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-900">Payment Gateway Terintegrasi</h3>
                    <p class="text-xs text-slate-600 mt-2 leading-relaxed">
                        Sistem pembayaran aman mendukung QRIS, Virtual Account BCA, Mandiri, BNI, dan Kartu Kredit dengan konfirmasi otomatis.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100 text-center">
                    <div class="w-14 h-14 rounded-2xl bg-indigo-100 text-indigo-600 flex items-center justify-center text-2xl mx-auto mb-4">
                        <i class="fa-solid fa-file-invoice"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-900">Cetak Invoice Otomatis</h3>
                    <p class="text-xs text-slate-600 mt-2 leading-relaxed">
                        Faktur resmi dan tanda terima dengan QR verification langsung diterbitkan dan siap diunduh atau dicetak kapan saja.
                    </p>
                </div>

                <!-- Feature 4 -->
                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100 text-center">
                    <div class="w-14 h-14 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center text-2xl mx-auto mb-4">
                        <i class="fa-solid fa-medal"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-900">Fotografer Terverifikasi</h3>
                    <p class="text-xs text-slate-600 mt-2 leading-relaxed">
                        Semua fotografer dan videografer mitra menggunakan kamera sinema standar profesional dan berpengalaman di bidangnya.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works (Cara Pesan) -->
    <section id="cara-pesan" class="py-20 bg-slate-50 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-brand-600 font-bold text-xs uppercase tracking-wider">Alur Pemesanan</span>
                <h2 class="text-3xl font-extrabold text-slate-900 mt-2">4 Langkah Mudah Pesan Dokumentasi</h2>
                <p class="text-slate-600 text-sm mt-2">Proses cepat tanpa ribet, mulai dari pemilihan paket hingga serah terima hasil foto & video.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 relative">
                <!-- Step 1 -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm text-center relative z-10">
                    <div class="w-12 h-12 rounded-full bg-brand-600 text-white font-extrabold text-lg flex items-center justify-center mx-auto mb-4 shadow-md shadow-brand-500/20">
                        1
                    </div>
                    <h4 class="text-base font-bold text-slate-900">Pilih Layanan & Paket</h4>
                    <p class="text-xs text-slate-600 mt-2">
                        Pilih paket sesuai kebutuhan (Wisuda, UMKM, Acara, atau Video Promosi).
                    </p>
                </div>

                <!-- Step 2 -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm text-center relative z-10">
                    <div class="w-12 h-12 rounded-full bg-brand-600 text-white font-extrabold text-lg flex items-center justify-center mx-auto mb-4 shadow-md shadow-brand-500/20">
                        2
                    </div>
                    <h4 class="text-base font-bold text-slate-900">Tentukan Jadwal & Lokasi</h4>
                    <p class="text-xs text-slate-600 mt-2">
                        Isi form tanggal, jam sesi foto/video, alamat lokasi, dan catatan khusus.
                    </p>
                </div>

                <!-- Step 3 -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm text-center relative z-10">
                    <div class="w-12 h-12 rounded-full bg-brand-600 text-white font-extrabold text-lg flex items-center justify-center mx-auto mb-4 shadow-md shadow-brand-500/20">
                        3
                    </div>
                    <h4 class="text-base font-bold text-slate-900">Bayar via Payment Gateway</h4>
                    <p class="text-xs text-slate-600 mt-2">
                        Bayar praktis dengan QRIS atau Virtual Account. Invoice otomatis terbit.
                    </p>
                </div>

                <!-- Step 4 -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm text-center relative z-10">
                    <div class="w-12 h-12 rounded-full bg-emerald-600 text-white font-extrabold text-lg flex items-center justify-center mx-auto mb-4 shadow-md shadow-emerald-500/20">
                        4
                    </div>
                    <h4 class="text-base font-bold text-slate-900">Sesi Foto & Terima Hasil</h4>
                    <p class="text-xs text-slate-600 mt-2">
                        Fotografer hadir tepat waktu. File hasil edit dibagikan via Google Drive / Flashdisk.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-brand-600 font-bold text-xs uppercase tracking-wider">Testimoni Klien</span>
                <h2 class="text-3xl font-extrabold text-slate-900 mt-2">Apa Kata Mereka Tentang LensCraft Studio?</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-4">
                    <div class="flex text-amber-400 gap-1 text-sm">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                    </div>
                    <p class="text-xs sm:text-sm text-slate-600 italic leading-relaxed">
                        "Foto wisuda keluarga kami hasilnya sangat memuaskan! Tone warnanya clean, fotografernya ramah dan jago mengarahkan gaya orang tua yang biasanya kaku di depan kamera."
                    </p>
                    <div class="flex items-center gap-3 pt-2">
                        <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=128&q=80" alt="Siti N." class="w-10 h-10 rounded-full object-cover">
                        <div>
                            <p class="text-xs font-bold text-slate-900">Siti Nurhaliza</p>
                            <p class="text-[11px] text-slate-500">Wisudawati Universitas Indonesia</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-4">
                    <div class="flex text-amber-400 gap-1 text-sm">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                    </div>
                    <p class="text-xs sm:text-sm text-slate-600 italic leading-relaxed">
                        "Sebagai pelaku UMKM kuliner, foto produk katalog dari LensCraft bikin penjualan toko online naik 3 kali lipat. Bayar pakai QRIS langsung dapat invoice untuk laporan pembukuan usaha."
                    </p>
                    <div class="flex items-center gap-3 pt-2">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=128&q=80" alt="Budi S." class="w-10 h-10 rounded-full object-cover">
                        <div>
                            <p class="text-xs font-bold text-slate-900">Budi Santoso</p>
                            <p class="text-[11px] text-slate-500">Owner Sambal Bakar Nusantara</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-4">
                    <div class="flex text-amber-400 gap-1 text-sm">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                    </div>
                    <p class="text-xs sm:text-sm text-slate-600 italic leading-relaxed">
                        "Dokumentasi video reels TikTok untuk event peluncuran produk kami tembus 150 ribu views! Tim videografernya sangat mengerti tren visual terkini dan pengerjaannya on-time."
                    </p>
                    <div class="flex items-center gap-3 pt-2">
                        <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=128&q=80" alt="Rina P." class="w-10 h-10 rounded-full object-cover">
                        <div>
                            <p class="text-xs font-bold text-slate-900">Rina Paramitha</p>
                            <p class="text-[11px] text-slate-500">Brand Manager GlowSkin ID</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Bottom CTA Banner -->
    <section class="py-16 bg-gradient-to-r from-brand-700 via-brand-600 to-indigo-700 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-6">
            <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Siap Mengabadikan Momen Istimewa Anda?</h2>
            <p class="text-brand-100 max-w-xl mx-auto text-sm sm:text-base leading-relaxed">
                Pesan sekarang dan dapatkan penawaran harga promo khusus untuk sesi dokumentasi Anda minggu ini.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-2">
                <a href="{{ route('services.index') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3.5 rounded-xl bg-white text-brand-700 hover:bg-slate-100 font-extrabold text-sm shadow-xl transition">
                    <i class="fa-solid fa-calendar-check"></i>
                    <span>Pilih Paket Sekarang</span>
                </a>
                <a href="https://wa.me/6281234567890" target="_blank" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3.5 rounded-xl bg-brand-800/80 hover:bg-brand-900 text-white font-bold text-sm border border-brand-400/30 transition">
                    <i class="fa-brands fa-whatsapp text-emerald-400 text-base"></i>
                    <span>Konsultasi WhatsApp</span>
                </a>
            </div>
        </div>
    </section>
@endsection
