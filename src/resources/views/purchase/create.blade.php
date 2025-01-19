@extends('layouts.app')

@section('content')
<div class="container">
    <h1>購入手続き</h1>
    
    <div>
        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid">
        <h2>{{ $product->name }}</h2>
        <p>値段: <span id="price">{{ $product->price }}</span>円</p>
        
        <label for="payment-method">支払方法:</label>
        <select id="payment-method" name="payment_method">
            <option value="convenience">コンビニ支払い</option>
            <option value="card">カード支払い</option>
        </select>
        
        <h3>配送先</h3>
        <p id="postal_code">{{ $user->postal_code }}</p>
        <p id="address">{{ $user->address }}</p>
        <p id="building_name">{{ $user->building_name }}</p>
        <a href="{{ route('address.change', $product->id) }}" class="btn btn-secondary">配送先変更</a>
        
        <h3>小計</h3>
        <p>商品代金: <span id="subtotal-price">{{ $product->price }}</span>円</p>
        <p>支払い方法: <span id="subtotal-payment">コンビニ支払い</span></p>
        
        <h3>合計: <span id="total">{{ $product->price }}</span>円</h3>
        
        <button id="purchase-button" class="btn btn-success">購入する</button>
    </div>
</div>

<script>
    const paymentMethodSelect = document.getElementById('payment-method');
    const subtotalPayment = document.getElementById('subtotal-payment');
    const total = document.getElementById('total');

    paymentMethodSelect.addEventListener('change', function() {
        subtotalPayment.textContent = this.options[this.selectedIndex].text;
        // 小計の計算（支払方法によって変わる場合はここにロジックを追加）
    });

    document.getElementById('purchase-button').addEventListener('click', function() {
        // Stripeの決済画面に接続するロジックをここに追加
        window.location.href = '/stripe/checkout'; // 例: StripeのチェックアウトURL
    });
</script>
@endsection
