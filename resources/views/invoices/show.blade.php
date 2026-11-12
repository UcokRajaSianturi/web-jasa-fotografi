@extends('layouts.app')

@section('title', 'Faktur & Invoice ' . $order->order_code . ' - LensCraft Studio')

@section('content')
<div class="bg-slate-50 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Action Toolbar -->
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mb-8">
            <div>
                <a href="{{ route('user.orders.index') }}" class="inline-flex items-center gap-1.5 text-xs text-slate-500 hover:text-brand-600 font-semibold transition mb-1">
                    <i class="fa-solid fa-arrow-left text-[10px]"></i>
                    <span>Kembali ke Riwayat Pesanan</span>
                </a>
                <h1 class="text-2xl font-extrabold text-slate-900">Invoice Resmi Layanan</h1>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('invoices.print', $order->id) }}" target="_blank" 
                   class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold shadow-md shadow-brand-500/20 transition">
                    <i class="fa-solid fa-print"></i>
                    <span>Cetak / Unduh PDF</span>
                </a>
                
                @if($order->status === 'pending' && optional($order->payment)->status === 'unpaid')
                    <a href="{{ route('payments.show', $order->id) }}" 
                       class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-md shadow-emerald-500/20 transition">
                        <i class="fa-solid fa-credit-card"></i>
                        <span>Bayar Sekarang</span>
                    </a>
                @endif
            </div>
        </div>

        <!-- The Printable Invoice Paper Card -->
        <div class="bg-white rounded-3xl p-8 sm:p-12 border border-slate-200 shadow-xl relative overflow-hidden">
            
            <!-- Stamp watermark if PAID -->
            @if(optional($order->payment)->status === 'paid')
                <div class="absolute right-8 top-32 rotate-12 pointer-events-none select-none opacity-20 border-4 border-emerald-600 text-emerald-600 font-black text-4xl px-6 py-2 rounded-2xl uppercase tracking-widest">
                    LUNAS / PAID
                </div>
            @else
                <div class="absolute right-8 top-32 -rotate-12 pointer-events-none select-none opacity-20 border-4 border-amber-600 text-amber-600 font-black text-3xl px-6 py-2 rounded-2xl uppercase tracking-widest">
                    MENUNGGU PEMBAYARAN
                </div>
            @endif

            <!-- Invoice Header -->
            <div class="flex flex-col sm:flex-row justify-between items-start gap-6 pb-8 border-b border-slate-100">
                <div>
                    <x-logo size="md" />
                    <p class="text-[11px] text-slate-400 mt-2">Jl. Studio Kreatif No. 12, Jakarta Selatan | Telp: +62 812-3456-7890</p>
                </div>

                <div class="text-left sm:text-right">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Faktur / Invoice</span>
                    <p class="text-xl font-mono font-extrabold text-slate-900 mt-0.5">{{ $order->order_code }}</p>
                    <p class="text-xs text-slate-500 mt-1">Tanggal Terbit: <strong>{{ $order->created_at->format('d F Y') }}</strong></p>
                    <span class="inline-flex items-center px-3 py-1 mt-2 rounded-full text-xs font-extrabold border {{ optional($order->payment)->status_badge_class }}">
                        {{ optional($order->payment)->status_label ?? 'Belum Dibayar' }}
                    </span>
                </div>
            </div>

            <!-- Billed to & Session Info -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 py-8 border-b border-slate-100 text-xs">
                <div>
                    <h3 class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">Ditagihkan Kepada:</h3>
                    <p class="text-sm font-bold text-slate-900">{{ $order->customer_name }}</p>
                    <p class="text-slate-600 mt-1">Email: {{ $order->customer_email }}</p>
                    <p class="text-slate-600">WhatsApp: {{ $order->customer_phone }}</p>
                </div>

                <div>
                    <h3 class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">Rincian Jadwal & Lokasi:</h3>
                    <p class="text-slate-700">Tanggal Sesi: <strong class="text-slate-900">{{ $order->booking_date->format('d F Y') }}</strong></p>
                    <p class="text-slate-700 mt-1">Slot Waktu: <strong class="text-slate-900">{{ $order->booking_time }}</strong></p>
                    <p class="text-slate-700 mt-1">Lokasi: <span class="text-slate-900">{{ $order->location }}</span></p>
                    @if($order->notes)
                        <p class="text-slate-500 mt-1 italic">Catatan: "{{ $order->notes }}"</p>
                    @endif
                </div>
            </div>

            <!-- Line Items Table -->
            <div class="py-8 border-b border-slate-100">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="text-slate-400 font-bold uppercase tracking-wider border-b border-slate-200/80 pb-3">
                            <th class="py-2.5">Deskripsi Layanan & Fasilitas</th>
                            <th class="py-2.5 text-center">Durasi</th>
                            <th class="py-2.5 text-right">Harga</th>
                            <th class="py-2.5 text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <tr>
                            <td class="py-4">
                                <p class="text-sm font-bold text-slate-900">{{ $order->service->name }}</p>
                                <p class="text-slate-500 text-[11px] mt-0.5">Kategori: {{ $order->service->category_label }}</p>
                                @if(!empty($order->service->features))
                                    <p class="text-[11px] text-slate-400 mt-1">
                                        Termasuk: {{ implode(', ', array_slice($order->service->features, 0, 3)) }}
                                    </p>
                                @endif
                            </td>
                            <td class="py-4 text-center text-slate-600 font-medium">{{ $order->service->duration }}</td>
                            <td class="py-4 text-right text-slate-900 font-bold">Rp {{ number_format((float)$order->package_price, 0, ',', '.') }}</td>
                            <td class="py-4 text-right text-slate-900 font-bold">Rp {{ number_format((float)$order->package_price, 0, ',', '.') }}</td>
                        </tr>
                        @if($order->additional_fee > 0)
                            <tr>
                                <td class="py-3 text-slate-700">Biaya Tambahan / Request Khusus</td>
                                <td class="py-3 text-center">-</td>
                                <td class="py-3 text-right">Rp {{ number_format((float)$order->additional_fee, 0, ',', '.') }}</td>
                                <td class="py-3 text-right font-bold text-slate-900">Rp {{ number_format((float)$order->additional_fee, 0, ',', '.') }}</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Financial Totals -->
            <div class="pt-6 grid grid-cols-1 sm:grid-cols-2 gap-8">
                <!-- Payment Verification info -->
                <div class="text-xs text-slate-500 space-y-2">
                    <p class="font-bold text-slate-800">Informasi Transaksi:</p>
                    <p>Metode Pembayaran: <strong class="text-slate-800">{{ optional($order->payment)->method_label ?? '-' }}</strong></p>
                    <p>Kode Referensi: <span class="font-mono text-slate-700">{{ optional($order->payment)->payment_reference ?? 'MIDTRANS-AUTO-GENERATED' }}</span></p>
                    @if(optional($order->payment)->paid_at)
                        <p>Waktu Lunas: <span class="text-emerald-700 font-semibold">{{ $order->payment->paid_at->format('d/m/Y H:i:s') }} WIB</span></p>
                    @endif

                    <!-- QR verification stamp -->
                    <div class="pt-4 flex items-center gap-3">
                        <div class="w-16 h-16 p-1 bg-white border border-slate-200 rounded-lg shrink-0">
                            <svg class="w-full h-full" viewBox="0 0 100 100" fill="none">
                                <rect width="100" height="100" fill="white"/>
                                <rect x="5" y="5" width="25" height="25" fill="#334155"/>
                                <rect x="9" y="9" width="17" height="17" fill="white"/>
                                <rect x="13" y="13" width="9" height="9" fill="#334155"/>
                                <rect x="70" y="5" width="25" height="25" fill="#334155"/>
                                <rect x="74" y="9" width="17" height="17" fill="white"/>
                                <rect x="78" y="13" width="9" height="9" fill="#334155"/>
                                <rect x="5" y="70" width="25" height="25" fill="#334155"/>
                                <rect x="9" y="74" width="17" height="17" fill="white"/>
                                <rect x="13" y="78" width="9" height="9" fill="#334155"/>
                                <rect x="35" y="35" width="30" height="30" fill="#0284c7"/>
                            </svg>
                        </div>
                        <div class="text-[11px] text-slate-400">
                            <p class="font-bold text-slate-600">Verifikasi Dokumen Elektronik</p>
                            <p>Invoice ini sah dan diproses otomatis oleh sistem LensCraft Studio.</p>
                        </div>
                    </div>
                </div>

                <!-- Grand Total -->
                <div class="space-y-2 text-xs">
                    <div class="flex justify-between text-slate-600">
                        <span>Subtotal:</span>
                        <span class="font-bold text-slate-900">Rp {{ number_format((float)$order->package_price, 0, ',', '.') }}</span>
                    </div>
                    @if($order->additional_fee > 0)
                        <div class="flex justify-between text-slate-600">
                            <span>Biaya Tambahan:</span>
                            <span class="font-bold text-slate-900">Rp {{ number_format((float)$order->additional_fee, 0, ',', '.') }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between text-slate-600">
                        <span>Pajak & Biaya Admin:</span>
                        <span class="font-bold text-emerald-600">Rp 0 (Termasuk)</span>
                    </div>
                    <div class="pt-3 border-t border-slate-200 flex justify-between items-baseline font-bold text-slate-900">
                        <span class="text-sm">Total Tagihan:</span>
                        <span class="text-2xl font-extrabold text-brand-600">{{ $order->formatted_total }}</span>
                    </div>
                </div>
            </div>

            <!-- Footer note -->
            <div class="mt-12 pt-6 border-t border-slate-100 text-center text-[11px] text-slate-400">
                Terima kasih telah mempercayakan momen dokumentasi Anda bersama LensCraft Studio. Untuk pertanyaan seputar invoice ini silakan hubungi kontak support kami di support@lenscraftstudio.id
            </div>

        </div>

    </div>
</div>
@endsection
