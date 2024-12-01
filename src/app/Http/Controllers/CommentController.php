<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, $productId)
    {
        $request->validate([
            'content' => 'required',
        ]);

        $comment = new Comment();
        $comment->content = $request->content;
        $comment->product_id = $productId;
        $comment->user_id = auth()->id(); // 認証ユーザーのIDを取得
        $comment->save();

        // コメント数を更新
        $product = Product::findOrFail($productId);
        $product->increment('comments_count');

        return redirect()->route('products.show', $productId); // 商品詳細ページにリダイレクト
    }
}