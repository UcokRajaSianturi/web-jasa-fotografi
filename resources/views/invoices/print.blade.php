<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Invoice - {{ $order->order_code }}</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; padding: 0 !important; }
            .print-shadow-none { box-shadow: none !important; border: 1px solid #e2e8f0 !important; }
        }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 p-4 sm:p-10 antialiased">

    <!-- Top floating print button for browser view -->
    <div class="max-w-4xl mx-auto mb-6 flex justify-between items-center no-print">
        <a href="{{ route('invoices.show', $order->id) }}" class="inline-flex items-center text-xs font-semibold text-slate-600 hover:text-slate-900 bg-white px-4 py-2 rounded-xl shadow-sm border border-slate-200">
            &larr; Kembali ke Detail Invoice
        </a>
        <div class="flex items-center gap-3">
            <button onclick="window.print()" class="px-5 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-md transition cursor-pointer">
                Cetak / Simpan PDF
            </button>
        </div>
    </div>

    <!-- Invoice Sheet (A4 format) -->
    <div class="max-w-4xl mx-auto bg-white p-10 sm:p-14 rounded-3xl shadow-xl print-shadow-none relative">
        
        <!-- Header -->
        <div class="flex justify-between items-start pb-8 border-b-2 border-slate-900">
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">LensCraft<span class="text-blue-600">.</span></h1>
                <p class="text-xs text-slate-500 font-semibold tracking-wider uppercase mt-1">Studio & Jasa Dokumentasi Profesional</p>
                <p class="text-xs text-slate-500 mt-1">Jl. Studio Kreatif No. 12, Jakarta Selatan, Indonesia</p>
                <p class="text-xs text-slate-500">WhatsApp: +62 812-3456-7890 | Email: billing@lenscraftstudio.id</p>
            </div>
            <div class="text-right">
                <span class="text-xs font-extrabold uppercase tracking-widest text-slate-400">FAKTUR / INVOICE</span>
                <p class="text-2xl font-mono font-black text-slate-900 mt-1">{{ $order->order_code }}</p>
                <p class="text-xs text-slate-600 mt-1">Tanggal: <strong>{{ $order->created_at->format('d/m/Y') }}</strong></p>
                <div class="mt-2 inline-block px-3 py-1 rounded-full text-xs font-black uppercase {{ optional($order->payment)->status === 'paid' ? 'bg-emerald-100 text-emerald-800 border border-emerald-300' : 'bg-amber-100 text-amber-800 border border-amber-300' }}">
                    {{ optional($order->payment)->status === 'paid' ? 'LUNAS (PAID)' : 'MENUNGGU PEMBAYARAN' }}
                </div>
            </div>
        </div>

        <!-- Customer & Event Details -->
        <div class="grid grid-cols-2 gap-8 py-8 border-b border-slate-200 text-xs">
            <div>
                <p class="font-extrabold text-slate-400 uppercase tracking-wider mb-1">Ditagihkan Kepada:</p>
                <p class="text-sm font-bold text-slate-900">{{ $order->customer_name }}</p>
                <p class="text-slate-600 mt-0.5">Email: {{ $order->customer_email }}</p>
                <p class="text-slate-600">WhatsApp: {{ $order->customer_phone }}</p>
            </div>
            <div>
                <p class="font-extrabold text-slate-400 uppercase tracking-wider mb-1">Detail Jadwal Dokumentasi:</p>
                <p class="text-slate-700">Tanggal Sesi: <strong class="text-slate-900">{{ $order->booking_date->format('d F Y') }}</strong></p>
                <p class="text-slate-700 mt-0.5">Waktu: <strong class="text-slate-900">{{ $order->booking_time }}</strong></p>
                <p class="text-slate-700 mt-0.5">Lokasi: <span class="text-slate-900 font-medium">{{ $order->location }}</span></p>
            </div>
        </div>

        <!-- Items Table -->
        <div class="py-8 border-b border-slate-200">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="font-bold text-slate-400 uppercase tracking-wider border-b border-slate-300 pb-3">
                        <th class="py-2.5">Rincian Paket Dokumentasi</th>
                        <th class="py-2.5 text-center">Durasi</th>
                        <th class="py-2.5 text-right">Tarif</th>
                        <th class="py-2.5 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <tr>
                        <td class="py-4">
                            <p class="text-sm font-bold text-slate-900">{{ $order->service->name }}</p>
                            <p class="text-slate-500 text-[11px] mt-0.5">Kategori: {{ $order->service->category_label }}</p>
                        </td>
                        <td class="py-4 text-center text-slate-700 font-medium">{{ $order->service->duration }}</td>
                        <td class="py-4 text-right font-bold text-slate-900">Rp {{ number_format((float)$order->package_price, 0, ',', '.') }}</td>
                        <td class="py-4 text-right font-bold text-slate-900">Rp {{ number_format((float)$order->package_price, 0, ',', '.') }}</td>
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

        <!-- Totals & Payment Info -->
        <div class="pt-6 grid grid-cols-2 gap-8 text-xs">
            <div class="space-y-1.5 text-slate-600">
                <p class="font-bold text-slate-800">Status Pembayaran:</p>
                <p>Metode: <strong class="text-slate-800">{{ optional($order->payment)->method_label ?? '-' }}</strong></p>
                <p>Ref: <span class="font-mono">{{ optional($order->payment)->payment_reference ?? 'MIDTRANS-AUTO' }}</span></p>
                @if(optional($order->payment)->paid_at)
                    <p class="text-emerald-700 font-bold">Lunas pada: {{ $order->payment->paid_at->format('d/m/Y H:i') }} WIB</p>
                @endif
            </div>

            <div class="space-y-2">
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
                <div class="pt-2 border-t-2 border-slate-900 flex justify-between items-baseline font-bold text-slate-900">
                    <span class="text-sm">TOTAL PEMBAYARAN:</span>
                    <span class="text-2xl font-black text-blue-700">{{ $order->formatted_total }}</span>
                </div>
            </div>
        </div>

        <!-- Signature Block -->
        <div class="pt-16 grid grid-cols-2 gap-8 text-center text-xs">
            <div>
                <p class="text-slate-400">Penerima Jasa,</p>
                <div class="h-20"></div>
                <p class="font-bold text-slate-900 border-t border-slate-300 pt-1 inline-block px-8">{{ $order->customer_name }}</p>
            </div>
            <div>
                <p class="text-slate-400">Hormat Kami, LensCraft Studio</p>
                <div class="h-20 flex items-center justify-center">
                    <span class="text-slate-300 font-black tracking-widest text-lg uppercase select-none">[ TTD & CAP RESMI ]</span>
                </div>
                <p class="font-bold text-slate-900 border-t border-slate-300 pt-1 inline-block px-8">Manajemen Operasional</p>
            </div>
        </div>

    </div>

    <script>
        // Auto trigger print dialog when opened
        window.addEventListener('load', function() {
            setTimeout(function() {
                window.print();
            }, 500);
        });
    </script>
</body>
</html>
