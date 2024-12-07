<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory;

    // Fillableプロパティを追加
    protected $fillable = ['name', 'email', 'password']; // 必要に応じて他の属性も追加

    public function likedProducts()
    {
        return $this->belongsToMany(Product::class, 'likes')->withTimestamps();
    }

    public function soldProducts()
    {
        return $this->hasMany(Product::class); // 出品した商品を取得
    }

    public function purchasedProducts()
    {
        return $this->hasMany(PurchasedProduct::class); // 購入した商品を取得
    }
}