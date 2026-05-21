<?php

namespace App\Models;

use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

#[Fillable(['name', 'slug', 'description', 'price', 'discount_price', 'stock', 'category_id', 'image'])]
class Product extends Model
{
    /** @use HasFactory<ProductFactory> */
    use HasFactory, SoftDeletes;

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'discount_price' => 'decimal:2',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function productImages(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    // ✅ FIX: Relasi reviews yang sebelumnya tidak ada
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function discountedPrice(): Attribute
    {
        return Attribute::get(fn () => $this->discount_price ?? $this->price);
    }

    public function finalPrice(): Attribute
    {
        return Attribute::get(fn () => $this->discount_price ?? $this->price);
    }

    public function scopeAvailable($query)
    {
        return $query->where('stock', '>', 0);
    }

    public function imageUrl(): Attribute
    {
        return Attribute::get(fn () => $this->image
            ? (str_starts_with($this->image, 'http') ? $this->image : asset($this->image))
            : 'https://placehold.co/600x600/1A1030/7C3AED?text=Produk');
    }
}