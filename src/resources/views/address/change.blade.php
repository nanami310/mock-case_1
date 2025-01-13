@extends('layouts.app')

@section('content')
<div class="container">
  <h1>送付先住所を変更</h1>

  
  <form action="{{ url('/address/update/' . $productId) }}" method="POST">
      @csrf
      <div class="form-group">
          <label for="postal_code">郵便番号</label>
          <input type="text" name="postal_code" class="form-control" id="postal_code" value="{{ old('postal_code', $user->postal_code) }}" >
          @error('postal_code')
              <div class="text-danger">{{ $message }}</div>
          @enderror
      </div>
      <div class="form-group">
          <label for="address">住所</label>
          <input type="text" name="address" class="form-control" id="address" value="{{ old('address', $user->address) }}" >
          @error('address')
              <div class="text-danger">{{ $message }}</div>
          @enderror
      </div>
      <div class="form-group">
          <label for="building_name">建物名</label>
          <input type="text" name="building_name" class="form-control" id="building_name" value="{{ old('building_name', $user->building_name) }}">
          @error('building_name')
              <div class="text-danger">{{ $message }}</div>
          @enderror
      </div>
      <button type="submit" class="btn btn-primary">更新する</button>
  </form>
</div>
@endsection