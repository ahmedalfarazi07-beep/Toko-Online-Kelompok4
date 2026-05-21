@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <h1 class="text-3xl font-heading font-bold text-white mb-8">Dashboard Pembeli</h1>

    {{-- Welcome Card --}}
    <div class="backdrop-blur-xl bg-surface/50 border border-accent/20 rounded-2xl p-8 shadow-2xl mb-10">
        <h2 class="text-xl font-heading font-semibold text-white mb-2">Selamat Datang, {{ auth()->user()->name }}!</h2>
        <p class="text-text-muted">
            Kelola pesanan Anda, lihat riwayat pembelian, dan berikan ulasan untuk produk yang telah dibeli.
        </p>
    </div>

    {{-- Tabs Navigation --}}
    <div class="flex gap-4 mb-8 border-b border-accent/20">
        <button x-data x-on:click="$dispatch('tab', 'orders')" class="px-4 py-3 text-accent border-b-2 border-accent font-medium" id="tab-orders-btn">
            📦 Riwayat Pesanan
        </button>
        <button x-data x-on:click="$dispatch('tab', 'reviews')" class="px-4 py-3 text-text-muted hover:text-white transition-colors" id="tab-reviews-btn">
            ⭐ Ulasan Saya
        </button>
    </div>

    {{-- Order History Tab --}}
    <div x-data="{ activeTab: 'orders' }" @tab.window="activeTab = $event.detail" id="orders-tab" class="mb-10">
        @if ($orders->isEmpty())
            <div class="bg-surface/50 border border-accent/20 rounded-xl p-8 text-center">
                <p class="text-text-muted mb-4">Belum ada pesanan.</p>
                <a href="{{ route('products.index') }}" class="inline-block px-6 py-2 bg-accent hover:bg-highlight text-white rounded-lg transition-colors">
                    Belanja Sekarang
                </a>
            </div>
        @else
            <div class="space-y-4">
                @foreach ($orders as $order)
                    <div class="bg-surface/50 border border-accent/20 rounded-xl p-6 hover:border-accent/50 transition-all">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <h3 class="text-lg font-semibold text-white">Pesanan #{{ $order->id }}</h3>
                                <p class="text-sm text-text-muted">{{ $order->created_at->format('d M Y, H:i') }}</p>
                            </div>
                            <span class="px-3 py-1 rounded-full text-sm font-medium 
                                @if($order->status === 'completed') bg-green-500/20 text-green-400
                                @elseif($order->status === 'pending') bg-yellow-500/20 text-yellow-400
                                @elseif($order->status === 'cancelled') bg-red-500/20 text-red-400
                                @else bg-blue-500/20 text-blue-400
                                @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>

                        {{-- Order Items --}}
                        <div class="bg-surface/50 rounded-lg p-4 mb-4 border border-accent/10">
                            @foreach ($order->items as $item)
                                <div class="flex items-start gap-4 pb-4 last:pb-0 last:border-b-0 border-b border-accent/10 last:mb-0 mb-4">
                                    @if ($item->product && $item->product->image_url)
                                        <img src="{{ $item->product->image_url }}" alt="{{ $item->product_name }}" class="w-16 h-16 rounded-lg object-cover">
                                    @else
                                        <div class="w-16 h-16 rounded-lg bg-accent/20 flex items-center justify-center text-accent">
                                            📦
                                        </div>
                                    @endif
                                    <div class="flex-1">
                                        <h4 class="text-white font-medium">{{ $item->product_name }}</h4>
                                        <p class="text-text-muted text-sm">{{ $item->quantity }}x @ Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="flex flex-col items-end gap-2">
                                        <p class="text-white font-semibold">Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Order Summary --}}
                        <div class="flex justify-between items-center mb-4 pt-4 border-t border-accent/10">
                            <span class="text-text-muted">Total Pesanan:</span>
                            <span class="text-xl font-semibold text-accent">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                        </div>

                        {{-- Actions --}}
                        <div class="flex gap-2">
                            <a href="{{ route('orders.show', $order) }}" class="px-4 py-2 bg-accent/20 hover:bg-accent/40 text-accent rounded-lg transition-colors text-sm">
                                Lihat Detail
                            </a>
                            @if ($order->status === 'completed')
                                <a href="#" x-data @click="document.getElementById('review-modal-{{ $order->id }}').classList.remove('hidden')" class="px-4 py-2 bg-highlight/20 hover:bg-highlight/40 text-highlight rounded-lg transition-colors text-sm">
                                    ⭐ Beri Ulasan
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Reviews Tab --}}
    <div x-data="{ activeTab: 'orders' }" @tab.window="activeTab = $event.detail" x-show="activeTab === 'reviews'" id="reviews-tab" class="mb-10">
        @if ($reviews->isEmpty())
            <div class="bg-surface/50 border border-accent/20 rounded-xl p-8 text-center">
                <p class="text-text-muted">Belum ada ulasan yang diberikan.</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach ($reviews as $review)
                    <div class="bg-surface/50 border border-accent/20 rounded-xl p-6">
                        <div class="flex items-start justify-between mb-2">
                            <h3 class="text-white font-semibold">{{ $review->product->name }}</h3>
                            <span class="text-sm text-text-muted">{{ $review->created_at->format('d M Y') }}</span>
                        </div>

                        {{-- Rating Stars --}}
                        <div class="flex items-center gap-2 mb-3">
                            @for ($i = 1; $i <= 5; $i++)
                                <span class="text-lg @if($i <= $review->rating) text-yellow-400 @else text-gray-600 @endif">★</span>
                            @endfor
                            <span class="text-sm text-text-muted ml-2">({{ $review->rating }}/5)</span>
                        </div>

                        <p class="text-text-muted mb-3">{{ $review->comment }}</p>

                        {{-- Delete Button --}}
                        <form action="{{ route('reviews.destroy', $review) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-sm text-red-400 hover:text-red-300 transition-colors" onclick="return confirm('Hapus ulasan?')">
                                Hapus
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

