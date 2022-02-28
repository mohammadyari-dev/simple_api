<?php

namespace App\Http\Controllers\Category;

use App\Models\Category;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();

        return $this->showAll($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
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
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return $this->showOne($category);
    }

    /**
     * Update the specified resource in storage.
     *
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
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
    }
}
