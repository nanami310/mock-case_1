@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/products/index.css') }}">
@endsection

@section('content')

<div class="container">
    <ul class="nav mb-3">
        <li class="nav-item">
            <a class="nav-link {{ $activeTab === 'recommended' ? 'active' : '' }}" href="/?tab=recommended&search={{ request('search') }}">おすすめ</a>
        </li>
        @if(Auth::check())
            <li class="nav-item">
                <a class="nav-link {{ $activeTab === 'mylist' ? 'active' : '' }}" href="/?tab=mylist&search={{ request('search') }}">マイリスト</a>
            </li>
        @endif
    </ul>

    <div class="tab-content">
        <div id="recommended" class="tab-pane {{ $activeTab === 'mylist' ? '' : 'show active' }}">
            @if($products->isNotEmpty())
            <div class="card-container">
                @foreach($products as $product)
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
                <p>おすすめの商品はありません。</p>
            @endif
        </div>

        @if(Auth::check())
        <div id="mylist" class="tab-pane {{ $activeTab === 'mylist' ? 'show active' : '' }}">
            @if($likedProducts->isNotEmpty())
            <div class="card-container">
                @foreach($likedProducts as $likedProduct)
                    <a href="{{ route('item.show', $likedProduct->id) }}" class="card mb-3 text-decoration-none">
                        <img src="{{ asset('storage/' . $likedProduct->image) }}" alt="{{ $likedProduct->name }}" class="img-fluid">
                        <div class="card-body">
                            <h5 class="card-title">{{ $likedProduct->name }}</h5>
                            @if($likedProduct->is_sold)
                                <span class="badge bg-danger">Sold</span>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
            @else
                <p>いいねした商品はありません。</p>
            @endif
        </div>
        @endif
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