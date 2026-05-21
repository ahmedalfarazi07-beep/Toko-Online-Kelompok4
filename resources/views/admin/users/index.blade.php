@extends('layouts.admin')

@section('title', 'Pengguna')

@section('content')
    @if(session('error'))
        <div class="mb-4 bg-red-600/20 border border-red-500/30 text-red-400 px-5 py-3 rounded-xl text-sm">{{ session('error') }}</div>
    @endif

    <div class="flex items-center justify-between mb-6">
        <h1 class="font-heading text-2xl font-bold text-white">Pengguna</h1>
    </div>

    {{-- User Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="glow-border bg-surface rounded-xl p-6 relative overflow-hidden">
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-accent"></div>
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-accent/20 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6 text-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/></svg>
                </div>
                <div>
                    <p class="text-2xl font-heading font-bold text-white">{{ $totalUsers }}</p>
                    <p class="text-sm text-text-muted">Total User</p>
                </div>
            </div>
        </div>

        <div class="glow-border bg-surface rounded-xl p-6 relative overflow-hidden">
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-green-500"></div>
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-green-500/20 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-2xl font-heading font-bold text-green-400">{{ $activeUsers }}</p>
                    <p class="text-sm text-text-muted">User Aktif</p>
                </div>
            </div>
        </div>

        <div class="glow-border bg-surface rounded-xl p-6 relative overflow-hidden">
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-blue-500"></div>
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-blue-500/20 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <div>
                    <p class="text-2xl font-heading font-bold text-blue-400">{{ $adminCount }}</p>
                    <p class="text-sm text-text-muted">Admin</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Search --}}
    <div class="glow-border bg-surface rounded-xl overflow-hidden">
        <div class="p-4 border-b border-accent/10">
            <form method="GET">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..." class="w-full max-w-md bg-dark-bg border border-accent/20 rounded-xl px-4 py-2.5 text-sm text-white placeholder-text-muted/50 focus:border-accent focus:outline-none">
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-accent/10 text-text-muted">
                        <th class="text-left py-3 px-4">Nama</th>
                        <th class="text-left py-3 px-4">Email</th>
                        <th class="text-center py-3 px-4">Role</th>
                        <th class="text-center py-3 px-4">Pesanan</th>
                        <th class="text-left py-3 px-4">Pesanan Terakhir</th>
                        <th class="text-left py-3 px-4">Bergabung</th>
                        <th class="text-right py-3 px-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr class="border-b border-accent/5 hover:bg-accent/5 transition-colors">
                            <td class="py-3 px-4 text-white font-medium">{{ $user->name }}</td>
                            <td class="py-3 px-4 text-text-muted">{{ $user->email }}</td>
                            <td class="py-3 px-4 text-center">
                                @if ($user->is_admin)
                                    <span class="bg-accent/20 text-accent text-xs font-semibold px-2 py-1 rounded-full">Admin</span>
                                @else
                                    <span class="text-text-muted text-xs">User</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-center text-white">{{ $user->orders_count }}</td>
                            <td class="py-3 px-4 text-text-muted text-xs">
                                @if($user->lastOrder)
                                    {{ $user->lastOrder->created_at->diffForHumans() }}
                                @else
                                    <span class="text-text-muted/60">Belum pernah</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-text-muted text-xs">{{ $user->created_at->format('d M Y') }}</td>
                            <td class="py-3 px-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <form method="POST" action="{{ route('admin.users.toggleAdmin', $user) }}">
                                        @csrf
                                        @method('PATCH')
                                        @if ($user->is_admin)
                                            <button type="submit" class="text-red-400 hover:text-red-300 transition-colors text-xs px-3 py-1.5 border border-red-500/30 rounded-lg">Cabut Admin</button>
                                        @else
                                            <button type="submit" class="text-accent hover:text-highlight transition-colors text-xs px-3 py-1.5 border border-accent/30 rounded-lg">Jadikan Admin</button>
                                        @endif
                                    </form>
                                    <a href="{{ route('admin.users.show', $user) }}" class="text-accent hover:text-highlight transition-colors text-xs px-3 py-1.5 border border-accent/30 rounded-lg">Detail</a>
                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Hapus pengguna ini? Semua data terkait akan dihapus.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:text-red-300 transition-colors text-xs px-3 py-1.5 border border-red-500/30 rounded-lg">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="py-12 text-center text-text-muted">Tidak ada pengguna.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($users->hasPages())
            <div class="p-4 border-t border-accent/10">
                {{ $users->links() }}
            </div>
        @endif
    </div>
@endsection
