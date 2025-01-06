@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $product->name }}</h1>
    <img src="{{ $product->image }}" alt="{{ $product->name }}" class="img-fluid">
    <p>{{ $product->description }}</p>
    <p>価格: {{ $product->price }}円</p>
    
    @if($product->is_sold)
        <span class="badge bg-danger">Sold</span>
    @endif

@if(Auth::check())
    @if($likedProducts->contains($product->id))
        <form action="{{ route('products.unlike', $product->id) }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="btn btn-danger">いいねを外す</button>
        </form>
    @else
        <form action="{{ route('products.like', $product->id) }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="btn btn-primary">いいね</button>
        </form>
    @endif
    <span>{{ $likeCount }} いいね</span> <!-- いいね数を表示 -->
@endif

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

    <h3>コメント</h3>
    <ul>
        @foreach($product->comments as $comment)
            <li>{{ $comment->content }} - {{ $comment->user->name }}</li>
        @endforeach
    </ul>

    <!-- コメント投稿フォーム -->
     <form action="{{ route('comments.store', $product->id) }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="comment" class="form-label">コメント</label>
        <textarea class="form-control" id="comment" name="comment" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary">投稿</button>
</form>
</div>
@endsection
