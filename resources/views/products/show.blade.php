@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- Breadcrumb --}}
    <nav class="mb-8 text-sm text-text-muted">
        <a href="{{ url('/') }}" class="hover:text-accent transition-colors">Beranda</a>
        <span class="mx-2">/</span>
        <a href="{{ url('/products') }}" class="hover:text-accent transition-colors">Produk</a>
        <span class="mx-2">/</span>
        <span class="text-white">{{ $product->name }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
        {{-- Left: Images --}}
        <div>
            <div class="glow-border bg-surface rounded-2xl overflow-hidden mb-4 aspect-square">
                <img src="{{ $product->image_url }}"
                     alt="{{ $product->name }}"
                     class="w-full h-full object-cover">
            </div>
            <div class="grid grid-cols-4 gap-3">
                @php $images = $product->productImages ?? collect(); @endphp
                @forelse ($images as $img)
                    <div class="glow-border bg-surface rounded-xl overflow-hidden aspect-square cursor-pointer hover:border-highlight/50 transition-all">
                        <img src="{{ $img->image_path }}"
                             alt="{{ $product->name }}"
                             class="w-full h-full object-cover">
                    </div>
                @empty
                    @for ($i = 0; $i < 4; $i++)
                        <div class="glow-border bg-surface rounded-xl overflow-hidden aspect-square cursor-pointer hover:border-highlight/50 transition-all">
                            <img src="{{ $product->image_url }}"
                                 alt="{{ $product->name }}"
                                 class="w-full h-full object-cover">
                        </div>
                    @endfor
                @endforelse
            </div>
        </div>

        {{-- Right: Details --}}
        <div>
            <h1 class="font-heading text-2xl sm:text-3xl font-bold text-white mb-4">{{ $product->name }}</h1>

            <div class="mb-6">
                @if ($product->discount_price)
                    <span class="text-3xl font-bold text-accent">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</span>
                    <span class="text-lg text-text-muted line-through ml-3">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                @else
                    <span class="text-3xl font-bold text-white">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                @endif
            </div>

            <div class="mb-6">
                @if ($product->stock > 0)
                    <span class="inline-flex items-center gap-2 bg-green-500/10 text-green-400 border border-green-500/30 rounded-full px-4 py-1.5 text-sm font-medium">
                        <span class="w-2 h-2 bg-green-400 rounded-full"></span>
                        Stok: {{ $product->stock }}
                    </span>
                @else
                    <span class="inline-flex items-center gap-2 bg-red-500/10 text-red-400 border border-red-500/30 rounded-full px-4 py-1.5 text-sm font-medium">
                        <span class="w-2 h-2 bg-red-400 rounded-full"></span>
                        Stok: Habis
                    </span>
                @endif
            </div>

            <div class="mb-8">
                <h3 class="font-heading font-semibold text-white mb-2">Deskripsi</h3>
                <p class="text-text-muted leading-relaxed">{{ $product->description }}</p>
            </div>

            {{-- Quantity & Actions --}}
            <div x-data="{ qty: 1 }" class="mb-8">
                <div class="flex items-center gap-4 mb-6">
                    <span class="text-text-muted font-medium">Jumlah:</span>
                    <div class="flex items-center border border-accent/30 rounded-xl overflow-hidden">
                        <button @click="qty = Math.max(1, qty - 1)" class="px-4 py-2 text-text-muted hover:text-white hover:bg-accent/20 transition-colors text-lg">−</button>
                        <span x-text="qty" class="px-6 py-2 text-white font-semibold min-w-[3rem] text-center border-x border-accent/30"></span>
                        <button @click="qty = Math.min({{ $product->stock }}, qty + 1)" class="px-4 py-2 text-text-muted hover:text-white hover:bg-accent/20 transition-colors text-lg">+</button>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-3">
                    <form method="POST" action="{{ route('cart.add') }}" class="flex-1">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" x-model="qty">
                        <button type="submit" class="w-full bg-accent hover:bg-highlight text-white font-semibold py-3 px-6 rounded-xl transition-all duration-300">
                            Tambah ke Keranjang
                        </button>
                    </form>
                    <a href="{{ route('checkout.index') }}?product_id={{ $product->id }}" class="flex-1 text-center border border-accent/50 hover:bg-accent/10 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-300">
                        Beli Sekarang
                    </a>
                </div>
            </div>

            {{-- Category --}}
            @if ($product->category)
                <div class="pt-6 border-t border-accent/10">
                    <span class="text-text-muted text-sm">Kategori: </span>
                    <a href="{{ url('/products?category=' . $product->category->slug) }}" class="text-accent hover:text-highlight text-sm transition-colors">
                        {{ $product->category->name }}
                    </a>
                </div>
            @endif
        </div>
    </div>

    {{-- Tabbed Section --}}
    <div x-data="{ tab: 'description' }" class="mt-16">
        <div class="border-b border-accent/10 mb-8">
            <nav class="flex gap-8">
                <button @click="tab = 'description'" :class="tab === 'description' ? 'text-accent border-accent' : 'text-text-muted border-transparent'" class="font-heading font-semibold pb-4 border-b-2 transition-all duration-300">
                    Deskripsi
                </button>
                <button @click="tab = 'reviews'" :class="tab === 'reviews' ? 'text-accent border-accent' : 'text-text-muted border-transparent'" class="font-heading font-semibold pb-4 border-b-2 transition-all duration-300">
                    Ulasan
                </button>
            </nav>
        </div>

        <div x-show="tab === 'description'" class="text-text-muted leading-relaxed max-w-3xl">
            {{ $product->description }}
        </div>

        <div x-show="tab === 'reviews'" class="text-text-muted text-center py-12">
            <x-product-reviews :product="$product" />
        </div>
    </div>

    {{-- Related Products --}}
    @if(($relatedProducts ?? collect())->isNotEmpty())
        <section class="mt-20">
            <h2 class="font-heading text-2xl sm:text-3xl font-bold text-white mb-8">Produk Terkait</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($relatedProducts as $related)
                    <div class="reveal stagger-{{ $loop->index + 1 }}">
                        <x-product-card :product="$related" />
                    </div>
                @endforeach
            </div>
        </section>
    @endif
</div>
@endsection
