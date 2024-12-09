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
        @if($product->user_id !== Auth::id()) <!-- Exclude user's own products -->
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
    <p class="no-products-recommended" style="display: none;">商品はありません。</p>
@endif
        </div>

        
        <!-- マイリストタブ -->
        <div id="mylist" class="tab-pane fade">
            @if($likedProducts->isNotEmpty())
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
    <p class="no-products-liked" style="display: none;">いいねした商品はありません。</p>
@endif
        </div>
        
    </div>
</div>

<script>
function showTab(tab) {
    const recommendedTab = document.querySelector('#recommended');
    const mylistTab = document.querySelector('#mylist');

    if (tab === 'recommended') {
        recommendedTab.classList.add('show', 'active');
        mylistTab.classList.remove('show', 'active');
        document.querySelector('.no-products-recommended').style.display = (recommendedTab.querySelectorAll('.card').length === 0) ? 'block' : 'none'; 
        document.querySelector('.no-products-liked').style.display = 'none'; 
    } else {
        mylistTab.classList.add('show', 'active');
        recommendedTab.classList.remove('show', 'active');
        document.querySelector('.no-products-liked').style.display = (mylistTab.querySelectorAll('.card').length === 0) ? 'block' : 'none'; 
        document.querySelector('.no-products-recommended').style.display = 'none'; 
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const activeTab = document.querySelector('.nav-link.active').getAttribute('href').substring(1);
    showTab(activeTab);
});
</script>
@endsection

