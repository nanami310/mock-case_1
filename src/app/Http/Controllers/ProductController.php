<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ExhibitionRequest;
use App\Http\Requests\CommentRequest;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $products = Product::when($search, function ($query) use ($search) {
            return $query->where('name', 'like', '%' . $search . '%');
        })->where('user_id', '!=', Auth::id()) 
        ->get();

        $likedProducts = Auth::check() ? Auth::user()->likedProducts()->when($search, function ($query) use ($search) {
            return $query->where('name', 'like', '%' . $search . '%');
        })->get() : collect(); 

        return view('products.index', compact('products', 'likedProducts', 'search'));
    }

    public function create()
    {
        return view('products.create'); 
    }

    public function store(ExhibitionRequest $request)
    {
        $product = new Product();
        $product->user_id = auth()->id();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('images', $filename, 'public'); 
            $product->image = 'images/' . $filename; 
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
        $likedProducts = Auth::check() ? Auth::user()->likedProducts : collect();
        $likeCount = $product->likeCount(); 

        $categories = json_decode($product->category);

        return view('products.show', compact('product', 'likedProducts', 'likeCount', 'categories'));
    }

    public function storeComment(CommentRequest $request, $item_id)
    {
        $product = Product::findOrFail($item_id);
        $product->comments()->create([
            'user_id' => Auth::id(),
            'content' => $request->comment,
        ]);
        return redirect()->route('item.show', $item_id)->with('success', 'コメントが送信されました。');
    }

    public function like($id)
    {
        $product = Product::findOrFail($id);
        $user = Auth::user();

        if (!$user->likedProducts()->where('product_id', $product->id)->exists()) {
            $user->likedProducts()->attach($product->id);
        }

        return redirect()->route('products.show', $id)->with('success', 'いいねしました。');
    }

    public function unlike($id)
    {
        $product = Product::findOrFail($id);
        $user = Auth::user();

        if ($user->likedProducts()->where('product_id', $product->id)->exists()) {
            $user->likedProducts()->detach($product->id);
        }

        return redirect()->route('products.show', $id)->with('success', 'いいねを外しました。');
    }   
}
