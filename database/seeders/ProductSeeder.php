<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $products = [
            // Elektronik (category_id = 1)
            [
                'name' => 'Smart TV 43 Inch 4K',
                'description' => 'Nikmati pengalaman menonton dengan kualitas gambar 4K Ultra HD yang memukau. Smart TV ini dilengkapi dengan fitur koneksi internet dan berbagai aplikasi streaming populer.',
                'price' => 4500000,
                'discount_price' => 4299000,
                'stock' => 15,
                'category_id' => 1,
                'image' => '/images/SmartTV.jpg',
            ],
            [
                'name' => 'Bluetooth Speaker Portable',
                'description' => 'Speaker Bluetooth portabel dengan suara jernih dan bass yang mantap. Baterai tahan lama hingga 12 jam, cocok untuk menemani aktivitas di luar rumah.',
                'price' => 350000,
                'discount_price' => null,
                'stock' => 40,
                'category_id' => 1,
                'image' => '/images/speaker.jpg',
            ],
            [
                'name' => 'Laptop Gaming 15 Inch',
                'description' => 'Laptop gaming dengan performa tinggi untuk pengalaman bermain game yang maksimal. Dilengkapi prosesor terbaru, kartu grafis dedicated, dan layar 15 inch dengan refresh rate tinggi.',
                'price' => 15,
                'discount_price' => 13,
                'stock' => 10,
                'category_id' => 1,
                'image' => '/images/laptop gaming.jpg',
            ],
            [
                'name' => 'Kipas Angin Digital',
                'description' => 'Kipas angin digital dengan pengaturan kecepatan otomatis yang hemat listrik. Dilengkapi remote control dan timer, cocok untuk digunakan di kamar tidur maupun ruang keluarga.',
                'price' => 275000,
                'discount_price' => 249000,
                'stock' => 60,
                'category_id' => 1,
                'image' => '/images/kipas.jpg',
            ],

            // Fashion (category_id = 2)
            [
                'name' => 'Jaket Hoodie Premium',
                'description' => 'Jaket hoodie premium berbahan katun fleece tebal dan nyaman dipakai. Cocok untuk santai sehari-hari maupun kegiatan outdoor ringan.',
                'price' => 185000,
                'discount_price' => 159000,
                'stock' => 50,
                'category_id' => 2,
                'image' => '/images/jacket.jpg',
            ],
            [
                'name' => 'Sepatu Running Sport',
                'description' => 'Sepatu running dengan sol empuk dan teknologi penyerap benturan yang baik. Desain ergonomis membuat kaki tetap nyaman saat berlari jarak jauh.',
                'price' => 320000,
                'discount_price' => null,
                'stock' => 35,
                'category_id' => 2,
                'image' => '/images/sepatu.jpg',
            ],
            [
                'name' => 'Tas Ransel Wanita',
                'description' => 'Tas ransel wanita dengan desain modis dan banyak kompartemen penyimpanan. Cocok untuk bekerja, kuliah, maupun traveling ringan sehari-hari.',
                'price' => 210000,
                'discount_price' => 189000,
                'stock' => 25,
                'category_id' => 2,
                'image' => '/images/tas ransel.jpg',
            ],
            [
                'name' => 'Kemeja Pria Lengan Panjang',
                'description' => 'Kemeja pria lengan panjang bahan katun oxford yang adem dan tidak mudah kusut. Cocok dipakai untuk acara formal maupun semi formal.',
                'price' => 145000,
                'discount_price' => null,
                'stock' => 70,
                'category_id' => 2,
                'image' => '/images/kameja.jpg',
            ],

            // Makanan & Minuman (category_id = 3)
            [
                'name' => 'Iphone 17 Pro Max',
                'description' => 'Produk Iphone terbaik saat ini .',
                'price' => 30,
                'discount_price' => 40,
                'stock' => 100,
                'category_id' => 1,
                'image' => '/images/Iphone.jpg',
            ],
            [
                'name' => 'Redmi note 14 Pro',
                'description' => 'Redmi',
                'price' => 25,
                'discount_price' => null,
                'stock' => 45,
                'category_id' => 1,
                'image' => '/images/Redmi.jpg',
            ],
            [
                'name' => 'Samsung S26 Ultra',
                'description' => 'teknologi canggih',
                'price' => 18000,
                'discount_price' => 15000,
                'stock' => 80,
                'category_id' => 1,
                'image' => '/images/Samsung.jpg',
            ],
            [
                'name' => 'Madu Murni Hutan',
                'description' => 'Madu murni dari hutan tropis yang kaya akan manfaat kesehatan. Dipanen langsung dari sarang lebah liar tanpa proses pemanasan berlebih.',
                'price' => 95000,
                'discount_price' => null,
                'stock' => 55,
                'category_id' => 3,
                'image' => '/images/Madu.jpg',
            ],

            // Rumah Tangga (category_id = 4)
            [
                'name' => 'Set Peralatan Masak 12pcs',
                'description' => 'Set peralatan masak lengkap 12 item berbahan stainless steel anti karat. Termasuk panci, wajan, spatula, dan berbagai alat dapur penting lainnya.',
                'price' => 520000,
                'discount_price' => 479000,
                'stock' => 20,
                'category_id' => 4,
                'image' => '/images/alatmasak.jpg',
            ],
            [
                'name' => 'Lampu Hias LED',
                'description' => 'Lampu hias LED dengan perubahan warna otomatis yang bisa diatur sesuai suasana. Cocok untuk mempercantik ruang tamu, kamar tidur, atau ruang makan.',
                'price' => 89000,
                'discount_price' => null,
                'stock' => 65,
                'category_id' => 4,
                'image' => '/images/lampu.jpg',
            ],
            [
                'name' => 'RTX 5090',
                'description' => '',
                'price' => 27,
                'discount_price' => 39000,
                'stock' => 90,
                'category_id' => 1,
                'image' => '/images/RTX.jpg',
            ],
            [
                'name' => 'Sapu Elektrik',
                'description' => 'Sapu elektrik ringan dengan daya hisap kuat yang praktis digunakan sehari-hari. Dilengkapi filter HEPA untuk menangkap debu dan alergen.',
                'price' => 375000,
                'discount_price' => null,
                'stock' => 30,
                'category_id' => 4,
                'image' => '/images/vakum.jpg',
            ],

            // Perlengkapan Olahraga (category_id = 5)
            [
                'name' => 'Sepatu Lari Pro',
                'description' => 'Sepatu lari profesional dengan teknologi bantalan udara untuk mengurangi dampak benturan. Material ringan dan breathable membuat kaki tetap sejuk.',
                'price' => 650000,
                'discount_price' => 599000,
                'stock' => 25,
                'category_id' => 5,
                'image' => '/images/sepatulari.jpg',
            ],
            [
                'name' => 'Matras Yoga Premium',
                'description' => 'Matras yoga premium dengan ketebalan 6mm yang nyaman untuk berbagai gerakan. Permukaan anti-slip memberikan kestabilan saat berlatih yoga maupun pilates.',
                'price' => 210000,
                'discount_price' => null,
                'stock' => 35,
                'category_id' => 5,
                'image' => '/images/matlas.jpg',
            ],
            [
                'name' => 'Dumbbell Set 10kg',
                'description' => 'Set dumbbell 10kg dengan bahan besi cor berkualitas dan lapisan karet anti selip. Cocok untuk latihan kekuatan otot lengan, bahu, dan dada di rumah.',
                'price' => 280000,
                'discount_price' => 259000,
                'stock' => 40,
                'category_id' => 5,
                'image' => '/images/dumble.jpg',
            ],
            [
                'name' => 'Botol Minum Sport 1L',
                'description' => 'Botol minum sport kapasitas 1 liter berbahan Tritan bebas BPA yang aman dan tahan lama. Desain one-touch lid memudahkan minum saat berolahraga.',
                'price' => 65000,
                'discount_price' => null,
                'stock' => 75,
                'category_id' => 5,
                'image' => '/images/botol.jpg',
            ],
        ];

        foreach ($products as $product) {
            DB::table('products')->insert([
                'name' => $product['name'],
                'slug' => Str::slug($product['name']),
                'description' => $product['description'],
                'price' => $product['price'],
                'discount_price' => $product['discount_price'],
                'stock' => $product['stock'],
                'category_id' => $product['category_id'],
                'image' => $product['image'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
