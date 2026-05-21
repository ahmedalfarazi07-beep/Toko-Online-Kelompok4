<div class="backdrop-blur-xl bg-surface/50 border border-accent/20 rounded-2xl p-8 shadow-2xl">
    <h2 class="text-xl font-heading font-bold text-white mb-1">Informasi Profil</h2>
    <p class="text-sm text-text-muted mb-6">Perbarui informasi nama dan email akun Anda.</p>

    <form method="POST" action="{{ route('profile.update') }}" class="space-y-5">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" value="Nama" />
            <x-text-input id="name" type="text" name="name" :value="old('name', Auth::user()->name)" required autofocus autocomplete="name" class="mt-1 block w-full" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" type="email" name="email" :value="old('email', Auth::user()->email)" required autocomplete="username" class="mt-1 block w-full" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />

            @if (Auth::user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! Auth::user()->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="text-sm text-text-muted">
                        Email Anda belum diverifikasi.
                        <button form="verification-send" class="text-accent hover:text-highlight underline transition-colors">
                            Klik di sini untuk mengirim ulang verifikasi.
                        </button>
                    </p>
                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-1 text-sm text-green-400">Tautan verifikasi baru telah dikirim ke email Anda.</p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>Simpan</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p class="text-sm text-green-400">Tersimpan.</p>
            @endif
        </div>
    </form>
</div>
