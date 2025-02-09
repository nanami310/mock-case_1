@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase/create.css') }}">
@endsection
@section('content')
<div class="container">
    <div class="flex-container">
        <div class="left-column">
            <div class="product-info">
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid">
                <div class="product-details">
                    <h2>{{ $product->name }}</h2>
                    <div class="product-details2">
                        <p>￥<span id="price">{{ number_format($product->price) }}</span></p>
                    </div>
                </div>
            </div>
            <div class="underline"></div>
            <div class="payment-method">
                <h3 class="payment-method">支払い方法</h3>
                <div class="shift-right">
                <select id="payment-method" name="payment_method">
                    <option value="" disabled selected>選択してください</option>
                    <option value="convenience">コンビニ払い</option>
                    <option value="card">カード支払い</option>
                </select>
                </div>
            </div>
            <div class="underline"></div>
            <div class="delivery-header">
                <h3>配送先</h3>
                <a href="{{ route('address.change', $product->id) }}" class="btn btn-secondary">変更する</a>
            </div>
            <div class="shift-right">
            <p id="postal_code">〒{{ $user->postal_code }}</p>
            <p id="address">{{ $user->address }}</p>
            <p id="building_name">{{ $user->building_name }}</p>
            </div>
            <div class="underline"></div>
        </div>

        <div class="right-column">
    <div class="payment-summary">
        <p class="shift-right2">商品代金　　　　　　￥<span id="total">{{ number_format($product->price) }}</span></p>
    </div>
    <div class="payment-summary">
        <p class="shift-right2">支払い方法　　　　　<span id="subtotal-payment">選択してください</span></p>
    </div>
    <button id="purchase-button" class="btn btn-success">購入する</button>
</div>
    </div>
</div>

<script>
    const paymentMethodSelect = document.getElementById('payment-method');
    const subtotalPayment = document.getElementById('subtotal-payment');
    const total = document.getElementById('total');

    paymentMethodSelect.addEventListener('change', function() {
        subtotalPayment.textContent = this.options[this.selectedIndex].text;
    });
</script>

<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe('{{ env('STRIPE_KEY') }}');

    document.getElementById('purchase-button').addEventListener('click', async function() {
        const response = await fetch('/stripe/checkout', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ price: {{ $product->price }} })
        });

        const session = await response.json();
        console.log(session); 
        const result = await stripe.redirectToCheckout({ sessionId: session.id });

        if (result.error) {
            alert(result.error.message);
        }
    });
</script>
@endsection
