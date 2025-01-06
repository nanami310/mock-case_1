<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class UserController extends Controller
{
    public function showMypage()
    {
        $user = Auth::user();
        // 出品した商品と購入した商品の取得
        $soldProducts = $user->soldProducts ?? []; // 出品した商品
        $purchasedProducts = $user->purchasedProducts ?? []; // 購入した商品

        return view('mypage', compact('user', 'soldProducts', 'purchasedProducts'));
    }

    public function editProfile()
    {
        $user = Auth::user();
        return view('editProfile', compact('user'));
    }

    public function showProducts()
{
    $user = Auth::user();

    // 自分が出品した商品を取得
    $myProducts = $user->soldProducts()->pluck('id')->toArray();

    // おすすめ商品（自分が出品していない商品）
    $products = Product::whereNotIn('id', $myProducts)->get();

    // ユーザーが「いいね」した商品を取得
    $likedProducts = $user->likedProducts;

    return view('products.index', compact('products', 'likedProducts'));
}

public function myPage()
{
    $user = Auth::user();
    // 出品した商品を取得（コレクションとして）
    $soldProducts = $user->soldProducts; // ここはリレーションを直接使用
    $purchasedProducts = $user->purchasedProducts; 

    return view('mypage', compact('user', 'soldProducts', 'purchasedProducts'));
}
}