<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class PurchaseController extends Controller
{
    public function create(Product $product)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'ログインしてください。');
        }
        $user = auth()->user();
        return view('purchase.create', compact('product', 'user'));
    }
}