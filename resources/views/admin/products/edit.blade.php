@extends('layouts.admin')

@section('title', 'Edit Produk')

@section('content')
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin.products.index') }}" class="text-text-muted hover:text-white transition-colors">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <h1 class="font-heading text-2xl font-bold text-white">Edit Produk</h1>
    </div>

    <div class="max-w-2xl glow-border bg-surface rounded-xl p-6">
        <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-text-muted mb-2">Nama Produk</label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}" required
                       oninput="document.getElementById('slug').value = this.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '')"
                       class="w-full bg-dark-bg border border-accent/20 rounded-xl px-4 py-2.5 text-white placeholder-text-muted/50 focus:border-accent focus:outline-none">
                @error('name') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-text-muted mb-2">Slug</label>
                <input type="text" name="slug" id="slug" value="{{ old('slug', $product->slug) }}" required
                       class="w-full bg-dark-bg border border-accent/20 rounded-xl px-4 py-2.5 text-white placeholder-text-muted/50 focus:border-accent focus:outline-none">
                @error('slug') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-text-muted mb-2">Deskripsi</label>
                <textarea name="description" rows="4" required
                          class="w-full bg-dark-bg border border-accent/20 rounded-xl px-4 py-2.5 text-white placeholder-text-muted/50 focus:border-accent focus:outline-none resize-none">{{ old('description', $product->description) }}</textarea>
                @error('description') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-text-muted mb-2">Harga</label>
                    <input type="number" name="price" value="{{ old('price', $product->price) }}" required min="0"
                           class="w-full bg-dark-bg border border-accent/20 rounded-xl px-4 py-2.5 text-white placeholder-text-muted/50 focus:border-accent focus:outline-none">
                    @error('price') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-text-muted mb-2">Harga Diskon</label>
                    <input type="number" name="discount_price" value="{{ old('discount_price', $product->discount_price) }}" min="0"
                           class="w-full bg-dark-bg border border-accent/20 rounded-xl px-4 py-2.5 text-white placeholder-text-muted/50 focus:border-accent focus:outline-none">
                    @error('discount_price') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-text-muted mb-2">Stok</label>
                    <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required min="0"
                           class="w-full bg-dark-bg border border-accent/20 rounded-xl px-4 py-2.5 text-white placeholder-text-muted/50 focus:border-accent focus:outline-none">
                    @error('stock') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-text-muted mb-2">Kategori</label>
                    <select name="category_id" required
                            class="w-full bg-dark-bg border border-accent/20 rounded-xl px-4 py-2.5 text-white focus:border-accent focus:outline-none">
                        <option value="">Pilih Kategori</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-text-muted mb-2">Gambar</label>
                @if ($product->image)
                    <div class="mb-3">
                        <img src="{{ str_starts_with($product->image, 'http') ? $product->image : asset($product->image) }}" class="w-40 h-40 object-cover rounded-xl border border-accent/20">
                    </div>
                @endif

                <div class="space-y-3">
                    <div>
                        <label class="block text-xs text-text-muted mb-1">Upload File</label>
                        <input type="file" name="image" accept="image/jpeg,image/png,image/webp"
                               onchange="if(this.files[0]){ document.getElementById('preview').src = URL.createObjectURL(this.files[0]); document.getElementById('preview').classList.remove('hidden'); document.getElementById('image_url').value=''; }"
                               class="w-full text-sm text-text-muted file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-accent/20 file:text-accent hover:file:bg-accent/30">
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="flex-1 h-px bg-accent/20"></div>
                        <span class="text-xs text-text-muted">atau</span>
                        <div class="flex-1 h-px bg-accent/20"></div>
                    </div>
                    <div>
                        <label class="block text-xs text-text-muted mb-1">URL Gambar (Cloudinary, Imgur, dll)</label>
                        <input type="text" name="image_url" id="image_url" placeholder="https://..." value="{{ str_starts_with($product->image ?? '', 'http') ? $product->image : '' }}"
                               oninput="if(this.value){ document.getElementById('preview').src=this.value; document.getElementById('preview').classList.remove('hidden'); }"
                               class="w-full bg-dark-bg border border-accent/20 rounded-xl px-4 py-2.5 text-white placeholder-text-muted/50 focus:border-accent focus:outline-none text-sm">
                    </div>
                </div>
                <img id="preview" class="mt-3 w-40 h-40 object-cover rounded-xl border border-accent/20 hidden">
                @error('image') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center gap-3 pt-4">
                <button type="submit" class="bg-accent hover:bg-highlight text-white font-semibold px-6 py-2.5 rounded-xl transition-all duration-300 btn-glow">Simpan</button>
                <a href="{{ route('admin.products.index') }}" class="border border-accent/30 text-text-muted hover:text-white px-6 py-2.5 rounded-xl transition-all duration-300">Batal</a>
            </div>
        </form>
    </div>
@endsection