@extends('layouts.app')

@section('title', 'Masuk ke Akun - LensCraft Studio')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-slate-50">
    <div class="max-w-md w-full space-y-8 bg-white p-8 sm:p-10 rounded-3xl border border-slate-200 shadow-xl">
        
        <!-- Logo & Title -->
        <div class="text-center">
            <div class="flex justify-center mb-4">
                <x-logo size="lg" />
            </div>
            <h2 class="text-2xl font-black text-slate-900 tracking-tight">Masuk ke Akun Anda</h2>
            <p class="text-xs text-slate-500 mt-1">Akses riwayat pemesanan atau panel administrasi studio</p>
        </div>

        <!-- Form -->
        <form class="space-y-4" action="{{ route('login.post') }}" method="POST">
            @csrf

            <div>
                <label for="email" class="block text-xs font-semibold text-slate-700 mb-1">Alamat Email</label>
                <input id="email" name="email" type="email" required autocomplete="email" 
                       value="{{ old('email') }}"
                       placeholder="nama@email.com"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500">
                @error('email')
                    <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <div class="flex items-center justify-between mb-1">
                    <label for="password" class="block text-xs font-semibold text-slate-700">Kata Sandi</label>
                </div>
                <input id="password" name="password" type="password" required autocomplete="current-password" 
                       placeholder="••••••••"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500">
                @error('password')
                    <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between text-xs">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="remember" class="rounded text-brand-600 focus:ring-brand-500">
                    <span class="text-slate-600">Ingat saya</span>
                </label>
            </div>

            <button type="submit" 
                    class="w-full py-3 px-4 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-extrabold text-sm shadow-md shadow-brand-500/25 transition">
                Masuk Sekarang
            </button>
        </form>

        <div class="text-center text-xs text-slate-500 pt-2 border-t border-slate-100">
            Belum memiliki akun pelanggan? 
            <a href="{{ route('register') }}" class="font-bold text-brand-600 hover:underline">Daftar sekarang</a>
        </div>

    </div>
</div>
@endsection
