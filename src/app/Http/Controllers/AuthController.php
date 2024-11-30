<?php

namespace App\Http\Controllers;

use App\Models\Product; // Productモデルをインポート
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index()
    {
        $products = Product::all(); // 全製品を取得
        $likedProducts = auth()->user()->likedProducts; // 現在のユーザーの「いいね」した製品を取得

        return redirect()->route('products.index'); // ビューに渡す
    }
}