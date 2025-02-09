<?php

namespace App\Http\Controllers;

use App\Models\Product;
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
        return view('auth.register');
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_first_login' => true,
        ]);

        return redirect()->route('login')->with('success', '登録が完了しました。ログインしてください。');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('username_or_email', 'password');
        $user = User::where('name', $credentials['username_or_email'])
                    ->orWhere('email', $credentials['username_or_email'])
                    ->first();

        if ($user && Auth::attempt(['email' => $user->email, 'password' => $credentials['password']])) {
            if ($user->is_first_login) {
                return redirect()->route('editProfile');
            }

            return redirect()->route('products.index'); 
        }

        return back()->withErrors([
            'username_or_email' => 'ユーザー名またはメールアドレス、パスワードが正しくありません。',
        ]);
    }

    public function logout()
    {
        Auth::logout(); 
        return redirect()->route('login'); 
    }


    public function index(Request $request)
    {
        $search = $request->input('search'); 
        $activeTab = $request->query('tab', 'recommended');

        $products = Product::when($search, function ($query) use ($search) {
            return $query->where('name', 'like', '%' . $search . '%');
        })->where('user_id', '!=', auth()->id()) 
        ->get();

        $likedProducts = auth()->check() ? auth()->user()->likedProducts()->when($search, function ($query) use ($search) {
            return $query->where('name', 'like', '%' . $search . '%');
        })->get() : collect(); 

        return view('products.index', compact('products', 'likedProducts', 'activeTab', 'search'));
    }
}