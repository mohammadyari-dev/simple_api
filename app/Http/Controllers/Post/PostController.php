<?php

namespace App\Http\Controllers\Post;

use App\Models\Post;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

/**
 * Posts read data
 * @author Mohammad.Y <mhd.yari021@gmail.com>
 */
class PostController extends ApiController
{
    /**
     * Display a listing of the resource.
     * @author Mohammad.Y <mhd.yari021@gmail.com>
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();

        return $this->showAll($posts);
    }

    /**
     * Display the specified resource.
     * @author Mohammad.Y <mhd.yari021@gmail.com>
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return $this->showOne($post);
    }
}
