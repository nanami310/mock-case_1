@extends('layouts.app')

@section('content')
<div class="product-detail">
    <h1>{{ $product->name }}</h1>
    <img src="{{ $product->image }}" alt="{{ $product->name }}">
    <p>{{ $product->description }}</p>
    <p>価格: {{ $product->price }}円</p>
</div>
@endsection