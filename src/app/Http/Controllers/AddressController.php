<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Productモデルをインポート

class AddressController extends Controller
{
    // 住所変更画面を表示するメソッド
    public function edit()
    {
        $user = auth()->user(); // 認証済みのユーザー情報を取得

        return view('address.change', compact('user')); // ビューにユーザー情報を渡す
    }

    // 住所更新メソッド
    public function update(Request $request)
    {
        $request->validate([
            'postal_code' => 'required|string|max:10',
            'address' => 'required|string|max:255',
            'building_name' => 'nullable|string|max:255',
        ]);

        $user = auth()->user();
        $user->update($request->only('postal_code', 'address', 'building_name'));

        // 商品購入画面にリダイレクト（特定の商品を指定）
        return redirect()->route('purchase.create', ['product' => $productId])->with('success', '住所が更新されました。');
    }
}
