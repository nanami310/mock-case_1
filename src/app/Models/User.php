<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory; // HasFactoryトレイトを追加

    // マスアサインメントを許可するプロパティ
    protected $fillable = [
        'name',           // ユーザー名
        'email',          // メールアドレス
        'password',       // パスワード
        'postal_code',    // 郵便番号
        'address',        // 住所
        'building_name',  // 建物名
    ];

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