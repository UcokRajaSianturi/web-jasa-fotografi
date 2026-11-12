@extends('layouts.app')

@section('title', 'Form Pemesanan Jasa Dokumentasi - LensCraft Studio')

@section('content')
<div class="bg-slate-50 py-12">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8">
            <a href="{{ url()->previous() ?: route('services.index') }}" class="inline-flex items-center gap-1.5 text-xs text-slate-500 hover:text-brand-600 font-semibold transition mb-3">
                <i class="fa-solid fa-arrow-left text-[10px]"></i>
                <span>Kembali ke Paket</span>
            </a>
            <h1 class="text-3xl font-extrabold text-slate-900">Formulir Pemesanan Sesi Dokumentasi</h1>
            <p class="text-sm text-slate-500 mt-1">Lengkapi rincian tanggal, lokasi acara, dan informasi kontak Anda di bawah ini.</p>
        </div>

        <form action="{{ route('bookings.store') }}" method="POST" id="bookingForm">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- Left Column: Form Inputs -->
                <div class="lg:col-span-7 space-y-6">
                    
                    <!-- 1. Pilihan Layanan -->
                    <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4">
                        <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-brand-100 text-brand-600 flex items-center justify-center text-xs">1</span>
                            <span>Pilih Paket Layanan</span>
                        </h2>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Paket Dokumentasi <span class="text-rose-500">*</span></label>
                            <select name="service_id" id="service_id" required 
                                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 bg-white">
                                <option value="" disabled {{ !$service ? 'selected' : '' }}>-- Pilih Layanan Dokumentasi --</option>
                                @foreach($allServices as $s)
                                    <option value="{{ $s->id }}" 
                                            data-price="{{ $s->effective_price }}" 
                                            data-formatted-price="{{ $s->formatted_effective_price }}"
                                            data-duration="{{ $s->duration }}"
                                            data-category="{{ $s->category_label }}"
                                            {{ ($service && $service->id === $s->id) || old('service_id') == $s->id ? 'selected' : '' }}>
                                        [{{ $s->category_label }}] {{ $s->name }} - {{ $s->formatted_effective_price }}
                                    </option>
                                @endforeach
                            </select>
                            @error('service_id')
                                <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- 2. Informasi Pelanggan -->
                    <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4">
                        <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-brand-100 text-brand-600 flex items-center justify-center text-xs">2</span>
                            <span>Informasi Pemesan</span>
                        </h2>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Lengkap <span class="text-rose-500">*</span></label>
                                <input type="text" name="customer_name" required 
                                       value="{{ old('customer_name', auth()->user()?->name) }}"
                                       placeholder="Nama pemesan"
                                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500">
                                @error('customer_name')
                                    <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Email Aktif <span class="text-rose-500">*</span></label>
                                    <input type="email" name="customer_email" required 
                                           value="{{ old('customer_email', auth()->user()?->email) }}"
                                           placeholder="nama@email.com"
                                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500">
                                    @error('customer_email')
                                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nomor WhatsApp <span class="text-rose-500">*</span></label>
                                    <input type="text" name="customer_phone" required 
                                           value="{{ old('customer_phone', auth()->user()?->phone) }}"
                                           placeholder="Contoh: 08123456789"
                                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500">
                                    @error('customer_phone')
                                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 3. Jadwal & Lokasi Sesi -->
                    <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4">
                        <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-brand-100 text-brand-600 flex items-center justify-center text-xs">3</span>
                            <span>Jadwal & Lokasi Dokumentasi</span>
                        </h2>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Tanggal Sesi / Acara <span class="text-rose-500">*</span></label>
                                <input type="date" name="booking_date" required 
                                       min="{{ date('Y-m-d') }}"
                                       value="{{ old('booking_date', date('Y-m-d', strtotime('+3 days'))) }}"
                                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500">
                                @error('booking_date')
                                    <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Pilihan Jam / Slot Waktu <span class="text-rose-500">*</span></label>
                                <select name="booking_time" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 bg-white">
                                    <option value="08:00 - 10:00 WIB" {{ old('booking_time') == '08:00 - 10:00 WIB' ? 'selected' : '' }}>Pagi (08:00 - 10:00 WIB)</option>
                                    <option value="10:00 - 12:00 WIB" {{ old('booking_time') == '10:00 - 12:00 WIB' ? 'selected' : '' }}>Pagi Menjelang Siang (10:00 - 12:00 WIB)</option>
                                    <option value="13:00 - 15:00 WIB" {{ old('booking_time') == '13:00 - 15:00 WIB' ? 'selected' : '' }}>Siang (13:00 - 15:00 WIB)</option>
                                    <option value="15:30 - 17:30 WIB (Golden Hour)" {{ old('booking_time') == '15:30 - 17:30 WIB (Golden Hour)' ? 'selected' : '' }}>Sore / Golden Hour (15:30 - 17:30 WIB)</option>
                                    <option value="18:30 - 21:00 WIB (Malam)" {{ old('booking_time') == '18:30 - 21:00 WIB (Malam)' ? 'selected' : '' }}>Malam (18:30 - 21:00 WIB)</option>
                                    <option value="Full Day (09:00 - 17:00 WIB)" {{ old('booking_time') == 'Full Day (09:00 - 17:00 WIB)' ? 'selected' : '' }}>Full Day (09:00 - 17:00 WIB)</option>
                                </select>
                                @error('booking_time')
                                    <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Alamat / Titik Lokasi Dokumentasi <span class="text-rose-500">*</span></label>
                            <textarea name="location" rows="2" required placeholder="Contoh: Gedung Rektorat Kampus / Hotel Aston Lt. 2 / Studio Foto LensCraft"
                                      class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500">{{ old('location') }}</textarea>
                            @error('location')
                                <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Catatan Khusus / Konsep Foto (Opsional)</label>
                            <textarea name="notes" rows="2" placeholder="Tuliskan jika ada permintaan khusus gaya foto, warna pakaian, atau daftar produk yang difoto..."
                                      class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500">{{ old('notes') }}</textarea>
                        </div>
                    </div>

                    <!-- 4. Metode Pembayaran -->
                    <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4">
                        <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-brand-100 text-brand-600 flex items-center justify-center text-xs">4</span>
                            <span>Pilih Metode Pembayaran</span>
                        </h2>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <!-- QRIS -->
                            <label class="flex items-center gap-3 p-3.5 rounded-2xl border border-slate-200 hover:border-brand-500 cursor-pointer transition">
                                <input type="radio" name="payment_method" value="qris" checked class="text-brand-600 focus:ring-brand-500">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-slate-100 flex items-center justify-center text-slate-800 text-xs font-extrabold">
                                        QRIS
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-900">QRIS Instant</p>
                                        <p class="text-[11px] text-slate-400">Gopay, OVO, ShopeePay, BCA Mobile</p>
                                    </div>
                                </div>
                            </label>

                            <!-- BCA VA -->
                            <label class="flex items-center gap-3 p-3.5 rounded-2xl border border-slate-200 hover:border-brand-500 cursor-pointer transition">
                                <input type="radio" name="payment_method" value="bca_va" class="text-brand-600 focus:ring-brand-500">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center text-xs font-extrabold">
                                        BCA
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-900">BCA Virtual Account</p>
                                        <p class="text-[11px] text-slate-400">Verifikasi otomatis 24 jam</p>
                                    </div>
                                </div>
                            </label>

                            <!-- Mandiri VA -->
                            <label class="flex items-center gap-3 p-3.5 rounded-2xl border border-slate-200 hover:border-brand-500 cursor-pointer transition">
                                <input type="radio" name="payment_method" value="mandiri_va" class="text-brand-600 focus:ring-brand-500">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center text-xs font-extrabold">
                                        MDR
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-900">Mandiri Virtual Account</p>
                                        <p class="text-[11px] text-slate-400">Livin' by Mandiri & ATM</p>
                                    </div>
                                </div>
                            </label>

                            <!-- BNI VA -->
                            <label class="flex items-center gap-3 p-3.5 rounded-2xl border border-slate-200 hover:border-brand-500 cursor-pointer transition">
                                <input type="radio" name="payment_method" value="bni_va" class="text-brand-600 focus:ring-brand-500">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-teal-50 text-teal-700 flex items-center justify-center text-xs font-extrabold">
                                        BNI
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-900">BNI Virtual Account</p>
                                        <p class="text-[11px] text-slate-400">BNI Mobile & ATM</p>
                                    </div>
                                </div>
                            </label>

                            <!-- Credit Card -->
                            <label class="sm:col-span-2 flex items-center gap-3 p-3.5 rounded-2xl border border-slate-200 hover:border-brand-500 cursor-pointer transition">
                                <input type="radio" name="payment_method" value="credit_card" class="text-brand-600 focus:ring-brand-500">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-indigo-50 text-indigo-700 flex items-center justify-center text-sm font-extrabold">
                                        <i class="fa-solid fa-credit-card"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-900">Kartu Kredit / Debit Online (Visa / Mastercard)</p>
                                        <p class="text-[11px] text-slate-400">Pembayaran instan terproteksi 3D Secure</p>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>

                </div>

                <!-- Right Column: Order Summary Sidebar -->
                <div class="lg:col-span-5">
                    <div class="sticky top-28 bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-xl space-y-6">
                        <h3 class="text-base font-bold text-slate-900 pb-3 border-b border-slate-100 flex items-center gap-2">
                            <i class="fa-solid fa-receipt text-brand-600 text-sm"></i>
                            <span>Ringkasan Tagihan</span>
                        </h3>

                        <!-- Package Summary Info -->
                        <div class="space-y-3 text-xs">
                            <div class="flex justify-between items-center text-slate-600">
                                <span>Kategori Layanan</span>
                                <span id="summary_category" class="font-bold text-slate-900">{{ $service ? $service->category_label : '-' }}</span>
                            </div>
                            <div class="flex justify-between items-center text-slate-600">
                                <span>Durasi Sesi</span>
                                <span id="summary_duration" class="font-bold text-slate-900">{{ $service ? $service->duration : '-' }}</span>
                            </div>
                            <div class="flex justify-between items-center text-slate-600">
                                <span>Harga Paket</span>
                                <span id="summary_price" class="font-bold text-slate-900">{{ $service ? $service->formatted_effective_price : 'Rp 0' }}</span>
                            </div>
                            <div class="flex justify-between items-center text-slate-600">
                                <span>Biaya Administrasi</span>
                                <span class="font-bold text-emerald-600">GRATIS</span>
                            </div>
                        </div>

                        <!-- Total Block -->
                        <div class="pt-4 border-t border-slate-100">
                            <div class="flex justify-between items-baseline">
                                <div>
                                    <span class="text-xs text-slate-500 font-medium">Total Pembayaran</span>
                                    <p class="text-2xl font-extrabold text-slate-900" id="summary_total">
                                        {{ $service ? $service->formatted_effective_price : 'Rp 0' }}
                                    </p>
                                </div>
                                <span class="text-[11px] font-bold text-brand-600 bg-brand-50 px-2 py-0.5 rounded border border-brand-200">
                                    Simulasi Midtrans
                                </span>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" 
                                class="w-full inline-flex items-center justify-center gap-2 py-3.5 px-6 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-extrabold text-sm shadow-lg shadow-brand-500/30 transition transform hover:-translate-y-0.5">
                            <i class="fa-solid fa-lock text-xs"></i>
                            <span>Konfirmasi & Lanjut Bayar</span>
                        </button>

                        <div class="text-[11px] text-slate-400 text-center leading-relaxed">
                            <i class="fa-solid fa-shield-check text-emerald-500 mr-1"></i>
                            Faktur dan invoice resmi akan diterbitkan otomatis sesaat setelah konfirmasi pesanan.
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const select = document.getElementById('service_id');
        const summaryCategory = document.getElementById('summary_category');
        const summaryDuration = document.getElementById('summary_duration');
        const summaryPrice = document.getElementById('summary_price');
        const summaryTotal = document.getElementById('summary_total');

        function updateSummary() {
            const selectedOption = select.options[select.selectedIndex];
            if (selectedOption && selectedOption.value) {
                summaryCategory.textContent = selectedOption.getAttribute('data-category');
                summaryDuration.textContent = selectedOption.getAttribute('data-duration');
                const formattedPrice = selectedOption.getAttribute('data-formatted-price');
                summaryPrice.textContent = formattedPrice;
                summaryTotal.textContent = formattedPrice;
            }
        }

        select.addEventListener('change', updateSummary);
    });
</script>
@endpush
@endsection
