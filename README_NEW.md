# 🛍️ Toko Online - Laravel 13

Platform e-commerce modern dengan fitur lengkap yang dibangun dengan **Laravel 13** dan **Tailwind CSS v4**.

## ✨ Fitur Utama

### 🛒 Shopping Cart
- Add/remove/update produk ke cart
- Simpan session berbasis database

### 📦 Order Management
- Checkout dengan shipping address
- Order history & tracking status
- Order detail view

### ⭐ Product Reviews & Ratings
- User dapat rating & review produk
- Rating display dengan average calculation
- Admin bisa hapus review

### 🔍 Advanced Search & Filtering
- Filter by kategori, harga, rating
- Sort by newest, price, popularity, rating
- Persistent query strings untuk pagination

### 🎟️ Coupon & Discount System
- Fixed (Rp) & percentage discount
- Validasi: minimal pembelian, tanggal berlaku, batas penggunaan
- Admin panel untuk manage coupon

### 👤 User Management
- Authentication (register/login)
- Profile management
- Wishlist produk favorit

### 🎯 Admin Panel
- Dashboard
- Kelola produk (CRUD, bulk delete, export)
- Kelola kategori
- Kelola order
- Kelola user & permission toggle
- Kelola coupon

---

## 🚀 Quick Start

### Prerequisites
- PHP 8.3+
- Composer
- Node.js 18+
- MySQL (atau SQLite for development)

### Installation

```bash
# Clone repository
git clone <repo-url>
cd Toko-online

# Setup project (install deps, migrate, build assets)
composer setup

# Or manual setup:
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm install --ignore-scripts
npm run build
```

### Development

```bash
# Start development servers (concurrent)
composer dev

# Runs 4 services:
# - Laravel server (http://localhost:8000)
# - Queue listener
# - Log streaming
# - Vite dev server
```

### Testing

```bash
# Run tests
composer test

# Format code (PSR-12)
./vendor/bin/pint
```

---

## 📂 Project Structure

```
├── app/
│   ├── Models/
│   │   ├── Product.php
│   │   ├── Order.php
│   │   ├── Review.php          ⭐ NEW
│   │   ├── Coupon.php          ⭐ NEW
│   │   ├── CouponUsage.php     ⭐ NEW
│   │   └── ...
│   ├── Http/Controllers/
│   │   ├── ProductController.php       (Enhanced dengan filter)
│   │   ├── ReviewController.php        ⭐ NEW
│   │   ├── CouponController.php        ⭐ NEW
│   │   ├── Admin/
│   │   │   ├── AdminProductController.php
│   │   │   ├── AdminCouponController.php ⭐ NEW
│   │   │   └── ...
│   │   └── ...
│   └── ...
├── database/
│   └── migrations/
│       ├── 2025_05_21_060000_create_reviews_table.php ⭐ NEW
│       ├── 2025_05_21_060001_create_coupons_table.php ⭐ NEW
│       └── ...
├── resources/
│   ├── views/
│   │   ├── components/
│   │   │   ├── product-reviews.blade.php    ⭐ NEW
│   │   │   ├── product-filters.blade.php    ⭐ NEW
│   │   │   └── ...
│   │   ├── admin/
│   │   │   ├── coupons.blade.php            ⭐ NEW
│   │   │   ├── coupon-form.blade.php        ⭐ NEW
│   │   │   ├── coupon-edit.blade.php        ⭐ NEW
│   │   │   └── ...
│   │   └── ...
│   └── css/app.css
├── routes/
│   ├── web.php (Includes new routes)
│   ├── api.php
│   └── console.php
├── tests/
│   ├── Feature/
│   └── Unit/
├── composer.json
├── package.json
├── tailwind.config.js
├── vite.config.js
└── FITUR_BARU.md ⭐ Documentation
```

---

## 📋 Routes

### Public Routes
```
GET  /                      Home
GET  /products              Products with filtering
GET  /products/{id}         Product detail with reviews
```

### Cart Routes
```
GET  /cart                  View cart
POST /cart/add              Add item
PATCH /cart/{id}            Update quantity
DELETE /cart/{id}           Remove item
```

