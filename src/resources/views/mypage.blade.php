@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection
@section('content')
<div class="mypage">
    <div class="profile">
        <img src="{{ asset('storage/profile_images/' . basename($user->profile_image)) }}" alt="プロフィール画像" class="profile__image">
        <h2 class="profile__name">{{ $user->name }}</h2>
        <a href="{{ route('editProfile') }}" class="edit-profile-button">プロフィールを編集</a>
    </div>

    <div class="container">
        <ul class="nav mb-3">
            <li class="nav-item2">
                <li class="nav-item">
                    <a class="nav-link {{ request('tab') === 'sell' ? 'active' : '' }}" href="{{ url('/mypage?tab=sell') }}">出品した商品</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('tab') === 'buy' ? 'active' : '' }}" href="{{ url('/mypage?tab=buy') }}">購入した商品</a>
                </li>
            </li>
        </ul>

        <div class="tab-content">
            <div id="soldProducts" class="tab-pane {{ request('tab') === 'sell' ? 'show active' : '' }}">
                @if($soldProducts->isNotEmpty())
                <div class="card-container">
                    @foreach($soldProducts as $product)
                        <a href="{{ route('item.show', $product->id) }}" class="card mb-3 text-decoration-none">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid">
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                @if($product->is_sold)
                                    <span class="badge bg-danger">Sold</span>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
                @else
                    <p>出品した商品はありません。</p>
                @endif
            </div>
            <div id="purchasedProducts" class="tab-pane {{ request('tab') === 'buy' ? 'show active' : '' }}">
            @if(count($purchasedProducts) > 0)
            <div class="card-container">
                @foreach($purchasedProducts as $product)
                    <a href="{{ route('item.show', $product->id) }}" class="card mb-3 text-decoration-none">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            @if($product->is_sold)
                                <span class="badge bg-danger">Sold</span>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
            @else
                <p>購入した商品はありません。</p>
            @endif
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    $('a[data-toggle="tab"]').on('click', function(e) {
        e.preventDefault();

        $('.nav-link').removeClass('active');
        $(this).addClass('active');
        
        $('.tab-pane').removeClass('show active');
        $($(this).attr('href')).addClass('show active');
    });
});
</script>
@endsection