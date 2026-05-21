@extends('layouts.admin')

@section('title', 'Dashboard')

@push('head')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')
    {{-- Stat Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <div class="glow-border bg-surface rounded-xl p-8 relative overflow-hidden">
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-accent"></div>
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-accent/20 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6 text-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
                <div>
                    <p class="text-2xl font-heading font-bold text-white">{{ $totalProducts }}</p>
                    <p class="text-sm text-text-muted">Total Produk</p>
                    <p class="text-xs text-green-400 mt-1">↑ 12% dari bulan lalu</p>
                </div>
            </div>
        </div>

        <div class="glow-border bg-surface rounded-xl p-8 relative overflow-hidden">
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-blue-500"></div>
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-blue-500/20 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
                <div>
                    <p class="text-2xl font-heading font-bold text-white">{{ $totalOrders }}</p>
                    <p class="text-sm text-text-muted">Total Pesanan</p>
                    <p class="text-xs text-green-400 mt-1">↑ 8% dari bulan lalu</p>
                </div>
            </div>
        </div>

        <div class="glow-border bg-surface rounded-xl p-8 relative overflow-hidden">
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-green-500"></div>
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-green-500/20 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-2xl font-heading font-bold text-white">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                    <p class="text-sm text-text-muted">Total Pendapatan</p>
                    <p class="text-xs text-green-400 mt-1">↑ 15% dari bulan lalu</p>
                </div>
            </div>
        </div>

        <div class="glow-border bg-surface rounded-xl p-8 relative overflow-hidden">
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-purple-500"></div>
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-purple-500/20 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/></svg>
                </div>
                <div>
                    <p class="text-2xl font-heading font-bold text-white">{{ $totalUsers }}</p>
                    <p class="text-sm text-text-muted">Total Pengguna</p>
                    <p class="text-xs text-red-400 mt-1">↓ 5% dari bulan lalu</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Revenue Chart --}}
    <div class="glow-border bg-surface rounded-xl p-6 mb-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-heading font-bold text-white">Grafik Pendapatan 7 Hari</h3>
            <span class="text-xs text-text-muted">Minggu ini</span>
        </div>
        <canvas id="revenueChart" height="80"></canvas>
    </div>

    {{-- Quick Stats Row --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="glow-border bg-surface rounded-xl p-6 relative overflow-hidden">
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-orange-500"></div>
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-orange-500/20 flex items-center justify-center">
                        <svg class="w-6 h-6 text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    </div>
                    <div>
                        <p class="text-2xl font-heading font-bold text-orange-400">{{ $lowStockCount }}</p>
                        <p class="text-sm text-text-muted">Stok Menipis</p>
                    </div>
                </div>
                <a href="{{ route('admin.products.index') }}" class="text-xs bg-orange-500/20 text-orange-400 px-3 py-1.5 rounded-lg hover:bg-orange-500/30 transition-colors">Lihat</a>
            </div>
        </div>

        <div class="glow-border bg-surface rounded-xl p-6 relative overflow-hidden">
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-red-500"></div>
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-red-500/20 flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-2xl font-heading font-bold text-red-400">{{ $pendingOrdersCount }}</p>
                        <p class="text-sm text-text-muted">Pesanan Pending</p>
                    </div>
                </div>
                <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="text-xs bg-red-500/20 text-red-400 px-3 py-1.5 rounded-lg hover:bg-red-500/30 transition-colors">Lihat</a>
            </div>
        </div>

        <div class="glow-border bg-surface rounded-xl p-6 relative overflow-hidden">
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-blue-500"></div>
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-blue-500/20 flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/></svg>
                    </div>
                    <div>
                        <p class="text-2xl font-heading font-bold text-blue-400">{{ $categoryCount }}</p>
                        <p class="text-sm text-text-muted">Kategori</p>
                    </div>
                </div>
                <a href="{{ route('admin.categories.index') }}" class="text-xs bg-blue-500/20 text-blue-400 px-3 py-1.5 rounded-lg hover:bg-blue-500/30 transition-colors">Lihat</a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Recent Orders --}}
        <div class="glow-border bg-surface rounded-xl p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-heading font-bold text-white">Pesanan Terbaru</h3>
                <a href="{{ route('admin.orders.index') }}" class="text-sm text-accent hover:text-highlight transition-colors">Lihat Semua</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-accent/10 text-text-muted">
                            <th class="text-left py-3 px-2">ID</th>
                            <th class="text-left py-3 px-2">Pelanggan</th>
                            <th class="text-right py-3 px-2">Total</th>
                            <th class="text-center py-3 px-2">Status</th>
                            <th class="text-right py-3 px-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recentOrders as $order)
                            <tr class="border-b border-accent/5 hover:bg-accent/5 transition-colors">
                                <td class="py-3 px-2 text-white">#{{ $order->id }}</td>
                                <td class="py-3 px-2 text-text-muted">{{ $order->user->name ?? 'N/A' }}</td>
                                <td class="py-3 px-2 text-right text-white font-medium">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                <td class="py-3 px-2 text-center"><x-status-badge :status="$order->status" /></td>
                                <td class="py-3 px-2 text-right">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="text-accent hover:text-highlight text-xs">Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="py-6 text-center text-text-muted">Belum ada pesanan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Activity Feed --}}
        <div class="glow-border bg-surface rounded-xl p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-heading font-bold text-white">Aktivitas Terbaru</h3>
            </div>
            <div class="space-y-4">
                @forelse ($recentOrders as $order)
                    <div class="flex items-start gap-3">
                        <div class="w-3 h-3 rounded-full bg-accent mt-1.5 shrink-0"></div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm text-white">Pesaran #{{ $order->id }} baru dari <span class="text-accent">{{ $order->user->name ?? 'N/A' }}</span></p>
                            <p class="text-xs text-text-muted mt-0.5">{{ $order->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-text-muted py-6">Belum ada aktivitas.</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Top Products --}}
    <div class="glow-border bg-surface rounded-xl p-6 mt-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-heading font-bold text-white">Produk Terlaris</h3>
            <a href="{{ route('admin.products.index') }}" class="text-sm text-accent hover:text-highlight transition-colors">Lihat Semua</a>
        </div>
        <div class="space-y-4">
            @forelse ($topProducts as $product)
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-lg bg-surface overflow-hidden border border-accent/20 shrink-0">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-white truncate">{{ $product->name }}</p>
                        <p class="text-xs text-text-muted">{{ $product->total_sold }} terjual</p>
                    </div>
                    <span class="text-sm text-accent font-semibold">Rp {{ number_format($product->discount_price ?? $product->price, 0, ',', '.') }}</span>
                </div>
            @empty
                <p class="text-center text-text-muted py-6">Belum ada data penjualan.</p>
            @endforelse
        </div>
    </div>
@endsection

@push('scripts')
<script>
const ctx = document.getElementById('revenueChart').getContext('2d');
const gradient = ctx.createLinearGradient(0, 0, 0, 200);
gradient.addColorStop(0, 'rgba(124,58,237,0.4)');
gradient.addColorStop(1, 'rgba(124,58,237,0)');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: @json($dailyRevenueLabels),
        datasets: [{
            label: 'Pendapatan (Rp)',
            data: @json($dailyRevenueData),
            borderColor: '#A855F7',
            backgroundColor: gradient,
            borderWidth: 2,
            pointBackgroundColor: '#7C3AED',
            pointRadius: 4,
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: {
                grid: { color: 'rgba(124,58,237,0.1)' },
                ticks: {
                    color: '#E2D9F3',
                    callback: val => 'Rp ' + val.toLocaleString('id-ID')
                }
            },
            x: {
                grid: { color: 'rgba(124,58,237,0.1)' },
                ticks: { color: '#E2D9F3' }
            }
        }
    }
});
</script>
@endpush
