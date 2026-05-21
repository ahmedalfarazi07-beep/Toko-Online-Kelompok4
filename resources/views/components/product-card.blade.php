@props(['product' => null, 'featured' => false])

<div class="bg-surface glow-border rounded-xl overflow-hidden group relative {{ $featured ? 'col-span-2 row-span-2' : '' }}"
     x-data="{ wishlisted: {{ isset($product) && $product->wishlistUsers && $product->wishlistUsers->contains(auth()->id()) ? 'true' : 'false' }} }">
    <div class="relative overflow-hidden aspect-square">
        <img
            src="{{ $product->image ? (str_starts_with($product->image, 'http') ? $product->image : asset($product->image)) : 'https://placehold.co/600x600/1A1030/A855F7?text=No+Image' }}"
            alt="{{ $product->name }}"
            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
        >
        @if(isset($product->discount_price) && $product->discount_price < $product->price)
            <div class="absolute top-3 left-3 bg-highlight text-white text-xs font-bold px-2 py-1 rounded-lg z-10">
                -{{ round((1 - $product->discount_price / $product->price) * 100) }}%
            </div>
        @endif
        @if($product->created_at->gt(now()->subDays(7)))
            <div class="absolute top-3 right-3 bg-green-500 text-white text-[10px] font-bold px-2 py-1 rounded-lg z-10">
                BARU
            </div>
        @endif

        {{-- Wishlist Button --}}
        <button type="button"
                @click="wishlisted = !wishlisted"
                class="absolute top-3 right-{{ isset($product->discount_price) && $product->discount_price < $product->price ? '12' : '3' }} z-10 p-1.5 rounded-full bg-dark-bg/60 backdrop-blur-sm hover:bg-dark-bg/80 transition-all"
                :class="wishlisted ? 'text-red-500' : 'text-white/70'">
            <svg x-show="!wishlisted" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
            </svg>
            <svg x-show="wishlisted" x-cloak class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
            </svg>
        </button>

        {{-- Quick View Overlay --}}
        <div class="absolute inset-0 bg-dark-bg/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
            <a href="{{ route('products.show', $product->id) }}"
               class="bg-white/90 hover:bg-white text-dark-bg font-semibold px-6 py-2.5 rounded-xl transition-all duration-300 transform translate-y-4 group-hover:translate-y-0 opacity-0 group-hover:opacity-100">
                Quick View
            </a>
        </div>

        {{-- Bottom Gradient --}}
        <div class="absolute bottom-0 left-0 right-0 h-16 bg-gradient-to-t from-surface to-transparent"></div>
    </div>

    <div class="p-4 space-y-3">
        <h3 class="font-heading font-semibold text-white text-lg truncate">{{ $product->name }}</h3>

        {{-- Star Rating --}}
        <div class="flex items-center gap-1">
            @for ($i = 0; $i < 5; $i++)
                <svg class="w-3.5 h-3.5 {{ $i < 4 ? 'text-yellow-400' : 'text-text-muted/30' }}" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
            @endfor
            <span class="text-text-muted/60 text-xs ml-1">Terjual 120+</span>
        </div>

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
                <button type="button" x-on:click="$el.previousElementSibling.value = Math.min({{ $product->stock }}, parseInt($el.previousElementSibling.value) + 1)" class="px-3 py-2 text-text-muted hover:text-white hover:bg-accent/10 transition-colors text-sm">+</button>
            </div>
            <button
                type="submit"
                @disabled($product->stock < 1)
                class="flex-1 px-4 py-2 text-sm font-medium bg-accent hover:bg-highlight text-white rounded-xl btn-glow transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed"
            >
                Add to Cart
            </button>
        </form>
    </div>
</div>