@extends('layouts.app')

@section('title', 'Pesanan Saya')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="font-heading text-3xl font-bold text-white mb-8">Pesanan Saya</h1>

    @forelse ($orders ?? [] as $order)
        <a href="{{ route('orders.show', $order->id) }}" class="block glow-border bg-surface rounded-xl p-5 mb-4 hover:border-accent/60 transition-all duration-300 group">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="font-heading font-semibold text-white">#{{ $order->id }}</span>
                        <x-button-status :status="$order->status" />
                    </div>
                    <p class="text-text-muted text-sm">{{ $order->created_at->format('d M Y, H:i') }}</p>
                </div>
                <div class="text-right">
                    <p class="text-accent font-bold text-lg">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                    <span class="text-text-muted text-sm group-hover:text-highlight transition-colors">Lihat Detail →</span>
                </div>
            </div>
        </a>
    @empty
        <div class="text-center py-20">
            <div class="text-7xl mb-6">📦</div>
            <h2 class="font-heading text-2xl font-semibold text-white mb-3">Belum ada pesanan</h2>
            <p class="text-text-muted mb-8">Ayo mulai belanja!</p>
            <a href="{{ url('/products') }}" class="inline-block bg-accent hover:bg-highlight text-white font-semibold px-8 py-4 rounded-xl transition-all duration-300">
                Belanja Sekarang
            </a>
        </div>
    @endforelse
</div>
@endsection
