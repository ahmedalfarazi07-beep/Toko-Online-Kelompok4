@extends('layouts.admin')

@section('title', 'Produk')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="font-heading text-2xl font-bold text-white">Produk</h1>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.products.export') }}" class="border border-accent/30 text-accent hover:bg-accent/10 px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-300">Export CSV</a>
            <a href="{{ route('admin.products.create') }}" class="bg-accent hover:bg-highlight text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-300 btn-glow">+ Tambah Produk</a>
        </div>
    </div>

    <div class="glow-border bg-surface rounded-xl overflow-hidden" x-data="{ selected: [], allChecked: false }">
        <div class="p-4 border-b border-accent/10">
            <form method="GET" class="flex items-center gap-3 flex-wrap">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk..." class="bg-dark-bg border border-accent/20 rounded-xl px-4 py-2.5 text-sm text-white placeholder-text-muted/50 focus:border-accent focus:outline-none">
                <select name="category" onchange="this.form.submit()" class="bg-dark-bg border border-accent/20 rounded-xl px-4 py-2.5 text-sm text-white">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category')==$cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

        {{-- Bulk Actions Bar --}}
        <div x-show="selected.length > 0" x-cloak class="px-4 py-3 bg-accent/10 border-b border-accent/20 flex items-center justify-between">
            <span class="text-sm text-white"><span x-text="selected.length"></span> produk dipilih</span>
            <form method="POST" action="{{ route('admin.products.bulk-delete') }}" onsubmit="return confirm('Hapus produk yang dipilih?')">
                @csrf
                @method('DELETE')
                <template x-for="id in selected" :key="id">
                    <input type="hidden" name="ids[]" :value="id">
                </template>
                <button type="submit" class="bg-red-500/20 text-red-400 hover:bg-red-500/30 px-4 py-2 rounded-xl text-sm font-medium transition-colors">Hapus Terpilih</button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-accent/10 text-text-muted">
                        <th class="text-left py-3 px-4 w-10">
                            @php $productIds = collect($products->items())->pluck('id'); @endphp
                            <input type="checkbox" x-model="allChecked" @change="selected = allChecked ? {{ json_encode($productIds) }} : []" class="rounded border-accent/30 bg-dark-bg text-accent focus:ring-accent">
                        </th>
                        <th class="text-left py-3 px-4">Produk</th>
                        <th class="text-left py-3 px-4">Kategori</th>
                        <th class="text-right py-3 px-4">Harga</th>
                        <th class="text-center py-3 px-4">Stok</th>
                        <th class="text-right py-3 px-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr class="border-b border-accent/5 hover:bg-accent/5 transition-colors">
                            <td class="py-3 px-4">
                                <input type="checkbox" :value="{{ $product->id }}" x-model="selected" @change="allChecked = selected.length === {{ json_encode($productIds) }}.length" class="rounded border-accent/30 bg-dark-bg text-accent focus:ring-accent">
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg overflow-hidden bg-surface border border-accent/20 shrink-0">
                                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                    </div>
                                    <span class="text-white font-medium truncate max-w-[200px]">{{ $product->name }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-4 text-text-muted">{{ $product->category?->name ?? '-' }}</td>
                            <td class="py-3 px-4 text-right text-white">
                                @if ($product->discount_price)
                                    <span class="text-accent">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</span>
                                    <span class="text-text-muted line-through text-xs ml-1">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                @else
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                @endif
                            </td>
                            <td class="py-3 px-4 text-center">
                                @if ($product->stock == 0)
                                    <span class="bg-red-500/20 text-red-400 text-xs font-semibold px-2 py-1 rounded-full">Habis</span>
                                @elseif ($product->stock < 10)
                                    <span class="bg-orange-500/20 text-orange-400 text-xs font-semibold px-2 py-1 rounded-full">Menipis</span>
                                @else
                                    <span class="bg-green-500/20 text-green-400 text-xs font-semibold px-2 py-1 rounded-full">Tersedia</span>
                                @endif
                                <p class="text-xs text-text-muted mt-1">{{ $product->stock }}</p>
                            </td>
                            <td class="py-3 px-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.products.edit', $product) }}" class="text-accent hover:text-highlight transition-colors text-xs px-3 py-1.5 border border-accent/30 rounded-lg">Edit</a>
                                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Hapus produk ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:text-red-300 transition-colors text-xs px-3 py-1.5 border border-red-500/30 rounded-lg">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="py-12 text-center text-text-muted">Tidak ada produk.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($products->hasPages())
            <div class="p-4 border-t border-accent/10">
                {{ $products->links() }}
            </div>
        @endif
    </div>
@endsection
