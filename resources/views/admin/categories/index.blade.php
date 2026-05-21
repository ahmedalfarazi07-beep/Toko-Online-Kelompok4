@extends('layouts.admin')

@section('title', 'Kategori')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="font-heading text-2xl font-bold text-white">Kategori</h1>
        <a href="{{ route('admin.categories.create') }}" class="bg-accent hover:bg-highlight text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-300 btn-glow">+ Tambah Kategori</a>
    </div>

    @if(session('error'))
        <div class="mb-4 bg-red-600/20 border border-red-500/30 text-red-400 px-5 py-3 rounded-xl text-sm">{{ session('error') }}</div>
    @endif

    <div class="glow-border bg-surface rounded-xl overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-accent/10 text-text-muted">
                    <th class="text-left py-3 px-4">Ikon</th>
                    <th class="text-left py-3 px-4">Nama</th>
                    <th class="text-left py-3 px-4">Slug</th>
                    <th class="text-center py-3 px-4">Jumlah Produk</th>
                    <th class="text-right py-3 px-4">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr class="border-b border-accent/5 hover:bg-accent/5 transition-colors">
                        <td class="py-3 px-4 text-2xl">{{ $category->icon ?? '📦' }}</td>
                        <td class="py-3 px-4 text-white font-medium">{{ $category->name }}</td>
                        <td class="py-3 px-4 text-text-muted">{{ $category->slug }}</td>
                        <td class="py-3 px-4 text-center text-white">{{ $category->products_count }}</td>
                        <td class="py-3 px-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.categories.edit', $category) }}" class="text-accent hover:text-highlight transition-colors text-xs px-3 py-1.5 border border-accent/30 rounded-lg">Edit</a>
                                <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Hapus kategori ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-300 transition-colors text-xs px-3 py-1.5 border border-red-500/30 rounded-lg">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="py-12 text-center text-text-muted">Tidak ada kategori.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
