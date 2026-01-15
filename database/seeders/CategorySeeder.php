<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            // Income
            ['name' => 'Gaji', 'type' => 'income'],
            ['name' => 'Bonus', 'type' => 'income'],
            ['name' => 'Investasi', 'type' => 'income'],
            
            // Expense
            ['name' => 'Makanan', 'type' => 'expense'],
            ['name' => 'Transportasi', 'type' => 'expense'],
            ['name' => 'Tagihan', 'type' => 'expense'],
            ['name' => 'Belanja', 'type' => 'expense'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}