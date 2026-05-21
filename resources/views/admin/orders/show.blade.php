@extends('layouts.admin')

@section('title', 'Detail Pesanan #' . $order->id)

@section('content')
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin.orders.index') }}" class="text-text-muted hover:text-white transition-colors">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <h1 class="font-heading text-2xl font-bold text-white">Detail Pesanan #{{ $order->id }}</h1>
        <x-status-badge :status="$order->status" />
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Main --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Items --}}
            <div class="glow-border bg-surface rounded-xl p-6">
                <h2 class="font-heading text-lg font-bold text-white mb-4">Item Pesanan</h2>
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-accent/10 text-text-muted">
                            <th class="text-left py-2 px-2">Produk</th>
                            <th class="text-center py-2 px-2">Qty</th>
                            <th class="text-right py-2 px-2">Harga</th>
                            <th class="text-right py-2 px-2">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->orderItems as $item)
                            <tr class="border-b border-accent/5">
                                <td class="py-3 px-2">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-lg overflow-hidden bg-surface border border-accent/20 shrink-0">
                                            <img src="{{ $item->product?->image_url ?? 'https://placehold.co/80x80/1A1030/7C3AED?text=Produk' }}" alt="{{ $item->name }}" class="w-full h-full object-cover">
                                        </div>
                                        <span class="text-white">{{ $item->name }}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-2 text-center text-white">{{ $item->quantity }}</td>
                                <td class="py-3 px-2 text-right text-text-muted">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                <td class="py-3 px-2 text-right text-white font-medium">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="font-bold">
                            <td colspan="3" class="py-3 px-2 text-right text-white">Total</td>
                            <td class="py-3 px-2 text-right text-accent">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            {{-- Timeline --}}
            <div class="glow-border bg-surface rounded-xl p-6">
                <h2 class="font-heading text-lg font-bold text-white mb-4">Riwayat Status</h2>
                <div class="relative pl-8 space-y-5 before:absolute before:left-3 before:top-2 before:bottom-2 before:w-0.5 before:bg-accent/30">
                    @forelse ($order->statuses as $status)
                        <div class="relative">
                            <div class="absolute -left-8 top-1 w-6 h-6 rounded-full flex items-center justify-center {{ $loop->first ? 'bg-accent' : 'bg-accent/20' }}">
                                <div class="w-2 h-2 rounded-full {{ $loop->first ? 'bg-white' : 'bg-accent' }}"></div>
                            </div>
                            <p class="text-white font-medium text-sm">{{ $status->name }}</p>
                            <p class="text-text-muted text-xs">{{ $status->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    @empty
                        <div class="relative">
                            <div class="absolute -left-8 top-1 w-6 h-6 rounded-full bg-accent flex items-center justify-center">
                                <div class="w-2 h-2 rounded-full bg-white"></div>
                            </div>
                            <p class="text-white font-medium text-sm">{{ ucfirst($order->status) }}</p>
                            <p class="text-text-muted text-xs">{{ $order->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            {{-- Status Update --}}
            <div class="glow-border bg-surface rounded-xl p-6">
                <h3 class="font-heading font-bold text-white mb-4">Update Status</h3>
                <form method="POST" action="{{ route('admin.orders.update', $order) }}" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <select name="status" class="w-full bg-dark-bg border border-accent/20 rounded-xl px-4 py-2.5 text-white focus:border-accent focus:outline-none text-sm">
                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Diproses</option>
                        <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Dikirim</option>
                        <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Selesai</option>
                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                    <button type="submit" class="w-full bg-accent hover:bg-highlight text-white font-semibold py-2.5 rounded-xl transition-all duration-300 text-sm btn-glow">Update Status</button>
                </form>
            </div>

            {{-- Customer Info --}}
            <div class="glow-border bg-surface rounded-xl p-6">
                <h3 class="font-heading font-bold text-white mb-4">Informasi Pelanggan</h3>
                <div class="space-y-2 text-sm">
                    <p class="text-text-muted">Nama</p>
                    <p class="text-white">{{ $order->user?->name ?? 'N/A' }}</p>
                    <p class="text-text-muted mt-3">Email</p>
                    <p class="text-white">{{ $order->user?->email ?? 'N/A' }}</p>
                </div>
            </div>

            {{-- Shipping Info --}}
            <div class="glow-border bg-surface rounded-xl p-6">
                <h3 class="font-heading font-bold text-white mb-4">Alamat Pengiriman</h3>
                <div class="space-y-2 text-sm">
                    <p class="text-white">{{ $order->shipping_address }}</p>
                    @if ($order->shipping_city)
                        <p class="text-text-muted">{{ $order->shipping_city }}{{ $order->shipping_province ? ', ' . $order->shipping_province : '' }}{{ $order->shipping_postal_code ? ' ' . $order->shipping_postal_code : '' }}</p>
                    @endif
                </div>
            </div>

            {{-- Payment Info --}}
            <div class="glow-border bg-surface rounded-xl p-6">
                <h3 class="font-heading font-bold text-white mb-4">Pembayaran</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-text-muted">Metode</span>
                        <span class="text-white">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</span>
                    </div>
                    <div class="flex justify-between border-t border-accent/10 pt-2 mt-2">
                        <span class="text-white font-bold">Total</span>
                        <span class="text-accent font-bold">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
