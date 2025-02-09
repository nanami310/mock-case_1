<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class UserController extends Controller
{
    public function showMypage()
    {
        $user = Auth::user();
        $soldProducts = $user->soldProducts ?? [];
        $purchasedProducts = $user->purchasedProducts ?? [];


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

        $myProducts = $user->soldProducts()->pluck('id')->toArray();

        $products = Product::whereNotIn('id', $myProducts)->get();

        $likedProducts = $user->likedProducts;

        return view('products.index', compact('products', 'likedProducts'));
    }

    public function myPage()
    {
        $user = Auth::user();
        $soldProducts = $user->soldProducts; 
        $purchasedProducts = $user->purchasedProducts; 

        return view('mypage', compact('user', 'soldProducts', 'purchasedProducts'));
    }
}