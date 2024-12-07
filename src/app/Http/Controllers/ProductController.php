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

        // 現在のユーザーのIDを取得
        $userId = Auth::id();

        // 商品を取得し、自分が出品した商品は除外
        $products = Product::when($search, function ($query) use ($search) {
                return $query->where('name', 'like', '%' . $search . '%');
            })
            ->where('user_id', '!=', $userId) // 自分が出品した商品は除外
            ->get();

        // いいねした商品を取得（いいねを付けた商品のみ）
        $likedProducts = Auth::user()->likedProducts; // いいねした商品を取得

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

    public function show($id)
    {
        $product = Product::with(['comments.user'])->findOrFail($id);
        $comments = $product->comments; // コメントを取得
        return view('products.show', compact('product', 'comments'));
    }

    public function like($id)
    {
        $product = Product::findOrFail($id);
        $user = Auth::user();

        // いいねを追加または削除する処理
        if ($user->likedProducts()->where('product_id', $product->id)->exists()) {
            $user->likedProducts()->detach($product->id); // すでにいいねしている場合は解除
        } else {
            $user->likedProducts()->attach($product->id); // いいねを追加
        }

        // いいね数を更新
        $product->likes_count = $product->likedUsers()->count();
        $product->save();

        return back(); // 前のページに戻る
    }
}
