<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        User::factory(10)->create();

        Category::create([
            'name' => 'Books',
            'icon' => 'book',
        ]);

        Category::create([
            'name' => 'Gadget',
            'icon' => 'tv',
        ]);

        Product::create([
            'name' => 'Buku Filsafat',
            'category_id' => 1,
            'img' => 'https://picsum.photos/200',
            'price' => 100000,
            'stock' => 10,
            'discount' => 50000,
        ]);
        Product::create([
            'name' => 'Buku PPKn',
            'category_id' => 1,
            'img' => 'https://picsum.photos/200',
            'price' => 100000,
            'stock' => 10,
            'discount' => 50000,
        ]);
    }
}
