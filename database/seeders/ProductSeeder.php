<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Auth\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::all();
        $categories = Category::all();

        for ($i = 0; $i < 100; $i++) {
            $user = $user->random();
            $category = $categories->random();

            Product::factory()->create([
                'user_id' => $user->id,
                'category_id' => $category->id
            ]);
        }
    }
}