### Authenticated Routes
```
GET  /dashboard             Dashboard
GET  /profile               Profile edit
PATCH /profile              Update profile
DELETE /profile             Delete account

GET  /checkout              Checkout form
POST /checkout              Place order
GET  /orders                Orders list
GET  /orders/{id}           Order detail

POST /products/{product}/reviews   Create review
DELETE /reviews/{review}           Delete review

POST /coupon/validate             Validate coupon (API)
```

### Admin Routes
```
GET    /admin                           Dashboard
GET    /admin/products                  List products
POST   /admin/products                  Create product
GET    /admin/products/{id}/edit        Edit form
PUT    /admin/products/{id}             Update product
DELETE /admin/products/{id}             Delete product
GET    /admin/products/export           Export to Excel
DELETE /admin/products/bulk-delete      Bulk delete

GET    /admin/categories                List categories
POST   /admin/categories                Create category
... (same CRUD pattern)

GET    /admin/coupons                   List coupons
POST   /admin/coupons                   Create coupon
PUT    /admin/coupons/{id}              Update coupon
DELETE /admin/coupons/{id}              Delete coupon

GET    /admin/orders                    List orders
GET    /admin/orders/{id}               Order detail
PATCH  /admin/orders/{id}               Update status

GET    /admin/users                     List users
PATCH  /admin/users/{id}/toggle-admin   Toggle admin role
DELETE /admin/users/{id}                Delete user
```

---

## 🎨 Technology Stack

### Backend
- **Laravel 13.8** - Web framework
- **Eloquent ORM** - Database abstraction
- **Laravel Breeze** - Auth scaffolding
- **PHPUnit** - Testing

### Frontend
- **Vite** - Build tool
- **Tailwind CSS v4** - Styling
- **Alpine.js** - Interactivity
- **Axios** - HTTP client

### Database
- **SQLite** (development) / **MySQL** (production-ready)
- **Database Migrations** - Schema management

---

## 📊 Database Schema

### Main Tables
- `users` - User accounts
- `products` - Product catalog
- `categories` - Product categories
- `product_images` - Product photos
- `reviews` ⭐ - User reviews & ratings
- `coupons` ⭐ - Discount codes
- `coupon_usage` ⭐ - Coupon usage tracking
- `cart_items` - Shopping cart
- `orders` - Customer orders
- `order_items` - Order line items
- `order_statuses` - Order status tracking
- `wishlists` - User favorites

---

## 🔐 Security Features

- Authentication dengan Laravel Breeze
- Admin middleware untuk protected routes
- Authorization policies (ReviewPolicy)
- CSRF protection
- Password hashing (bcrypt)
- SQL injection prevention (Eloquent)

---

## 📖 Documentation

Lihat file `FITUR_BARU.md` untuk dokumentasi detail:
- Product Reviews & Ratings
- Advanced Search & Filtering  
- Coupon & Discount System

---

## 🤝 Contributing

Contributions welcome! Follow Laravel conventions dan pastikan semua tests pass.

---

## 📝 License

MIT License - Bebas untuk dipelajari dan dikembangkan.

---

## 👨‍💻 Development Tips

### Enable Hot Module Replacement (HMR)
Edit `vite.config.js`:
```js
laravel({
    input: ['resources/css/app.css', 'resources/js/app.js'],
    refresh: true,
    // Uncomment untuk HMR:
    // hmr: {
    //     host: 'localhost',
    //     port: 5173,
    // }
}),
```

### Database Seeders
```bash
# Buat seeder
php artisan make:seeder ProductSeeder

# Jalankan seeder
php artisan db:seed
# atau specific:
php artisan db:seed --class=ProductSeeder
```

### Tinker (Interactive Shell)
```bash
php artisan tinker
# Then interact with models:
> $product = Product::find(1);
> $product->reviews()->count();
```

### Generate Test
```bash
php artisan make:test FeatureNameTest
php artisan make:test Unit/ModelNameTest --unit
```

---

**Happy Coding! 🚀**
