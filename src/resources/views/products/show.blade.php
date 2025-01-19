@extends('layouts.app')

@section('content')
<style>
    .profile__image {
    width: 40px; /* 画像の幅を調整 */
    height: 40px; /* 画像の高さを調整 */
    border-radius: 50%; /* 丸い形にする */
    margin-right: 10px; /* 画像とテキストの間に余白を追加 */
    vertical-align: middle; /* テキストと垂直に揃える */
}

.like-container {
    text-align: center; /* 中央揃え */
}

.like-count {
    margin-top: 5px; /* 星マークといいね数の間に余白を追加 */
}

.comment-container {
    text-align: center; /* 中央揃え */
    margin-bottom: 10px; /* コメントセクションの下に余白を追加 */
}

.bubble-icon {
    font-size: 24px; /* 吹き出しアイコンのサイズ */
}

.comment-count {
    margin-top: 5px; /* 吹き出しアイコンとコメント数の間に余白を追加 */
}
</style>


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

    <h3>コメント</h3>
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



    <!-- コメント投稿フォーム -->
     <form action="{{ route('comments.store', $product->id) }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="comment" class="form-label">商品へのコメント</label>
        <textarea class="form-control" id="comment" name="comment" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary">コメントを送信する</button>
</form>
</div>
@endsection

