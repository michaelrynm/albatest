<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // pastikan ada user & category
        if (User::count() === 0 || Category::count() === 0) {
            $this->call([
                UserSeeder::class,
                CategorySeeder::class,
            ]);
        }

        // buat 20 post acak
        Post::factory(20)->create();
    }
}
