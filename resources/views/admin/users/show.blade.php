@extends('layouts.admin')

@section('title', 'Detail Pengguna')

@section('content')
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin.users.index') }}" class="text-text-muted hover:text-white transition-colors">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <h1 class="font-heading text-2xl font-bold text-white">Detail Pengguna</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- User Info --}}
        <div class="glow-border bg-surface rounded-xl p-6">
            <h3 class="font-heading font-bold text-white mb-4">Informasi Pengguna</h3>
            <div class="space-y-3 text-sm">
                <div>
                    <p class="text-text-muted">Nama</p>
                    <p class="text-white font-medium">{{ $user->name }}</p>
                </div>
                <div>
                    <p class="text-text-muted">Email</p>
                    <p class="text-white">{{ $user->email }}</p>
                </div>
                <div>
                    <p class="text-text-muted">Role</p>
                    <p>@if ($user->is_admin) <span class="bg-accent/20 text-accent text-xs font-semibold px-2 py-1 rounded-full">Admin</span> @else <span class="text-text-muted text-xs">User</span> @endif</p>
                </div>
                <div>
                    <p class="text-text-muted">Bergabung</p>
                    <p class="text-white">{{ $user->created_at->format('d M Y, H:i') }}</p>
                </div>
                <div>
                    <p class="text-text-muted">Total Pesanan</p>
                    <p class="text-white font-bold">{{ $user->orders_count }}</p>
                </div>
            </div>
        </div>

        {{-- Orders --}}
        <div class="lg:col-span-2 glow-border bg-surface rounded-xl p-6">
            <h3 class="font-heading font-bold text-white mb-4">Riwayat Pesanan</h3>
            @if ($user->orders->isEmpty())
                <p class="text-text-muted text-sm text-center py-8">Belum ada pesanan.</p>
            @else
                <div class="space-y-3">
                    @foreach ($user->orders as $order)
                        <a href="{{ route('admin.orders.show', $order) }}" class="flex items-center justify-between p-4 rounded-xl border border-accent/10 hover:border-accent/30 transition-all">
                            <div>
                                <span class="text-white font-medium">#{{ $order->id }}</span>
                                <p class="text-text-muted text-xs mt-0.5">{{ $order->created_at->format('d M Y, H:i') }}</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <x-status-badge :status="$order->status" />
                                <span class="text-accent font-semibold">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
