<?php

namespace App\Http\Controllers;

use App\Models\Product; // Productモデルをインポート
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;


class AuthController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register'); // 登録フォームのビューを返す
    }

    public function register(RegisterRequest $request)
{
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    Auth::login($user); // 登録後に自動的にログイン

    return redirect()->route('editProfile'); // プロフィール編集画面にリダイレクト
}

    public function showLoginForm()
    {
        return view('auth.login'); // ログインフォームのビューを返す
    }

    public function login(LoginRequest $request)
{
    if (Auth::attempt($request->only('email', 'password'))) {
        return redirect()->route('products.index'); // 商品一覧ページにリダイレクト
    }

    return back()->withErrors([
        'email' => 'メールアドレスまたはパスワードが正しくありません。',
    ]);
}

    public function logout()
    {
        Auth::logout(); // ログアウト処理
        return redirect()->route('login'); // ログインページにリダイレクト
    }



    public function index()
    {
        $products = Product::all(); // 全製品を取得
        $likedProducts = auth()->user()->likedProducts; // 現在のユーザーの「いいね」した製品を取得

        return redirect()->route('products.index'); // ビューに渡す
    }
}