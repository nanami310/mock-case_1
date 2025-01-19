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
        return view('editProfile', compact('user')); // editProfileを指定
    }

    public function update(UpdateProfileRequest $request)
    {

        // ユーザー情報の更新
        $user = Auth::user();
        if ($request->hasFile('profile_image')) {
            // 画像の保存処理を追加
            $path = $request->file('profile_image')->store('profile_images', 'public');
            $user->profile_image = $path;
        }
        $user->name = $request->name;
        $user->postal_code = $request->postal_code;
        $user->address = $request->address;
        $user->building_name = $request->building_name;
        $user->save();

        // /mypageにリダイレクト
        return redirect('/mypage')->with('success', 'プロフィールが更新されました。');
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
