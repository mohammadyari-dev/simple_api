<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ['pivot'];

    /**
     * Sets many-to-many relationship to posts table.
     */
    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }
}
