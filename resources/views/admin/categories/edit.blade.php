@extends('layouts.admin')

@section('title', 'Edit Kategori')

@section('content')
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin.categories.index') }}" class="text-text-muted hover:text-white transition-colors">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <h1 class="font-heading text-2xl font-bold text-white">Edit Kategori</h1>
    </div>

    <div class="max-w-lg glow-border bg-surface rounded-xl p-6">
        <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-text-muted mb-2">Nama Kategori</label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}" required
                       oninput="document.getElementById('slug').value = this.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '')"
                       class="w-full bg-dark-bg border border-accent/20 rounded-xl px-4 py-2.5 text-white placeholder-text-muted/50 focus:border-accent focus:outline-none">
                @error('name') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-text-muted mb-2">Slug</label>
                <input type="text" name="slug" id="slug" value="{{ old('slug', $category->slug) }}" required
                       class="w-full bg-dark-bg border border-accent/20 rounded-xl px-4 py-2.5 text-white placeholder-text-muted/50 focus:border-accent focus:outline-none">
                @error('slug') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-text-muted mb-2">Ikon (emoji)</label>
                <input type="text" name="icon" value="{{ old('icon', $category->icon) }}" placeholder="📱"
                       class="w-full bg-dark-bg border border-accent/20 rounded-xl px-4 py-2.5 text-white placeholder-text-muted/50 focus:border-accent focus:outline-none">
                @error('icon') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center gap-3 pt-4">
                <button type="submit" class="bg-accent hover:bg-highlight text-white font-semibold px-6 py-2.5 rounded-xl transition-all duration-300 btn-glow">Simpan</button>
                <a href="{{ route('admin.categories.index') }}" class="border border-accent/30 text-text-muted hover:text-white px-6 py-2.5 rounded-xl transition-all duration-300">Batal</a>
            </div>
        </form>
    </div>
@endsection
