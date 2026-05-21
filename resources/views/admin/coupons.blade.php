@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Kelola Kupon</h1>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-6">
        <a href="{{ route('admin.coupons.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">
            + Tambah Kupon
        </a>
    </div>

    <div class="bg-white shadow rounded overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-900">Kode</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-900">Diskon</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-900">Minimal Pembelian</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-900">Valid Sampai</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-900">Digunakan</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-900">Status</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-900">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($coupons as $coupon)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm font-mono font-medium">{{ $coupon->code }}</td>
                        <td class="px-6 py-4 text-sm">
                            @if ($coupon->type === 'fixed')
                                Rp {{ number_format($coupon->value, 0, ',', '.') }}
                            @else
                                {{ $coupon->value }}%
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm">
                            {{ $coupon->min_purchase ? 'Rp ' . number_format($coupon->min_purchase, 0, ',', '.') : '-' }}
                        </td>
                        <td class="px-6 py-4 text-sm">{{ $coupon->valid_until?->format('d/m/Y') ?? 'Tidak terbatas' }}</td>
                        <td class="px-6 py-4 text-sm">
                            {{ $coupon->used_count }}
                            @if ($coupon->usage_limit)
                                / {{ $coupon->usage_limit }}
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <span class="px-2 py-1 rounded text-xs font-medium {{ $coupon->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $coupon->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm space-x-2">
                            <a href="{{ route('admin.coupons.edit', $coupon) }}" class="text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">Belum ada kupon</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($coupons->hasPages())
        <div class="mt-6">
            {{ $coupons->links() }}
        </div>
    @endif
</div>
@endsection
