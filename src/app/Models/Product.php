<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'image', 'is_sold', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->belongsToMany(User::class, 'likes'); 
    }

    public function likeCount()
    {
        return $this->likes()->count();
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'purchases');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}