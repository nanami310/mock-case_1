@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{ asset('css/address/change.css') }}">
@endsection
@section('content')
<div class="container">
  <h2>住所の変更</h2>

  
  <form action="{{ url('/address/update/' . $productId) }}" method="POST">
      @csrf
      <div class="form-group">
          <label for="postal_code" class="label">郵便番号</label>
          <input type="text" name="postal_code" class="form-control" id="postal_code" value="{{ old('postal_code', $user->postal_code) }}" >
          @error('postal_code')
              <div class="text-danger">{{ $message }}</div>
          @enderror
      </div>
      <div class="form-group">
          <label for="address" class="label">住所</label>
          <input type="text" name="address" class="form-control" id="address" value="{{ old('address', $user->address) }}" >
          @error('address')
              <div class="text-danger">{{ $message }}</div>
          @enderror
      </div>
      <div class="form-group">
          <label for="building_name" class="label">建物名</label>
          <input type="text" name="building_name" class="form-control" id="building_name" value="{{ old('building_name', $user->building_name) }}">
          @error('building_name')
              <div class="text-danger">{{ $message }}</div>
          @enderror
      </div>
      <button type="submit" class="btn btn-primary2">更新する</button>
  </form>
</div>
@endsection