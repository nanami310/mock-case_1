<?php

namespace App\Http\Controllers;

use App\Models\Product; // Productモデルをインポート
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index()
    {
        return redirect()->route('products.index'); // 商品一覧画面にリダイレクト
    }
}