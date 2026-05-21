@extends('layouts.admin')

@section('title', 'Tambah Produk')

@section('content')
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin.products.index') }}" class="text-text-muted hover:text-white transition-colors">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <h1 class="font-heading text-2xl font-bold text-white">Tambah Produk</h1>
    </div>

    <div class="max-w-2xl glow-border bg-surface rounded-xl p-6">
        <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-text-muted mb-2">Nama Produk</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                       oninput="document.getElementById('slug').value = this.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '')"
                       class="w-full bg-dark-bg border border-accent/20 rounded-xl px-4 py-2.5 text-white placeholder-text-muted/50 focus:border-accent focus:outline-none">
                @error('name') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-text-muted mb-2">Slug</label>
                <input type="text" name="slug" id="slug" value="{{ old('slug') }}" required
                       class="w-full bg-dark-bg border border-accent/20 rounded-xl px-4 py-2.5 text-white placeholder-text-muted/50 focus:border-accent focus:outline-none">
                @error('slug') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-text-muted mb-2">Deskripsi</label>
                <textarea name="description" rows="4" required
                          class="w-full bg-dark-bg border border-accent/20 rounded-xl px-4 py-2.5 text-white placeholder-text-muted/50 focus:border-accent focus:outline-none resize-none">{{ old('description') }}</textarea>
                @error('description') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-text-muted mb-2">Harga</label>
                    <input type="number" name="price" value="{{ old('price') }}" required min="0"
                           class="w-full bg-dark-bg border border-accent/20 rounded-xl px-4 py-2.5 text-white placeholder-text-muted/50 focus:border-accent focus:outline-none">
                    @error('price') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-text-muted mb-2">Harga Diskon</label>
                    <input type="number" name="discount_price" value="{{ old('discount_price') }}" min="0"
                           class="w-full bg-dark-bg border border-accent/20 rounded-xl px-4 py-2.5 text-white placeholder-text-muted/50 focus:border-accent focus:outline-none">
                    @error('discount_price') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-text-muted mb-2">Stok</label>
                    <input type="number" name="stock" value="{{ old('stock', 1) }}" required min="0"
                           class="w-full bg-dark-bg border border-accent/20 rounded-xl px-4 py-2.5 text-white placeholder-text-muted/50 focus:border-accent focus:outline-none">
                    @error('stock') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-text-muted mb-2">Kategori</label>
                    <select name="category_id" required
                            class="w-full bg-dark-bg border border-accent/20 rounded-xl px-4 py-2.5 text-white focus:border-accent focus:outline-none">
                        <option value="">Pilih Kategori</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-text-muted mb-2">Gambar</label>
                <input type="file" name="image" accept="image/jpeg,image/png,image/webp"
                       onchange="if(this.files[0]) document.getElementById('preview').src = URL.createObjectURL(this.files[0])"
                       class="w-full text-sm text-text-muted file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-accent/20 file:text-accent hover:file:bg-accent/30">
                <img id="preview" class="mt-3 w-40 h-40 object-cover rounded-xl border border-accent/20 hidden">
                @error('image') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center gap-3 pt-4">
                <button type="submit" class="bg-accent hover:bg-highlight text-white font-semibold px-6 py-2.5 rounded-xl transition-all duration-300 btn-glow">Simpan</button>
                <a href="{{ route('admin.products.index') }}" class="border border-accent/30 text-text-muted hover:text-white px-6 py-2.5 rounded-xl transition-all duration-300">Batal</a>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        document.querySelector('input[name="image"]')?.addEventListener('change', function() {
            document.getElementById('preview').classList.remove('hidden');
        });
    </script>
    @endpush
@endsection
