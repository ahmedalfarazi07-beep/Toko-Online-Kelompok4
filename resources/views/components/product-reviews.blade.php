@auth
@php
    $canReview = auth()->user()->orders()
        ->whereIn('status', ['completed', 'shipped'])
        ->whereHas('items', fn($q) => $q->where('product_id', $product->id))
        ->exists();
@endphp

@if ($canReview)
<div class="mt-8 border-t border-accent/10 pt-8">
    <h3 class="text-2xl font-heading font-bold text-white mb-6">Beri Rating & Review</h3>
    
    <form action="{{ route('reviews.store', $product) }}" method="POST" class="space-y-6 bg-surface/50 border border-accent/20 rounded-xl p-6">
        @csrf
        
        <div>
            <label class="block text-sm font-medium text-text-muted mb-3">Rating</label>
            <div class="flex gap-3">
                @for ($i = 1; $i <= 5; $i++)
                    <label class="cursor-pointer">
                        <input type="radio" name="rating" value="{{ $i }}" class="hidden peer" required>
                        <span class="text-4xl peer-checked:text-yellow-400 text-gray-600 hover:text-yellow-300 transition-colors">★</span>
                    </label>
                @endfor
            </div>
            @error('rating')
                <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-text-muted mb-3">Komentar (opsional)</label>
            <textarea name="comment" rows="4" class="w-full bg-surface border border-accent/20 rounded-lg px-4 py-2 text-white focus:border-accent outline-none placeholder-gray-600" placeholder="Bagikan pengalaman Anda..."></textarea>
            @error('comment')
                <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="w-full bg-accent hover:bg-highlight text-white font-semibold py-3 px-6 rounded-lg transition-all duration-300">
            Kirim Review
        </button>
    </form>
</div>
@else
<div class="mt-8 border-t border-accent/10 pt-8 text-center bg-surface/50 border border-accent/20 rounded-lg p-6">
    <p class="text-text-muted">
        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        Anda harus membeli dan menerima produk ini terlebih dahulu untuk memberikan review.
    </p>
</div>
@endif
@else
<div class="mt-8 border-t border-accent/10 pt-8 text-center">
    <p class="text-text-muted"><a href="{{ route('login') }}" class="text-accent hover:text-highlight transition-colors">Login</a> untuk memberikan review</p>
</div>
@endauth

@if ($product->reviews->count())
<div class="mt-12">
    <h3 class="text-2xl font-heading font-bold text-white mb-8">Ulasan Produk ({{ $product->reviews->count() }})</h3>
    
    <div class="space-y-4">
        @foreach ($product->reviews as $review)
            <div class="bg-surface/50 border border-accent/20 rounded-lg p-6 hover:border-accent/40 transition-all">
                <div class="flex justify-between items-start gap-4 mb-3">
                    <div>
                        <p class="font-semibold text-white">{{ $review->user->name }}</p>
                        <div class="text-yellow-400 text-lg mt-1">
                            @for ($i = 0; $i < $review->rating; $i++)
                                ★
                            @endfor
                            @for ($i = $review->rating; $i < 5; $i++)
                                <span class="text-gray-600">★</span>
                            @endfor
                        </div>
                    </div>
                    
                    @auth
                        @if (auth()->id() === $review->user_id || auth()->user()->is_admin)
                            <form action="{{ route('reviews.destroy', $review) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-300 text-sm transition-colors" onclick="return confirm('Yakin hapus ulasan?')">
                                    Hapus
                                </button>
                            </form>
                        @endif
                    @endauth
                </div>
                
                @if ($review->comment)
                    <p class="mt-3 text-text-muted leading-relaxed">{{ $review->comment }}</p>
                @endif
                
                <p class="text-xs text-text-muted/60 mt-4">{{ $review->created_at->diffForHumans() }}</p>
            </div>
        @endforeach
    </div>
</div>
@else
<div class="mt-12 bg-surface/50 border border-accent/20 rounded-lg p-8 text-center">
    <p class="text-text-muted">Belum ada ulasan untuk produk ini. Jadilah yang pertama memberikan ulasan!</p>
</div>
@endif
