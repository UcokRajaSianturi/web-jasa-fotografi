@extends('layouts.admin')

@section('title', 'Detail Pesanan ' . $order->order_code)
@section('page_title', 'Kelola Pesanan ' . $order->order_code)

@section('content')
<div class="max-w-5xl space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center gap-1.5 text-xs text-slate-500 hover:text-brand-600 font-semibold transition">
            <i class="fa-solid fa-arrow-left text-[10px]"></i>
            <span>Kembali ke Daftar Pesanan</span>
        </a>

        <div class="flex items-center gap-2">
            <a href="{{ route('invoices.show', $order->id) }}" target="_blank" 
               class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-bold transition shadow-sm">
                <i class="fa-solid fa-file-invoice text-brand-600"></i>
                <span>Lihat Invoice</span>
            </a>
            <a href="{{ route('invoices.print', $order->id) }}" target="_blank" 
               class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold transition shadow-sm">
                <i class="fa-solid fa-print"></i>
                <span>Cetak Invoice</span>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left 2 Cols: Order & Schedule Manager -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Status Update Card -->
            <div class="bg-white p-6 rounded-3xl border border-slate-200/90 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Status Pesanan Saat Ini</span>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $order->status_badge_class }}">
                            {{ $order->status_label }}
                        </span>
                        <span class="text-xs text-slate-400 font-mono">{{ $order->order_code }}</span>
                    </div>
                </div>

                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="flex items-center gap-2">
                    @csrf
                    @method('PATCH')
                    <select name="status" class="px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-brand-500 bg-white">
                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }}>Terkonfirmasi</option>
                        <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Sesi Berlangsung</option>
                        <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Selesai</option>
                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                    <button type="submit" class="px-4 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold transition">
                        Update Status
                    </button>
                </form>
            </div>

            <!-- Customer & Service Information -->
            <div class="bg-white p-6 rounded-3xl border border-slate-200/90 shadow-sm space-y-4">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100 pb-2">Informasi Pelanggan & Layanan</h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div>
                        <span class="text-slate-400">Nama Pelanggan:</span>
                        <p class="font-bold text-slate-900 mt-0.5">{{ $order->customer_name }}</p>
                    </div>
                    <div>
                        <span class="text-slate-400">Nomor Telepon / WhatsApp:</span>
                        <p class="font-bold text-slate-900 mt-0.5">{{ $order->customer_phone }}</p>
                    </div>
                    <div>
                        <span class="text-slate-400">Email:</span>
                        <p class="font-bold text-slate-900 mt-0.5">{{ $order->customer_email }}</p>
                    </div>
                    <div>
                        <span class="text-slate-400">Akun Terdaftar:</span>
                        <p class="font-bold text-slate-900 mt-0.5">{{ optional($order->user)->name ?? 'Guest' }}</p>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-start gap-4">
                    <img src="{{ $order->service->thumbnail }}" alt="{{ $order->service->name }}" class="w-16 h-16 rounded-2xl object-cover shrink-0">
                    <div>
                        <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-600 mb-0.5">
                            {{ $order->service->category_label }}
                        </span>
                        <h4 class="text-sm font-bold text-slate-900">{{ $order->service->name }}</h4>
                        <p class="text-xs text-slate-500 mt-0.5">Durasi Sesi: {{ $order->service->duration }} | Tarif: Rp {{ number_format((float)$order->package_price, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <!-- Schedule and Location Editor Form -->
            <div class="bg-white p-6 rounded-3xl border border-slate-200/90 shadow-sm space-y-4">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100 pb-2">Edit Rincian Jadwal & Biaya</h3>

                <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" class="space-y-4 text-xs">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Tanggal Sesi</label>
                            <input type="date" name="booking_date" value="{{ old('booking_date', $order->booking_date->format('Y-m-d')) }}" required
                                   class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-500">
                        </div>

                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Slot Waktu</label>
                            <input type="text" name="booking_time" value="{{ old('booking_time', $order->booking_time) }}" required
                                   class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-500">
                        </div>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Lokasi Sesi / Acara</label>
                        <textarea name="location" rows="2" required 
                                  class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-500">{{ old('location', $order->location) }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Biaya Tambahan / Extra Charge (Rp)</label>
                            <input type="number" name="additional_fee" min="0" step="1000" value="{{ old('additional_fee', (int)$order->additional_fee) }}" 
                                   class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-500">
                        </div>
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Catatan Khusus</label>
                            <input type="text" name="notes" value="{{ old('notes', $order->notes) }}" 
                                   class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-500">
                        </div>
                    </div>

                    <div class="pt-2 flex justify-end">
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-bold transition shadow-sm">
                            Simpan Perubahan Jadwal & Biaya
                        </button>
                    </div>
                </form>
            </div>

        </div>

        <!-- Right Col: Payment Summary & Gateway Info -->
        <div class="space-y-6">
            <div class="bg-white p-6 rounded-3xl border border-slate-200/90 shadow-sm space-y-4 text-xs">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100 pb-2">Informasi Pembayaran</h3>

                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-slate-400">Status Pembayaran:</span>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold border {{ optional($order->payment)->status_badge_class }}">
                            {{ optional($order->payment)->status_label ?? 'Belum Ada' }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-slate-400">Metode Bayar:</span>
                        <span class="font-bold text-slate-800">{{ optional($order->payment)->method_label ?? '-' }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-slate-400">Gateway:</span>
                        <span class="font-mono text-slate-700">{{ optional($order->payment)->payment_gateway ?? '-' }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-slate-400">Kode Transaksi:</span>
                        <span class="font-mono text-slate-700">{{ optional($order->payment)->transaction_code ?? '-' }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-slate-400">Referensi:</span>
                        <span class="font-mono text-slate-700">{{ optional($order->payment)->payment_reference ?? '-' }}</span>
                    </div>

                    @if(optional($order->payment)->paid_at)
                        <div class="flex justify-between">
                            <span class="text-slate-400">Waktu Bayar:</span>
                            <span class="text-emerald-700 font-bold">{{ $order->payment->paid_at->format('d/m/Y H:i') }}</span>
                        </div>
                    @endif
                </div>

                <!-- Price Breakdown -->
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 space-y-2 mt-4">
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
                    <div class="pt-2 border-t border-slate-200 flex justify-between font-bold text-slate-900">
                        <span>Total Tagihan:</span>
                        <span class="text-base text-brand-600 font-extrabold">{{ $order->formatted_total }}</span>
                    </div>
                </div>
            </div>

            <!-- Danger Zone -->
            <div class="bg-rose-50/50 p-6 rounded-3xl border border-rose-200/80 space-y-3 text-xs">
                <h4 class="font-bold text-rose-800">Zona Hapus Pesanan</h4>
                <p class="text-[11px] text-rose-600 leading-relaxed">Menghapus pesanan ini akan menghapus riwayat transaksi dan data pembayaran terkait secara permanen.</p>
                <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('PERINGATAN: Apakah Anda yakin ingin menghapus pesanan ini secara permanen?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-bold transition shadow-sm">
                        Hapus Pesanan Ini
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
