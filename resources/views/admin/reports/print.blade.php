<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Keuangan - LensCraft Studio</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; padding: 0 !important; }
            .print-shadow-none { box-shadow: none !important; border: 1px solid #cbd5e1 !important; }
        }
    </style>
</head>
<body class="bg-slate-100 text-slate-900 p-6 sm:p-10 antialiased">

    <!-- Action Bar -->
    <div class="max-w-5xl mx-auto mb-6 flex justify-between items-center no-print">
        <a href="{{ route('admin.reports.index') }}" class="inline-flex items-center text-xs font-semibold text-slate-600 hover:text-slate-900 bg-white px-4 py-2 rounded-xl shadow-sm border border-slate-200">
            &larr; Kembali ke Panel Admin
        </a>
        <div class="flex items-center gap-3">
            <button onclick="window.print()" class="px-5 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold shadow-md transition cursor-pointer">
                Cetak / Simpan PDF
            </button>
        </div>
    </div>

    <!-- Official Report Paper Sheet (A4) -->
    <div class="max-w-5xl mx-auto bg-white p-8 sm:p-12 rounded-3xl shadow-xl print-shadow-none">
        
        <!-- Letterhead (Kop Surat) -->
        <div class="flex items-center justify-between pb-6 border-b-2 border-slate-900">
            <div>
                <h1 class="text-2xl font-black tracking-tight text-slate-900">LENSCRAFT STUDIO INDONESIA</h1>
                <p class="text-xs text-slate-600 font-semibold tracking-wider uppercase mt-0.5">Platform Pemesanan Jasa Dokumentasi & Fotografi</p>
                <p class="text-[11px] text-slate-500 mt-1">Jl. Studio Kreatif No. 12, Jakarta Selatan | Telp: +62 812-3456-7890 | Email: finance@lenscraftstudio.id</p>
            </div>
            <div class="text-right">
                <span class="text-[10px] font-mono text-slate-400">FIN-REP-{{ date('Ymd') }}</span>
                <p class="text-xs text-slate-500 mt-1">Dicetak: {{ now()->translatedFormat('d F Y H:i') }}</p>
            </div>
        </div>

        <!-- Title -->
        <div class="text-center my-6">
            <h2 class="text-lg font-black uppercase tracking-wide text-slate-900">LAPORAN KEUANGAN & REKAPITULASI TRANSAKSI</h2>
            <p class="text-xs text-slate-500 mt-0.5">
                Periode: <strong>{{ date('d F Y', strtotime($startDate)) }}</strong> s/d <strong>{{ date('d F Y', strtotime($endDate)) }}</strong>
            </p>
        </div>

        <!-- Summary KPI Table -->
        <div class="grid grid-cols-3 gap-4 mb-8">
            <div class="p-4 rounded-xl border border-slate-200 bg-slate-50 text-center">
                <span class="text-[10px] font-bold text-slate-400 uppercase">Total Pendapatan (Lunas)</span>
                <p class="text-xl font-black text-slate-900 mt-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                <p class="text-[10px] text-emerald-600 font-semibold mt-0.5">{{ $totalPaidCount }} Transaksi Sukses</p>
            </div>
            <div class="p-4 rounded-xl border border-slate-200 bg-slate-50 text-center">
                <span class="text-[10px] font-bold text-slate-400 uppercase">Piutang / Pending</span>
                <p class="text-xl font-black text-amber-700 mt-1">Rp {{ number_format($totalUnpaidAmount, 0, ',', '.') }}</p>
                <p class="text-[10px] text-amber-600 font-semibold mt-0.5">{{ $totalUnpaidCount }} Pesanan Unpaid</p>
            </div>
            <div class="p-4 rounded-xl border border-slate-200 bg-slate-50 text-center">
                <span class="text-[10px] font-bold text-slate-400 uppercase">Rata-Rata Transaksi</span>
                <p class="text-xl font-black text-blue-700 mt-1">
                    Rp {{ number_format($totalPaidCount > 0 ? ($totalRevenue / $totalPaidCount) : 0, 0, ',', '.') }}
                </p>
                <p class="text-[10px] text-slate-400 mt-0.5">Per booking lunas</p>
            </div>
        </div>

        <!-- Transaction Details Table -->
        <table class="w-full text-left text-xs mb-8">
            <thead>
                <tr class="bg-slate-100 font-bold text-slate-700 border-y border-slate-300">
                    <th class="py-2.5 px-3">No.</th>
                    <th class="py-2.5 px-3">Kode Transaksi</th>
                    <th class="py-2.5 px-3">No. Invoice</th>
                    <th class="py-2.5 px-3">Pelanggan</th>
                    <th class="py-2.5 px-3">Paket Layanan</th>
                    <th class="py-2.5 px-3">Kanal Pembayaran</th>
                    <th class="py-2.5 px-3 text-center">Status</th>
                    <th class="py-2.5 px-3 text-right">Nominal (Rp)</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($payments as $index => $payment)
                    <tr>
                        <td class="py-2.5 px-3">{{ $index + 1 }}</td>
                        <td class="py-2.5 px-3 font-mono text-[11px] font-bold">{{ $payment->transaction_code }}</td>
                        <td class="py-2.5 px-3 font-mono text-[11px]">{{ optional($payment->order)->order_code }}</td>
                        <td class="py-2.5 px-3">
                            <p class="font-bold text-slate-900">{{ optional($payment->order)->customer_name }}</p>
                            <p class="text-[10px] text-slate-400">{{ optional($payment->order)->customer_phone }}</p>
                        </td>
                        <td class="py-2.5 px-3">
                            <p class="font-semibold text-slate-800">{{ optional($payment->order->service)->name }}</p>
                            <span class="text-[10px] text-slate-500">({{ optional($payment->order->service)->category_label }})</span>
                        </td>
                        <td class="py-2.5 px-3 text-[11px] text-slate-700">{{ $payment->method_label }}</td>
                        <td class="py-2.5 px-3 text-center font-bold text-[10px]">
                            <span class="{{ $payment->status === 'paid' ? 'text-emerald-700' : 'text-amber-700' }}">
                                {{ $payment->status_label }}
                            </span>
                        </td>
                        <td class="py-2.5 px-3 text-right font-extrabold text-slate-900">
                            Rp {{ number_format((float)$payment->amount, 0, ',', '.') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-6 text-slate-400">Tidak ada transaksi ditemukan pada periode ini.</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr class="bg-slate-50 font-black border-t-2 border-slate-900 text-slate-900">
                    <td colspan="7" class="py-3 px-3 text-right uppercase tracking-wider">TOTAL PENDAPATAN LUNAS (RP):</td>
                    <td class="py-3 px-3 text-right text-base text-blue-700">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>

        <!-- Signature Section -->
        <div class="grid grid-cols-2 gap-8 pt-12 text-center text-xs">
            <div>
                <p class="text-slate-500">Mengetahui,</p>
                <div class="h-16"></div>
                <p class="font-bold text-slate-900 border-t border-slate-400 pt-1 inline-block px-10">Pimpinan Studio</p>
            </div>
            <div>
                <p class="text-slate-500">Jakarta, {{ now()->translatedFormat('d F Y') }}</p>
                <p class="text-slate-500">Petugas Keuangan,</p>
                <div class="h-14"></div>
                <p class="font-bold text-slate-900 border-t border-slate-400 pt-1 inline-block px-10">{{ auth()->user()->name }}</p>
            </div>
        </div>

    </div>

    <script>
        window.addEventListener('load', function() {
            setTimeout(function() {
                window.print();
            }, 500);
        });
    </script>
</body>
</html>
