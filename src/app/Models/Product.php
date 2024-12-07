<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    // Fillableプロパティの追加
    protected $fillable = ['name', 'image', 'is_sold', 'user_id'];

    public function likedUsers()
    {
        return $this->belongsToMany(User::class, 'likes')->withTimestamps();
    }

    // purchasedProductsリレーション
    public function purchasedProducts(): HasMany
    {
        return $this->hasMany(PurchasedProduct::class);
    }

    // soldProductsリレーション
    public function soldProducts(): HasMany
    {
        return $this->hasMany(SoldProduct::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class); // ユーザーとのリレーション
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes_count()
    {
        return $this->likedUsers()->count();
    }

    public function likes()
    {
        return $this->hasMany(Like::class); // Likeモデルとのリレーション
    }
}