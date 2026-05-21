# Fitur Baru Toko Online

## 1️⃣ Product Reviews & Ratings ⭐

### File yang Ditambahkan:
- `database/migrations/2025_05_21_060000_create_reviews_table.php` - Database table
- `app/Models/Review.php` - Model dengan relasi
- `app/Http/Controllers/ReviewController.php` - Handle create & delete review
- `resources/views/components/product-reviews.blade.php` - View component

### Fitur:
- User dapat memberikan rating (1-5 bintang) + komentar ke produk
- Hanya user terotentikasi yang bisa review
- User hanya bisa review 1x per produk (update/overwrite)
- Admin & user sendiri bisa delete review
- Tampil review count & rating di halaman produk

### Cara Menggunakan:
Di view produk (product.show), tambahkan:
```blade
<x-product-reviews :product="$product" />
```

### Database:
```sql
reviews:
  - id
  - product_id
  - user_id
  - rating (1-5)
  - comment
  - timestamps
```

---

## 2️⃣ Advanced Search & Filtering 🔍

### File yang Dimodifikasi:
- `app/Http/Controllers/ProductController.php` - Enhanced dengan filter
- `resources/views/components/product-filters.blade.php` - Filter sidebar component (baru)

### Fitur Filter:
- **Cari Produk** - By name/description
- **Kategori** - Multiple select checkbox
- **Range Harga** - Min & Max
- **Rating** - Filter minimal rating (2⭐, 3⭐, 4⭐ keatas)
- **Sort** - Terbaru, Termurah, Termahal, Paling Laris, Rating Tertinggi

### Cara Menggunakan:
Di halaman products (index), tambahkan filter di sidebar:
```blade
<x-product-filters :categories="$categories" />
```

### Fitur Teknis:
- Menggunakan query builder dengan eager loading
- Aggregate functions: `withCount()`, `withAvg()`
- Query string preserved untuk pagination
- Reset filter button tersedia

---

## 3️⃣ Coupon & Discount System 🎟️

### File yang Ditambahkan:
- `database/migrations/2025_05_21_060001_create_coupons_table.php` - Database tables
- `app/Models/Coupon.php` - Model dengan logic validasi & kalkulasi
- `app/Models/CouponUsage.php` - Track penggunaan coupon
- `app/Http/Controllers/CouponController.php` - Validate coupon (API)
- `app/Http/Controllers/Admin/AdminCouponController.php` - CRUD coupon
- `resources/views/admin/coupons.blade.php` - List coupon
- `resources/views/admin/coupon-form.blade.php` - Create coupon
- `resources/views/admin/coupon-edit.blade.php` - Edit coupon

### Fitur Coupon:
- **Tipe Diskon** - Fixed (Rp) atau Percentage (%)
- **Validasi Coupon**:
  - Status aktif/nonaktif
  - Tanggal berlaku (from/until)
  - Minimal pembelian
  - Batas penggunaan
  - Usage tracking per user & order
- **Endpoint API** - `/coupon/validate` (POST) - Return discount info

### Admin Panel:
- Create, Read, Update, Delete coupon
- Lihat usage count & status
- Set description & term

### Database:
```sql
coupons:
  - id
  - code (unique)
  - description
  - type (fixed/percentage)
  - value
  - usage_limit
  - used_count
  - min_purchase
  - valid_from/valid_until
  - is_active
  - timestamps

coupon_usage:
  - id
  - coupon_id
  - user_id
  - order_id (unique pair)
  - discount_amount
  - timestamps
```

### API Endpoint:
```
POST /coupon/validate
Request:
  {
    "code": "DISKON50",
    "total_amount": 500000
  }

Response Success (200):
  {
    "valid": true,
    "coupon_id": 1,
    "code": "DISKON50",
    "type": "percentage",
    "value": 50,
    "discount_amount": 250000,
    "message": "Diskon Rp 250.000,00"
  }

Response Error (404/422):
  {
    "valid": false,
    "message": "Coupon tidak ditemukan"
  }
```

---

## 📋 Setup Checklist

Setelah download fitur baru, lakukan:

```bash
# 1. Jalankan migrasi baru
php artisan migrate

# 2. Test routes (pastikan sudah di web.php):
# - POST /products/{product}/reviews (auth)
# - DELETE /reviews/{review} (auth)
# - POST /coupon/validate (auth)
# - /admin/coupons (admin resource)

# 3. Modifikasi view produk untuk tampilkan reviews
# Tambahkan: <x-product-reviews :product="$product" />

# 4. Modifikasi view products/index untuk tampilkan filter
# Tambahkan: <x-product-filters :categories="$categories" />

# 5. Test di development
composer dev
# Akses: http://localhost:8000
```

---

## 🔗 Routes Summary

```php
// Public/Auth routes
GET    /products                    # Dengan filter & sort
GET    /products/{id}               # Dengan reviews & avg rating
POST   /products/{product}/reviews  # Create review (auth)
DELETE /reviews/{review}            # Delete review (auth)
POST   /coupon/validate             # Validate coupon (auth, API)

// Admin routes
GET    /admin/coupons               # List coupons
GET    /admin/coupons/create        # Create form
POST   /admin/coupons               # Store coupon
GET    /admin/coupons/{coupon}/edit # Edit form
PUT    /admin/coupons/{coupon}      # Update coupon
DELETE /admin/coupons/{coupon}      # Delete coupon
```

---

## 📝 Catatan

- Review & Rating sudah full-featured, siap pakai
- Filter produk enhance existing ProductController
- Coupon system sudah CRUD + validasi logic lengkap
- Integrasi dengan order masih manual (pake API coupon.validate di checkout)
- Semua view sudah include error validation & styling Tailwind

Butuh bantuan integrasi lebih lanjut? Tanya aja! 🚀
