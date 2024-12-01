<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function edit()
    {
        return view('address.edit'); // 住所変更画面のビューを返す
    }

    public function update(Request $request)
    {
        $request->validate([
            'address' => 'required|string',
        ]);

        $user = auth()->user();
        $user->address = $request->address;
        $user->save();

        // item_idをリクエストから取得
        $item_id = $request->input('item_id');

        return redirect()->route('purchase.show', ['item_id' => $item_id]); // 商品購入画面にリダイレクト
    }
}