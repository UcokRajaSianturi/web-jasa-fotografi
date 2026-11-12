<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'LensCraft Studio - Platform Pemesanan Jasa Dokumentasi & Fotografi')</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;0,800;1,500;1,600;1,700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        serif: ['"Playfair Display"', 'Georgia', 'serif'],
                    },
                    colors: {
                        brand: {
                            50: '#f0f7ff',
                            100: '#e0effe',
                            200: '#bae0fd',
                            300: '#7cc8fb',
                            400: '#38bdf8',
                            500: '#0284c7',
                            600: '#0369a1',
                            700: '#075985',
                            800: '#0c4a6e',
                            900: '#082f49',
                            950: '#031726',
                        },
                        amber: {
                            50: '#fffbeb',
                            100: '#fef3c7',
                            200: '#fde68a',
                            300: '#fcd34d',
                            400: '#fbbf24',
                            500: '#f59e0b',
                            600: '#d97706',
                            700: '#b45309',
                            800: '#92400e',
                            900: '#78350f',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
    @stack('styles')
</head>
<body class="flex flex-col min-h-screen text-slate-800 antialiased selection:bg-brand-500 selection:text-white">

    <!-- Navbar -->
    <header class="sticky top-0 z-40 bg-white/90 backdrop-blur-md border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="group block">
                    <x-logo size="md" />
                </a>

                <!-- Desktop Nav -->
                <nav class="hidden md:flex items-center gap-8">
                    <a href="{{ route('home') }}" class="text-sm font-semibold {{ request()->routeIs('home') ? 'text-brand-600' : 'text-slate-600 hover:text-brand-600' }} transition">Beranda</a>
                    <a href="{{ route('services.index') }}" class="text-sm font-semibold {{ request()->routeIs('services.*') ? 'text-brand-600' : 'text-slate-600 hover:text-brand-600' }} transition">Katalog Layanan</a>
                    <a href="{{ route('home') }}#tentang-kami" class="text-sm font-semibold text-slate-600 hover:text-brand-600 transition">Tentang Kami</a>
                    <a href="{{ route('home') }}#cara-pesan" class="text-sm font-semibold text-slate-600 hover:text-brand-600 transition">Cara Pesan</a>
                </nav>

                <!-- Auth / User Action -->
                <div class="flex items-center gap-3">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-slate-900 text-white text-sm font-semibold hover:bg-slate-800 shadow-sm transition">
                                <i class="fa-solid fa-gauge-high text-xs"></i>
                                <span>Panel Admin</span>
                            </a>
                        @endif

                        <a href="{{ route('user.orders.index') }}" class="hidden sm:inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-brand-50 text-brand-700 text-sm font-semibold hover:bg-brand-100 transition border border-brand-200">
                            <i class="fa-solid fa-receipt text-xs"></i>
                            <span>Pesanan Saya</span>
                        </a>

                        <!-- User Dropdown Menu -->
                        <div class="relative group" x-data="{ open: false }">
                            <button type="button" class="flex items-center gap-2 p-1.5 rounded-full hover:bg-slate-100 transition focus:outline-none">
                                <img src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=0284c7&color=fff' }}" 
                                     alt="{{ auth()->user()->name }}" 
                                     class="w-9 h-9 rounded-full object-cover ring-2 ring-brand-500/30">
                                <span class="hidden lg:block text-sm font-semibold text-slate-700 text-left">
                                    {{ Str::limit(auth()->user()->name, 12) }}
                                </span>
                                <i class="fa-solid fa-chevron-down text-xs text-slate-600"></i>
                            </button>

                            <!-- Dropdown List -->
                            <div class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl border border-slate-100 py-2 hidden group-hover:block hover:block z-50">
                                <div class="px-4 py-2 border-b border-slate-100">
                                    <p class="text-xs text-slate-600 font-medium">Masuk sebagai</p>
                                    <p class="text-sm font-bold text-slate-900 truncate">{{ auth()->user()->name }}</p>
                                    <span class="inline-flex items-center px-2 py-0.5 mt-1 rounded text-xs font-semibold {{ auth()->user()->isAdmin() ? 'bg-indigo-100 text-indigo-700' : 'bg-emerald-100 text-emerald-700' }}">
                                        {{ auth()->user()->isAdmin() ? 'Administrator' : 'Pelanggan' }}
                                    </span>
                                </div>

                                <a href="{{ route('user.orders.index') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition">
                                    <i class="fa-solid fa-list-check w-4 text-slate-600"></i>
                                    <span>Riwayat Pesanan</span>
                                </a>

                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-brand-600 hover:bg-brand-50 transition font-medium">
                                        <i class="fa-solid fa-chart-line w-4 text-brand-600"></i>
                                        <span>Dashboard Admin</span>
                                    </a>
                                @endif

                                <div class="border-t border-slate-100 my-1"></div>

                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 text-sm text-rose-600 hover:bg-rose-50 transition">
                                        <i class="fa-solid fa-arrow-right-from-bracket w-4 text-rose-500"></i>
                                        <span>Keluar (Logout)</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-700 hover:text-brand-600 px-3 py-2 transition">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-4 py-2 rounded-lg bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold shadow-sm shadow-brand-500/30 transition">
                            Daftar Akun
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Flash Alert Messages -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full mt-4">
        @if (session('success'))
            <div class="flex items-center gap-3 p-4 mb-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm">
                <i class="fa-solid fa-circle-check text-emerald-500 text-lg"></i>
                <div class="font-medium">{{ session('success') }}</div>
            </div>
        @endif

        @if (session('error'))
            <div class="flex items-center gap-3 p-4 mb-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm">
                <i class="fa-solid fa-circle-xmark text-rose-500 text-lg"></i>
                <div class="font-medium">{{ session('error') }}</div>
            </div>
        @endif

        @if (session('info'))
            <div class="flex items-center gap-3 p-4 mb-4 rounded-xl bg-blue-50 border border-blue-200 text-blue-800 text-sm">
                <i class="fa-solid fa-circle-info text-blue-500 text-lg"></i>
                <div class="font-medium">{{ session('info') }}</div>
            </div>
        @endif
    </div>

    <!-- Main Content -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-300 pt-16 pb-12 border-t border-slate-800 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10 pb-12 border-b border-slate-800">
                <!-- Col 1 -->
                <div class="space-y-4 md:col-span-1">
                    <x-logo size="md" :dark="true" />
                    <p class="text-sm text-slate-400 leading-relaxed">
                        Platform web terpercaya untuk memudahkan pemesanan jasa dokumentasi foto wisuda, foto produk UMKM, acara, dan video promosi profesional.
                    </p>
                    <div class="flex items-center gap-3 pt-2">
                        <a href="#" class="w-9 h-9 rounded-lg bg-slate-800 flex items-center justify-center text-slate-400 hover:text-white hover:bg-brand-600 transition"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" class="w-9 h-9 rounded-lg bg-slate-800 flex items-center justify-center text-slate-400 hover:text-white hover:bg-brand-600 transition"><i class="fa-brands fa-tiktok"></i></a>
                        <a href="#" class="w-9 h-9 rounded-lg bg-slate-800 flex items-center justify-center text-slate-400 hover:text-white hover:bg-brand-600 transition"><i class="fa-brands fa-whatsapp"></i></a>
                        <a href="#" class="w-9 h-9 rounded-lg bg-slate-800 flex items-center justify-center text-slate-400 hover:text-white hover:bg-brand-600 transition"><i class="fa-brands fa-youtube"></i></a>
                    </div>
                </div>

                <!-- Col 2 -->
                <div>
                    <h4 class="text-sm font-bold text-white uppercase tracking-wider mb-4">Layanan Utama</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ route('services.index', ['category' => 'wisuda']) }}" class="text-slate-400 hover:text-brand-400 transition">Foto Wisuda & Studio</a></li>
                        <li><a href="{{ route('services.index', ['category' => 'umkm']) }}" class="text-slate-400 hover:text-brand-400 transition">Foto Produk UMKM & E-Commerce</a></li>
                        <li><a href="{{ route('services.index', ['category' => 'acara']) }}" class="text-slate-400 hover:text-brand-400 transition">Dokumentasi Acara & Seminar</a></li>
                        <li><a href="{{ route('services.index', ['category' => 'video_promosi']) }}" class="text-slate-400 hover:text-brand-400 transition">Video Promosi & Reels TikTok</a></li>
                    </ul>
                </div>

                <!-- Col 3 -->
                <div>
                    <h4 class="text-sm font-bold text-white uppercase tracking-wider mb-4">Fitur Platform</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li class="flex items-center gap-2"><i class="fa-solid fa-credit-card text-xs text-brand-400"></i> Payment Gateway Midtrans</li>
                        <li class="flex items-center gap-2"><i class="fa-solid fa-file-invoice text-xs text-brand-400"></i> Cetak Invoice Otomatis</li>
                        <li class="flex items-center gap-2"><i class="fa-solid fa-sliders text-xs text-brand-400"></i> Manajemen Data CRUD</li>
                        <li class="flex items-center gap-2"><i class="fa-solid fa-chart-pie text-xs text-brand-400"></i> Laporan Keuangan PDF/Excel</li>
                    </ul>
                </div>

                <!-- Col 4 -->
                <div>
                    <h4 class="text-sm font-bold text-white uppercase tracking-wider mb-4">Hubungi Studio</h4>
                    <ul class="space-y-3 text-sm text-slate-400">
                        <li class="flex items-start gap-3">
                            <i class="fa-solid fa-location-dot text-brand-400 mt-1"></i>
                            <span>Jl. Studio Kreatif No. 12, Jakarta Selatan, Indonesia</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fa-solid fa-phone text-brand-400"></i>
                            <span>+62 812-3456-7890</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fa-solid fa-envelope text-brand-400"></i>
                            <span>booking@lenscraftstudio.id</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-400 gap-4">
                <p>&copy; {{ date('Y') }} LensCraft Studio. Seluruh hak cipta dilindungi.</p>
                <div class="flex items-center gap-6">
                    <span class="hover:text-slate-300">Syarat & Ketentuan</span>
                    <span class="hover:text-slate-300">Kebijakan Privasi</span>
                    <span class="hover:text-slate-300">Bantuan & FAQ</span>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
