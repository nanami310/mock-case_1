@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{ asset('css/products/show.css') }}">
@endsection
@section('content')
<div class="container">
    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid">
    <h1>{{ $product->name }}</h1>
    <p>￥{{ number_format($product->price) }}(税込)</p>

    @if(Auth::check())
    <div class="like-container">
        @if($likedProducts->contains($product->id))
            <form action="{{ route('products.unlike', $product->id) }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-danger">
                    ★ <!-- 星マーク -->
                </button>
            </form>
        @else
            <form action="{{ route('products.like', $product->id) }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-primary">
                    ☆ <!-- 空の星マーク -->
                </button>
            </form>
        @endif
        <div class="like-count"> <!-- いいね数を表示 -->
            <span>{{ $likeCount }}</span>
        </div>
    </div>
    @endif

    <div class="comment-container">
        <div class="bubble-icon">
            💬 <!-- 吹き出しのマーク -->
        </div>
        <div class="comment-count">
            {{ $product->comments->count() }} <!-- コメント数を表示 -->
        </div>
    </div>

    <a href="{{ route('purchase.create', ['product' => $product->id]) }}" class="btn btn-primary">購入手続きへ</a>

    <h3>商品説明</h3>
    <p>{{ $product->description }}</p>

    <h3>商品の情報</h3>
    <p class="card-text">カテゴリー {{ implode(', ', $categories) }}</p>
    <p>商品の状態 {{ $product->condition }} <!-- 商品の状態を表示 --></p>
    
    @if($product->is_sold)
        <span class="badge bg-danger">Sold</span>
    @endif


    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <h3>コメント ({{ $product->comments->count() }})</h3> <!-- コメント数を表示 -->
    <ul>
        @foreach($product->comments as $comment)
            <li>
                <img src="{{ asset('storage/profile_images/' . basename($comment->user->profile_image)) }}" alt="プロフィール画像" class="profile__image">
                <strong>{{ $comment->user->name }}</strong> - {{ $comment->content }}
            </li>
        @endforeach
    </ul>

    @if (Auth::check())
    <!-- コメント投稿フォーム -->
    <form action="{{ route('comments.store', $product->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="comment" class="form-label">商品へのコメント</label>
            <textarea class="form-control" id="comment" name="comment" ></textarea>
            @error('comment')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">コメントを送信する</button>
    </form>
@else
    <div class="alert alert-warning">
        コメントするにはログインしてください
    </div>
@endif
</div>
@endsection

