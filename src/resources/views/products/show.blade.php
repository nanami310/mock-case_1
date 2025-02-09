@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{ asset('css/products/show.css') }}">
@endsection
@section('content')
<div class="container">
    <div class="flex-container">
        <div class="left-column">
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid">
        </div>
        <div class="right-column">
            <h1>{{ $product->name }}</h1>
            <p class="plase">￥{{ number_format($product->price) }}(税込)</p>

            <div class="interaction-container">
            @if(Auth::check())
            <div class="like-container">
                <div class="like-section">
                @if($likedProducts->contains($product->id))
                    <form action="{{ route('products.unlike', $product->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-danger">
                            ★ 
                        </button>
                    </form>
                @else
                    <form action="{{ route('products.like', $product->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-primary2">
                            ☆ 
                        </button>
                    </form>
                @endif
                <div class="like-count"> 
                    <span>{{ $likeCount }}</span>
                </div>
            </div>
        </div>
        @endif
        <div class="comment-container">
            <div class="comment-section">
                <div class="bubble-icon">
                    💬 
                </div>
                <div class="comment-count">
                    {{ $product->comments->count() }}
                </div>
            </div>
        </div>
        </div>

        <a href="{{ route('purchase.create', ['product' => $product->id]) }}" class="btn btn-buy">購入手続きへ</a>

        <h2>商品説明</h2>
        <p>{{ $product->description }}</p>

        <h2>商品の情報</h2>
        <div class="category-container">
        <p class="card-text">カテゴリー</p>
        <div class="category-box">{{ implode(', ', $categories) }}</div>
        </div>
        <div class="category-container">
        <p class="card-text">商品の状態</p><p>{{ $product->condition }} </p>
        </div>
    
        @if($product->is_sold)
            <span class="badge bg-danger">Sold</span>
        @endif

        <h2 class="come2">コメント ({{ $product->comments->count() }})</h2> 
        <ul>
    @foreach($product->comments as $comment)
        <li class="comment-item">
            <div class="user-info">
                <img src="{{ asset('storage/profile_images/' . basename($comment->user->profile_image)) }}" alt="プロフィール画像" class="profile__image">
                <strong>{{ $comment->user->name }}</strong>
            </div>
            <p class="comment-content">{{ $comment->content }}</p>
        </li>
    @endforeach
</ul>

        @if (Auth::check())
        <form action="{{ route('comments.store', $product->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="comment" class="form-label">商品へのコメント</label>
                <br>
                <textarea class="form-control" id="comment" name="comment" ></textarea>
                @error('comment')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-come">コメントを送信する</button>
        </form>
        @else
        <div class="alert alert-warning">
            コメントするにはログインしてください
        </div>
        @endif
    </div>
@endsection
</div>
</div>

