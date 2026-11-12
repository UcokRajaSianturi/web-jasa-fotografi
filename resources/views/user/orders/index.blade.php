@extends('layouts.app')

@section('title', 'Pesanan Saya - LensCraft Studio')

@section('content')
<div class="bg-slate-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Riwayat Pesanan Saya</h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">Pantau status konfirmasi jadwal sesi, status transaksi, dan cetak invoice pemesanan Anda.</p>
            </div>

            <a href="{{ route('services.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold shadow-md shadow-brand-500/20 transition">
                <i class="fa-solid fa-plus text-[10px]"></i>
                <span>Pesan Layanan Baru</span>
            </a>
        </div>

        <!-- Status Filter Tabs -->
        <div class="flex flex-wrap items-center gap-2 mb-8 bg-white p-1.5 rounded-2xl border border-slate-200 shadow-sm">
            @foreach(['all' => 'Semua', 'pending' => 'Menunggu Pembayaran', 'confirmed' => 'Terkonfirmasi', 'processing' => 'Sesi Berlangsung', 'completed' => 'Selesai', 'cancelled' => 'Dibatalkan'] as $sKey => $sLabel)
                <a href="{{ route('user.orders.index', ['status' => $sKey]) }}" 
                   class="px-3.5 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 {{ $status === $sKey ? 'bg-brand-600 text-white shadow-sm' : 'text-slate-600 hover:text-brand-600 hover:bg-slate-50' }}">
                    <span>{{ $sLabel }}</span>
                    @if(isset($counts[$sKey]))
                        <span class="px-1.5 py-0.2 rounded-full text-[10px] {{ $status === $sKey ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600' }}">
                            {{ $counts[$sKey] }}
                        </span>
                    @endif
                </a>
            @endforeach
        </div>

        <!-- Orders Table / List -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
            @if($orders->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr class="bg-slate-50 text-slate-400 font-bold uppercase tracking-wider border-b border-slate-200">
                                <th class="py-3.5 px-6">No. Pesanan</th>
                                <th class="py-3.5 px-6">Paket Layanan</th>
                                <th class="py-3.5 px-6">Jadwal Sesi</th>
                                <th class="py-3.5 px-6">Total Biaya</th>
                                <th class="py-3.5 px-6 text-center">Status Pesanan</th>
                                <th class="py-3.5 px-6 text-center">Status Bayar</th>
                                <th class="py-3.5 px-6 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($orders as $order)
                                <tr class="hover:bg-slate-50/80 transition">
                                    <td class="py-4 px-6 font-mono font-bold text-slate-900">
                                        <a href="{{ route('user.orders.show', $order->id) }}" class="hover:text-brand-600 transition">
                                            {{ $order->order_code }}
                                        </a>
                                        <p class="text-[11px] font-sans text-slate-400 font-normal mt-0.5">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                                    </td>
                                    <td class="py-4 px-6">
                                        <p class="font-bold text-slate-900">{{ $order->service->name }}</p>
                                        <span class="inline-block mt-0.5 px-2 py-0.5 rounded text-[10px] font-semibold bg-slate-100 text-slate-600">
                                            {{ $order->service->category_label }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6">
                                        <p class="font-semibold text-slate-800">{{ $order->booking_date->format('d M Y') }}</p>
                                        <p class="text-slate-500 text-[11px] mt-0.5">{{ $order->booking_time }}</p>
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
                                            @if($order->status === 'pending' && optional($order->payment)->status === 'unpaid')
                                                <a href="{{ route('payments.show', $order->id) }}" 
                                                   class="px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-[11px] shadow-sm transition">
                                                    Bayar
                                                </a>
                                            @endif

                                            <a href="{{ route('invoices.show', $order->id) }}" 
                                               class="px-3 py-1.5 rounded-lg bg-white border border-slate-200 hover:bg-slate-100 text-slate-700 font-bold text-[11px] transition" title="Lihat & Cetak Invoice">
                                                <i class="fa-solid fa-file-invoice mr-1 text-brand-600"></i> Invoice
                                            </a>

                                            <a href="{{ route('user.orders.show', $order->id) }}" 
                                               class="p-1.5 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition" title="Detail Pesanan">
                                                <i class="fa-solid fa-chevron-right text-xs"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="p-6 border-t border-slate-100">
                    {{ $orders->withQueryString()->links() }}
                </div>
            @else
                <div class="py-16 text-center p-8">
                    <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto text-2xl mb-4">
                        <i class="fa-solid fa-calendar-xmark"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-900">Belum ada pesanan ditemukan</h3>
                    <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">Anda belum memiliki riwayat pemesanan untuk kategori filter ini.</p>
                    <a href="{{ route('services.index') }}" class="inline-flex items-center gap-2 mt-4 px-4 py-2 rounded-xl bg-brand-600 text-white text-xs font-bold shadow-md shadow-brand-500/20">
                        Jelajahi Paket Layanan
                    </a>
                </div>
            @endif
        </div>

    </div>
</div>
@endsection
