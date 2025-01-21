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
        // ユーザーの作成
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_first_login' => true, // 初回ログインフラグを設定
        ]);

        // 自動ログインを行わない
        // Auth::login($user); // この行をコメントアウトまたは削除

        // ログイン画面にリダイレクト
        return redirect()->route('login')->with('success', '登録が完了しました。ログインしてください。');
    }

    public function showLoginForm()
    {
        return view('auth.login'); // ログインフォームのビューを返す
    }

    public function login(LoginRequest $request)
{
    // ユーザー名またはメールアドレスを取得
    $credentials = $request->only('username_or_email', 'password');

    // ユーザー名またはメールアドレスでユーザーを取得
    $user = User::where('name', $credentials['username_or_email'])
                ->orWhere('email', $credentials['username_or_email'])
                ->first();

    // ユーザーが存在する場合、認証を試みる
    if ($user && Auth::attempt(['email' => $user->email, 'password' => $credentials['password']])) {
        if ($user->is_first_login) {
            return redirect()->route('editProfile'); // 初回ログインの場合
        }

        return redirect()->route('products.index'); // 商品一覧ページにリダイレクト
    }

    return back()->withErrors([
        'username_or_email' => 'ユーザー名またはメールアドレス、パスワードが正しくありません。',
    ]);
}
    public function logout()
    {
        Auth::logout(); // ログアウト処理
        return redirect()->route('login'); // ログインページにリダイレクト
    }



    public function index(Request $request)
    {
        $products = Product::all(); // 全製品を取得
        $likedProducts = auth()->user()->likedProducts; // 現在のユーザーの「いいね」した製品を取得

        // タブの状態を取得
    $activeTab = $request->query('tab', 'recommended'); // デフォルトは'recommended'

    return view('products.index', compact('products', 'likedProducts', 'activeTab'));
    }
}