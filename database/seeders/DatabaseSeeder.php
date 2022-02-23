<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('PRAGMA foreign_keys = OFF;');

        User::truncate();
        Category::truncate();
        Post::truncate();
        DB::table('category_post')->truncate();

        User::flushEventListeners();
        Post::flushEventListeners();
        Category::flushEventListeners();

        $usersQuantity      = 1000;
        $categoriesQuantity = 30;
        $postsQuantity      = 1000;

        User::factory()->count($usersQuantity)->create();
        Category::factory()->count($categoriesQuantity)->create();
        Post::factory()->count($postsQuantity)->create()->each(
            function ($post) {
                $categories = Category::all()->random()->id;

                $post->categories()->attach($categories);
            }
        );
    }
}
