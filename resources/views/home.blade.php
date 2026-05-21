@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
    {{-- Hero Section --}}
    <section class="relative min-h-screen overflow-hidden flex items-center">
        <canvas id="particleCanvas" class="absolute inset-0 w-full h-full"></canvas>

        <div class="absolute inset-0 bg-gradient-to-br from-accent/5 via-dark-bg/2 to-surface/3 animate-[gradient_shift_15s_ease_infinite]"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            {{-- Promo Banner Badge --}}
            <div class="inline-flex items-center gap-2 bg-gradient-to-r from-purple-600 to-pink-500 text-white text-sm sm:text-base font-semibold px-6 py-2.5 rounded-full mb-8 animate-pulse shadow-lg shadow-purple-500/30">
                <span>🔥</span>
                <span>Harbolnas Sale Up to 70% OFF</span>
            </div>

            <h1 class="font-heading text-5xl sm:text-6xl lg:text-7xl font-bold text-white mb-4">
                Toko Online
            </h1>
            <p class="font-heading text-2xl sm:text-3xl lg:text-4xl font-semibold text-highlight mb-6 h-12">
                <span id="typewriter-text"></span>
            </p>
            <p class="text-text-muted text-lg sm:text-xl mb-10 max-w-2xl mx-auto">
                Belanja Mudah, Cepat, dan Terpercaya
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ url('/products') }}" class="inline-block bg-accent hover:bg-highlight text-white font-semibold px-8 py-4 rounded-xl transition-all duration-300 text-lg shadow-lg shadow-accent/25">
                    Belanja Sekarang
                </a>
                <a href="{{ url('/products') }}" class="inline-block border border-accent/50 hover:border-highlight text-white font-semibold px-8 py-4 rounded-xl transition-all duration-300 text-lg">
                    Lihat Katalog
                </a>
            </div>

            {{-- Trust Badges --}}
            <div class="mt-10 flex flex-wrap items-center justify-center gap-3 sm:gap-6 text-sm text-text-muted/70">
                <span>✅ Gratis Ongkir</span>
                <span class="hidden sm:inline text-accent/40">•</span>
                <span>🔒 Transaksi Aman</span>
                <span class="hidden sm:inline text-accent/40">•</span>
                <span>↩️ Retur 30 Hari</span>
                <span class="hidden sm:inline text-accent/40">•</span>
                <span>⭐ 4.9/5 Rating</span>
            </div>
        </div>

        {{-- Animated Gradient Border Bottom --}}
        <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-transparent via-accent to-transparent animate-[gradient_shift_3s_ease_infinite]"></div>
        <div class="absolute bottom-0 left-0 right-0 h-32 bg-gradient-to-t from-dark-bg to-transparent"></div>
    </section>

    {{-- Flash Sale Section --}}
    <section class="py-16 bg-gradient-to-b from-dark-bg via-red-950/10 to-dark-bg" x-data="flashSaleTimer()">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Flash Sale Header --}}
            <div class="flex flex-col sm:flex-row items-center justify-between mb-10 gap-4">
                <div class="flex items-center gap-3">
                    <span class="text-3xl">⚡</span>
                    <h2 class="font-heading text-3xl sm:text-4xl font-bold text-white">
                        FLASH SALE
                    </h2>
                    <span class="bg-red-500/20 text-red-400 text-xs font-bold px-3 py-1 rounded-full animate-pulse">BERLANGSUNG</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-text-muted text-sm">Berakhir dalam</span>
                    <div class="flex gap-1.5">
                        <span class="bg-surface border border-accent/30 rounded-lg px-2.5 py-1.5 text-white font-mono font-bold text-lg min-w-[2.5rem] text-center" x-text="hours"></span>
                        <span class="text-highlight font-bold text-lg">:</span>
                        <span class="bg-surface border border-accent/30 rounded-lg px-2.5 py-1.5 text-white font-mono font-bold text-lg min-w-[2.5rem] text-center" x-text="minutes"></span>
                        <span class="text-highlight font-bold text-lg">:</span>
                        <span class="bg-surface border border-accent/30 rounded-lg px-2.5 py-1.5 text-white font-mono font-bold text-lg min-w-[2.5rem] text-center" x-text="seconds"></span>
                    </div>
                </div>
            </div>

            {{-- Flash Sale Products --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse ($flashSaleProducts ?? [] as $product)
                    @php
                        $stockPercent = $product->stock > 0 ? min(100, max(5, ($product->stock / max($product->stock + 50, 1)) * 100)) : 0;
                    @endphp
                    <div class="bg-surface glow-border rounded-xl overflow-hidden group relative">
                        <div class="relative overflow-hidden aspect-square">
                            <img
                                src="{{ $product->image ? asset('storage/' . $product->image) : 'https://placehold.co/600x600/1A1030/A855F7?text=No+Image' }}"
                                alt="{{ $product->name }}"
                                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                            >
                            @if(isset($product->discount_price) && $product->discount_price < $product->price)
                                <div class="absolute top-3 left-3 bg-red-500 text-white text-xs font-bold px-2.5 py-1 rounded-lg shadow-lg">
                                    -{{ round((1 - $product->discount_price / $product->price) * 100) }}%
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-dark-bg/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </div>
                        <div class="p-4 space-y-3">
                            <h3 class="font-heading font-semibold text-white text-base truncate">{{ $product->name }}</h3>
                            <div class="flex items-baseline gap-2">
                                @if(isset($product->discount_price) && $product->discount_price < $product->price)
                                    <span class="font-heading font-bold text-red-400 text-lg">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</span>
                                    <span class="text-text-muted text-sm line-through">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                @else
                                    <span class="font-heading font-bold text-white text-lg">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                @endif
                            </div>
                            {{-- Stock Progress Bar --}}
                            <div>
                                <div class="flex justify-between text-xs mb-1">
                                    <span class="text-red-400 font-medium">Stok tersisa {{ round($stockPercent) }}%</span>
                                </div>
                                <div class="w-full bg-dark-bg rounded-full h-2 overflow-hidden">
                                    <div class="bg-gradient-to-r from-red-500 to-orange-500 h-full rounded-full transition-all duration-500" style="width: {{ $stockPercent }}%"></div>
                                </div>
                            </div>
                            <form method="POST" action="{{ route('cart.add') }}" class="flex items-center gap-2">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" @disabled($product->stock < 1) class="w-full px-4 py-2.5 text-sm font-medium bg-red-600 hover:bg-red-500 text-white rounded-xl transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed">
                                    Ambil Sekarang
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <div class="text-5xl mb-4">⚡</div>
                        <p class="text-text-muted text-lg">Flash sale akan segera hadir!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- Featured Products --}}
    <section class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="font-heading text-3xl sm:text-4xl font-bold text-white text-center mb-12">
                Produk Unggulan
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse ($products ?? [] as $product)
                    <div class="stagger-enter" style="animation-delay: {{ $loop->index * 0.1 }}s">
                        <x-product-card :product="$product" />
                    </div>
                @empty
                    <p class="col-span-full text-center text-text-muted">Belum ada produk.</p>
                @endforelse
            </div>
        </div>
    </section>

    {{-- Categories Section --}}
    <section class="py-20 bg-surface/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="font-heading text-3xl sm:text-4xl font-bold text-white text-center mb-12">
                Kategori
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse ($categories ?? [] as $category)
                    <a href="{{ url('/products?category=' . $category->slug) }}" class="glow-border bg-surface rounded-2xl p-8 text-center hover:bg-accent/5 transition-all duration-300 group shadow-md hover:shadow-lg transform hover:-translate-y-1">
                        <div class="text-5xl mb-4">{{ $category->icon ?? '📦' }}</div>
                        <h3 class="font-heading text-2xl font-semibold text-white group-hover:text-highlight transition-colors">{{ $category->name }}</h3>
                    </a>
                @empty
                    <p class="col-span-full text-center text-text-muted">Belum ada kategori.</p>
                @endforelse
            </div>
        </div>
    </section>

    {{-- Banner Promo Section --}}
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-[#3B0764] to-[#1E1B4B] animate-[gradient_shift_5s_ease_infinite]" style="background-size: 200% 200%;">
                <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiM3QzNBRUQiIGZpbGwtb3BhY2l0eT0iMC4wNSI+PHBhdGggZD0iTTM2IDM0djZoLTZWMzRoNnptMC0zMHY2aC02VjRoNnptMCAxNXY2aC02VjE5aDZ6bTAgMTV2NmgtNlYzNGg2em0tMTUgMHY2aC02VjM0aDZ6bTAtMTV2NmgtNlYxOWg2em0wLTE1djZoLTZWNGg2eiIvPjwvZz48L2c+PC9zdmc+')] opacity-30"></div>
                <div class="relative z-10 flex flex-col lg:flex-row items-center justify-between gap-8 p-8 sm:p-12">
                    <div class="text-center lg:text-left">
                        <h3 class="font-heading text-2xl sm:text-3xl font-bold text-white mb-3">
                            Daftar Sekarang & Dapatkan Voucher Rp 50.000!
                        </h3>
                        <p class="text-text-muted/80">Khusus untuk member baru. Berlaku untuk pembelian pertama.</p>
                    </div>
                    <form action="{{ route('register') }}" method="GET" class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">
                        <input type="email" name="email" placeholder="Masukkan email Anda" required
                            class="flex-1 sm:w-72 bg-white/10 border border-white/20 rounded-xl px-5 py-3 text-white placeholder-text-muted/50 focus:outline-none focus:border-highlight focus:ring-1 focus:ring-highlight transition-all">
                        <button type="submit" class="bg-highlight hover:bg-white hover:text-purple-900 text-white font-semibold px-8 py-3 rounded-xl transition-all duration-300 whitespace-nowrap shadow-lg shadow-purple-500/25">
                            Klaim Sekarang
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    {{-- Testimonial Section --}}
    <section class="py-20 bg-surface/30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="font-heading text-3xl sm:text-4xl font-bold text-white text-center mb-4">
                Apa Kata Pelanggan Kami
            </h2>
            <p class="text-text-muted text-center mb-12 max-w-xl mx-auto">Ribuan pelanggan puas berbelanja di Toko Online</p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Testimonial 1 --}}
                <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-6 hover:border-accent/50 hover:shadow-lg hover:shadow-accent/10 transition-all duration-300 group">
                    <div class="flex items-center gap-3 mb-4">
                        <img src="https://ui-avatars.com/api/?name=Budi+Santoso&background=7C3AED&color=fff&size=48" alt="Budi S." class="w-12 h-12 rounded-full">
                        <div>
                            <p class="font-semibold text-white">Budi Santoso</p>
                            <p class="text-text-muted text-sm">Jakarta</p>
                        </div>
                    </div>
                    <div class="flex gap-0.5 mb-3">
                        @for ($i = 0; $i < 5; $i++)
                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endfor
                    </div>
                    <p class="text-text-muted text-sm leading-relaxed">"Pengalaman belanja yang luar biasa! Barang sampai dengan cepat dan kualitasnya sesuai deskripsi. Pasti akan belanja lagi di sini."</p>
                </div>

                {{-- Testimonial 2 --}}
                <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-6 hover:border-accent/50 hover:shadow-lg hover:shadow-accent/10 transition-all duration-300 group">
                    <div class="flex items-center gap-3 mb-4">
                        <img src="https://ui-avatars.com/api/?name=Siti+Aminah&background=A855F7&color=fff&size=48" alt="Siti A." class="w-12 h-12 rounded-full">
                        <div>
                            <p class="font-semibold text-white">Siti Aminah</p>
                            <p class="text-text-muted text-sm">Bandung</p>
                        </div>
                    </div>
                    <div class="flex gap-0.5 mb-3">
                        @for ($i = 0; $i < 5; $i++)
                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endfor
                    </div>
                    <p class="text-text-muted text-sm leading-relaxed">"Customer service sangat responsif dan membantu. Proses retur juga mudah tanpa ribet. Recommended banget untuk belanja online!"</p>
                </div>

                {{-- Testimonial 3 --}}
                <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-6 hover:border-accent/50 hover:shadow-lg hover:shadow-accent/10 transition-all duration-300 group">
                    <div class="flex items-center gap-3 mb-4">
                        <img src="https://ui-avatars.com/api/?name=Andi+Pratama&background=6D28D9&color=fff&size=48" alt="Andi P." class="w-12 h-12 rounded-full">
                        <div>
                            <p class="font-semibold text-white">Andi Pratama</p>
                            <p class="text-text-muted text-sm">Surabaya</p>
                        </div>
                    </div>
                    <div class="flex gap-0.5 mb-3">
                        @for ($i = 0; $i < 5; $i++)
                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endfor
                    </div>
                    <p class="text-text-muted text-sm leading-relaxed">"Harga bersaing dan banyak promo menarik. Gratis ongkir juga bikin hemat. Sudah 5 kali belanja dan selalu puas!"</p>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    // Particle canvas
    const canvas = document.getElementById('particleCanvas');
    const ctx = canvas.getContext('2d');
    let particles = [];

    function resizeCanvas() {
        canvas.width = canvas.offsetWidth;
        canvas.height = canvas.offsetHeight;
    }
    resizeCanvas();
    window.addEventListener('resize', resizeCanvas);

    class Particle {
        constructor() { this.reset(); }
        reset() {
            this.x = Math.random() * canvas.width;
            this.y = Math.random() * canvas.height;
            this.size = Math.random() * 2 + 0.5;
            this.speedX = (Math.random() - 0.5) * 0.5;
            this.speedY = (Math.random() - 0.5) * 0.5;
            this.opacity = Math.random() * 0.5 + 0.1;
        }
        update() {
            this.x += this.speedX;
            this.y += this.speedY;
            if (this.x < 0 || this.x > canvas.width) this.speedX *= -1;
            if (this.y < 0 || this.y > canvas.height) this.speedY *= -1;
        }
        draw() {
            ctx.beginPath();
            ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
            ctx.fillStyle = `rgba(124, 58, 237, ${this.opacity})`;
            ctx.fill();
        }
    }

    for (let i = 0; i < 80; i++) particles.push(new Particle());

    function animate() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        particles.forEach(p => { p.update(); p.draw(); });
        particles.forEach((a, i) => {
            for (let j = i + 1; j < particles.length; j++) {
                const b = particles[j];
                const dx = a.x - b.x, dy = a.y - b.y;
                const dist = Math.sqrt(dx * dx + dy * dy);
                if (dist < 120) {
                    ctx.beginPath();
                    ctx.moveTo(a.x, a.y);
                    ctx.lineTo(b.x, b.y);
                    ctx.strokeStyle = `rgba(124, 58, 237, ${0.08 * (1 - dist / 120)})`;
                    ctx.stroke();
                }
            }
        });
        requestAnimationFrame(animate);
    }
    animate();

    // Typewriter effect
    const words = ['Elektronik', 'Fashion', 'Aksesoris', 'Terbaik'];
    let wordIndex = 0, charIndex = 0, isDeleting = false;
    const typewriter = document.getElementById('typewriter-text');

    function typeEffect() {
        const current = words[wordIndex];
        if (isDeleting) {
            typewriter.textContent = current.substring(0, charIndex--);
        } else {
            typewriter.textContent = current.substring(0, charIndex++);
        }
        if (!isDeleting && charIndex === current.length) {
            setTimeout(() => isDeleting = true, 1500);
        } else if (isDeleting && charIndex === 0) {
            isDeleting = false;
            wordIndex = (wordIndex + 1) % words.length;
        }
        const speed = isDeleting ? 50 : 100;
        setTimeout(typeEffect, speed);
    }
    typeEffect();

    // Stagger animation observer
    document.addEventListener('DOMContentLoaded', () => {
        const staggerEls = document.querySelectorAll('.stagger-enter');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animation = `fadeInUp 0.5s ease forwards`;
                    entry.target.style.animationDelay = entry.target.style.animationDelay || '0s';
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });
        staggerEls.forEach(el => observer.observe(el));
    });
</script>
<script>
    function flashSaleTimer() {
        return {
            hours: '00',
            minutes: '00',
            seconds: '00',
            init() {
                this.update();
                setInterval(() => this.update(), 1000);
            },
            update() {
                const now = new Date();
                const midnight = new Date();
                midnight.setHours(24, 0, 0, 0);
                const diff = midnight - now;
                if (diff <= 0) {
                    this.hours = '00';
                    this.minutes = '00';
                    this.seconds = '00';
                    return;
                }
                const h = Math.floor(diff / 3600000);
                const m = Math.floor((diff % 3600000) / 60000);
                const s = Math.floor((diff % 60000) / 1000);
                this.hours = String(h).padStart(2, '0');
                this.minutes = String(m).padStart(2, '0');
                this.seconds = String(s).padStart(2, '0');
            }
        };
    }
</script>
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes gradient_shift {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
</style>
@endpush
