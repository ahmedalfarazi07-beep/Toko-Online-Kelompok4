@props(['cartCount' => 0])

<nav
    x-data="{ mobileOpen: false, userOpen: false, searchOpen: false, searchQuery: '{{ request('search', '') }}' }"
    class="sticky top-0 z-40 backdrop-blur-lg bg-dark-bg/80 border-b border-accent/20"
>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 gap-4">
            <div class="flex items-center gap-8">
                <a href="{{ url('/') }}" class="font-heading text-xl font-bold text-highlight tracking-tight">
                    Toko Online
                </a>
                <div class="hidden md:flex items-center gap-6">
                    <a href="{{ url('/') }}" class="text-sm font-medium text-text-muted hover:text-white transition-colors duration-200">Home</a>
                    <a href="{{ route('products.index') }}" class="text-sm font-medium text-text-muted hover:text-white transition-colors duration-200">Products</a>
                </div>
            </div>

            {{-- Search Bar --}}
            <div class="hidden md:flex flex-1 max-w-md mx-4">
                <form action="{{ route('products.index') }}" method="GET" class="w-full">
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Cari produk..."
                               class="w-full bg-surface/80 border border-accent/20 rounded-full pl-10 pr-4 py-2 text-sm text-white placeholder-text-muted/50 focus:outline-none focus:border-accent focus:ring-1 focus:ring-accent transition-all">
                        <button type="submit" class="absolute left-3 top-1/2 -translate-y-1/2 text-text-muted hover:text-white transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>

            <div class="flex items-center gap-4">
                {{-- Mobile Search Toggle --}}
                <button @click="searchOpen = !searchOpen" class="md:hidden text-text-muted hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </button>

                <a href="{{ route('cart.index') }}" class="relative text-text-muted hover:text-white transition-colors duration-200">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/>
                    </svg>
                    <span
                        x-data="{ count: {{ $cartCount }} }"
                        x-show="count > 0"
                        x-text="count"
                        class="absolute -top-2 -right-2 bg-accent text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center"
                    ></span>
                </a>

                @auth
                    <div class="relative hidden md:block">
                        <button
                            @click="userOpen = !userOpen"
                            @click.away="userOpen = false"
                            class="flex items-center gap-2 text-sm font-medium text-text-muted hover:text-white transition-colors duration-200"
                        >
                            {{ Auth::user()->name }}
                            <svg class="w-4 h-4" :class="userOpen ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div
                            x-show="userOpen"
                            x-transition:enter="animate-fade-up"
                            class="absolute right-0 mt-2 w-48 bg-surface rounded-xl glow-border py-2 shadow-2xl"
                        >
                            <a href="{{ Auth::user()->is_admin ? route('admin.dashboard') : route('dashboard') }}" class="block px-4 py-2 text-sm text-text-muted hover:text-white hover:bg-accent/10 transition-colors">Dashboard</a>
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-text-muted hover:text-white hover:bg-accent/10 transition-colors">Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-text-muted hover:text-white hover:bg-accent/10 transition-colors">Logout</button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="hidden md:flex items-center gap-3">
                        <a href="{{ route('login') }}" class="text-sm font-medium text-text-muted hover:text-white transition-colors duration-200">Login</a>
                        <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-medium bg-accent hover:bg-highlight text-white rounded-xl btn-glow transition-all duration-300">Register</a>
                    </div>
                @endauth

                <button @click="mobileOpen = !mobileOpen" class="md:hidden text-text-muted hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path x-show="!mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path x-show="mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Mobile Search Bar --}}
        <div x-show="searchOpen" x-transition:enter="animate-fade-up" class="md:hidden pb-4">
            <form action="{{ route('products.index') }}" method="GET">
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari produk..."
                           class="w-full bg-surface/80 border border-accent/20 rounded-full pl-10 pr-4 py-2.5 text-sm text-white placeholder-text-muted/50 focus:outline-none focus:border-accent transition-all">
                    <button type="submit" class="absolute left-3 top-1/2 -translate-y-1/2 text-text-muted">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div
        x-show="mobileOpen"
        x-transition:enter="animate-fade-up"
        class="md:hidden border-t border-accent/20 bg-dark-bg/95 backdrop-blur-lg"
    >
        <div class="px-4 py-4 space-y-3">
            <a href="{{ url('/') }}" class="block text-sm font-medium text-text-muted hover:text-white transition-colors">Home</a>
            <a href="{{ route('products.index') }}" class="block text-sm font-medium text-text-muted hover:text-white transition-colors">Products</a>
            <hr class="border-accent/20">
            @auth
                <p class="text-sm text-white font-medium">{{ Auth::user()->name }}</p>
                <a href="{{ Auth::user()->is_admin ? route('admin.dashboard') : route('dashboard') }}" class="block text-sm text-text-muted hover:text-white transition-colors">Dashboard</a>
                <a href="{{ route('profile.edit') }}" class="block text-sm text-text-muted hover:text-white transition-colors">Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-text-muted hover:text-white transition-colors">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block text-sm text-text-muted hover:text-white transition-colors">Login</a>
                <a href="{{ route('register') }}" class="block text-sm font-medium text-highlight hover:text-white transition-colors">Register</a>
            @endauth
        </div>
    </div>
</nav>