<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{
    public function index()
    {
        return redirect()->route('products.index'); // 商品一覧画面にリダイレクト
        $user = Auth::user();

        // 出品した商品を取得
        $soldProducts = $user->soldProducts;

        // 自分が出品した商品を除いた全商品を取得
        $products = Product::where('user_id', '!=', $user->id)->get();

        // いいねした商品を取得
        $likedProducts = $user->likedProducts;

        return view('your_view_name', compact('products', 'soldProducts', 'likedProducts'));
    }

    public function register(RegisterRequest $request)
    {
        // バリデーション済みデータを取得
        $validatedData = $request->validated();

        // ユーザーを作成
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ]);

        // ログイン
        Auth::login($user);

        // プロフィール編集画面にリダイレクト
        return redirect()->route('profile.edit');
    }

    public function login(LoginRequest $request)
    {
        // バリデーション済みデータを取得
        $credentials = $request->validated();

        // ログイン処理
        if (Auth::attempt($credentials)) {
            return redirect()->route('products.index');
        }

        return back()->withErrors([
            'email' => '認証に失敗しました。',
        ]);
    }
}