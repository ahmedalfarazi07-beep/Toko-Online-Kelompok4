<div class="backdrop-blur-xl bg-surface/50 border border-red-500/20 rounded-2xl p-8 shadow-2xl">
    <h2 class="text-xl font-heading font-bold text-white mb-1">Hapus Akun</h2>
    <p class="text-sm text-text-muted mb-6">
        Setelah akun Anda dihapus, semua sumber daya dan data akan dihapus secara permanen. Sebelum menghapus akun, unduh data atau informasi yang ingin Anda simpan.
    </p>

    <button onclick="document.getElementById('confirmDeleteModal').showModal()" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded">
        Hapus Akun
    </button>

    <!-- Modal Dialog -->
    <dialog id="confirmDeleteModal" class="backdrop:bg-black/50 rounded-2xl border border-accent/20 bg-surface p-6 max-w-md w-full">
        <h2 class="text-lg font-heading font-bold text-white mb-2">Apakah Anda yakin?</h2>
        <p class="text-sm text-text-muted mb-6">
            Setelah akun Anda dihapus, semua sumber daya dan data akan dihapus secara permanen. Masukkan kata sandi Anda untuk mengonfirmasi penghapusan akun.
        </p>

        <form method="POST" action="{{ route('profile.destroy') }}" class="space-y-5">
            @csrf
            @method('delete')

            <div>
                <label class="block text-sm font-medium text-white mb-2">Kata Sandi</label>
                <input type="password" name="password" required class="w-full bg-dark-bg border border-accent/20 rounded-lg px-3 py-2 text-white focus:border-accent focus:outline-none" placeholder="Kata sandi Anda" />
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" onclick="document.getElementById('confirmDeleteModal').close()" class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded">
                    Batal
                </button>
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded">
                    Hapus Akun
                </button>
            </div>
        </form>
    </dialog>
</div>
