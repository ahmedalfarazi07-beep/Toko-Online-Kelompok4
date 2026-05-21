@extends('layouts.app')

@section('title', 'Detail Pesanan #' . $order->id)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <nav class="mb-6 text-sm text-text-muted">
        <a href="{{ url('/') }}" class="hover:text-accent transition-colors">Beranda</a>
        <span class="mx-2">/</span>
        <a href="{{ route('orders.index') }}" class="hover:text-accent transition-colors">Pesanan Saya</a>
        <span class="mx-2">/</span>
        <span class="text-white">#{{ $order->id }}</span>
    </nav>

    <div class="flex items-center gap-4 mb-8">
        <h1 class="font-heading text-3xl font-bold text-white">Detail Pesanan #{{ $order->id }}</h1>
        <x-button-status :status="$order->status" />
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Main Content --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Order Items --}}
            <div class="glow-border bg-surface rounded-xl p-6">
                <h2 class="font-heading text-lg font-bold text-white mb-4">Item Pesanan</h2>
                <div class="space-y-4">
                    @foreach ($order->orderItems as $item)
                        <div class="flex items-center gap-4 border-b border-accent/10 pb-4 last:border-0 last:pb-0">
                            <img src="{{ $item->product?->image_url ?? 'https://placehold.co/80x80/1A1030/7C3AED?text=Produk' }}"
                                 alt="{{ $item->name }}"
                                 class="w-16 h-16 rounded-lg object-cover shrink-0">
                            <div class="flex-1">
                                <h3 class="font-heading font-semibold text-white">{{ $item->name }}</h3>
                                <p class="text-text-muted text-sm">{{ $item->quantity }} × Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                            </div>
                            <p class="text-accent font-semibold">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Timeline --}}
            <div class="glow-border bg-surface rounded-xl p-6">
                <h2 class="font-heading text-lg font-bold text-white mb-4">Status Pesanan</h2>
                <div class="relative pl-8 space-y-6 before:absolute before:left-3 before:top-2 before:bottom-2 before:w-0.5 before:bg-accent/30">
                    @forelse ($order->statuses as $status)
                        <div class="relative">
                            <div class="absolute -left-8 top-1 w-6 h-6 rounded-full flex items-center justify-center
                                {{ $loop->first ? 'bg-accent' : 'bg-accent/20' }}">
                                <div class="w-2 h-2 rounded-full {{ $loop->first ? 'bg-white' : 'bg-accent' }}"></div>
                            </div>
                            <p class="text-white font-medium">{{ $status->name }}</p>
                            <p class="text-text-muted text-sm">{{ $status->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    @empty
                        <div class="relative">
                            <div class="absolute -left-8 top-1 w-6 h-6 rounded-full bg-accent flex items-center justify-center">
                                <div class="w-2 h-2 rounded-full bg-white"></div>
                            </div>
                            <p class="text-white font-medium">{{ ucfirst($order->status) }}</p>
                            <p class="text-text-muted text-sm">{{ $order->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            <div class="glow-border bg-surface rounded-xl p-6">
                <h3 class="font-heading font-bold text-white mb-4">Informasi Pengiriman</h3>
                <div class="space-y-2 text-sm">
                    <p class="text-text-muted">Alamat:</p>
                    <p class="text-white">{{ $order->shipping_address }}</p>
                    @if($order->shipping_city)
                        <p class="text-text-muted">{{ $order->shipping_city }}{{ $order->shipping_province ? ', ' . $order->shipping_province : '' }}{{ $order->shipping_postal_code ? ' ' . $order->shipping_postal_code : '' }}</p>
                    @endif
                </div>
            </div>

            <div class="glow-border bg-surface rounded-xl p-6">
                <h3 class="font-heading font-bold text-white mb-4">Pembayaran</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between text-text-muted">
                        <span>Metode</span>
                        <span class="text-white">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</span>
                    </div>
                    <div class="flex justify-between text-text-muted">
                        <span>Subtotal</span>
                        <span class="text-white">Rp {{ number_format($order->orderItems->sum(fn($i) => $i->price * $i->quantity), 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-text-muted">
                        <span>Pengiriman</span>
                        <span class="text-green-400">Gratis</span>
                    </div>
                    <div class="border-t border-accent/10 pt-3 flex justify-between">
                        <span class="text-white font-bold">Total</span>
                        <span class="text-accent font-bold text-lg">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-8">
        <a href="{{ route('orders.index') }}" class="text-text-muted hover:text-white transition-colors">
            ← Kembali ke Pesanan Saya
        </a>
    </div>
</div>
@endsection
