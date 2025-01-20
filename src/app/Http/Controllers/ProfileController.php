<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateProfileRequest;

class ProfileController extends Controller
{
    public function edit()
{
    $user = Auth::user();
    return view('editProfile', compact('user')); // editProfileビューを返す
}

    public function update(UpdateProfileRequest $request)
    {
        $user = Auth::user();

        // ユーザー情報の更新
        if ($request->hasFile('profile_image')) {
            // 画像の保存処理を追加
            $path = $request->file('profile_image')->store('profile_images', 'public');
            $user->profile_image = $path;
        }
        
        // その他のユーザー情報を更新
        $user->name = $request->name;
        $user->postal_code = $request->postal_code;
        $user->address = $request->address;
        $user->building_name = $request->building_name;
        $user->is_first_login = false; // フラグを更新
        $user->save();

        return redirect()->route('products.index')->with('success', 'プロフィールが更新されました。');
    }

    public function show()
    {
        $user = Auth::user();
    
        // 売れた商品を取得するロジックを追加
        $soldProducts = $user->soldProducts; // ユーザーの売れた商品を取得
        $purchasedProducts = $user->purchasedProducts; // ユーザーの購入した商品を取得

        return view('mypage', compact('user', 'soldProducts', 'purchasedProducts')); // 変数を渡す
    }
}
