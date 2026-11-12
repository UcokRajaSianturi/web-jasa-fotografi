@extends('layouts.admin')

@section('title', 'Dasbor Administrator')
@section('page_title', 'Ringkasan & Analitik Studio')

@section('content')
<div class="space-y-8">
    
    <!-- KPI Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Card 1: Total Omset -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200/90 shadow-sm relative overflow-hidden">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Pendapatan</span>
                <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-coins"></i>
                </div>
            </div>
            <p class="text-2xl font-black text-slate-900 mt-3">
                Rp {{ number_format($totalRevenue, 0, ',', '.') }}
            </p>
            <p class="text-xs text-emerald-600 font-semibold mt-1 flex items-center gap-1">
                <i class="fa-solid fa-circle-check text-[10px]"></i>
                <span>Dari transaksi terverifikasi Lunas</span>
            </p>
        </div>

        <!-- Card 2: Bulan Ini -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200/90 shadow-sm relative overflow-hidden">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Bulan Ini</span>
                <div class="w-10 h-10 rounded-xl bg-brand-100 text-brand-600 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
            </div>
            <p class="text-2xl font-black text-slate-900 mt-3">
                Rp {{ number_format($thisMonthRevenue, 0, ',', '.') }}
            </p>
            <p class="text-xs text-slate-500 mt-1">
                Periode {{ now()->translatedFormat('F Y') }}
            </p>
        </div>

        <!-- Card 3: Total Pesanan -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200/90 shadow-sm relative overflow-hidden">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Pesanan</span>
                <div class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-calendar-check"></i>
                </div>
            </div>
            <p class="text-2xl font-black text-slate-900 mt-3">
                {{ $totalOrders }} <span class="text-xs font-semibold text-slate-400">Booking</span>
            </p>
            <div class="flex items-center gap-2 mt-1 text-[11px] font-bold">
                <span class="text-emerald-600">{{ $completedOrders }} Selesai</span>
                <span class="text-slate-300">•</span>
                <span class="text-amber-600">{{ $pendingOrders }} Pending</span>
            </div>
        </div>

        <!-- Card 4: Pelanggan & Layanan -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200/90 shadow-sm relative overflow-hidden">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Katalog Layanan</span>
                <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-camera"></i>
                </div>
            </div>
            <p class="text-2xl font-black text-slate-900 mt-3">
                {{ $totalServices }} <span class="text-xs font-semibold text-slate-400">Paket Aktif</span>
            </p>
            <p class="text-xs text-slate-500 mt-1">
                Melayani {{ $totalCustomers }} Pelanggan Terdaftar
            </p>
        </div>
    </div>

    <!-- Quick Action Banner -->
    <div class="bg-gradient-to-r from-slate-900 to-slate-800 text-white p-6 sm:p-8 rounded-3xl shadow-sm flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="space-y-1 text-center md:text-left">
            <h3 class="text-lg font-bold">Pintasan Cepat Operasional</h3>
            <p class="text-xs text-slate-400">Akses cepat menu pengelolaan layanan, pesanan masuk, dan cetak laporan finansial.</p>
        </div>
        <div class="flex flex-wrap items-center justify-center gap-3">
            <a href="{{ route('admin.services.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-brand-600 hover:bg-brand-500 text-white text-xs font-bold transition shadow-sm">
                <i class="fa-solid fa-plus text-[10px]"></i>
                <span>Tambah Layanan Baru</span>
            </a>
            <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-bold transition border border-slate-700">
                <i class="fa-solid fa-calendar-days text-[10px]"></i>
                <span>Kelola Jadwal Pesanan</span>
            </a>
            <a href="{{ route('admin.reports.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold transition shadow-sm">
                <i class="fa-solid fa-file-invoice-dollar text-[10px]"></i>
                <span>Buka Laporan Keuangan</span>
            </a>
        </div>
    </div>

    <!-- Recent Orders Table -->
    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-base font-bold text-slate-900">Pesanan Masuk Terbaru</h3>
                <p class="text-xs text-slate-500">Daftar transaksi dan booking sesi dokumentasi paling baru.</p>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="text-xs font-bold text-brand-600 hover:underline">
                Lihat Semua Pesanan &rarr;
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-slate-50 text-slate-400 font-bold uppercase tracking-wider border-b border-slate-200">
                        <th class="py-3 px-6">Kode Pesanan</th>
                        <th class="py-3 px-6">Pelanggan</th>
                        <th class="py-3 px-6">Layanan</th>
                        <th class="py-3 px-6">Jadwal Sesi</th>
                        <th class="py-3 px-6">Total Biaya</th>
                        <th class="py-3 px-6 text-center">Status Pesanan</th>
                        <th class="py-3 px-6 text-center">Status Bayar</th>
                        <th class="py-3 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($recentOrders as $order)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-4 px-6 font-mono font-bold text-slate-900">
                                {{ $order->order_code }}
                                <p class="text-[10px] font-sans font-normal text-slate-400 mt-0.5">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                            </td>
                            <td class="py-4 px-6">
                                <p class="font-bold text-slate-900">{{ $order->customer_name }}</p>
                                <p class="text-[11px] text-slate-500">{{ $order->customer_phone }}</p>
                            </td>
                            <td class="py-4 px-6">
                                <p class="font-bold text-slate-800">{{ $order->service->name }}</p>
                                <span class="inline-block mt-0.5 px-2 py-0.5 rounded text-[10px] font-semibold bg-slate-100 text-slate-600">
                                    {{ $order->service->category_label }}
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                <p class="font-semibold text-slate-800">{{ $order->booking_date->format('d M Y') }}</p>
                                <p class="text-slate-400 text-[11px]">{{ $order->booking_time }}</p>
                            </td>
                            <td class="py-4 px-6 font-bold text-slate-900">
                                {{ $order->formatted_total }}
                            </td>
                            <td class="py-4 px-6 text-center">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold border {{ $order->status_badge_class }}">
                                    {{ $order->status_label }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold border {{ optional($order->payment)->status_badge_class }}">
                                    {{ optional($order->payment)->status_label ?? 'Unpaid' }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" 
                                       class="px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-[11px] transition">
                                        Detail
                                    </a>
                                    <a href="{{ route('invoices.show', $order->id) }}" target="_blank"
                                       class="p-1.5 rounded-lg text-slate-400 hover:text-brand-600 transition" title="Invoice">
                                        <i class="fa-solid fa-file-invoice text-sm"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-8 text-slate-400">Belum ada pesanan terbaru.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
