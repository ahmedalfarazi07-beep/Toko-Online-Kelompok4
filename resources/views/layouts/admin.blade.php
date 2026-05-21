<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Admin - Toko Online' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')

    <script>
        (function() {
            var saved = localStorage.getItem('theme');
            if (!saved) {
                saved = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            }
            if (saved === 'light') {
                document.documentElement.classList.add('light');
            }
        })();
    </script>
</head>
<body class="font-sans antialiased" style="background-color: var(--bg-primary); color: var(--text-primary);">
    @php
        $pendingOrders = \App\Models\Order::where('status','pending')->count();
        $lowStock = \App\Models\Product::where('stock','<',10)->count();
    @endphp

    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        <aside class="w-64 shrink-0 flex flex-col" style="background-color: var(--bg-surface); border-right: 1px solid var(--border-color);">
            <div class="p-6" style="border-bottom: 1px solid var(--border-color);">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-accent to-highlight flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-heading font-bold text-base leading-tight" style="color: var(--text-primary);">Toko Online</p>
                        <p class="text-xs text-accent">Admin Panel</p>
                    </div>
                </a>
            </div>

            <nav class="flex-1 p-4 overflow-y-auto space-y-6">
                {{-- Utama --}}
                <div>
                    <p class="text-xs font-semibold text-text-muted/50 uppercase tracking-widest px-4 mb-2">Utama</p>
                    <div class="space-y-1">
                        <a href="{{ route('admin.dashboard') }}"
                            class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
                            {{ request()->routeIs('admin.dashboard')
                                ? 'bg-gradient-to-r from-accent/30 to-highlight/10 border border-accent/30'
                                : 'text-text-muted hover:bg-accent/10' }}"
                            style="{{ request()->routeIs('admin.dashboard') ? 'color: var(--text-primary)' : '' }}">
                            <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            <span>Dashboard</span>
                        </a>
                    </div>
                </div>

                {{-- Katalog --}}
                <div>
                    <p class="text-xs font-semibold text-text-muted/50 uppercase tracking-widest px-4 mb-2">Katalog</p>
                    <div class="space-y-1">
                        <a href="{{ route('admin.products.index') }}"
                            class="flex items-center justify-between px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
                            {{ request()->routeIs('admin.products.*')
                                ? 'bg-gradient-to-r from-accent/30 to-highlight/10 border border-accent/30'
                                : 'text-text-muted hover:bg-accent/10' }}"
                            style="{{ request()->routeIs('admin.products.*') ? 'color: var(--text-primary)' : '' }}">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                                <span>Produk</span>
                            </div>
                            <span class="text-xs bg-accent/20 text-accent px-2 py-0.5 rounded-full">{{ \App\Models\Product::count() }}</span>
                        </a>

                        <a href="{{ route('admin.categories.index') }}"
                            class="flex items-center justify-between px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
                            {{ request()->routeIs('admin.categories.*')
                                ? 'bg-gradient-to-r from-accent/30 to-highlight/10 border border-accent/30'
                                : 'text-text-muted hover:bg-accent/10' }}"
                            style="{{ request()->routeIs('admin.categories.*') ? 'color: var(--text-primary)' : '' }}">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                                <span>Kategori</span>
                            </div>
                            <span class="text-xs bg-accent/20 text-accent px-2 py-0.5 rounded-full">{{ \App\Models\Category::count() }}</span>
                        </a>
                    </div>
                </div>

                {{-- Transaksi --}}
                <div>
                    <p class="text-xs font-semibold text-text-muted/50 uppercase tracking-widest px-4 mb-2">Transaksi</p>
                    <div class="space-y-1">
                        <a href="{{ route('admin.orders.index') }}"
                            class="flex items-center justify-between px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
                            {{ request()->routeIs('admin.orders.*')
                                ? 'bg-gradient-to-r from-accent/30 to-highlight/10 border border-accent/30'
                                : 'text-text-muted hover:bg-accent/10' }}"
                            style="{{ request()->routeIs('admin.orders.*') ? 'color: var(--text-primary)' : '' }}">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                <span>Pesanan</span>
                            </div>
                            @if($pendingOrders > 0)
                                <span class="text-xs bg-red-500/20 text-red-400 px-2 py-0.5 rounded-full animate-pulse">{{ $pendingOrders }} pending</span>
                            @endif
                        </a>
                    </div>
                </div>

                {{-- Pengguna --}}
                <div>
                    <p class="text-xs font-semibold text-text-muted/50 uppercase tracking-widest px-4 mb-2">Pengguna</p>
                    <div class="space-y-1">
                        <a href="{{ route('admin.users.index') }}"
                            class="flex items-center justify-between px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
                            {{ request()->routeIs('admin.users.*')
                                ? 'bg-gradient-to-r from-accent/30 to-highlight/10 border border-accent/30'
                                : 'text-text-muted hover:bg-accent/10' }}"
                            style="{{ request()->routeIs('admin.users.*') ? 'color: var(--text-primary)' : '' }}">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                                </svg>
                                <span>Pengguna</span>
                            </div>
                            <span class="text-xs bg-accent/20 text-accent px-2 py-0.5 rounded-full">{{ \App\Models\User::count() }}</span>
                        </a>
                    </div>
                </div>

                {{-- Dark/Light Toggle in Sidebar --}}
                <div class="mx-2 p-3 rounded-xl" style="background-color: var(--bg-surface-2); border: 1px solid var(--border-color);">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-semibold text-text-muted">Tema</span>
                        <button id="admin-theme-toggle" onclick="toggleTheme()"
                            class="flex items-center gap-2 text-xs text-text-muted hover:text-accent transition-colors">
                            <span id="admin-theme-label">🌙 Dark</span>
                        </button>
                    </div>
                </div>

                {{-- Stok Menipis Warning --}}
                @if($lowStock > 0)
                <div class="mx-2 p-3 rounded-xl bg-orange-500/10 border border-orange-500/20">
                    <div class="flex items-center gap-2 mb-1">
                        <svg class="w-4 h-4 text-orange-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <span class="text-xs font-semibold text-orange-400">Stok Menipis!</span>
                    </div>
                    <p class="text-xs text-orange-300/70">{{ $lowStock }} produk stok di bawah 10</p>
                    <a href="{{ route('admin.products.index') }}" class="text-xs text-orange-400 hover:text-orange-300 mt-1 inline-block">Lihat produk →</a>
                </div>
                @endif
            </nav>
        </aside>

        {{-- Main Content --}}
        <div class="flex-1 flex flex-col min-w-0">
            {{-- Top Bar --}}
            <header class="sticky top-0 z-30 backdrop-blur-lg" style="background-color: var(--nav-bg); border-bottom: 1px solid var(--border-color);">
                <div class="flex items-center justify-between px-6 py-3">
                    <div>
                        <h2 class="font-heading font-bold text-lg leading-tight" style="color: var(--text-primary);">
                            {{ $title ?? 'Dashboard' }}
                        </h2>
                        <div class="flex items-center gap-1 text-xs text-text-muted mt-0.5">
                            <a href="{{ route('admin.dashboard') }}" class="hover:text-accent transition-colors">Admin</a>
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                            <span>{{ $title ?? 'Dashboard' }}</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.products.create') }}"
                            class="hidden md:flex items-center gap-2 px-4 py-2 bg-accent/10 hover:bg-accent/20 text-accent border border-accent/20 rounded-xl text-sm font-medium transition-all">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Tambah Produk
                        </a>

                        {{-- Notification --}}
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="relative p-2.5 rounded-xl hover:bg-accent/10 text-text-muted hover:text-accent transition-colors">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.437L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                </svg>
                                @if($pendingOrders > 0)
                                    <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full"></span>
                                @endif
                            </button>
                            <div x-show="open" @click.away="open = false"
                                class="absolute right-0 top-full mt-2 w-72 rounded-xl shadow-xl overflow-hidden z-50"
                                style="background-color: var(--bg-surface); border: 1px solid var(--border-color);"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100">
                                <div class="px-4 py-3" style="border-bottom: 1px solid var(--border-color);">
                                    <p class="text-sm font-semibold" style="color: var(--text-primary);">Notifikasi</p>
                                </div>
                                <div class="p-3 space-y-2">
                                    @if($pendingOrders > 0)
                                    <div class="flex items-start gap-3 p-3 rounded-xl bg-red-500/10 border border-red-500/20">
                                        <div class="w-8 h-8 rounded-lg bg-red-500/20 flex items-center justify-center shrink-0">
                                            <svg class="w-4 h-4 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium" style="color: var(--text-primary);">{{ $pendingOrders }} Pesanan Pending</p>
                                            <p class="text-xs text-text-muted">Butuh konfirmasi segera</p>
                                            <a href="{{ route('admin.orders.index', ['status'=>'pending']) }}" class="text-xs text-red-400 hover:text-red-300 mt-1 inline-block">Lihat pesanan →</a>
                                        </div>
                                    </div>
                                    @endif
                                    @if($lowStock > 0)
                                    <div class="flex items-start gap-3 p-3 rounded-xl bg-orange-500/10 border border-orange-500/20">
                                        <div class="w-8 h-8 rounded-lg bg-orange-500/20 flex items-center justify-center shrink-0">
                                            <svg class="w-4 h-4 text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium" style="color: var(--text-primary);">{{ $lowStock }} Stok Menipis</p>
                                            <p class="text-xs text-text-muted">Segera tambah stok produk</p>
                                            <a href="{{ route('admin.products.index') }}" class="text-xs text-orange-400 hover:text-orange-300 mt-1 inline-block">Lihat produk →</a>
                                        </div>
                                    </div>
                                    @endif
                                    @if($pendingOrders == 0 && $lowStock == 0)
                                    <div class="py-6 text-center text-text-muted text-sm">Tidak ada notifikasi baru</div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- User dropdown --}}
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-accent/10 transition-colors">
                                <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-accent to-highlight flex items-center justify-center text-white text-sm font-bold shrink-0">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <div class="hidden md:block text-left">
                                    <p class="text-sm font-medium leading-tight" style="color: var(--text-primary);">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-accent leading-tight">Administrator</p>
                                </div>
                                <svg class="w-4 h-4 text-text-muted hidden md:block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div x-show="open" @click.away="open = false"
                                class="absolute right-0 top-full mt-2 w-48 rounded-xl shadow-xl overflow-hidden z-50"
                                style="background-color: var(--bg-surface); border: 1px solid var(--border-color);"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100">
                                <div class="p-2 space-y-1">
                                    <a href="{{ url('/') }}" class="flex items-center gap-2 px-3 py-2 text-sm text-text-muted hover:text-accent hover:bg-accent/10 rounded-lg transition-colors">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                        </svg>
                                        Kembali ke Toko
                                    </a>
                                    <div class="my-1" style="border-top: 1px solid var(--border-color);"></div>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 text-sm text-red-400 hover:text-red-300 hover:bg-red-500/10 rounded-lg transition-colors">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                            </svg>
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="mx-6 mt-4 bg-green-600/20 border border-green-500/30 text-green-400 px-5 py-3 rounded-xl text-sm flex items-center gap-2">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mx-6 mt-4 bg-red-600/20 border border-red-500/30 text-red-400 px-5 py-3 rounded-xl text-sm flex items-center gap-2">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ session('error') }}
                </div>
            @endif

            {{-- Content --}}
            <main class="flex-1 p-6">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        // Sync admin theme label
        document.addEventListener('DOMContentLoaded', function() {
            var label = document.getElementById('admin-theme-label');
            if (label) {
                var saved = localStorage.getItem('theme') || 'dark';
                label.textContent = saved === 'light' ? '☀️ Light' : '🌙 Dark';
            }
        });

        // Override toggleTheme to also update admin label
        var _origToggle = window.toggleTheme;
        window.toggleTheme = function() {
            _origToggle && _origToggle();
            setTimeout(function() {
                var label = document.getElementById('admin-theme-label');
                if (label) {
                    var saved = localStorage.getItem('theme') || 'dark';
                    label.textContent = saved === 'light' ? '☀️ Light' : '🌙 Dark';
                }
            }, 50);
        };
    </script>

    @stack('scripts')
</body>
</html>
