<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class PurchaseController extends Controller
{
    public function create(Product $product)
    {
        // ユーザーがログインしていない場合
        if (!auth()->check()) {
            // ログインページにリダイレクト
            return redirect()->route('login')->with('error', 'ログインしてください。');
        }
        $user = auth()->user(); // ログインユーザーの取得
        return view('purchase.create', compact('product', 'user'));
    }
}