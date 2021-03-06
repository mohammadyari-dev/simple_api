<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'slug',
        'content',
        'user_id',
    ];

    /**
     * Sets many-to-many relationship to categories table.
     * @author Mohammad.Y <mhd.yari021@gmail.com>
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * Sets one-to-many relationship to users table.
     * @author Mohammad.Y <mhd.yari021@gmail.com>
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
