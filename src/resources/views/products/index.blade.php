@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{ asset('css/products/index.css') }}">
@endsection
@section('content')

<div class="container">
<ul class="nav mb-3">
    <li class="nav-item">
        <a class="nav-link {{ $activeTab === 'mylist' ? '' : 'active' }}" href="/?tab=recommended">おすすめ</a>
    </li>
    @if(Auth::check())
        <li class="nav-item">
            <a class="nav-link {{ $activeTab === 'mylist' ? 'active' : '' }}" href="/?tab=mylist">マイリスト</a>
        </li>
    @endif
</ul>


    <div class="tab-content">
        <div id="recommended" class="tab-pane {{ $activeTab === 'mylist' ? '' : 'show active' }}">
            @foreach($products as $product)
                <a href="{{ route('item.show', $product->id) }}" class="card mb-3 text-decoration-none">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        @if($product->is_sold)
                            <span class="badge bg-danger">Sold</span>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>

        @if(Auth::check())
            <div id="mylist" class="tab-pane {{ $activeTab === 'mylist' ? 'show active' : '' }}">
                @foreach($likedProducts as $likedProduct)
                    <a href="{{ route('item.show', $likedProduct->id) }}" class="card mb-3 text-decoration-none">
                        <img src="{{ asset('storage/' . $likedProduct->image) }}" alt="{{ $likedProduct->name }}" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title">{{ $likedProduct->name }}</h5>
                            @if($likedProduct->is_sold)
                                <span class="badge bg-danger">Sold</span>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    // タブのクリックイベント
    $('a[data-toggle="tab"]').on('click', function(e) {
        e.preventDefault(); // デフォルトの動作を防ぐ

        // URLを更新
        const tab = $(this).data('tab');
        const newUrl = `/?tab=${tab}`;
        history.pushState(null, '', newUrl); // URLを変更

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
