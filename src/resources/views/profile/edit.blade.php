<!-- プロフィール設定 -->
@extends('layouts.app')

@section('content')
<form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT') <!-- PUTメソッドを指定 -->

    <div>
        <label for="name">名前:</label>
        <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
        @error('name')
            <div>{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="postal_code">郵便番号:</label>
        <input type="text" name="postal_code" value="{{ old('postal_code', $user->postal_code) }}" required>
        @error('postal_code')
            <div>{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="address">住所:</label>
        <input type="text" name="address" value="{{ old('address', $user->address) }}" required>
        @error('address')
            <div>{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="building_name">建物名:</label>
        <input type="text" name="building_name" value="{{ old('building_name', $user->building_name) }}">
        @error('building_name')
            <div>{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="profile_image">プロフィール画像:</label>
        <input type="file" name="profile_image">
        @error('profile_image')
            <div>{{ $message }}</div>
        @enderror
    </div>

    <button type="submit">更新</button>
</form>
@endsection