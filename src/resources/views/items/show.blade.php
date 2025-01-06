@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card mb-4">
        <img src="{{ $product->image }}" alt="{{ $product->name }}" class="card-img-top">
        <div class="card-body">
            <h5 class="card-title">{{ $product->name }}</h5>
            <p class="card-text">ブランド: {{ $product->brand }}</p>
            <p class="card-text">値段: ¥{{ number_format($product->price) }}</p>
            <p class="card-text">
                <i class="fas fa-heart"></i> {{ $product->likes }} いいね
                <i class="fas fa-comment"></i> {{ $product->comments_count }} コメント
            </p>
            <p class="card-text">{{ $product->description }}</p>
            <p class="card-text">カテゴリー: {{ $product->category }}</p>
            <p class="card-text">商品の状態: {{ $product->condition }}</p>
            <a href="{{ route('purchase.show', $product->id) }}" class="btn btn-primary">購入手続きへ</a>
        </div>
    </div>

    <h5>コメント</h5>
    <div id="comments">
        @foreach($product->comments as $comment)
            <div class="mb-2">
                <strong>{{ $comment->user->name }}:</strong>
                <p>{{ $comment->content }}</p>
            </div>
        @endforeach
    </div>

    <form action="{{ route('comment.store', $product->id) }}" method="POST" class="mt-3">
        @csrf
        <div class="form-group">
            <label for="comment">コメントを送信する</label>
            <textarea name="comment" id="comment" class="form-control" rows="3" required></textarea>
        </div>
        <button type="submit" class="btn btn-secondary">コメントを送信</button>
    </form>
</div>
@endsection
