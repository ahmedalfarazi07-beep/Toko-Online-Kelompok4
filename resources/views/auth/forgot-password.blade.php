@extends('layouts.guest')

@php($fullBg = true)

@section('content')
<div class="w-full max-w-md mx-auto">
    <div class="backdrop-blur-2xl bg-white/5 border border-white/10 rounded-2xl p-8 shadow-2xl">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-heading font-bold text-white mb-2">Lupa Kata Sandi</h1>
            <p class="text-text-muted/80 text-sm">Masukkan email untuk menerima tautan reset</p>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-text-muted mb-2">Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-text-muted/50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full bg-white/5 border border-white/10 rounded-xl pl-11 pr-4 py-3 text-white placeholder-text-muted/30 focus:outline-none focus:border-accent focus:ring-1 focus:ring-accent transition-all"
                        placeholder="nama@email.com">
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <button type="submit"
                class="w-full bg-gradient-to-r from-accent to-highlight hover:from-highlight hover:to-accent text-white font-semibold py-3 px-6 rounded-xl transition-all duration-300 shadow-lg shadow-accent/25 hover:shadow-accent/40">
                Kirim Tautan Reset
            </button>

            <p class="text-center text-sm text-text-muted">
                Ingat kata sandi?
                <a href="{{ route('login') }}" class="text-accent hover:text-highlight font-medium transition-colors">Masuk</a>
            </p>
        </form>
    </div>
</div>
@endsection
