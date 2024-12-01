<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store($id)
    {
        $product = Product::findOrFail($id);
        $product->increment('likes_count'); // いいね数を増やす
        return redirect()->back(); // 前のページにリダイレクト
    }
}