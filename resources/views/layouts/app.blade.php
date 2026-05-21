<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Toko Online' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
@php
    use App\Models\CartItem;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Session;

    $cartCount = Auth::check()
        ? CartItem::where('user_id', Auth::id())->sum('quantity')
        : CartItem::where('session_id', Session::getId())->sum('quantity');
@endphp

<body class="bg-dark-bg text-white/85 font-sans antialiased">
    <x-nav :cartCount="$cartCount" />

    <main>
        @yield('content')
    </main>

    {{-- Toast Container --}}
    <div id="toast-container" class="fixed bottom-4 right-4 z-50 flex flex-col gap-2"></div>

    {{-- Legacy Toast (for session messages) --}}
    <div
        x-data="{ show: false, message: '', type: 'success' }"
        x-init="
            @if(session('success'))
                message = '{{ session('success') }}'; type = 'success'; show = true;
                setTimeout(() => { if (window.showToast) showToast(message, type); }, 500);
                setTimeout(() => show = false, 5000);
            @elseif(session('error'))
                message = '{{ session('error') }}'; type = 'error'; show = true;
                setTimeout(() => { if (window.showToast) showToast(message, type); }, 500);
                setTimeout(() => show = false, 5000);
            @endif
        "
        x-show="show"
        x-transition:enter="animate-fade-up"
        class="fixed top-4 right-4 z-50 max-w-sm"
    >
        <div x-show="type === 'success'" class="bg-green-600/90 backdrop-blur-sm text-white px-5 py-4 rounded-xl shadow-2xl border border-green-500/30 flex items-center gap-3">
            <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <p x-text="message" class="text-sm font-medium"></p>
        </div>
        <div x-show="type === 'error'" class="bg-red-600/90 backdrop-blur-sm text-white px-5 py-4 rounded-xl shadow-2xl border border-red-500/30 flex items-center gap-3">
            <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <p x-text="message" class="text-sm font-medium"></p>
        </div>
    </div>

    {{-- Full Footer --}}
    <footer class="border-t border-[rgba(124,58,237,0.2)] mt-20" style="background-color: #0D0A1A;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-10">
                {{-- Column 1: Logo + Description --}}
                <div>
                    <a href="{{ url('/') }}" class="font-heading text-xl font-bold text-highlight tracking-tight inline-block mb-4">
                        Toko Online
                    </a>
                    <p class="text-text-muted text-sm leading-relaxed mb-4">
                        Belanja Mudah, Cepat, dan Terpercaya. Temukan produk berkualitas dengan harga terbaik.
                    </p>
                    {{-- Social Icons --}}
                    <div class="flex gap-3">
                        <a href="#" class="text-text-muted hover:text-highlight transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                        <a href="#" class="text-text-muted hover:text-highlight transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                        </a>
                        <a href="#" class="text-text-muted hover:text-highlight transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-2.88 2.5 2.89 2.89 0 01-2.89-2.89 2.89 2.89 0 012.89-2.89c.28 0 .54.04.79.1v-3.5a6.37 6.37 0 00-.79-.05A6.34 6.34 0 003.15 15.2a6.34 6.34 0 0010.86 4.46 6.3 6.3 0 001.86-4.48V8.73a8.26 8.26 0 004.85 1.56V6.84a4.84 4.84 0 01-1.13-.15z"/></svg>
                        </a>
                    </div>
                </div>

                {{-- Column 2: Produk Links --}}
                <div>
                    <h4 class="font-heading font-semibold text-white mb-4">Produk</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('products.index') }}" class="text-text-muted hover:text-white transition-colors">Semua Produk</a></li>
                        <li><a href="{{ url('/products?category=elektronik') }}" class="text-text-muted hover:text-white transition-colors">Elektronik</a></li>
                        <li><a href="{{ url('/products?category=fashion') }}" class="text-text-muted hover:text-white transition-colors">Fashion</a></li>
                        <li><a href="{{ url('/products?category=aksesoris') }}" class="text-text-muted hover:text-white transition-colors">Aksesoris</a></li>
                    </ul>
                </div>

                {{-- Column 3: Bantuan Links --}}
                <div>
                    <h4 class="font-heading font-semibold text-white mb-4">Bantuan</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="text-text-muted hover:text-white transition-colors">Cara Belanja</a></li>
                        <li><a href="#" class="text-text-muted hover:text-white transition-colors">Pengiriman</a></li>
                        <li><a href="#" class="text-text-muted hover:text-white transition-colors">Pengembalian</a></li>
                        <li><a href="#" class="text-text-muted hover:text-white transition-colors">FAQ</a></li>
                        <li><a href="#" class="text-text-muted hover:text-white transition-colors">Hubungi Kami</a></li>
                    </ul>
                </div>

                {{-- Column 4: Kontak --}}
                <div>
                    <h4 class="font-heading font-semibold text-white mb-4">Kontak</h4>
                    <ul class="space-y-3 text-sm text-text-muted">
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 mt-0.5 shrink-0 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>Jl. Contoh No. 123, Jakarta, Indonesia</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 shrink-0 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <span>support@tokoonline.id</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 shrink-0 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            <span>+62 812-3456-7890</span>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Bottom Bar --}}
            <div class="border-t border-accent/10 pt-8 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-text-muted text-sm">&copy; {{ date('Y') }} Toko Online. All rights reserved.</p>
                <div class="flex items-center gap-3">
                    <span class="bg-white/10 text-text-muted text-xs font-semibold px-3 py-1.5 rounded">VISA</span>
                    <span class="bg-white/10 text-text-muted text-xs font-semibold px-3 py-1.5 rounded">Mastercard</span>
                    <span class="bg-white/10 text-text-muted text-xs font-semibold px-3 py-1.5 rounded">GoPay</span>
                    <span class="bg-white/10 text-text-muted text-xs font-semibold px-3 py-1.5 rounded">OVO</span>
                    <span class="bg-white/10 text-text-muted text-xs font-semibold px-3 py-1.5 rounded">DANA</span>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
