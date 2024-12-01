@extends('layouts.app')

@section('content')
<div class="container">
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
                <a href="{{ route('products.show', $product->id) }}" class="card">
                    <img src="{{ $product->image }}" alt="{{ $product->name }}" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        @if($product->is_sold)
                            <span class="badge bg-secondary">Sold</span>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>

        @if(Auth::check())
            <div id="mylist" class="tab-pane fade">
                @foreach($likedProducts as $likedProduct)
                    <a href="{{ route('products.show', $likedProduct->id) }}" class="card">
                        <img src="{{ $likedProduct->image }}" alt="{{ $likedProduct->name }}" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title">{{ $likedProduct->name }}</h5>
                            @if($likedProduct->is_sold)
                                <span class="badge bg-secondary">Sold</span>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection