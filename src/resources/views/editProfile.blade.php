@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{ asset('css/editProfile.css') }}">
@endsection
@section('content')
<div class="container">
    <h2>プロフィール設定</h2>

    <form action="{{ url('/mypage') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
    <div class="profile-image-container">
        <img src="{{ asset('storage/profile_images/' . basename($user->profile_image)) }}" alt="プロフィール画像" class="profile__image">
        <input type="file" name="profile_image" class="form-control" id="profile_image" style="display: none;" onchange="updateLabel()">
        <label id="file-label" class="btn btn-secondary" for="profile_image">画像を選択する</label>
    </div>
    <script>
        function updateLabel() {
            const input = document.getElementById('profile_image');
            const label = document.getElementById('file-label');

            if (input.files.length > 0) {
                label.textContent = '画像が選択されました';
            } else {
                label.textContent = '画像を選択する'; 
            }
        }
    </script>
    @error('profile_image')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
        <div class="form-group">
            <label for="name" class="label">ユーザー名</label>
            <input type="text" name="name" class="form-control" id="name" value="{{ old('name', $user->name) }}" >
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="postal_code" class="label">郵便番号</label>
            <input type="text" name="postal_code" class="form-control" id="postal_code" value="{{ old('postal_code', $user->postal_code) }}" >
            @error('postal_code')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="address" class="label">住所</label>
            <input type="text" name="address" class="form-control" id="address" value="{{ old('address', $user->address) }}">
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
        <button type="submit" class="btn btn-primary1">更新する</button>
    </form>
</div>
@endsection
