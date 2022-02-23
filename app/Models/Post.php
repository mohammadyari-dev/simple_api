<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    /**
     * Sets many-to-many relationship to categories table.
     * 
     * @return array
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * Sets one-to-many relationship to users table.
     * 
     * @return array
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
