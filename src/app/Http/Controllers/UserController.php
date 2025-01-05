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
}