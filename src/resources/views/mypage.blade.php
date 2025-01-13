@extends('layouts.app')

@section('content')
<style>
    .mypage {
        padding: 20px;
    }

    .profile {
        text-align: center;
        margin-bottom: 20px;
    }

    .profile__image {
        width: 150px;
        height: 150px;
        border-radius: 50%;
    }

    .nav {
        list-style-type: none;
        padding: 0;
        display: flex;
        border-bottom: 1px solid #ccc;
    }

    .nav-item {
        margin-right: 10px;
    }

    .nav-link {
        padding: 10px 15px;
        text-decoration: none;
        border: 1px solid transparent;
        border-radius: 5px 5px 0 0;
        background-color: #f8f9fa;
        color: #007bff;
    }

    .nav-link.active {
        border-color: #007bff;
        background-color: #fff;
        color: #007bff;
    }

    .tab-content {
        border: 1px solid #ccc;
        padding: 15px;
        border-radius: 0 0 5px 5px;
    }

    .tab-pane {
        display: none;
    }

    .tab-pane.show {
        display: block;
    }

    .edit-profile-button {
        display: inline-block;
        margin-top: 20px;
        padding: 10px 20px;
        background-color: #007bff;
        color: white;
        text-decoration: none;
        border-radius: 5px;
    }

    .edit-profile-button:hover {
        background-color: #0056b3;
    }
</style>

<div class="mypage">
    <div class="profile">
        {{ dd($user->profile_image) }}
        <img src="{{ asset('storage/' . $user->profile_image) }}" alt="プロフィール画像" class="profile__image">
        <h2 class="profile__name">{{ $user->name }}</h2>
    </div>

    <div class="container">
        <ul class="nav mb-3">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#soldProducts">出品した商品</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#purchasedProducts">購入した商品</a>
            </li>
        </ul>

        <div class="tab-content">
    <div id="soldProducts" class="tab-pane show active">
        @if($soldProducts->isNotEmpty())
            @foreach($soldProducts as $product)
                <a href="{{ route('item.show', $product->id) }}" class="card mb-3 text-decoration-none">
                    <img src="{{ $product->image }}" alt="{{ $product->name }}" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        @if($product->is_sold)
                            <span class="badge bg-danger">Sold</span>
                        @endif
                    </div>
                </a>
            @endforeach
        @else
            <p>出品した商品はありません。</p>
        @endif
    </div>
    <div id="purchasedProducts" class="tab-pane">
        @if(count($purchasedProducts) > 0)
            @foreach($purchasedProducts as $product)
                <a href="{{ route('item.show', $product->id) }}" class="card mb-3 text-decoration-none">
                    <img src="{{ $product->image }}" alt="{{ $product->name }}" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        @if($product->is_sold)
                            <span class="badge bg-danger">Sold</span>
                        @endif
                    </div>
                </a>
            @endforeach
        @else
            <p>購入した商品はありません。</p>
        @endif
    </div>
</div>
    </div>

    <a href="{{ route('editProfile') }}" class="edit-profile-button">プロフィールを編集</a>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    // タブのクリックイベント
    $('a[data-toggle="tab"]').on('click', function(e) {
        e.preventDefault(); // デフォルトの動作を防ぐ

        // アクティブなタブを切り替え
        $('.nav-link').removeClass('active');
        $(this).addClass('active');

        // タブの表示を切り替え
        $('.tab-pane').removeClass('show active');
        $($(this).attr('href')).addClass('show active');
    });
});
</script>
@endsection