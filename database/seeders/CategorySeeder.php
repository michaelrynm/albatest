<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
     {
        $categories = ['Technology','Health','Sports','Education','Business'];
        foreach ($categories as $name) {
            Category::create([
                'name' => $name,
                'slug' => strtolower($name),
            ]);
        }

        // tambahan random
        Category::factory(5)->create();
    }
}
