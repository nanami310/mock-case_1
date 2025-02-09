<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\AddressRequest;

class AddressController extends Controller
{
    public function edit($productId)
    {
        $user = auth()->user();
        $product = Product::findOrFail($productId);

        return view('address.change', compact('user', 'product', 'productId'));
        
    }

    public function update(AddressRequest $request, $productId)
    {

        $user = auth()->user();
        $user->update($request->only('postal_code', 'address', 'building_name'));
        
        return redirect()->route('purchase.create', ['product' => $productId])->with('success', '住所が更新されました。');
    }
}
