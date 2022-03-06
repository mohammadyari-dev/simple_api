<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\ApiController;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

/**
 * Crud categories for posts
 * @author Mohammad.Y <mhd.yari021@gmail.com>
 */
class PostCategoryController extends ApiController
{
    /**
     * Constructor
     * @author Mohammad.Y <mhd.yari021@gmail.com>
     */
    public function __construct()
    {
        // Prevent access routes
        $this->middleware(['auth:sanctum', 'abilities:admin'])->except(['index']);
    }

    /**
     * Display a listing of the resource.
     * @author Mohammad.Y <mhd.yari021@gmail.com>
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function index(Post $post)
    {
        $posts = $post->categories;

        return $this->showAll($posts);
    }

    /**
     * Update the specified resource in storage.
     * @author Mohammad.Y <mhd.yari021@gmail.com>
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post, Category $category)
    {
        // attach, sync, syncWithoutDetaching
        $post->categories()->syncWithoutDetaching([$category->id]);

        return $this->showAll($post->categories);
    }

    /**
     * Remove the specified resource from storage.
     * @author Mohammad.Y <mhd.yari021@gmail.com>
     * @param  \App\Models\Post  $post
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post, Category $category)
    {
        if (!$post->categories()->find($category->id)) {
            return $this->errorResponse("The specified category is not a category of this post", 404);
        }

        $post->categories()->detach($category->id);

        return $this->showAll($post->categories);
    }
}
