@extends('layouts.admin')

@section('title', 'Pesanan')

@section('content')
    <h1 class="font-heading text-2xl font-bold text-white mb-6">Pesanan</h1>

    {{-- Search --}}
    <div class="mb-4">
        <form method="GET" class="flex items-center gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari ID pesanan atau nama pelanggan..." class="w-full max-w-md bg-surface border border-accent/20 rounded-xl px-4 py-2.5 text-sm text-white placeholder-text-muted/50 focus:border-accent focus:outline-none">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <button type="submit" class="bg-accent hover:bg-highlight text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-300">Cari</button>
        </form>
    </div>

    {{-- Filter Tabs --}}
    <div class="flex items-center gap-2 mb-6 flex-wrap">
        @php $currentStatus = request('status'); @endphp
        <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 rounded-xl text-sm font-medium transition-all duration-200 {{ !$currentStatus ? 'bg-accent text-white' : 'bg-surface text-text-muted hover:text-white border border-accent/20' }}">Semua ({{ $statusCounts->sum(fn($c) => (int)$c) }})</a>
        @foreach (['pending', 'processing', 'shipped', 'delivered', 'cancelled'] as $s)
            <a href="{{ route('admin.orders.index', ['status' => $s]) }}" class="px-4 py-2 rounded-xl text-sm font-medium transition-all duration-200 {{ $currentStatus === $s ? 'bg-accent text-white' : 'bg-surface text-text-muted hover:text-white border border-accent/20' }}">{{ ucfirst($s) }} ({{ $statusCounts[$s] ?? 0 }})</a>
        @endforeach
    </div>

    <div class="glow-border bg-surface rounded-xl overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-accent/10 text-text-muted">
                    <th class="text-left py-3 px-4">ID</th>
                    <th class="text-left py-3 px-4">Pelanggan</th>
                    <th class="text-center py-3 px-4">Item</th>
                    <th class="text-right py-3 px-4">Total</th>
                    <th class="text-center py-3 px-4">Status</th>
                    <th class="text-left py-3 px-4">Tanggal</th>
                    <th class="text-right py-3 px-4">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr class="border-b border-accent/5 hover:bg-accent/5 transition-colors">
                        <td class="py-3 px-4 text-white">#{{ $order->id }}</td>
                        <td class="py-3 px-4 text-text-muted">{{ $order->user?->name ?? 'N/A' }}</td>
                        <td class="py-3 px-4 text-center text-white">{{ $order->orderItems->sum('quantity') }}</td>
                        <td class="py-3 px-4 text-right text-white font-medium">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                        <td class="py-3 px-4 text-center"><x-status-badge :status="$order->status" /></td>
                        <td class="py-3 px-4 text-text-muted text-xs">{{ $order->created_at->format('d M Y, H:i') }}</td>
                        <td class="py-3 px-4 text-right">
                            <a href="{{ route('admin.orders.show', $order) }}" class="text-accent hover:text-highlight transition-colors text-xs px-3 py-1.5 border border-accent/30 rounded-lg">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="py-16 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <svg class="w-16 h-16 text-accent/30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <p class="text-text-muted font-medium">Belum ada pesanan</p>
                            <p class="text-sm text-text-muted/60">Pesanan dari pelanggan akan muncul di sini</p>
                        </div>
                    </td></tr>
                @endforelse
            </tbody>
        </table>

        @if ($orders->hasPages())
            <div class="p-4 border-t border-accent/10">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
@endsection
