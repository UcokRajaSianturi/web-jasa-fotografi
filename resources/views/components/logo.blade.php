@props([
    'size' => 'md', // sm, md, lg
    'dark' => false,
    'withSubtitle' => true
])

@php
    $iconSize = match($size) {
        'sm' => 'w-8 h-8 text-base',
        'lg' => 'w-14 h-14 text-2xl',
        default => 'w-11 h-11 text-xl',
    };
    $titleSize = match($size) {
        'sm' => 'text-base',
        'lg' => 'text-2xl',
        default => 'text-xl',
    };
    $subSize = match($size) {
        'sm' => 'text-[9px]',
        'lg' => 'text-xs',
        default => 'text-[10px]',
    };
@endphp

<div class="flex items-center gap-3 select-none">
    <!-- Distinctive Shutter & Aperture Vector Emblem -->
    <div class="{{ $iconSize }} rounded-2xl bg-gradient-to-br from-slate-900 via-slate-800 to-amber-950 p-0.5 shadow-lg shadow-amber-950/20 relative group-hover:scale-105 transition-transform duration-300 flex items-center justify-center shrink-0">
        <div class="w-full h-full rounded-[14px] bg-slate-950/80 flex items-center justify-center relative overflow-hidden backdrop-blur-sm border border-amber-500/30">
            <!-- Subtle Lens Reflection Glow -->
            <div class="absolute -top-3 -right-3 w-8 h-8 bg-amber-400/30 rounded-full blur-md"></div>
            <div class="absolute -bottom-3 -left-3 w-8 h-8 bg-indigo-500/20 rounded-full blur-md"></div>
            
            <!-- Aperture Blades SVG -->
            <svg class="w-6 h-6 text-amber-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <!-- Outer camera body line -->
                <circle cx="12" cy="12" r="9" stroke="url(#amber-grad)" stroke-width="2"/>
                <!-- Shutter diaphragm geometric leaves -->
                <path d="M12 3 L16.5 8" stroke="currentColor" opacity="0.8"/>
                <path d="M19.8 7.5 L17.5 13" stroke="currentColor" opacity="0.8"/>
                <path d="M21 12 L15.5 16.5" stroke="currentColor" opacity="0.8"/>
                <path d="M16.5 19.8 L11 17.5" stroke="currentColor" opacity="0.8"/>
                <path d="M12 21 L7.5 16.5" stroke="currentColor" opacity="0.8"/>
                <path d="M4.2 16.5 L6.5 11" stroke="currentColor" opacity="0.8"/>
                <path d="M3 12 L8.5 7.5" stroke="currentColor" opacity="0.8"/>
                <path d="M7.5 4.2 L13 6.5" stroke="currentColor" opacity="0.8"/>
                <!-- Center focal dot -->
                <circle cx="12" cy="12" r="2.5" fill="#f59e0b" stroke="#fef08a" stroke-width="1"/>
                <defs>
                    <linearGradient id="amber-grad" x1="0" y1="0" x2="24" y2="24" gradientUnits="userSpaceOnUse">
                        <stop offset="0%" stop-color="#fbbf24"/>
                        <stop offset="100%" stop-color="#d97706"/>
                    </linearGradient>
                </defs>
            </svg>
        </div>
    </div>

    <!-- Wordmark -->
    <div class="flex flex-col">
        <span class="{{ $titleSize }} font-extrabold tracking-tight leading-none {{ $dark ? 'text-white' : 'text-slate-900' }}">
            Lens<span class="font-serif italic font-semibold text-transparent bg-clip-text bg-gradient-to-r from-amber-500 to-amber-600">Craft</span>
            <span class="inline-block w-1.5 h-1.5 rounded-full bg-amber-500 ml-0.5"></span>
        </span>
        @if($withSubtitle)
            <span class="{{ $subSize }} uppercase font-bold tracking-[0.22em] {{ $dark ? 'text-slate-400' : 'text-slate-600' }} mt-1">
                Studio & Dokumentasi
            </span>
        @endif
    </div>
</div>
