<?php

namespace App\Http\Controllers\Category;

use App\Models\Category;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Categories crud
 * @author Mohammad.Y <mhd.yari021@gmail.com>
 */
class CategoryController extends ApiController
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();

        return $this->showAll($categories);
    }

    /**
     * Store a newly created resource in storage.
     * @author Mohammad.Y <mhd.yari021@gmail.com>
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'     => 'required',
            'slug'      => 'required|unique:categories,slug'
        ]);

        // Add new category
        $data = $request->all();
        $data['slug'] = Str::slug($data['slug'], '-');

        $category = Category::create($data);

        return $this->showOne($category);
    }

    /**
     * Display the specified resource.
     * @author Mohammad.Y <mhd.yari021@gmail.com>
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return $this->showOne($category);
    }

    /**
     * Update the specified resource in storage.
     * @author Mohammad.Y <mhd.yari021@gmail.com>
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'title'     => 'required',
            'slug'      => 'required|unique:categories,slug,' . $category->id,
        ]);

        // Check data
        if ($request->has('title')) {
            $category->title = $request->title;
        }
        if ($request->has('slug')) {
            $category->slug = Str::slug($request->slug, '-');
        }
        if ($request->has('content')) {
            $category->content = $request->content;
        }

        if ($category->isClean()) {
            return $this->errorResponse('You need to specify a defferent value to update', 409);
        }

        // Update category data
        $category->save();

        return $this->showOne($category);
    }

    /**
     * Remove the specified resource from storage.
     * @author Mohammad.Y <mhd.yari021@gmail.com>
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return $this->showOne($category);
    }
}
