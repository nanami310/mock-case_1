<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{   
    public function index(Request $request)
    {
        $user = Auth::user(); // ユーザー情報を取得
        $purchasedProducts = $user->purchasedProducts ?? []; // 購入した商品
        $soldProducts = $user->soldProducts ?? []; // 出品した商品

        return view('mypage.index', compact('user', 'purchasedProducts', 'soldProducts'));
    }

    public function showPurchased(Request $request)
    {
        $user = Auth::user();
        $purchasedProducts = $user->purchasedProducts ?? []; // 購入した商品

        return view('mypage.index', compact('user', 'purchasedProducts'));
    }

    public function showSold(Request $request)
    {
        $user = Auth::user();
        $soldProducts = $user->soldProducts ?? []; // 出品した商品

        return view('mypage.index', compact('user', 'soldProducts'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }
    public function update(Request $request)
{
    $user = Auth::user();
    $validatedData = $request->validate([
        'profile_image' => 'nullable|image|max:2048',
        'name' => 'required|string|max:255',
        'postal_code' => 'required|string|max:10',
        'address' => 'required|string|max:255',
        'building_name' => 'nullable|string|max:255',
    ]);

    if ($request->hasFile('profile_image')) {
        if ($user->profile_image) {
            Storage::disk('public')->delete($user->profile_image);
        }
        $path = $request->file('profile_image')->store('profile_images', 'public');
        $validatedData['profile_image'] = $path;
    }

    $user->update($validatedData);

    return redirect()->route('profile.edit')->with('success', 'プロフィールが更新されました。');
}
}
