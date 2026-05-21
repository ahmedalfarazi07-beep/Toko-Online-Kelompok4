<div class="bg-white p-4 rounded shadow">
    <h3 class="text-lg font-bold mb-4">Filter & Cari</h3>

    <form action="{{ route('products.index') }}" method="GET" class="space-y-4">
        <!-- Search -->
        <div>
            <label class="block text-sm font-medium mb-2">Cari Produk</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama produk..."
                class="w-full border rounded px-3 py-2 text-sm">
        </div>

        <!-- Categories -->
        <div>
            <label class="block text-sm font-medium mb-2">Kategori</label>
            <div class="space-y-2">
                @foreach ($categories as $category)
                    <label class="flex items-center">
                        <input type="checkbox" name="category[]" value="{{ $category->slug }}"
                            @if (in_array($category->slug, (array) request('category', []))) checked @endif
                            class="w-4 h-4 cursor-pointer">
                        <span class="ml-2 text-sm">{{ $category->name }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <!-- Price Range -->
        <div>
            <label class="block text-sm font-medium mb-2">Harga</label>
            <div class="space-y-2">
                <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min"
                    class="w-full border rounded px-3 py-2 text-sm">
                <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max"
                    class="w-full border rounded px-3 py-2 text-sm">
            </div>
        </div>

        <!-- Rating Filter -->
        <div>
            <label class="block text-sm font-medium mb-2">Rating Minimal</label>
            <select name="min_rating" class="w-full border rounded px-3 py-2 text-sm">
                <option value="">Semua</option>
                <option value="4" @if (request('min_rating') == '4') selected @endif>4 ⭐ & Keatas</option>
                <option value="3" @if (request('min_rating') == '3') selected @endif>3 ⭐ & Keatas</option>
                <option value="2" @if (request('min_rating') == '2') selected @endif>2 ⭐ & Keatas</option>
            </select>
        </div>

        <!-- Sorting -->
        <div>
            <label class="block text-sm font-medium mb-2">Urutkan</label>
            <select name="sort" class="w-full border rounded px-3 py-2 text-sm">
                <option value="newest" @if (request('sort') == 'newest') selected @endif>Terbaru</option>
                <option value="price_low" @if (request('sort') == 'price_low') selected @endif>Harga Terendah</option>
                <option value="price_high" @if (request('sort') == 'price_high') selected @endif>Harga Tertinggi</option>
                <option value="popular" @if (request('sort') == 'popular') selected @endif>Paling Laris</option>
                <option value="rating" @if (request('sort') == 'rating') selected @endif>Rating Tertinggi</option>
            </select>
        </div>

        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm font-medium">
            Terapkan Filter
        </button>

        @if (request()->filled(['search', 'category', 'min_price', 'max_price', 'min_rating', 'sort']))
            <a href="{{ route('products.index') }}" class="block w-full text-center text-gray-600 hover:text-gray-800 text-sm">
                Reset Filter
            </a>
        @endif
    </form>
</div>
