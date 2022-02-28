<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\ApiController;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class PostCategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Post $post)
    {
        $posts = $post->categories;

        return $this->showAll($posts);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
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
     *
     * @param  int  $id
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
