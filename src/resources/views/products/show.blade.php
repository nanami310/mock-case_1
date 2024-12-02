@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 100px; height: auto;">
        </div>
        <div class="col-md-6">
            <h1>{{ $product->name }}</h1>
            <p><strong>ブランド名</strong> {{ $product->brand }}</p>
            <p><strong></strong> ¥{{ number_format($product->price) }}</p>
            <form action="{{ route('products.like', $product->id) }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-link">
                    <i class="fas fa-heart"></i> いいね
                </button>
            </form>
            <p>
                <i class="fas fa-heart"></i> {{ $product->likes_count }} いいね
                <i class="fas fa-comments"></i> {{ $product->comments_count }} コメント
            </p>
            <a href="{{ route('purchase.show', $product->id) }}" class="btn btn-success">購入手続きへ</a>
            <p><strong>商品説明</strong></p>
            <p>{{ $product->description }}</p>
            <p><strong>商品の情報</strong></p>
            <ul>
                <li>カテゴリー {{ $product->category }}</li>
                <li>商品の状態 {{ $product->condition }}</li>
            </ul>
        </div>
    </div>

    <hr>

    <h2>コメント</h2>
    <div id="comments">
        @foreach($comments as $comment)
            <div class="comment">
                <strong>{{ $comment->user->name }}</strong>
                <p>{{ $comment->content }}</p>
            </div>
        @endforeach
    </div>

    <form action="{{ route('comments.store', $product->id) }}" method="POST" class="mt-3">
        @csrf
        <div class="form-group">
            <label for="comment">商品へのコメント</label>
            <textarea name="content" id="comment" class="form-control" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">コメントを送信する</button>
    </form>
</div>
@endsection