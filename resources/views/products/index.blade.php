@extends('layouts.app')

@section('title', 'Produk')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col lg:flex-row gap-8">
        {{-- Sidebar Filter --}}
        <aside class="w-full lg:w-72 shrink-0">
            <div class="sticky top-24 glow-border bg-surface rounded-xl p-6">
                <h3 class="font-heading text-xl font-bold text-white mb-6">Filter</h3>

                <form method="GET" action="{{ url()->current() }}">
                    {{-- Category Filter --}}
                    <div class="mb-6">
                        <h4 class="font-semibold text-white mb-3">Kategori</h4>
                        <div class="space-y-2">
                            @foreach ($categories ?? [] as $category)
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="checkbox" name="category[]" value="{{ $category->slug }}"
                                        class="w-4 h-4 rounded border-accent/30 bg-surface text-accent focus:ring-accent"
                                        {{ in_array($category->slug, (array) request('category', [])) ? 'checked' : '' }}>
                                    <span class="text-sm text-white group-hover:text-accent transition-colors">{{ $category->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Price Range --}}
                    <div class="mb-6">
                        <h4 class="font-semibold text-white mb-3">Rentang Harga</h4>
                        <div class="flex gap-2 items-center">
                            <input type="number" name="min_price" placeholder="Min" value="{{ request('min_price') }}"
                                class="w-full bg-dark-bg border border-accent/20 rounded-lg px-3 py-2 text-sm text-white placeholder-text-muted/50 focus:border-accent focus:outline-none">
                            <span class="text-text-muted">—</span>
                            <input type="number" name="max_price" placeholder="Max" value="{{ request('max_price') }}"
                                class="w-full bg-dark-bg border border-accent/20 rounded-lg px-3 py-2 text-sm text-white placeholder-text-muted/50 focus:border-accent focus:outline-none">
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-accent hover:bg-highlight text-white font-semibold py-3 rounded-xl transition-all duration-300">
                        Terapkan
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main Content --}}
        <div class="flex-1 min-w-0">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="font-heading text-3xl font-bold text-white">
                        @if(request('search'))
                            Hasil pencarian untuk '{{ request('search') }}'
                        @else
                            Produk
                        @endif
                    </h1>
                </div>
                <span class="text-text-muted text-sm">{{ $products->total() ?? 0 }} produk ditemukan</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($products as $product)
                    <div class="reveal">
                        <x-product-card :product="$product" />
                    </div>
                @empty
                    <div class="col-span-full text-center py-16">
                        <div class="text-6xl mb-4">🔍</div>
                        <p class="text-text-muted text-lg">Tidak ada produk ditemukan</p>
                        <a href="{{ url('/products') }}" class="inline-block mt-4 text-accent hover:text-highlight transition-colors">Reset Filter</a>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if ($products->hasPages())
                <div class="mt-10">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection