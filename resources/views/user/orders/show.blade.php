@extends('layouts.app')

@section('title', 'Detail Pesanan ' . $order->order_code . ' - LensCraft Studio')

@section('content')
<div class="bg-slate-50 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex items-center justify-between mb-8">
            <div>
                <a href="{{ route('user.orders.index') }}" class="inline-flex items-center gap-1.5 text-xs text-slate-500 hover:text-brand-600 font-semibold transition mb-1">
                    <i class="fa-solid fa-arrow-left text-[10px]"></i>
                    <span>Kembali ke Riwayat Pesanan</span>
                </a>
                <h1 class="text-2xl font-extrabold text-slate-900">Detail Pesanan {{ $order->order_code }}</h1>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('invoices.show', $order->id) }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-bold transition shadow-sm">
                    <i class="fa-solid fa-file-invoice text-brand-600"></i>
                    <span>Buka Invoice</span>
                </a>

                @if($order->status === 'pending')
                    <a href="{{ route('payments.show', $order->id) }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-md shadow-emerald-500/20 transition">
                        <i class="fa-solid fa-credit-card"></i>
                        <span>Bayar Sekarang</span>
                    </a>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Left 2 Cols: Main Info -->
            <div class="md:col-span-2 space-y-6">
                <!-- Status Card -->
                <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-[11px] text-slate-400 font-semibold uppercase">Status Pesanan</p>
                        <p class="text-lg font-extrabold text-slate-900 mt-0.5">{{ $order->status_label }}</p>
                    </div>
                    <span class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-bold border {{ $order->status_badge_class }}">
                        {{ $order->status_label }}
                    </span>
                </div>

                <!-- Session Details -->
                <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4">
                    <h3 class="text-sm font-bold text-slate-900 border-b border-slate-100 pb-3">Informasi Jadwal & Lokasi</h3>

                    <div class="grid grid-cols-2 gap-4 text-xs">
                        <div>
                            <span class="text-slate-400">Tanggal Dokumentasi:</span>
                            <p class="font-bold text-slate-800 mt-0.5">{{ $order->booking_date->format('d F Y') }}</p>
                        </div>
                        <div>
                            <span class="text-slate-400">Slot Waktu:</span>
                            <p class="font-bold text-slate-800 mt-0.5">{{ $order->booking_time }}</p>
                        </div>
                        <div class="col-span-2">
                            <span class="text-slate-400">Alamat / Lokasi:</span>
                            <p class="font-bold text-slate-800 mt-0.5">{{ $order->location }}</p>
                        </div>
                        @if($order->notes)
                            <div class="col-span-2">
                                <span class="text-slate-400">Catatan Khusus:</span>
                                <p class="text-slate-700 italic mt-0.5">{{ $order->notes }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Package Info -->
                <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4">
                    <h3 class="text-sm font-bold text-slate-900 border-b border-slate-100 pb-3">Paket yang Dipesan</h3>

                    <div class="flex items-start gap-4">
                        <img src="{{ $order->service->thumbnail }}" alt="{{ $order->service->name }}" class="w-24 h-24 object-cover rounded-2xl shrink-0">
                        <div>
                            <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-600 mb-1">
                                {{ $order->service->category_label }}
                            </span>
                            <h4 class="text-base font-extrabold text-slate-900">{{ $order->service->name }}</h4>
                            <p class="text-xs text-slate-500 mt-1">Durasi: {{ $order->service->duration }}</p>
                            <p class="text-xs font-bold text-brand-600 mt-1">Rp {{ number_format((float)$order->package_price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Col: Payment Summary -->
            <div class="space-y-6">
                <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4 text-xs">
                    <h3 class="text-sm font-bold text-slate-900 border-b border-slate-100 pb-3">Ringkasan Pembayaran</h3>

                    <div class="space-y-2.5">
                        <div class="flex justify-between text-slate-600">
                            <span>Harga Paket:</span>
                            <span class="font-bold text-slate-800">Rp {{ number_format((float)$order->package_price, 0, ',', '.') }}</span>
                        </div>
                        @if($order->additional_fee > 0)
                            <div class="flex justify-between text-slate-600">
                                <span>Biaya Tambahan:</span>
                                <span class="font-bold text-slate-800">Rp {{ number_format((float)$order->additional_fee, 0, ',', '.') }}</span>
                            </div>
                        @endif
                        <div class="pt-3 border-t border-slate-100 flex justify-between font-bold text-slate-900">
                            <span>Total Tagihan:</span>
                            <span class="text-base font-extrabold text-brand-600">{{ $order->formatted_total }}</span>
                        </div>
                    </div>

                    <div class="pt-3 border-t border-slate-100 space-y-2">
                        <div class="flex justify-between">
                            <span class="text-slate-400">Status Bayar:</span>
                            <span class="font-bold {{ optional($order->payment)->status === 'paid' ? 'text-emerald-600' : 'text-amber-600' }}">
                                {{ optional($order->payment)->status_label ?? 'Belum Dibayar' }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400">Metode:</span>
                            <span class="font-semibold text-slate-800">{{ optional($order->payment)->method_label ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                @if($order->status === 'pending')
                    <form action="{{ route('user.orders.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?');">
                        @csrf
                        <button type="submit" class="w-full py-2.5 rounded-xl border border-rose-200 text-rose-600 hover:bg-rose-50 text-xs font-bold transition">
                            Batalkan Pesanan
                        </button>
                    </form>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection
