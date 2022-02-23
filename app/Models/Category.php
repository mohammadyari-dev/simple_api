<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * Sets many-to-many relationship to posts table.
     * 
     * @return Array
     */
    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }
}
