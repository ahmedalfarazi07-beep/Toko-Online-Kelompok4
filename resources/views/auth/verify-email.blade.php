@extends('layouts.guest')

@php($fullBg = true)

@section('content')
<div class="w-full max-w-md mx-auto">
    <div class="backdrop-blur-2xl bg-white/5 border border-white/10 rounded-2xl p-8 shadow-2xl text-center">
        <div class="w-16 h-16 bg-accent/20 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-8 h-8 text-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
        </div>
        <h1 class="text-3xl font-heading font-bold text-white mb-2">Verifikasi Email</h1>
        <p class="text-text-muted/80 text-sm mb-6">Terima kasih telah mendaftar!</p>

        <div class="text-sm text-text-muted/70 mb-8 leading-relaxed">
            Sebelum memulai, verifikasi email Anda dengan mengklik tautan yang kami kirimkan. Jika tidak menerima email, kami akan dengan senang hati mengirimkan yang lain.
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('verification.send') }}" class="space-y-4">
            @csrf
            <button type="submit"
                class="w-full bg-gradient-to-r from-accent to-highlight hover:from-highlight hover:to-accent text-white font-semibold py-3 px-6 rounded-xl transition-all duration-300 shadow-lg shadow-accent/25 hover:shadow-accent/40">
                Kirim Ulang Email Verifikasi
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="mt-4">
            @csrf
            <button type="submit" class="w-full text-center text-sm text-text-muted hover:text-white transition-colors">
                Keluar
            </button>
        </form>
    </div>
</div>
@endsection
