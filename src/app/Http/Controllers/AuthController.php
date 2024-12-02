<?php

namespace App\Http\Controllers;

use App\Models\Product; // Productモデルをインポート
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Userモデルをインポート

class AuthController extends Controller
{
    public function index()
    {
        return redirect()->route('products.index'); // 商品一覧画面にリダイレクト
    }

    public function register(Request $request)
    {
        // バリデーション処理
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

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

    public function login(Request $request)
    {
        // バリデーション処理
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // ログイン処理
        if (Auth::attempt($credentials)) {
            // ログイン成功時に商品一覧画面にリダイレクト
            return redirect()->route('products.index');
        }

        // ログイン失敗時の処理
        return back()->withErrors([
            'email' => '認証に失敗しました。',
        ]);
    }
}