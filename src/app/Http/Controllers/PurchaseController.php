<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class PurchaseController extends Controller
{
    public function create(Product $product)
    {
        $user = auth()->user(); // ログインユーザーの取得
        return view('purchase.create', compact('product', 'user'));
    }
}
