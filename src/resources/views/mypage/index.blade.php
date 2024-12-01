@extends('layouts.app')

@section('content')
<div class="container">
    <div class="profile-info text-center mb-4">
        <img src="{{ $user->profile_image }}" alt="プロフィール画像" class="rounded-circle" width="100">
        <h2>{{ $user->name }}</h2>
    </div>
    <header class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('profile.edit') }}" class="btn btn-secondary">プロフィールを編集</a>
    </header>

    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('mypage.index', ['page' => 'sell']) }}">出品した商品</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('mypage.index', ['page' => 'buy']) }}">購入した商品</a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade show active" id="sold-products">
            @if(count($soldProducts) > 0)
                @foreach($soldProducts as $product)
                    <div class="card mb-3">
                        <img src="{{ $product->image }}" alt="{{ $product->name }}">
                        <h5>{{ $product->name }}</h5>
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary">詳細</a>
                    </div>
                @endforeach
            @else
                <p>出品した商品はありません。</p>
            @endif
        </div>

        <div class="tab-pane fade" id="purchased-products">
            @if(count($purchasedProducts) > 0)
                @foreach($purchasedProducts as $product)
                    <div class="card mb-3">
                        <img src="{{ $product->image }}" alt="{{ $product->name }}">
                        <h5>{{ $product->name }}</h5>
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary">詳細</a>
                    </div>
                @endforeach
            @else
                <p>購入した商品はありません。</p>
            @endif
        </div>
    </div>
</div>
@endsection