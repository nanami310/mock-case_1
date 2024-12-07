<!-- 商品詳細 -->
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
            <p><strong>価格</strong> ¥{{ number_format($product->price) }}</p>

            <!-- いいねボタンをアイコンに変更 -->
            @if(Auth::check() && Auth::id() !== $product->user_id)
                <form action="{{ route('products.like', $product->id) }}" method="POST" class="d-inline" id="like-form">
                    @csrf
                    <button type="submit" style="display: none;"></button> <!-- ボタンは隠す -->
                </form>
                <i class="fas fa-heart" onclick="document.getElementById('like-form').submit();" style="cursor: pointer;"></i> {{ 
                $product->likes_count }} いいね
            @else
                <span class="text-muted">いいねはできません</span>
            @endif

            <p>
                <i class="fas fa-comments"></i> {{ $product->comments_count }} コメント
            </p>
            <a href="{{ route('purchase.show', $product->id) }}" class="btn btn-success">購入手続きへ</a>
            <p><strong>商品説明</strong></p>
            <p>{{ $product->description }}</p>
            <p><strong>商品の情報</strong></p>
            <ul>
                <li>カテゴリー 
                    @php
                        $categories = json_decode($product->category); // JSONをデコード
                    @endphp
                    {{ is_array($categories) ? implode(', ', $categories) : $categories }}
                </li>
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