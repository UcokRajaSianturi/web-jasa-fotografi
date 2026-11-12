@extends('layouts.admin')

@section('title', 'Kelola Pengguna')
@section('page_title', 'Manajemen Pengguna & Hak Akses')

@section('content')
<div class="space-y-6">
    
    <!-- Top Bar with Search & Add Button -->
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
        <!-- Search and Filter Form -->
        <form action="{{ route('admin.users.index') }}" method="GET" class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
            <div class="relative flex-1 sm:w-64">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama, email, telepon..." 
                       class="w-full pl-9 pr-3 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:ring-2 focus:ring-brand-500">
            </div>

            <select name="role" onchange="this.form.submit()" 
                    class="px-3 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:ring-2 focus:ring-brand-500 bg-white">
                <option value="all" {{ $role === 'all' ? 'selected' : '' }}>Semua Peran (Role)</option>
                <option value="super_admin" {{ $role === 'super_admin' ? 'selected' : '' }}>Super Administrator</option>
                <option value="admin" {{ $role === 'admin' ? 'selected' : '' }}>Administrator / Mitra</option>
                <option value="customer" {{ $role === 'customer' ? 'selected' : '' }}>Pelanggan (Customer)</option>
            </select>
        </form>

        <a href="{{ route('admin.users.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold shadow-md shadow-brand-500/20 transition whitespace-nowrap">
            <i class="fa-solid fa-user-plus text-[10px]"></i>
            <span>Tambah Pengguna Baru</span>
        </a>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-slate-50 text-slate-400 font-bold uppercase tracking-wider border-b border-slate-200">
                        <th class="py-3 px-6">Pengguna</th>
                        <th class="py-3 px-6">Kontak</th>
                        <th class="py-3 px-6 text-center">Hak Akses (Role)</th>
                        <th class="py-3 px-6 text-center">Total Pesanan</th>
                        <th class="py-3 px-6">Bergabung</th>
                        <th class="py-3 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $user)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=0284c7&color=fff' }}" 
                                         alt="{{ $user->name }}" class="w-9 h-9 rounded-full object-cover">
                                    <div>
                                        <p class="font-bold text-slate-900">{{ $user->name }}</p>
                                        <p class="text-slate-400 text-[11px]">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6 text-slate-600">
                                <p class="font-medium text-slate-800">{{ $user->phone ?? '-' }}</p>
                                <p class="text-[11px] text-slate-400 truncate max-w-xs">{{ $user->address ?? 'Alamat belum diatur' }}</p>
                            </td>
                            <td class="py-4 px-6 text-center">
                                @if($user->role === 'super_admin')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-purple-100 text-purple-700 border border-purple-200">
                                        Super Admin
                                    </span>
                                @elseif($user->role === 'admin')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-indigo-100 text-indigo-700 border border-indigo-200">
                                        Admin / Mitra
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700 border border-emerald-200">
                                        Pelanggan
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-center font-bold text-slate-700">
                                {{ $user->orders_count }} Pesanan
                            </td>
                            <td class="py-4 px-6 text-slate-400 text-[11px]">
                                {{ $user->created_at->format('d M Y') }}
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.users.edit', $user->id) }}" 
                                       class="p-1.5 rounded-lg text-brand-600 hover:bg-brand-50 transition" title="Edit Pengguna">
                                        <i class="fa-solid fa-pen-to-square text-xs"></i>
                                    </a>
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 rounded-lg text-rose-500 hover:bg-rose-50 transition" title="Hapus Pengguna">
                                                <i class="fa-solid fa-trash text-xs"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-10 text-slate-400">Tidak ada data pengguna yang cocok.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-6 border-t border-slate-100">
            {{ $users->withQueryString()->links() }}
        </div>
    </div>

</div>
@endsection
