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
        return $this->belongsToMany(Product::class, 'likes'); // likesテーブルを使用
    }
}