@extends('layouts.app')

@section('content')
<div class="container">
    <div>
        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid">
        <h2>{{ $product->name }}</h2>
        <p>￥<span id="price">{{ number_format($product->price) }}</span></p>
        
        <label for="payment-method">支払方法</label>
        <select id="payment-method" name="payment_method">
            <option value="" disabled selected>選択してください</option>
            <option value="convenience">コンビニ払い</option>
            <option value="card">カード支払い</option>
        </select>
        
        <h3>配送先</h3>
        <a href="{{ route('address.change', $product->id) }}" class="btn btn-secondary">変更する</a>
        <p id="postal_code">〒{{ $user->postal_code }}</p>
        <p id="address">{{ $user->address }}</p>
        <p id="building_name">{{ $user->building_name }}</p>
        
        <p>商品代金 ￥<span id="total">{{ number_format($product->price) }}</span></p>
        <p>支払い方法 <span id="subtotal-payment">選択してください</span></p>
        
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
