@extends('layouts.admin')

@section('title', 'Laporan Keuangan & Pendapatan')
@section('page_title', 'Laporan Keuangan & Arus Kas')

@section('content')
<div class="space-y-8">
    
    <!-- Top Action & Filter Header -->
    <div class="bg-white p-6 rounded-3xl border border-slate-200/90 shadow-sm space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-5">
            <div>
                <h2 class="text-lg font-bold text-slate-900">Filter Laporan Finansial</h2>
                <p class="text-xs text-slate-500">Sesuaikan rentang tanggal, kategori layanan, dan status pembayaran untuk memfilter data.</p>
            </div>

            <!-- Export Buttons -->
            <div class="flex items-center gap-3">
                <!-- Export to Excel Button -->
                <a href="{{ route('admin.reports.export', request()->all()) }}" 
                   class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-md shadow-emerald-500/20 transition">
                    <i class="fa-solid fa-file-excel"></i>
                    <span>Ekspor ke Excel (.csv)</span>
                </a>

                <!-- Print / PDF Button -->
                <a href="{{ route('admin.reports.print', request()->all()) }}" target="_blank" 
                   class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold shadow-sm transition">
                    <i class="fa-solid fa-print"></i>
                    <span>Cetak Laporan / PDF</span>
                </a>
            </div>
        </div>

        <!-- Filter Form -->
        <form action="{{ route('admin.reports.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
            <div>
                <label class="block text-[11px] font-bold text-slate-500 mb-1">Mulai Tanggal</label>
                <input type="date" name="start_date" value="{{ $startDate }}" 
                       class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:ring-2 focus:ring-brand-500">
            </div>

            <div>
                <label class="block text-[11px] font-bold text-slate-500 mb-1">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ $endDate }}" 
                       class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:ring-2 focus:ring-brand-500">
            </div>

            <div>
                <label class="block text-[11px] font-bold text-slate-500 mb-1">Kategori Layanan</label>
                <select name="category" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:ring-2 focus:ring-brand-500 bg-white">
                    <option value="all" {{ $category === 'all' ? 'selected' : '' }}>Semua Kategori</option>
                    <option value="wisuda" {{ $category === 'wisuda' ? 'selected' : '' }}>Foto Wisuda</option>
                    <option value="umkm" {{ $category === 'umkm' ? 'selected' : '' }}>Foto Produk UMKM</option>
                    <option value="acara" {{ $category === 'acara' ? 'selected' : '' }}>Dokumentasi Acara</option>
                    <option value="video_promosi" {{ $category === 'video_promosi' ? 'selected' : '' }}>Video Promosi</option>
                </select>
            </div>

            <div>
                <label class="block text-[11px] font-bold text-slate-500 mb-1">Status Pembayaran</label>
                <select name="payment_status" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:ring-2 focus:ring-brand-500 bg-white">
                    <option value="all" {{ $paymentStatus === 'all' ? 'selected' : '' }}>Semua Status</option>
                    <option value="paid" {{ $paymentStatus === 'paid' ? 'selected' : '' }}>Lunas (Paid)</option>
                    <option value="unpaid" {{ $paymentStatus === 'unpaid' ? 'selected' : '' }}>Belum Lunas (Unpaid)</option>
                </select>
            </div>

            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 py-2 rounded-xl bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold transition shadow-sm">
                    Terapkan Filter
                </button>
                <a href="{{ route('admin.reports.index') }}" class="px-3 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-bold transition" title="Reset">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Financial KPI Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- 1: Total Pendapatan Lunas -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200/90 shadow-sm relative overflow-hidden">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Pendapatan (Lunas)</span>
                <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-money-bill-wave"></i>
                </div>
            </div>
            <p class="text-2xl font-black text-slate-900 mt-3">
                Rp {{ number_format($totalRevenue, 0, ',', '.') }}
            </p>
            <p class="text-xs text-emerald-600 font-semibold mt-1">
                {{ $totalPaidCount }} Transaksi Berhasil
            </p>
        </div>

        <!-- 2: Rata-Rata Nilai Order -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200/90 shadow-sm relative overflow-hidden">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Rata-Rata Transaksi</span>
                <div class="w-10 h-10 rounded-xl bg-brand-100 text-brand-600 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-chart-pie"></i>
                </div>
            </div>
            <p class="text-2xl font-black text-slate-900 mt-3">
                Rp {{ number_format($averageOrderValue, 0, ',', '.') }}
            </p>
            <p class="text-xs text-slate-400 mt-1">
                Per transaksi sukses
            </p>
        </div>

        <!-- 3: Piutang / Pending Payment -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200/90 shadow-sm relative overflow-hidden">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Menunggu Pembayaran</span>
                <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                </div>
            </div>
            <p class="text-2xl font-black text-slate-900 mt-3">
                Rp {{ number_format($totalUnpaidAmount, 0, ',', '.') }}
            </p>
            <p class="text-xs text-amber-600 font-semibold mt-1">
                {{ $totalUnpaidCount }} Pesanan Belum Selesai
            </p>
        </div>

        <!-- 4: Periode Laporan -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200/90 shadow-sm relative overflow-hidden">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Rentang Waktu</span>
                <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-calendar-days"></i>
                </div>
            </div>
            <p class="text-sm font-black text-slate-900 mt-3">
                {{ date('d M Y', strtotime($startDate)) }}
            </p>
            <p class="text-xs text-slate-500">
                s/d {{ date('d M Y', strtotime($endDate)) }}
            </p>
        </div>
    </div>

    <!-- Category & Payment Method Breakdown Graphs / Bars -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Category Breakdown -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200/90 shadow-sm space-y-4">
            <h3 class="text-sm font-bold text-slate-900 flex items-center justify-between">
                <span>Pendapatan Berdasarkan Kategori Layanan</span>
                <i class="fa-solid fa-layer-group text-slate-400 text-xs"></i>
            </h3>

            <div class="space-y-3 pt-2">
                @foreach($categoryRevenue as $cName => $cSum)
                    @php 
                        $percentage = $totalRevenue > 0 ? round(($cSum / $totalRevenue) * 100, 1) : 0;
                    @endphp
                    <div>
                        <div class="flex justify-between text-xs mb-1">
                            <span class="font-bold text-slate-700">{{ $cName }}</span>
                            <span class="font-mono font-bold text-slate-900">Rp {{ number_format($cSum, 0, ',', '.') }} ({{ $percentage }}%)</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                            <div class="bg-brand-600 h-2.5 rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Payment Method Breakdown -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200/90 shadow-sm space-y-4">
            <h3 class="text-sm font-bold text-slate-900 flex items-center justify-between">
                <span>Volume Berdasarkan Kanal Pembayaran</span>
                <i class="fa-solid fa-wallet text-slate-400 text-xs"></i>
            </h3>

            <div class="space-y-3 pt-2">
                @forelse($methodRevenue as $mKey => $mSum)
                    @php 
                        $mPercentage = $totalRevenue > 0 ? round(($mSum / $totalRevenue) * 100, 1) : 0;
                    @endphp
                    <div>
                        <div class="flex justify-between text-xs mb-1">
                            <span class="font-bold text-slate-700 uppercase">{{ str_replace('_', ' ', $mKey) }}</span>
                            <span class="font-mono font-bold text-slate-900">Rp {{ number_format($mSum, 0, ',', '.') }} ({{ $mPercentage }}%)</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                            <div class="bg-emerald-600 h-2.5 rounded-full transition-all duration-500" style="width: {{ $mPercentage }}%"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-slate-400 py-6 text-center">Belum ada transaksi pembayaran dalam periode ini.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Detailed Transactions Table -->
    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-base font-bold text-slate-900">Daftar Transaksi & Pembayaran Finansial</h3>
                <p class="text-xs text-slate-500">Rincian mutasi transaksi yang terverifikasi dalam sistem.</p>
            </div>
            <span class="text-xs font-semibold text-slate-500 bg-slate-100 px-3 py-1 rounded-full">
                {{ $payments->total() }} Data Ditemukan
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-slate-50 text-slate-400 font-bold uppercase tracking-wider border-b border-slate-200">
                        <th class="py-3 px-6">No. Transaksi</th>
                        <th class="py-3 px-6">Invoice</th>
                        <th class="py-3 px-6">Pelanggan</th>
                        <th class="py-3 px-6">Layanan</th>
                        <th class="py-3 px-6">Metode</th>
                        <th class="py-3 px-6 text-center">Status</th>
                        <th class="py-3 px-6">Waktu Lunas</th>
                        <th class="py-3 px-6 text-right">Nominal (Rp)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($payments as $payment)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-4 px-6 font-mono font-bold text-slate-900">
                                {{ $payment->transaction_code }}
                                <p class="text-[10px] font-sans font-normal text-slate-400 mt-0.5">{{ $payment->payment_gateway }}</p>
                            </td>
                            <td class="py-4 px-6 font-mono text-slate-700">
                                <a href="{{ route('admin.orders.show', $payment->order_id) }}" class="font-bold hover:text-brand-600 transition">
                                    {{ optional($payment->order)->order_code }}
                                </a>
                            </td>
                            <td class="py-4 px-6">
                                <p class="font-bold text-slate-900">{{ optional($payment->order)->customer_name }}</p>
                                <p class="text-[11px] text-slate-400">{{ optional($payment->order)->customer_phone }}</p>
                            </td>
                            <td class="py-4 px-6">
                                <p class="font-semibold text-slate-800">{{ optional($payment->order->service)->name }}</p>
                                <span class="inline-block mt-0.5 px-2 py-0.5 rounded text-[10px] font-semibold bg-slate-100 text-slate-600">
                                    {{ optional($payment->order->service)->category_label }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-slate-700 font-medium">
                                {{ $payment->method_label }}
                            </td>
                            <td class="py-4 px-6 text-center">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $payment->status_badge_class }}">
                                    {{ $payment->status_label }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-slate-500 text-[11px]">
                                {{ $payment->paid_at ? $payment->paid_at->format('d/m/Y H:i') : '-' }}
                            </td>
                            <td class="py-4 px-6 text-right font-extrabold text-slate-900 text-sm">
                                {{ $payment->formatted_amount }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-12 text-slate-400">Tidak ada riwayat transaksi pada filter ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-6 border-t border-slate-100">
            {{ $payments->withQueryString()->links() }}
        </div>
    </div>

</div>
@endsection
