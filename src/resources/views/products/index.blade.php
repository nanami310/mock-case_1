@extends('layouts.app')

@section('content')
<div class="container">
    <header class="d-flex justify-content-between align-items-center mb-4">
        <h1>商品一覧</h1>
    </header>

    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#recommended">おすすめ</a>
        </li>
        @if(Auth::check())
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#mylist">マイリスト</a>
            </li>
        @endif
    </ul>

    <div class="tab-content">
        <div id="recommended" class="tab-pane fade show active">
            @foreach($products as $product)
                <div class="card">
                    <img src="{{ $product->image }}" alt="{{ $product->name }}">
                    <h5>{{ $product->name }}</h5>
                    @if($product->is_sold)
                        <span>Sold</span>
                    @endif
                </div>
            @endforeach
        </div>

        @if(Auth::check())
            <div id="mylist" class="tab-pane fade">
                @foreach($likedProducts as $likedProduct)
                    <div class="card">
                        <img src="{{ $likedProduct->image }}" alt="{{ $likedProduct->name }}">
                        <h5>{{ $likedProduct->name }}</h5>
                        @if($likedProduct->is_sold)
                            <span>Sold</span>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection