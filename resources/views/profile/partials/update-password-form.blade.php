<div class="backdrop-blur-xl bg-surface/50 border border-accent/20 rounded-2xl p-8 shadow-2xl">
    <h2 class="text-xl font-heading font-bold text-white mb-1">Perbarui Kata Sandi</h2>
    <p class="text-sm text-text-muted mb-6">Pastikan akun Anda menggunakan kata sandi yang panjang dan acak untuk keamanan.</p>

    <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
        @csrf
        @method('put')

        <div>
            <x-input-label for="current_password" value="Kata Sandi Saat Ini" />
            <x-text-input id="current_password" type="password" name="current_password" required autocomplete="current-password" class="mt-1 block w-full" />
            <x-input-error :messages="$errors->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" value="Kata Sandi Baru" />
            <x-text-input id="password" type="password" name="password" required autocomplete="new-password" class="mt-1 block w-full" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" value="Konfirmasi Kata Sandi" />
            <x-text-input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="mt-1 block w-full" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>Simpan</x-primary-button>

            @if (session('status') === 'password-updated')
                <p class="text-sm text-green-400">Tersimpan.</p>
            @endif
        </div>
    </form>
</div>
