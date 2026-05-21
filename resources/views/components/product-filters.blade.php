<div class="glow-border rounded-xl p-6" style="background-color: var(--bg-surface);">
    <h3 class="font-heading text-xl font-bold mb-6" style="color: var(--text-primary);">Filter & Cari</h3>

    <form action="{{ route('products.index') }}" method="GET" class="space-y-6">
        {{-- Search --}}
        <div>
            <label class="block text-sm font-medium text-text-muted mb-2">Cari Produk</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama produk..."
                class="w-full rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-accent transition-all"
                style="background-color: var(--input-bg); border: 1px solid var(--border-color); color: var(--text-primary);">
        </div>

        {{-- Categories --}}
        <div>
            <label class="block text-sm font-medium text-text-muted mb-2">Kategori</label>
            <div class="space-y-2">
                @foreach ($categories as $category)
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="checkbox" name="category[]" value="{{ $category->slug }}"
                            @if (in_array($category->slug, (array) request('category', []))) checked @endif
                            class="w-4 h-4 rounded border-accent/30 bg-surface text-accent focus:ring-accent cursor-pointer">
                        <span class="text-sm text-text-muted group-hover:text-accent transition-colors">{{ $category->name }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        {{-- Price Range --}}
        <div>
            <label class="block text-sm font-medium text-text-muted mb-2">Rentang Harga</label>
            <div class="flex gap-2 items-center">
                <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min"
                    class="w-full rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-accent transition-all"
                    style="background-color: var(--input-bg); border: 1px solid var(--border-color); color: var(--text-primary);">
                <span class="text-text-muted">—</span>
                <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max"
                    class="w-full rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-accent transition-all"
                    style="background-color: var(--input-bg); border: 1px solid var(--border-color); color: var(--text-primary);">
            </div>
        </div>

        {{-- Rating Filter --}}
        <div>
            <label class="block text-sm font-medium text-text-muted mb-2">Rating Minimal</label>
            <select name="min_rating"
                class="w-full rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-accent transition-all"
                style="background-color: var(--input-bg); border: 1px solid var(--border-color); color: var(--text-primary);">
                <option value="">Semua</option>
                <option value="4" @if (request('min_rating') == '4') selected @endif>4 ⭐ & Keatas</option>
                <option value="3" @if (request('min_rating') == '3') selected @endif>3 ⭐ & Keatas</option>
                <option value="2" @if (request('min_rating') == '2') selected @endif>2 ⭐ & Keatas</option>
            </select>
        </div>

        {{-- Sorting --}}
        <div>
            <label class="block text-sm font-medium text-text-muted mb-2">Urutkan</label>
            <select name="sort"
                class="w-full rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-accent transition-all"
                style="background-color: var(--input-bg); border: 1px solid var(--border-color); color: var(--text-primary);">
                <option value="newest" @if (request('sort') == 'newest') selected @endif>Terbaru</option>
                <option value="price_low" @if (request('sort') == 'price_low') selected @endif>Harga Terendah</option>
                <option value="price_high" @if (request('sort') == 'price_high') selected @endif>Harga Tertinggi</option>
                <option value="popular" @if (request('sort') == 'popular') selected @endif>Paling Laris</option>
                <option value="rating" @if (request('sort') == 'rating') selected @endif>Rating Tertinggi</option>
            </select>
        </div>

        <button type="submit" class="w-full bg-accent hover:bg-highlight text-white font-semibold py-3 rounded-xl transition-all duration-300">
            Terapkan Filter
        </button>

        @if (request()->filled(['search', 'category', 'min_price', 'max_price', 'min_rating', 'sort']))
            <a href="{{ route('products.index') }}" class="block w-full text-center text-text-muted hover:text-accent text-sm transition-colors">
                Reset Filter
            </a>
        @endif
    </form>
</div>
