<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function show($item_id)
    {
        $product = Product::findOrFail($item_id);
        $userAddress = auth()->user()->address; // ユーザーのプロフィールから住所を取得

        return view('purchase.show', compact('product', 'userAddress'));
    }
}