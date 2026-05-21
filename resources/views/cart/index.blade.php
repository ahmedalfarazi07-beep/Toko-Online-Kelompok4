@extends('layouts.app')

@section('title', 'Keranjang')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="font-heading text-3xl font-bold text-white mb-8">Keranjang Belanja</h1>

    @if (($cartItems ?? collect())->isEmpty())
        {{-- Empty Cart --}}
        <div class="text-center py-20">
            <svg class="w-48 h-48 mx-auto mb-6 text-text-muted/20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="0.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/>
            </svg>
            <h2 class="font-heading text-2xl font-semibold text-white mb-3">Keranjang kosong</h2>
            <p class="text-text-muted mb-8">Yuk mulai belanja sekarang!</p>
            <a href="{{ url('/products') }}" class="inline-block bg-accent hover:bg-highlight text-white font-semibold px-8 py-4 rounded-xl transition-all duration-300">
                Belanja Sekarang
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Cart Items --}}
            <div class="lg:col-span-2 space-y-4">
                @foreach ($cartItems as $item)
                    <div class="glow-border bg-surface rounded-xl p-4 flex items-center gap-4">
                        <img src="{{ $item->product->image_url }}"
                             alt="{{ $item->product->name }}"
                             class="w-20 h-20 rounded-lg object-cover shrink-0">

                        <div class="flex-1 min-w-0">
                            <h3 class="font-heading font-semibold text-white truncate">{{ $item->product->name }}</h3>
                            <p class="text-accent font-semibold mt-1">Rp {{ number_format($item->product->discount_price ?? $item->product->price, 0, ',', '.') }}</p>
                        </div>

                        <form method="POST" action="{{ route('cart.update', $item->id) }}" class="flex items-center border border-accent/30 rounded-xl overflow-hidden shrink-0">
                            @csrf
                            @method('PATCH')
                            <button type="button" x-on:click="let qty = parseInt($el.parentElement.querySelector('input').value); qty = Math.max(1, qty - 1); $el.parentElement.querySelector('input').value = qty; $el.parentElement.submit()" class="px-3 py-1.5 text-text-muted hover:text-white hover:bg-accent/20 transition-colors">−</button>
                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}"
                                   class="w-14 text-center bg-transparent text-white text-sm py-1.5 border-x border-accent/30 focus:outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                            <button type="button" x-on:click="let qty = parseInt($el.parentElement.querySelector('input').value); qty = Math.min({{ $item->product->stock }}, qty + 1); $el.parentElement.querySelector('input').value = qty; $el.parentElement.submit()" class="px-3 py-1.5 text-text-muted hover:text-white hover:bg-accent/20 transition-colors">+</button>
                        </form>

                        <div class="text-right shrink-0 min-w-[90px]">
                            <p class="text-white font-semibold">Rp {{ number_format(($item->product->discount_price ?? $item->product->price) * $item->quantity, 0, ',', '.') }}</p>
                        </div>

                        <a href="{{ route('cart.remove', $item->id) }}"
                           class="text-text-muted hover:text-red-400 transition-colors p-2 shrink-0"
                           onclick="event.preventDefault(); if(confirm('Hapus item ini?')) document.getElementById('remove-form-{{ $item->id }}').submit();">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </a>
                        <form id="remove-form-{{ $item->id }}" method="POST" action="{{ route('cart.remove', $item->id) }}" class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                @endforeach

                {{-- Continue Shopping Button --}}
                <div class="pt-4">
                    <a href="{{ url('/products') }}" class="inline-flex items-center gap-2 text-accent hover:text-highlight transition-colors font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Lanjut Belanja
                    </a>
                </div>
            </div>

            {{-- Summary Sidebar --}}
            <div>
                <div class="sticky top-24 glow-border bg-surface rounded-xl p-6">
                    <h3 class="font-heading text-xl font-bold text-white mb-6">Ringkasan Pesanan</h3>

                    {{-- Promo Code --}}
                    <div class="mb-6">
                        <label class="text-sm text-text-muted mb-2 block">Kode Promo / Voucher</label>
                        <div class="flex gap-2">
                            <input type="text" placeholder="Masukkan kode"
                                   class="flex-1 bg-dark-bg border border-accent/20 rounded-lg px-3 py-2 text-sm text-white placeholder-text-muted/50 focus:outline-none focus:border-accent transition-all">
                            <button type="button" class="bg-accent/20 hover:bg-accent/30 text-accent font-medium px-4 py-2 rounded-lg text-sm transition-colors">
                                Pakai
                            </button>
                        </div>
                    </div>

                    <div class="space-y-4 text-sm">
                        <div class="flex justify-between text-text-muted">
                            <span>Subtotal</span>
                            <span class="text-white font-semibold">Rp {{ number_format($subtotal ?? 0, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-text-muted">
                            <span>Pengiriman</span>
                            @php $shipping = ($subtotal ?? 0) >= 100000 ? 0 : 15000; @endphp
                            @if($shipping === 0)
                                <span class="text-green-400 font-semibold">Gratis</span>
                            @else
                                <span class="text-white font-semibold">Rp {{ number_format($shipping, 0, ',', '.') }}</span>
                            @endif
                        </div>
                        <div class="border-t border-accent/10 pt-4 flex justify-between text-lg">
                            <span class="text-white font-bold">Total</span>
                            <span class="text-accent font-bold">Rp {{ number_format(($subtotal ?? 0) + $shipping, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="mt-6 flex flex-col sm:flex-row gap-3">
                        <a href="{{ url('/products') }}"
                           class="flex-1 text-center border border-accent/50 hover:bg-accent/10 text-white font-semibold py-3 rounded-xl transition-all duration-300 text-sm">
                            Lanjut Belanja
                        </a>
                        <a href="{{ url('/checkout') }}"
                           class="flex-1 block text-center bg-accent hover:bg-highlight text-white font-semibold py-3 rounded-xl transition-all duration-300 text-sm">
                            Checkout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
