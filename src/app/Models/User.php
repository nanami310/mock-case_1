<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function purchasedProducts()
    {
        return $this->belongsToMany(Product::class, 'purchases');
    }

    public function soldProducts()
    {
        return $this->hasMany(Product::class, 'user_id'); // ここで出品した商品を取得
    }

    public function likedProducts()
    {
        return $this->belongsToMany(Product::class, 'likes');
    }
}