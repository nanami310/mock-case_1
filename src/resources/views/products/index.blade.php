<!-- 商品一覧 -->
@extends('layouts.app')

@section('content')
<div class="container">
    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#recommended" onclick="showTab('recommended')">おすすめ</a>
        </li>
        @if(Auth::check())
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#mylist" onclick="showTab('mylist')">マイリスト</a>
            </li>
        @endif
    </ul>

    <div class="tab-content">
        <!-- おすすめタブ -->
        <div id="recommended" class="tab-pane fade show active">
            @if(count($products) > 0)
                @foreach($products as $product)
                    @if(!$product->likes->contains('user_id', Auth::id())) <!-- いいねしていない商品を表示 -->
                        <a href="{{ route('products.show', $product->id) }}" class="card mb-3">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="card-img-top">
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                @if($product->is_sold)
                                    <span class="badge bg-secondary">Sold</span>
                                @endif
                            </div>
                        </a>
                    @endif
                @endforeach
            @else
                <p class="no-products-recommended" style="display: none;">商品はありません。</p> <!-- おすすめタブでは表示しない -->
            @endif
        </div>

        @if(Auth::check())
        <!-- マイリストタブ -->
        <div id="mylist" class="tab-pane fade">
            @if($likedProducts->isNotEmpty()) <!-- いいねした商品があるか確認 -->
                @foreach($likedProducts as $likedProduct)
                    <a href="{{ route('products.show', $likedProduct->id) }}" class="card mb-3">
                        <img src="{{ asset('storage/' . $likedProduct->image) }}" alt="{{ $likedProduct->name }}" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title">{{ $likedProduct->name }}</h5>
                            @if($likedProduct->is_sold)
                                <span class="badge bg-secondary">Sold</span>
                            @endif
                        </div>
                    </a>
                @endforeach
            @else
                <p class="no-products-liked" style="display: none;">いいねした商品はありません。</p> <!-- マイリストタブでは表示しない -->
            @endif
        </div>
        @endif
    </div>
</div>

<script>
function showTab(tab) {
    // タブの切り替え処理
    const recommendedTab = document.querySelector('#recommended');
    const mylistTab = document.querySelector('#mylist');
    
    if (tab === 'recommended') {
        recommendedTab.classList.add('show', 'active');
        mylistTab.classList.remove('show', 'active');
        document.querySelector('.no-products-recommended').style.display = (recommendedTab.querySelectorAll('.card').length === 0) ? 'block' : 'none'; // おすすめタブのメッセージ表示
        document.querySelector('.no-products-liked').style.display = 'none'; // マイリストタブのメッセージ非表示
    } else {
        mylistTab.classList.add('show', 'active');
        recommendedTab.classList.remove('show', 'active');
        document.querySelector('.no-products-liked').style.display = (mylistTab.querySelectorAll('.card').length === 0) ? 'block' : 'none'; // マイリストタブのメッセージ表示
        document.querySelector('.no-products-recommended').style.display = 'none'; // おすすめタブのメッセージ非表示
    }
}

// ページが読み込まれたときに初期状態を設定
document.addEventListener('DOMContentLoaded', function() {
    const activeTab = document.querySelector('.nav-link.active').getAttribute('href').substring(1);
    showTab(activeTab);
});
</script>
@endsection