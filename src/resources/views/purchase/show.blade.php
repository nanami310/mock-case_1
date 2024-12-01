@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <img src="{{ $product->image }}" alt="{{ $product->name }}" class="img-fluid">
        </div>
        <div class="col-md-6">
            <h2>{{ $product->name }}</h2>
            <p><strong></strong> ¥{{ number_format($product->price) }}</p>

            <h3>支払い方法</h3>
            <select id="paymentMethod" class="form-control">
                <option value="convenience">コンビニ払い</option>
                <option value="card">カード支払い</option>
            </select>

            <h3>配送先</h3>
            <p id="shippingAddress">{{ $userAddress }}</p>
            <a href="{{ route('address.change', ['item_id' => $product->id]) }}" class="btn btn-secondary">変更する</a>

            <div>
                <p><strong>商品代金</strong> ¥<span id="productPrice">{{ number_format($product->price) }}</span></p>
                <p><strong>支払い方法</strong> <span id="paymentDisplay">コンビニ支払い</span></p>
            </div>

            <button id="purchaseButton" class="btn btn-success">購入する</button>
        </div>
    </div>
</div>

<script>
    document.getElementById('paymentMethod').addEventListener('change', function() {
        const paymentMethod = this.value;
        const productPrice = parseInt(document.getElementById('productPrice').innerText.replace(/,/g, ''), 10);
        const subtotal = productPrice; // 小計は商品代金のみ

        document.getElementById('paymentDisplay').innerText = paymentMethod === 'convenience' ? 'コンビニ支払い' : 'カード支払い';
        document.getElementById('subtotal').innerText = subtotal.toLocaleString();
    });

    document.getElementById('purchaseButton').addEventListener('click', function() {
        // Stripeの決済処理をここに追加
        alert('Stripeの決済画面に遷移します。');
        // 例: window.location.href = '/stripe/checkout';
    });
</script>
@endsection