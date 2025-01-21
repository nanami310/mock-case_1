<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Productモデルをインポート
use App\Http\Requests\AddressRequest;

class AddressController extends Controller
{
    // 住所変更画面を表示するメソッド
    public function edit($productId)
    {
        $user = auth()->user(); // 認証済みのユーザー情報を取得
        $product = Product::findOrFail($productId); // 商品を取得

        return view('address.change', compact('user', 'product', 'productId')); // ビューにユーザー情報と商品情報を渡す
        
    }

    // 住所更新メソッド
    public function update(AddressRequest $request, $productId)
    {

        $user = auth()->user();
        $user->update($request->only('postal_code', 'address', 'building_name'));

        // 商品購入画面にリダイレクト（特定の商品を指定）
        return redirect()->route('purchase.create', ['product' => $productId])->with('success', '住所が更新されました。');
    }
}
