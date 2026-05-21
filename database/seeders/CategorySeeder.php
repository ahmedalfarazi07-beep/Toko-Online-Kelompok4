<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $categories = [
            ['name' => 'Elektronik', 'icon' => '📱'],
            ['name' => 'Fashion', 'icon' => '👕'],
            ['name' => 'Makanan & Minuman', 'icon' => '🍕'],
            ['name' => 'Rumah Tangga', 'icon' => '🏠'],
            ['name' => 'Perlengkapan Olahraga', 'icon' => '⚽'],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'icon' => $category['icon'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
