<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - LensCraft Studio</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,600&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
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
<body class="flex min-h-screen text-slate-800 antialiased selection:bg-brand-500 selection:text-white">

    <!-- Sidebar -->
    <aside class="w-64 bg-slate-900 text-slate-300 flex flex-col shrink-0 border-r border-slate-800 min-h-screen">
        <!-- Brand -->
        <div class="h-20 flex items-center px-5 border-b border-slate-800">
            <x-logo size="sm" :dark="true" />
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto">
            <div class="px-3 pb-2 text-[11px] font-bold text-slate-500 uppercase tracking-wider">Navigasi Utama</div>

            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}" 
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.dashboard') ? 'bg-brand-600 text-white shadow-md shadow-brand-500/20' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                <i class="fa-solid fa-gauge-high w-5 text-center"></i>
                <span>Dasbor Overview</span>
            </a>

            <!-- Kelola Layanan (CRUD) -->
            <a href="{{ route('admin.services.index') }}" 
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.services.*') ? 'bg-brand-600 text-white shadow-md shadow-brand-500/20' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                <i class="fa-solid fa-camera w-5 text-center"></i>
                <span>Kelola Layanan</span>
            </a>

            <!-- Kelola Pesanan (CRUD) -->
            <a href="{{ route('admin.orders.index') }}" 
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.orders.*') ? 'bg-brand-600 text-white shadow-md shadow-brand-500/20' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                <i class="fa-solid fa-calendar-check w-5 text-center"></i>
                <span>Kelola Pesanan</span>
            </a>

            <!-- Kelola Pengguna (CRUD) -->
            <a href="{{ route('admin.users.index') }}" 
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.users.*') ? 'bg-brand-600 text-white shadow-md shadow-brand-500/20' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                <i class="fa-solid fa-users w-5 text-center"></i>
                <span>Kelola Pengguna</span>
            </a>

            <div class="px-3 pt-6 pb-2 text-[11px] font-bold text-slate-500 uppercase tracking-wider">Laporan & Finansial</div>

            <!-- Laporan Keuangan -->
            <a href="{{ route('admin.reports.index') }}" 
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.reports.*') ? 'bg-emerald-600 text-white shadow-md shadow-emerald-500/20' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                <i class="fa-solid fa-file-invoice-dollar w-5 text-center text-emerald-400 group-hover:text-white"></i>
                <span>Laporan Keuangan</span>
            </a>

            <div class="px-3 pt-6 pb-2 text-[11px] font-bold text-slate-500 uppercase tracking-wider">Pintasan</div>

            <!-- Ke Halaman Depan -->
            <a href="{{ route('home') }}" target="_blank"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold text-slate-400 hover:text-white hover:bg-slate-800 transition">
                <i class="fa-solid fa-arrow-up-right-from-square w-5 text-center"></i>
                <span>Lihat Website Depan</span>
            </a>
        </nav>

        <!-- User Info & Logout -->
        <div class="p-4 border-t border-slate-800 bg-slate-950/40">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <img src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=0284c7&color=fff' }}" 
                         alt="{{ auth()->user()->name }}" class="w-9 h-9 rounded-full object-cover">
                    <div class="overflow-hidden">
                        <p class="text-xs font-bold text-white truncate">{{ auth()->user()->name }}</p>
                        <p class="text-[11px] text-brand-400 font-medium">{{ auth()->user()->role === 'super_admin' ? 'Super Administrator' : 'Administrator' }}</p>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" title="Keluar" class="p-2 rounded-lg text-slate-400 hover:text-rose-400 hover:bg-slate-800 transition">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content Wrapper -->
    <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">
        <!-- Topbar -->
        <header class="h-20 bg-white border-b border-slate-200 px-6 sm:px-8 flex items-center justify-between shrink-0">
            <div>
                <h1 class="text-lg font-bold text-slate-900">@yield('page_title', 'Dasbor Administrator')</h1>
                <p class="text-xs text-slate-500">Kelola operasional, transaksi, jadwal dokumentasi, dan laporan finansial.</p>
            </div>

            <div class="flex items-center gap-4">
                <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="hidden sm:inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-amber-50 text-amber-700 text-xs font-semibold border border-amber-200">
                    <i class="fa-solid fa-bell text-amber-500"></i>
                    <span>Pesanan Perlu Diproses</span>
                </a>

                <div class="h-8 w-px bg-slate-200"></div>

                <a href="{{ route('home') }}" class="text-sm font-semibold text-slate-600 hover:text-brand-600 transition flex items-center gap-1.5">
                    <i class="fa-solid fa-globe text-xs"></i>
                    <span class="hidden md:inline">Website Utama</span>
                </a>
            </div>
        </header>

        <!-- Flash Messages -->
        <div class="px-6 sm:px-8 pt-6 w-full">
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
        </div>

        <!-- Content Body -->
        <main class="flex-1 p-6 sm:p-8">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
