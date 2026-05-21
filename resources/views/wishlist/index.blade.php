@extends('layouts.app')

@section('title', 'Wishlist')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="font-heading text-3xl font-bold text-white mb-8">Wishlist Saya</h1>

        @if (($wishlists ?? collect())->isEmpty())
            <div class="text-center py-20">
                <div class="text-7xl mb-6">❤️</div>
                <h2 class="font-heading text-2xl font-semibold text-white mb-3">Wishlist masih kosong</h2>
                <p class="text-text-muted mb-8">Tambah produk favoritmu ke wishlist!</p>
                <a href="{{ url('/products') }}" class="inline-block bg-accent hover:bg-highlight text-white font-semibold px-8 py-4 rounded-xl transition-all duration-300">
                    Lihat Produk
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($wishlists as $wishlist)
                    @php $product = $wishlist->product; @endphp
                    @if ($product)
                        <div class="bg-surface glow-border rounded-xl overflow-hidden group">
                            <div class="relative overflow-hidden aspect-square">
                                <img
                                    src="{{ $product->image_url }}"
                                    alt="{{ $product->name }}"
                                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                                >
                                @if(isset($product->discount_price) && $product->discount_price < $product->price)
                                    <div class="absolute top-3 left-3 bg-highlight text-white text-xs font-bold px-2 py-1 rounded-lg">
                                        -{{ round((1 - $product->discount_price / $product->price) * 100) }}%
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-dark-bg/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            </div>

                            <div class="p-4 space-y-3">
                                <h3 class="font-heading font-semibold text-white text-lg truncate">{{ $product->name }}</h3>
                                <div class="flex items-baseline gap-2">
                                    @if(isset($product->discount_price) && $product->discount_price < $product->price)
                                        <span class="font-heading font-bold text-highlight text-xl">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</span>
                                        <span class="text-text-muted text-sm line-through">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                    @else
                                        <span class="font-heading font-bold text-white text-xl">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                    @endif
                                </div>
                                <div class="flex items-center gap-2">
                                    @if($product->stock > 0)
                                        <span class="text-xs text-green-400 font-medium bg-green-400/10 px-2 py-0.5 rounded-full">In Stock</span>
                                    @else
                                        <span class="text-xs text-red-400 font-medium bg-red-400/10 px-2 py-0.5 rounded-full">Out of Stock</span>
                                    @endif
                                </div>

                                <form method="POST" action="{{ route('cart.add') }}" class="flex items-center gap-2">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <div class="flex items-center border border-accent/30 rounded-xl overflow-hidden">
                                        <button type="button" x-on:click="$el.nextElementSibling.value = Math.max(1, parseInt($el.nextElementSibling.value) - 1)" class="px-3 py-2 text-text-muted hover:text-white hover:bg-accent/10 transition-colors text-sm">-</button>
                                        <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="w-12 text-center bg-transparent text-white text-sm border-x border-accent/30 py-2 focus:outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                                        <button type="button" x-on:click="$el.previousElementSibling.value = Math.min({{ $product->stock }}, parseInt($el.previousElementSibling.value) + 1)" class="px-3 py-2 text-text-hover:text-white hover:bg-accent/10 transition-colors text-sm">+</button>
                                    </div>
                                    <button
                                        type="submit"
                                        @disabled($product->stock < 1)
                                        class="flex-1 px-4 py-2 text-sm font-medium bg-accent hover:bg-highlight text-white rounded-xl btn-glow transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed"
                                    >
                                        Add to Cart
                                    </button>
                                </form>

                                <button
                                    @click="toggleWishlist({{ $product->id }})"
                                    class="mt-3 w-full text-center text-sm font-medium border border-accent/30 rounded-xl px-4 py-2 transition-all duration-300 hover:bg-accent/10"
                                    x-data="{ inWishlist: true }"
                                    x-init="fetchWishlistStatus()"
                                    :class="{ 'text-accent': inWishlist, 'text-text-muted': !inWishlist }"
                                >
                                    <span x-show="!inWishlist" class="mr-1">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"></path></svg>
                                    </span>
                                    <span x-show="inWishlist" class="mr-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 013.842 10.154c-.086.374-.156.768-.203 1.17a9.06 9.06 0 00-4.116 0c-.047-.402-.117-.796-.203-1.17A48.827 48.827 0 0116.5 4.705v-.227zM12 14l4.763-2.216a.89.89 0 011.119 0l.705 2.757a1.125 1.125 0 01-.865 1.318L12 20.355l-3.896-2.288a1.125 1.125 0 01-.865-1.318l.705-2.757a.89.89 0 011.119 0L12 14z" clip-rule="evenodd"></path></svg>
                                    </span>
                                    Wishlist
                                </button>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @endif
    </div>

    @push('scripts')
    <script>
        function toggleWishlist(productId) {
            fetch('/wishlist/toggle', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: new URLSearchParams({ 'product_id': productId })
            })
            .then(response => response.json())
            .then(data => {
                // Toggle the button state
                const btn = document.querySelector(`button[onclick*="toggleWishlist(${productId})"]`);
                if (btn) {
                    const isInWishlist = btn.__x && btn.__x.$data.inWishlist;
                    btn.__x.$data.inWishlist = !isInWishlist;
                }
                
                // Optional: Show toast notification
                if (data.status === 'added') {
                    showToast('Produk ditambahkan ke wishlist!');
                } else {
                    showToast('Produk dihapus dari wishlist!');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        function fetchWishlistStatus() {
            // This would ideally check if product is in wishlist via API
            // For now, we'll assume the component knows based on context
            // A more complete implementation would make an API call here
        }

        function showToast(message) {
            // Remove any existing toast
            const existing = document.querySelector('.toast');
            if (existing) existing.remove();

            const toast = document.createElement('div');
            toast.className = 'toast fixed bottom-4 right-4 bg-accent/90 backdrop-blur-sm text-white px-4 py-2 rounded-xl shadow-2xl z-50';
            toast.textContent = message;
            document.body.appendChild(toast);

            // Auto remove after 3 seconds
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.parentNode.removeChild(toast);
                }
            }, 3000);
        }
    </script>
    <style>
        .toast {
            animation: slideIn 0.3s ease-out forwards;
        }
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
    </style>
    @endpush
@endsection
