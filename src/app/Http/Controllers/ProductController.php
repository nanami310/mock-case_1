<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreProductRequest;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $products = Product::when($search, function ($query) use ($search) {
            return $query->where('name', 'like', '%' . $search . '%');
        })->where('user_id', '!=', Auth::id()) // 自分が出品した商品は除外
          ->get();

        $likedProducts = Auth::check() ? Auth::user()->likedProducts : collect(); // いいねした商品

        return view('products.index', compact('products', 'likedProducts', 'search'));
    }

    public function create()
    {
        return view('products.create'); // 新しい製品作成用のビューを返す
    }

    public function store(StoreProductRequest $request)
    {
        // 現在のユーザーのIDを取得
        $product = new Product();
        $product->user_id = auth()->id(); // ユーザーIDを設定

        // 画像ファイルの保存
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension(); // ファイル名を生成
            $file->storeAs('images', $filename, 'public'); // publicディスクに保存
            $product->image = 'images/' . $filename; // 保存した画像のパスを設定
        }

        $product->category = json_encode($request->input('category'));
        $product->condition = $request->input('condition');
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->save();

        return redirect()->route('products.index');
    }
}
