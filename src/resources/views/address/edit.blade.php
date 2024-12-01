@extends('layouts.app')

@section('content')
<div class="container">
    <h1>住所の変更</h1>
    <form action="{{ route('address.update') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="address">住所</label>
            <input type="text" name="address" id="address" class="form-control" value="{{ auth()->user()->address }}" required>
        </div>
        <!-- item_idを隠しフィールドとして追加 -->
        <input type="hidden" name="item_id" value="{{ request()->get('item_id') }}">
        <button type="submit" class="btn btn-primary">更新する</button>
    </form>
</div>
@endsection