{{-- Review Modal (per order, show items as tabs/list) --}}
@foreach ($orders as $order)
    @if ($order->status === 'completed')
        <div id="review-modal-{{ $order->id }}" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 overflow-y-auto">
            <div class="bg-surface border border-accent/20 rounded-xl p-6 w-full max-w-2xl my-8">
                <h3 class="text-xl font-semibold text-white mb-6">Beri Ulasan untuk Pesanan #{{ $order->id }}</h3>
                
                <div class="space-y-6">
                    @foreach ($order->items as $item)
                        <div class="bg-surface/50 border border-accent/10 rounded-lg p-4">
                            <h4 class="text-white font-medium mb-4">{{ $item->product_name }}</h4>
                            
                            <form method="POST" action="{{ route('reviews.storeDashboard') }}" class="space-y-4">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $item->product_id }}">

                                {{-- Rating --}}
                                <div>
                                    <label class="block text-sm text-text-muted mb-3">Rating</label>
                                    <div class="flex gap-2">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <input type="radio" name="rating" value="{{ $i }}" id="rating-{{ $order->id }}-{{ $item->product_id }}-{{ $i }}" class="hidden" required>
                                            <label for="rating-{{ $order->id }}-{{ $item->product_id }}-{{ $i }}" class="text-3xl cursor-pointer text-gray-600 hover:text-yellow-400 transition-colors" onclick="this.previousElementSibling.checked = true">
                                                ★
                                            </label>
                                        @endfor
                                    </div>
                                </div>

                                {{-- Comment --}}
                                <div>
                                    <label class="block text-sm text-text-muted mb-2">Komentar</label>
                                    <textarea name="comment" class="w-full bg-surface/50 border border-accent/20 rounded-lg px-3 py-2 text-white focus:border-accent outline-none" rows="2" placeholder="Tuliskan pengalaman Anda..." required></textarea>
                                </div>

                                <button type="submit" class="w-full px-4 py-2 bg-accent hover:bg-highlight text-white rounded-lg transition-colors font-medium text-sm">
                                    Kirim Ulasan
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>

                {{-- Close Button --}}
                <div class="mt-6">
                    <button type="button" onclick="document.getElementById('review-modal-{{ $order->id }}').classList.add('hidden')" class="w-full px-4 py-2 bg-surface/50 hover:bg-surface border border-accent/20 text-text-muted rounded-lg transition-colors">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    @endif
@endforeach

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection
