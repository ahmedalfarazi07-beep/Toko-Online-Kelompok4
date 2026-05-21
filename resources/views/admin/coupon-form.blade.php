@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <h1 class="text-3xl font-bold mb-6">Tambah Kupon Baru</h1>

    <div class="bg-white shadow rounded p-6">
        <form action="{{ route('admin.coupons.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium mb-2">Kode Kupon *</label>
                <input type="text" name="code" value="{{ old('code') }}" placeholder="Contoh: DISKON50"
                    class="w-full border rounded px-3 py-2 @error('code') border-red-500 @enderror">
                @error('code')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">Deskripsi</label>
                <textarea name="description" rows="3" placeholder="Contoh: Diskon spesial untuk member baru"
                    class="w-full border rounded px-3 py-2">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-2">Tipe Diskon *</label>
                    <select name="type" class="w-full border rounded px-3 py-2 @error('type') border-red-500 @enderror">
                        <option value="fixed" @selected(old('type') == 'fixed')>Fixed (Rp)</option>
                        <option value="percentage" @selected(old('type') == 'percentage')>Persentase (%)</option>
                    </select>
                    @error('type')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Nilai Diskon *</label>
                    <input type="number" name="value" value="{{ old('value') }}" step="0.01" min="0.01" placeholder="50000"
                        class="w-full border rounded px-3 py-2 @error('value') border-red-500 @enderror">
                    @error('value')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-2">Minimal Pembelian (Opsional)</label>
                    <input type="number" name="min_purchase" value="{{ old('min_purchase') }}" step="0.01" placeholder="100000"
                        class="w-full border rounded px-3 py-2 @error('min_purchase') border-red-500 @enderror">
                    @error('min_purchase')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Batas Penggunaan (Opsional)</label>
                    <input type="number" name="usage_limit" value="{{ old('usage_limit') }}" min="1" placeholder="100"
                        class="w-full border rounded px-3 py-2 @error('usage_limit') border-red-500 @enderror">
                    @error('usage_limit')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-2">Berlaku Dari</label>
                    <input type="date" name="valid_from" value="{{ old('valid_from') }}"
                        class="w-full border rounded px-3 py-2 @error('valid_from') border-red-500 @enderror">
                    @error('valid_from')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Berlaku Sampai</label>
                    <input type="date" name="valid_until" value="{{ old('valid_until') }}"
                        class="w-full border rounded px-3 py-2 @error('valid_until') border-red-500 @enderror">
                    @error('valid_until')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex gap-3 pt-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded font-medium">
                    Simpan Kupon
                </button>
                <a href="{{ route('admin.coupons.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-2 rounded font-medium">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
