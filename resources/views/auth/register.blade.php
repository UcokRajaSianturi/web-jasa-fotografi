@extends('layouts.app')

@section('title', 'Daftar Akun Baru - LensCraft Studio')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-slate-50">
    <div class="max-w-md w-full space-y-6 bg-white p-8 sm:p-10 rounded-3xl border border-slate-200 shadow-xl">
        
        <!-- Logo & Title -->
        <div class="text-center">
            <div class="flex justify-center mb-4">
                <x-logo size="lg" />
            </div>
            <h2 class="text-2xl font-black text-slate-900 tracking-tight">Daftar Akun Pelanggan</h2>
            <p class="text-xs text-slate-500 mt-1">Buat akun untuk memesan layanan dan memantau status sesi dokumentasi</p>
        </div>

        <!-- Form -->
        <form class="space-y-4" action="{{ route('register.post') }}" method="POST">
            @csrf

            <div>
                <label for="name" class="block text-xs font-semibold text-slate-700 mb-1">Nama Lengkap</label>
                <input id="name" name="name" type="text" required 
                       value="{{ old('name') }}"
                       placeholder="Contoh: Budi Santoso"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500">
                @error('name')
                    <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-xs font-semibold text-slate-700 mb-1">Alamat Email</label>
                <input id="email" name="email" type="email" required 
                       value="{{ old('email') }}"
                       placeholder="nama@email.com"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500">
                @error('email')
                    <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="phone" class="block text-xs font-semibold text-slate-700 mb-1">Nomor WhatsApp</label>
                <input id="phone" name="phone" type="text" required 
                       value="{{ old('phone') }}"
                       placeholder="08123456789"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500">
                @error('phone')
                    <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label for="password" class="block text-xs font-semibold text-slate-700 mb-1">Kata Sandi</label>
                    <input id="password" name="password" type="password" required 
                           placeholder="Minimal 6 karakter"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500">
                    @error('password')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-xs font-semibold text-slate-700 mb-1">Ulangi Sandi</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required 
                           placeholder="Konfirmasi sandi"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500">
                </div>
            </div>

            <button type="submit" 
                    class="w-full py-3 px-4 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-extrabold text-sm shadow-md shadow-brand-500/25 transition mt-2">
                Daftar Sekarang
            </button>
        </form>

        <div class="text-center text-xs text-slate-500 pt-2 border-t border-slate-100">
            Sudah memiliki akun? 
            <a href="{{ route('login') }}" class="font-bold text-brand-600 hover:underline">Masuk di sini</a>
        </div>

    </div>
</div>
@endsection
