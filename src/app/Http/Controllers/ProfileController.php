<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProfileRequest;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('editProfile', compact('user'));
    }

    public function update(ProfileRequest $request)
    {
        $user = Auth::user();

        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profile_images', 'public');
            $user->profile_image = $path;
        }
        
        $user->name = $request->name;
        $user->postal_code = $request->postal_code;
        $user->address = $request->address;
        $user->building_name = $request->building_name;
        $user->is_first_login = false;
        $user->save();

        return redirect()->route('products.index')->with('success', 'プロフィールが更新されました。');
    }

    public function show()
    {
        $user = Auth::user();
    
        $soldProducts = $user->soldProducts; 
        $purchasedProducts = $user->purchasedProducts; 

        return view('mypage', compact('user', 'soldProducts', 'purchasedProducts')); 
    }
}
