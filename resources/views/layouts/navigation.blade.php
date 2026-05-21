@props(['cartCount' => 0])

<nav
    x-data="{ open: false }"
    class="bg-dark-bg/90 backdrop-blur-lg border-b border-accent/20"
>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <a href="{{ Auth::check() && Auth::user()->is_admin ? route('admin.dashboard') : route('dashboard') }}" class="font-heading text-xl font-bold text-highlight">
                    Toko Online
                </a>
            </div>

            <div class="hidden sm:flex sm:items-center sm:gap-6">
                <x-nav-link href="{{ Auth::check() && Auth::user()->is_admin ? route('admin.dashboard') : route('dashboard') }}" :active="request()->routeIs(Auth::check() && Auth::user()->is_admin ? 'admin.dashboard' : 'dashboard')">
                    {{ __('Dashboard') }}
                </x-nav-link>
                <x-nav-link href="{{ route('products.index') }}" :active="request()->routeIs('products.*')">
                    {{ __('Products') }}
                </x-nav-link>
            </div>

            <div class="hidden sm:flex sm:items-center sm:gap-4">
                <a href="{{ route('cart.index') }}" class="relative text-text-muted hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/>
                    </svg>
                    @if($cartCount > 0)
                        <span class="absolute -top-2 -right-2 bg-accent text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">{{ $cartCount }}</span>
                    @endif
                </a>

                @auth
                    <div class="relative" x-data="{ userOpen: false }">
                        <button @click="userOpen = !userOpen" @click.away="userOpen = false" class="flex items-center gap-2 text-sm font-medium text-text-muted hover:text-white transition-colors">
                            {{ Auth::user()->name }}
                            <svg class="w-4 h-4" :class="userOpen && 'rotate-180'" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div x-show="userOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" class="absolute right-0 mt-2 w-48 bg-surface rounded-xl glow-border py-2 shadow-2xl">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-text-muted hover:text-white hover:bg-accent/10 transition-colors">{{ __('Profile') }}</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-text-muted hover:text-white hover:bg-accent/10 transition-colors">{{ __('Logout') }}</button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="flex items-center gap-3">
                        <a href="{{ route('login') }}" class="text-sm text-text-muted hover:text-white transition-colors">{{ __('Login') }}</a>
                        <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-medium bg-accent hover:bg-highlight text-white rounded-xl btn-glow transition-all duration-300">{{ __('Register') }}</a>
                    </div>
                @endauth
            </div>

            <div class="flex items-center sm:hidden">
                <button @click="open = !open" class="text-text-muted hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{ 'block': open, 'hidden': !open }" class="sm:hidden border-t border-accent/20">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('products.index') }}" :active="request()->routeIs('products.*')">
                {{ __('Products') }}
            </x-responsive-nav-link>
        </div>
        <div class="pt-4 pb-3 border-t border-accent/20">
            @auth
                <div class="px-4 text-sm text-white font-medium">{{ Auth::user()->name }}</div>
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link href="{{ route('profile.edit') }}">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link href="#" onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Logout') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            @else
                <div class="space-y-1 px-4">
                    <x-responsive-nav-link href="{{ route('login') }}">{{ __('Login') }}</x-responsive-nav-link>
                    <x-responsive-nav-link href="{{ route('register') }}">{{ __('Register') }}</x-responsive-nav-link>
                </div>
            @endauth
        </div>
    </div>
</nav>
