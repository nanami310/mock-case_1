@extends('layouts.app')

@section('content')
<div class="container">
    <div class="profile-info text-center mb-4">
        @if($user->profile_image)
            <img src="{{ asset('storage/' . $user->profile_image) }}" alt="プロフィール画像" style="width: 100px; height: auto;">
        @else
            <p>画像がありません。</p>
        @endif
        <h2>{{ $user->name }}</h2>
    </div>
    <header class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('profile.edit') }}" class="btn btn-secondary">プロフィールを編集</a>
    </header>

    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link {{ request('page') === 'sell' ? 'active' : '' }}" href="{{ route('mypage.index', ['page' => 'sell']) }}">出品した商品</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request('page') === 'buy' ? 'active' : '' }}" href="{{ route('mypage.index', ['page' => 'buy']) }}">購入した商品</a>
        </li>
    </ul>

    <div class="tab-content">
        <!-- 出品した商品 -->
        <div class="tab-pane fade {{ request('page') === 'sell' ? 'show active' : '' }}">
            @if(request('page') === 'sell')
                @if(count($soldProducts) > 0)
                    @foreach($soldProducts as $product)
                        <div class="card mb-3">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 100px; height: auto;">
                            <h5>{{ $product->name }}</h5>
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary">詳細</a>
                        </div>
                    @endforeach
                @else
                    <p>出品した商品はありません。</p>
                @endif
            @endif
        </div>

        <!-- 購入した商品 -->
        <div class="tab-pane fade {{ request('page') === 'buy' ? 'show active' : '' }}">
            @if(request('page') === 'buy')
                @if(count($purchasedProducts) > 0)
                    @foreach($purchasedProducts as $product)
                        <div class="card mb-3">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 100px; height: auto;">
                            <h5>{{ $product->name }}</h5>
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary">詳細</a>
                        </div>
                    @endforeach
                @else
                    <p>購入した商品はありません。</p>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection