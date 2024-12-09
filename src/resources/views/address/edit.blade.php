@extends('layouts.app')

@section('content')
<div class="container">
    <h1>住所の変更</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('address.update', ['item_id' => request()->get('item_id')]) }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label for="postal_code">郵便番号</label>
            <input type="text" name="postal_code" id="postal_code" class="form-control" value="{{ auth()->user()->postal_code ?? '' }}" required>
        </div>
        
        <div class="form-group">
            <label for="address">住所</label>
            <input type="text" name="address" id="address" class="form-control" value="{{ auth()->user()->address ?? '' }}" required>
        </div>
        
        <div class="form-group">
            <label for="building_name">建物名</label>
            <input type="text" name="building_name" id="building_name" class="form-control" value="{{ auth()->user()->building_name ?? '' }}">
        </div>
        
        <!-- item_idを隠しフィールドとして追加 -->
        <input type="hidden" name="item_id" value="{{ request()->get('item_id') }}">
        
        <button type="submit" class="btn btn-primary">更新する</button>
    </form>
</div>
@endsection