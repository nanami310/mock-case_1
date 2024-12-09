<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    // ユーザーがログインした後のリダイレクト
    public function index()
    {
        $user = Auth::user();

        // 出品した商品を取得
        $soldProducts = $user->soldProducts;

        // 自分が出品した商品を除いた全商品を取得
        $products = Product::where('user_id', '!=', $user->id)->get();

        // いいねした商品を取得
        $likedProducts = $user->likedProducts;

        return view('your_view_name', compact('products', 'soldProducts', 'likedProducts'));
    }

    // 会員登録処理
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

    // プロフィール編集後の処理
    public function updateProfile(Request $request)
    {
        // プロフィールのバリデーション
        $validatedData = $request->validate([
            'profile_field' => 'required|string|max:255', // 例: プロフィールフィールドのバリデーション
        ]);

        // ユーザー情報の更新
        $user = Auth::user();
        $user->update($validatedData);

        // 商品一覧画面にリダイレクト
        return redirect()->route('products.index');
    }

    // ログイン処理
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

    // ログインフォームを表示
    public function showLoginForm()
    {
        return view('auth.login'); // ログイン用のビューを返す
    }

    // 会員登録フォームを表示
    public function showRegistrationForm()
    {
        return view('auth.register'); // 登録用のビューを返す
    }
}