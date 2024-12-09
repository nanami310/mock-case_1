<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;

class AddressController extends Controller
{
    public function edit($item_id)
    {
        // item_idに基づいて住所を取得
        $address = Address::where('item_id', $item_id)->firstOrFail();

        return view('address.edit', compact('address')); // 住所変更画面のビューを返す
    }

    public function update(Request $request, $item_id)
    {
        $request->validate([
            'address' => 'required|string',
            'postal_code' => 'required|string|max:10',
            'building_name' => 'nullable|string|max:100',
        ]);

        try {
            $address = Address::where('item_id', $item_id)->firstOrFail();
            $address->address = $request->address;
            $address->postal_code = $request->postal_code;
            $address->building_name = $request->building_name;
            $address->save();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => '住所の更新に失敗しました。']);
        }

        return redirect()->route('purchase.show', ['item_id' => $item_id])
                         ->with('success', '住所が正常に更新されました。');
    }
}