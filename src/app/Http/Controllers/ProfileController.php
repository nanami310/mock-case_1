<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class ProfileController extends Controller
{   
    public function index(Request $request)
    {
        $user = Auth::user(); // ユーザー情報を取得
        $purchasedProducts = $user->purchasedProducts ?? []; // 購入した商品
        $soldProducts = $user->soldProducts ?? []; // 出品した商品

        return view('mypage.index', compact('user', 'purchasedProducts', 'soldProducts'));
    }

    public function showPurchased(Request $request)
    {
        $user = Auth::user();
        $purchasedProducts = $user->purchasedProducts ?? []; // 購入した商品

        return view('mypage.index', compact('user', 'purchasedProducts'));
    }

    public function showSold(Request $request)
    {
        $user = Auth::user();
        $soldProducts = $user->soldProducts ?? []; // 出品した商品


        return view('mypage.index', compact('user', 'soldProducts'));
    }
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
    
        // バリデーション
        $request->validate([
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'name' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
            'address' => 'required|string|max:255',
            'building_name' => 'nullable|string|max:255',
        ]);

        // プロフィール画像の処理
        if ($request->hasFile('profile_image')) {
            // 画像を保存し、パスを取得
            $path = $request->file('profile_image')->store('profile_images', 'public');
            $user->profile_image = $path; // 画像パスをユーザーに保存
        }

        // ユーザー情報の更新
        $user->update($request->only('name', 'postal_code', 'address', 'building_name'));
    
        return redirect()->route('mypage.index')->with('success', 'プロフィールが更新されました。');
    }
}