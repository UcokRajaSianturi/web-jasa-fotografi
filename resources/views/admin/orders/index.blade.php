@extends('layouts.admin')

@section('title', 'Kelola Pesanan Masuk')
@section('page_title', 'Manajemen Pesanan & Jadwal Sesi')

@section('content')
<div class="space-y-6">
    
    <!-- Filter and Search Bar -->
    <div class="bg-white p-4 rounded-3xl border border-slate-200/90 shadow-sm">
        <form action="{{ route('admin.orders.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-3">
            <!-- Search text -->
            <div class="relative sm:col-span-2">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari kode invoice, nama, telepon..." 
                       class="w-full pl-9 pr-3 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:ring-2 focus:ring-brand-500">
            </div>

            <!-- Status filter -->
            <div>
                <select name="status" onchange="this.form.submit()" 
                        class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:ring-2 focus:ring-brand-500 bg-white">
                    <option value="all" {{ $status === 'all' ? 'selected' : '' }}>Semua Status</option>
                    <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                    <option value="confirmed" {{ $status === 'confirmed' ? 'selected' : '' }}>Terkonfirmasi</option>
                    <option value="processing" {{ $status === 'processing' ? 'selected' : '' }}>Sesi Berlangsung</option>
                    <option value="completed" {{ $status === 'completed' ? 'selected' : '' }}>Selesai</option>
                    <option value="cancelled" {{ $status === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>

            <!-- Service Filter -->
            <div>
                <select name="service_id" onchange="this.form.submit()" 
                        class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:ring-2 focus:ring-brand-500 bg-white">
                    <option value="">Semua Layanan</option>
                    @foreach($services as $s)
                        <option value="{{ $s->id }}" {{ $serviceId == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>

    <!-- Orders Table -->
    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-slate-50 text-slate-400 font-bold uppercase tracking-wider border-b border-slate-200">
                        <th class="py-3.5 px-6">No. Invoice</th>
                        <th class="py-3.5 px-6">Pelanggan</th>
                        <th class="py-3.5 px-6">Paket Layanan</th>
                        <th class="py-3.5 px-6">Jadwal Sesi</th>
                        <th class="py-3.5 px-6">Total Tagihan</th>
                        <th class="py-3.5 px-6 text-center">Status Pesanan</th>
                        <th class="py-3.5 px-6 text-center">Pembayaran</th>
                        <th class="py-3.5 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($orders as $order)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-4 px-6 font-mono font-bold text-slate-900">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="hover:text-brand-600 transition">
                                    {{ $order->order_code }}
                                </a>
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
                                <!-- Status Changer Dropdown Form -->
                                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" onchange="this.form.submit()" 
                                            class="px-2 py-1 rounded-full text-[10px] font-bold border cursor-pointer {{ $order->status_badge_class }}">
                                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }}>Terkonfirmasi</option>
                                        <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Sesi Berlangsung</option>
                                        <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Selesai</option>
                                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                                    </select>
                                </form>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold border {{ optional($order->payment)->status_badge_class }}">
                                    {{ optional($order->payment)->status_label ?? 'Unpaid' }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" 
                                       class="px-2.5 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-[11px] transition">
                                        Detail
                                    </a>
                                    <a href="{{ route('invoices.show', $order->id) }}" target="_blank"
                                       class="p-1.5 rounded-lg text-slate-400 hover:text-brand-600 transition" title="Buka Invoice">
                                        <i class="fa-solid fa-file-invoice text-sm"></i>
                                    </a>
                                    <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Hapus pesanan ini secara permanen?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg text-rose-500 hover:bg-rose-50 transition" title="Hapus">
                                            <i class="fa-solid fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-10 text-slate-400">Tidak ada data pesanan yang cocok dengan filter.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-6 border-t border-slate-100">
            {{ $orders->withQueryString()->links() }}
        </div>
    </div>

</div>
@endsection
