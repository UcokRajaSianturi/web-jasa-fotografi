@extends('layouts.app')

@section('title', 'Pembayaran Pesanan ' . $order->order_code . ' - LensCraft Studio')

@section('content')
<div class="bg-slate-50 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header status -->
        <div class="text-center max-w-xl mx-auto mb-10">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-50 text-brand-700 text-xs font-bold border border-brand-200 mb-3">
                <i class="fa-solid fa-lock text-brand-600"></i>
                <span>Midtrans Payment Gateway Simulator</span>
            </div>
            <h1 class="text-3xl font-extrabold text-slate-900">Selesaikan Pembayaran Anda</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Lakukan pembayaran untuk mengonfirmasi jadwal sesi dokumentasi Anda.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Left: Payment Gateway Mockup -->
            <div class="lg:col-span-7 bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-xl space-y-6">
                
                <!-- Gateway Header -->
                <div class="flex items-center justify-between pb-5 border-b border-slate-100">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-brand-600 text-white flex items-center justify-center text-sm font-black">
                            M
                        </div>
                        <div>
                            <p class="text-xs font-extrabold text-slate-900">MIDTRANS SNAP</p>
                            <p class="text-[10px] text-slate-400">Secure Payment Channel</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="text-[10px] text-slate-400 font-medium">Batas Waktu:</span>
                        <p class="text-xs font-bold text-rose-600 flex items-center gap-1 justify-end">
                            <i class="fa-regular fa-clock text-[10px]"></i>
                            <span id="countdown">14:59</span>
                        </p>
                    </div>
                </div>

                <!-- Active Payment Method Display -->
                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-xs font-bold text-slate-700">Metode Terpilih:</span>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-brand-100 text-brand-800">
                            {{ $payment->method_label }}
                        </span>
                    </div>

                    @if($payment->payment_method === 'qris')
                        <!-- QRIS Simulation -->
                        <div class="text-center py-4 space-y-4">
                            <div class="inline-block p-4 bg-white rounded-2xl border-2 border-slate-800 shadow-sm">
                                <!-- Simulated SVG QR Code -->
                                <svg class="w-48 h-48 mx-auto" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="100" height="100" fill="white"/>
                                    <!-- QR Corners -->
                                    <rect x="5" y="5" width="25" height="25" fill="#1e293b"/>
                                    <rect x="9" y="9" width="17" height="17" fill="white"/>
                                    <rect x="13" y="13" width="9" height="9" fill="#1e293b"/>

                                    <rect x="70" y="5" width="25" height="25" fill="#1e293b"/>
                                    <rect x="74" y="9" width="17" height="17" fill="white"/>
                                    <rect x="78" y="13" width="9" height="9" fill="#1e293b"/>

                                    <rect x="5" y="70" width="25" height="25" fill="#1e293b"/>
                                    <rect x="9" y="74" width="17" height="17" fill="white"/>
                                    <rect x="13" y="78" width="9" height="9" fill="#1e293b"/>

                                    <!-- QR Bits -->
                                    <rect x="35" y="10" width="6" height="6" fill="#1e293b"/>
                                    <rect x="45" y="10" width="8" height="6" fill="#1e293b"/>
                                    <rect x="58" y="12" width="6" height="8" fill="#1e293b"/>

                                    <rect x="35" y="25" width="8" height="8" fill="#1e293b"/>
                                    <rect x="50" y="22" width="12" height="6" fill="#1e293b"/>

                                    <rect x="10" y="35" width="15" height="6" fill="#1e293b"/>
                                    <rect x="30" y="38" width="10" height="10" fill="#1e293b"/>
                                    <rect x="45" y="35" width="12" height="12" fill="#0284c7"/>
                                    <rect x="62" y="38" width="8" height="8" fill="#1e293b"/>
                                    <rect x="75" y="35" width="15" height="6" fill="#1e293b"/>

                                    <rect x="15" y="48" width="10" height="8" fill="#1e293b"/>
                                    <rect x="32" y="52" width="14" height="6" fill="#1e293b"/>
                                    <rect x="52" y="50" width="8" height="12" fill="#1e293b"/>
                                    <rect x="70" y="48" width="18" height="8" fill="#1e293b"/>

                                    <rect x="35" y="70" width="8" height="14" fill="#1e293b"/>
                                    <rect x="48" y="68" width="12" height="8" fill="#1e293b"/>
                                    <rect x="65" y="70" width="10" height="12" fill="#1e293b"/>
                                    <rect x="80" y="72" width="12" height="10" fill="#1e293b"/>
                                    <rect x="45" y="82" width="16" height="8" fill="#1e293b"/>
                                </svg>
                                <p class="text-[10px] font-extrabold text-slate-800 tracking-wider mt-1">QRIS STANDAR NASIONAL</p>
                            </div>
                            <p class="text-xs text-slate-500">
                                Buka aplikasi e-Wallet atau Mobile Banking Anda (BCA, Mandiri, GoPay, OVO, Dana, ShopeePay), lalu scan kode QR di atas.
                            </p>
                        </div>
                    @elseif(in_array($payment->payment_method, ['bca_va', 'mandiri_va', 'bni_va']))
                        <!-- Virtual Account Simulation -->
                        <div class="space-y-4 py-2">
                            <div>
                                <span class="text-xs text-slate-500 font-medium">Nomor Virtual Account:</span>
                                <div class="flex items-center justify-between p-3.5 mt-1 bg-white rounded-xl border border-slate-200">
                                    <span class="font-mono text-base font-extrabold text-slate-900 tracking-wider">
                                        88019{{ sprintf('%011d', $order->id * 4321) }}
                                    </span>
                                    <button type="button" onclick="navigator.clipboard.writeText('88019{{ sprintf('%011d', $order->id * 4321) }}'); alert('Nomor VA berhasil disalin!');" 
                                            class="px-2.5 py-1 rounded bg-slate-100 hover:bg-slate-200 text-xs font-bold text-slate-700 transition">
                                        <i class="fa-regular fa-copy mr-1"></i> Salin
                                    </button>
                                </div>
                            </div>
                            <div class="text-xs text-slate-600 space-y-1.5 pt-2">
                                <p class="font-bold text-slate-800">Petunjuk Pembayaran:</p>
                                <ol class="list-decimal pl-4 space-y-1 text-[11px] text-slate-500">
                                    <li>Buka Mobile Banking atau ATM bank Anda.</li>
                                    <li>Pilih menu <strong>Transfer > Virtual Account</strong>.</li>
                                    <li>Masukkan nomor Virtual Account di atas.</li>
                                    <li>Konfirmasi tagihan sebesar <strong>{{ $payment->formatted_amount }}</strong>.</li>
                                </ol>
                            </div>
                        </div>
                    @else
                        <!-- Credit Card Simulation -->
                        <div class="space-y-3 py-2 text-xs">
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Nomor Kartu (Simulasi)</label>
                                <input type="text" readonly value="4111 •••• •••• 9928" class="w-full px-3 py-2 bg-white rounded-lg border border-slate-200 font-mono font-bold text-slate-800">
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-[11px] font-semibold text-slate-600 mb-1">Berlaku Hingga</label>
                                    <input type="text" readonly value="12/28" class="w-full px-3 py-2 bg-white rounded-lg border border-slate-200 font-mono font-bold text-slate-800">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-semibold text-slate-600 mb-1">CVV</label>
                                    <input type="text" readonly value="•••" class="w-full px-3 py-2 bg-white rounded-lg border border-slate-200 font-mono font-bold text-slate-800">
                                </div>
                            </div>
                        </div>
                    @endif

                </div>

                <!-- Simulation Action Button -->
                <form action="{{ route('payments.process', $order->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="payment_method" value="{{ $payment->payment_method }}">
                    <button type="submit" 
                            class="w-full py-4 px-6 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-sm shadow-xl shadow-emerald-500/25 transition transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                        <i class="fa-solid fa-circle-check"></i>
                        <span>Simulasi Bayar Sekarang (Berhasil)</span>
                    </button>
                    <p class="text-[11px] text-slate-400 text-center mt-2">
                        *Klik tombol ini untuk mensimulasikan webhook settlement Midtrans secara instan.
                    </p>
                </form>

                <!-- Change Payment Method Options -->
                <div class="pt-4 border-t border-slate-100">
                    <p class="text-xs font-bold text-slate-700 mb-3">Ganti Metode Pembayaran Lain:</p>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                        @foreach(['qris' => 'QRIS', 'bca_va' => 'BCA VA', 'mandiri_va' => 'Mandiri VA', 'bni_va' => 'BNI VA'] as $mKey => $mLabel)
                            <form action="{{ route('payments.changeMethod', $order->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="payment_method" value="{{ $mKey }}">
                                <button type="submit" 
                                        class="w-full py-2 px-3 rounded-xl border text-xs font-bold transition {{ $payment->payment_method === $mKey ? 'bg-brand-600 text-white border-brand-600 shadow-sm' : 'bg-slate-50 text-slate-600 border-slate-200 hover:bg-slate-100' }}">
                                    {{ $mLabel }}
                                </button>
                            </form>
                        @endforeach
                    </div>
                </div>

            </div>

            <!-- Right: Order Details Summary -->
            <div class="lg:col-span-5 bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-6">
                <h3 class="text-base font-bold text-slate-900 pb-3 border-b border-slate-100 flex items-center gap-2">
                    <i class="fa-solid fa-clipboard-list text-brand-600 text-sm"></i>
                    <span>Rincian Pesanan</span>
                </h3>

                <div class="space-y-3.5 text-xs text-slate-600">
                    <div class="flex justify-between">
                        <span class="text-slate-400">Nomor Pesanan:</span>
                        <span class="font-bold text-slate-900 font-mono">{{ $order->order_code }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400">Paket Layanan:</span>
                        <span class="font-bold text-slate-900 text-right">{{ $order->service->name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400">Kategori:</span>
                        <span class="font-bold text-slate-900">{{ $order->service->category_label }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400">Jadwal Sesi:</span>
                        <span class="font-bold text-slate-900">{{ $order->booking_date->format('d/m/Y') }} ({{ $order->booking_time }})</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400">Pemesan:</span>
                        <span class="font-bold text-slate-900">{{ $order->customer_name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400">WhatsApp:</span>
                        <span class="font-bold text-slate-900">{{ $order->customer_phone }}</span>
                    </div>
                </div>

                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 space-y-2 text-xs">
                    <div class="flex justify-between text-slate-600">
                        <span>Biaya Paket:</span>
                        <span class="font-bold text-slate-900">Rp {{ number_format((float)$order->package_price, 0, ',', '.') }}</span>
                    </div>
                    @if($order->additional_fee > 0)
                        <div class="flex justify-between text-slate-600">
                            <span>Biaya Tambahan:</span>
                            <span class="font-bold text-slate-900">Rp {{ number_format((float)$order->additional_fee, 0, ',', '.') }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between text-slate-600">
                        <span>Biaya Transaksi:</span>
                        <span class="font-bold text-emerald-600">Rp 0 (Gratis)</span>
                    </div>
                    <div class="pt-2 border-t border-slate-200/60 flex justify-between items-baseline font-bold">
                        <span class="text-sm text-slate-900">Total Tagihan:</span>
                        <span class="text-xl font-extrabold text-brand-600">{{ $order->formatted_total }}</span>
                    </div>
                </div>

                <div class="pt-2">
                    <a href="{{ route('user.orders.index') }}" class="w-full inline-flex items-center justify-center gap-1.5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
                        <i class="fa-solid fa-list-check text-xs"></i>
                        <span>Bayar Nanti (Lihat Pesanan Saya)</span>
                    </a>
                </div>
            </div>

        </div>

    </div>
</div>

@push('scripts')
<script>
    // Simple visual countdown simulator
    let duration = 14 * 60 + 59;
    const timerElement = document.getElementById('countdown');
    setInterval(function () {
        if (duration <= 0) return;
        duration--;
        const minutes = Math.floor(duration / 60);
        const seconds = duration % 60;
        timerElement.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
    }, 1000);
</script>
@endpush
@endsection
