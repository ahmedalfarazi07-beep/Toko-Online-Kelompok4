@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="font-heading text-3xl font-bold text-white mb-8 text-center">Checkout</h1>

    <div x-data="checkoutForm()" x-init="init()" class="space-y-8">

        {{-- Step Progress --}}
        <div class="flex items-center justify-center gap-2 sm:gap-4">
            <template x-for="(step, index) in steps" :key="index">
                <div class="flex items-center">
                    <div class="flex flex-col items-center">
                        <div :class="stepNumberClass(index)" class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold transition-all duration-300"
                             x-text="index + 1">
                        </div>
                        <span class="text-xs mt-2 hidden sm:block" :class="stepLabelClass(index)" x-text="step"></span>
                    </div>
                    <template x-if="index < steps.length - 1">
                        <div :class="stepConnectorClass(index)" class="w-8 sm:w-16 h-0.5 mx-1 sm:mx-2 rounded transition-all duration-300"></div>
                    </template>
                </div>
            </template>
        </div>

        {{-- Step 1: Shipping --}}
        <div x-show="step === 1" class="glow-border bg-surface rounded-xl p-6 sm:p-8">
            <h2 class="font-heading text-xl font-bold text-white mb-6">Alamat Pengiriman</h2>
            <div class="space-y-4">
                <div>
                    <label class="block text-text-muted text-sm mb-2">Alamat Lengkap</label>
                    <textarea x-model="form.address" rows="3"
                              class="w-full bg-dark-bg border border-accent/20 rounded-xl px-4 py-3 text-white placeholder-text-muted/50 focus:border-accent focus:outline-none resize-none"
                              placeholder="Jalan, nomor rumah, RT/RW, kelurahan..."></textarea>
                    <template x-if="errors.address">
                        <p class="text-red-400 text-sm mt-1" x-text="errors.address"></p>
                    </template>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-text-muted text-sm mb-2">Kota</label>
                        <input type="text" x-model="form.city"
                               class="w-full bg-dark-bg border border-accent/20 rounded-xl px-4 py-3 text-white placeholder-text-muted/50 focus:border-accent focus:outline-none"
                               placeholder="Kota">
                        <template x-if="errors.city">
                            <p class="text-red-400 text-sm mt-1" x-text="errors.city"></p>
                        </template>
                    </div>
                    <div>
                        <label class="block text-text-muted text-sm mb-2">Provinsi</label>
                        <input type="text" x-model="form.province"
                               class="w-full bg-dark-bg border border-accent/20 rounded-xl px-4 py-3 text-white placeholder-text-muted/50 focus:border-accent focus:outline-none"
                               placeholder="Provinsi">
                        <template x-if="errors.province">
                            <p class="text-red-400 text-sm mt-1" x-text="errors.province"></p>
                        </template>
                    </div>
                </div>
                <div>
                    <label class="block text-text-muted text-sm mb-2">Kode Pos</label>
                    <input type="text" x-model="form.postal_code"
                           class="w-full bg-dark-bg border border-accent/20 rounded-xl px-4 py-3 text-white placeholder-text-muted/50 focus:border-accent focus:outline-none"
                           placeholder="Kode Pos">
                    <template x-if="errors.postal_code">
                        <p class="text-red-400 text-sm mt-1" x-text="errors.postal_code"></p>
                    </template>
                </div>
            </div>
            <div class="mt-8 flex justify-end">
                <button @click="goToStep(2)" class="bg-accent hover:bg-highlight text-white font-semibold px-8 py-3 rounded-xl transition-all duration-300">
                    Lanjut ke Pembayaran
                </button>
            </div>
        </div>

        {{-- Step 2: Payment --}}
        <div x-show="step === 2" class="glow-border bg-surface rounded-xl p-6 sm:p-8">
            <h2 class="font-heading text-xl font-bold text-white mb-6">Metode Pembayaran</h2>

            <div class="space-y-4 mb-8">
                <template x-for="method in paymentMethods" :key="method.id">
                    <label class="flex items-center gap-4 p-4 rounded-xl border cursor-pointer transition-all"
                           :class="form.payment_method === method.id ? 'border-accent bg-accent/10' : 'border-accent/20 hover:border-accent/40'">
                        <input type="radio" x-model="form.payment_method" :value="method.id" class="text-accent focus:ring-accent">
                        <div>
                            <span class="text-white font-medium" x-text="method.name"></span>
                            <p class="text-text-muted text-sm" x-text="method.description"></p>
                        </div>
                    </label>
                </template>
                <template x-if="errors.payment_method">
                    <p class="text-red-400 text-sm" x-text="errors.payment_method"></p>
                </template>
            </div>

            {{-- Bank Details --}}
            <div x-show="form.payment_method === 'transfer'" class="glow-border bg-dark-bg rounded-xl p-4 mb-8">
                <h4 class="font-semibold text-white mb-3">Transfer ke:</h4>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between text-text-muted"><span>BCA</span><span class="text-white font-mono">1234567890 a.n. Toko Online</span></div>
                    <div class="flex justify-between text-text-muted"><span>Mandiri</span><span class="text-white font-mono">9876543210 a.n. Toko Online</span></div>
                    <div class="flex justify-between text-text-muted"><span>BRI</span><span class="text-white font-mono">5556667770 a.n. Toko Online</span></div>
                </div>
            </div>

            <div class="flex justify-between mt-8">
                <button @click="goToStep(1)" class="border border-accent/50 hover:bg-accent/10 text-white font-semibold px-6 py-3 rounded-xl transition-all duration-300">
                    Kembali
                </button>
                <button @click="goToStep(3)" class="bg-accent hover:bg-highlight text-white font-semibold px-8 py-3 rounded-xl transition-all duration-300">
                    Lanjut ke Konfirmasi
                </button>
            </div>
        </div>

        {{-- Step 3: Confirmation --}}
        <div x-show="step === 3" class="glow-border bg-surface rounded-xl p-6 sm:p-8">
            <h2 class="font-heading text-xl font-bold text-white mb-6">Konfirmasi Pesanan</h2>

            <div class="space-y-6">
                {{-- Order Items --}}
                <div>
                    <h3 class="font-semibold text-text-muted mb-3">Pesanan</h3>
                    <div class="space-y-2">
                        <template x-for="item in cartItems" :key="item.id">
                            <div class="flex justify-between text-sm">
                                <span class="text-white" x-text="item.product.name + ' × ' + item.quantity"></span>
                                <span class="text-accent font-semibold" x-text="'Rp ' + Number((item.product.discount_price ?? item.product.price) * item.quantity).toLocaleString('id-ID')"></span>
                            </div>
                        </template>
                    </div>
                    <div class="border-t border-accent/10 pt-3 mt-3 flex justify-between">
                        <span class="text-white font-bold">Total</span>
                        <span class="text-accent font-bold" x-text="'Rp ' + Number(total).toLocaleString('id-ID')"></span>
                    </div>
                </div>

                {{-- Shipping Address --}}
                <div>
                    <h3 class="font-semibold text-text-muted mb-2">Alamat Pengiriman</h3>
                    <p class="text-white text-sm" x-text="form.address"></p>
                    <p class="text-text-muted text-sm" x-text="form.city + ', ' + form.province + ' ' + form.postal_code"></p>
                </div>

                {{-- Payment Method --}}
                <div>
                    <h3 class="font-semibold text-text-muted mb-2">Metode Pembayaran</h3>
                    <p class="text-white text-sm" x-text="paymentMethods.find(m => m.id === form.payment_method)?.name"></p>
                </div>
            </div>

            <form method="POST" action="{{ route('checkout.store') }}" class="mt-8 flex justify-between">
                @csrf
                <template x-for="(value, key) in form" :key="key">
                    <input type="hidden" :name="key" x-model="form[key]">
                </template>
                <button type="button" @click="goToStep(2)" class="border border-accent/50 hover:bg-accent/10 text-white font-semibold px-6 py-3 rounded-xl transition-all duration-300">
                    Kembali
                </button>
                <button type="submit" class="bg-accent hover:bg-highlight text-white font-semibold px-8 py-3 rounded-xl transition-all duration-300">
                    Pesan Sekarang
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function checkoutForm() {
        return {
            step: 1,
            steps: ['Pengiriman', 'Pembayaran', 'Konfirmasi'],
            form: {
                address: '{{ old('address') }}',
                city: '{{ old('city') }}',
                province: '{{ old('province') }}',
                postal_code: '{{ old('postal_code') }}',
                payment_method: '',
            },
            cartItems: @json($cartItems ?? []),
            total: {{ $total ?? 0 }},
            paymentMethods: [
                { id: 'transfer', name: 'Transfer Bank', description: 'Bayar via transfer ke rekening kami' },
                { id: 'credit_card', name: 'Kartu Kredit', description: 'Bayar menggunakan kartu kredit' },
                { id: 'cod', name: 'COD', description: 'Bayar di tempat saat barang diterima' },
            ],
            errors: {},
            init() { this.step = 1; },
            stepNumberClass(index) {
                if (index + 1 < this.step) return 'bg-green-500 text-white';
                if (index + 1 === this.step) return 'bg-accent text-white';
                return 'bg-dark-bg border border-accent/30 text-text-muted';
            },
            stepLabelClass(index) {
                if (index + 1 <= this.step) return 'text-white';
                return 'text-text-muted';
            },
            stepConnectorClass(index) {
                if (index + 1 < this.step) return 'bg-green-500';
                return 'bg-accent/30';
            },
            goToStep(target) {
                this.errors = {};
                if (target === 2) {
                    if (!this.form.address) this.errors.address = 'Alamat wajib diisi';
                    if (!this.form.city) this.errors.city = 'Kota wajib diisi';
                    if (!this.form.province) this.errors.province = 'Provinsi wajib diisi';
                    if (!this.form.postal_code) this.errors.postal_code = 'Kode Pos wajib diisi';
                    if (Object.keys(this.errors).length) return;
                }
                if (target === 3) {
                    if (!this.form.payment_method) { this.errors.payment_method = 'Pilih metode pembayaran'; return; }
                }
                this.step = target;
            }
        };
    }
</script>
@endpush
