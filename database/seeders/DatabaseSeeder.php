<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * @author Mohammad.Y <mhd.yari021@gmail.com>
     * @return void
     */
    public function run()
    {
        User::truncate();
        Category::truncate();
        Post::truncate();
        DB::table('category_post')->truncate();

        User::flushEventListeners();
        Post::flushEventListeners();
        Category::flushEventListeners();

        $usersQuantity      = 300;
        $categoriesQuantity = 30;
        $postsQuantity      = 300;

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
