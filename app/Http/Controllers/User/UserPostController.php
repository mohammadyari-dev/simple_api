<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Crud posts for user
 * @author Mohammad.Y <mhd.yari021@gmail.com>
 */
class UserPostController extends ApiController
{
    /**
     * Constructor
     * @author Mohammad.Y <mhd.yari021@gmail.com>
     */
    public function __construct()
    {
        // Prevent access routes
        $this->middleware(['auth:sanctum', 'abilities:admin'])->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     * @author Mohammad.Y <mhd.yari021@gmail.com>
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        $posts = $user->posts;

        return $this->showAll($posts);
    }

    /**
     * Store a newly created resource in storage.
     * @author Mohammad.Y <mhd.yari021@gmail.com>
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        // Validate post data
        $request->validate([
            'title'     => 'required',
            'slug'      => 'required|unique:posts,slug'
        ]);

        // Add new post to database
        $data               = $request->all();
        $data['user_id']    = $user->id;
        $data['slug']       = Str::slug($data['slug'], '-');

        $post = Post::create($data);

        return $this->showOne($post, 201);
    }

    /**
     * Update the specified resource in storage.
     * @author Mohammad.Y <mhd.yari021@gmail.com>
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user, Post $post)
    {
        // Validate post data
        $request->validate([
            'title'     => 'required',
            'slug'      => 'required|unique:posts,slug,' . $post->id
        ]);

        // Check user access this post
        $this->checkUser($user, $post);

        // Check data
        if ($request->has('title')) {
            $post->title = $request->title;
        }
        if ($request->has('slug')) {
            $post->slug = Str::slug($request->slug, '-');
        }
        if ($request->has('content')) {
            $post->content = $request->content;
        }

        if ($post->isClean()) {
            return $this->errorResponse('You need to specify a defferent value to update', 409);
        }

        // Update post data
        $post->save();

        return $this->showOne($post);
    }

    /**
     * Remove the specified resource from storage.
     * @author Mohammad.Y <mhd.yari021@gmail.com>
     * @param  \App\Models\User  $user
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, Post $post)
    {
        // Check user access this post
        $this->checkUser($user, $post);

        $post->delete();

        return $this->showOne($post);
    }

    /**
     * Check user access post
     * @author Mohammad.Y <mhd.yari021@gmail.com>
     * @param \App\Models\User  $user
     * @param \App\Models\Post  $post
     * @return HttpException\Response
     */
    protected function checkUser(User $user, Post $post)
    {
        if ($user->id != $post->user_id) {
            throw new HttpException(422, "The specific user is not the actual of the post");
        }
    }
}
