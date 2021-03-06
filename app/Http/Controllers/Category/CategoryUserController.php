<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\ApiController;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryUserController extends ApiController
{
    /**
     * Display a listing of the resource.
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category)
    {
        $users = $category->posts()
            ->with('user')
            ->get()
            ->pluck('user')
            ->unique('id')
            ->values();

        return $this->showAll($users);
    }
}
