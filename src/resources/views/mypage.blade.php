@extends('layouts.app')

@section('content')
<div class="mypage">
    <div class="profile">
        <img src="{{ $user->profile_image }}" alt="プロフィール画像" class="profile__image">
        <h2 class="profile__name">{{ $user->name }}</h2>
    </div>

    <div class="container">
        <ul class="nav nav-tabs mb-3">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#soldProducts">出品した商品</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#purchasedProducts">購入した商品</a>
            </li>
        </ul>

        <div class="tab-content">
            <div id="soldProducts" class="tab-pane fade show active">
    @if($soldProducts->isNotEmpty())
        @foreach($soldProducts as $product)
            <div class="card mb-3">
                <img src="{{ $product->image }}" alt="{{ $product->name }}" class="card-img-top">
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    @if($product->is_sold)
                        <span class="badge bg-danger">Sold</span>
                    @endif
                </div>
            </div>
        @endforeach
    @else
        <p>出品した商品はありません。</p>
    @endif
</div>
            <div id="purchasedProducts" class="tab-pane fade">
                @if(count($purchasedProducts) > 0)
                    @foreach($purchasedProducts as $product)
                        <div class="card mb-3">
                            <img src="{{ $product->image }}" alt="{{ $product->name }}" class="card-img-top">
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                @if($product->is_sold)
                                    <span class="badge bg-danger">Sold</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @else
                    <p>購入した商品はありません。</p>
                @endif
            </div>
        </div>
    </div>

    <a href="{{ route('editProfile') }}" class="edit-profile-button">プロフィールを編集</a>
</div>
@endsection