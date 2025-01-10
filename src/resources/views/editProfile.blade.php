@extends('layouts.app')

@section('content')
<div class="container">
    <h1>プロフィールを編集</h1>
    
    <div class="profile">
        <img src="{{ asset($user->profile_image) }}" alt="プロフィール画像" class="profile__image">
        <h2 class="profile__name">{{ $user->name }}</h2>
    </div>

    <form action="{{ url('/mypage') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="profile_image">プロフィール画像</label>
            <input type="file" name="profile_image" class="form-control" id="profile_image">
            <small class="form-text text-muted">現在の画像: <img src="{{ asset($user->profile_image) }}" alt="現在のプロフィール画像" style="width: 100px;"></small>
        </div>
        <div class="form-group">
            <label for="name">ユーザー名</label>
            <input type="text" name="name" class="form-control" id="name" value="{{ old('name', $user->name) }}" required>
        </div>
        <div class="form-group">
            <label for="postal_code">郵便番号</label>
            <input type="text" name="postal_code" class="form-control" id="postal_code" value="{{ old('postal_code', $user->postal_code) }}" required>
        </div>
        <div class="form-group">
            <label for="address">住所</label>
            <input type="text" name="address" class="form-control" id="address" value="{{ old('address', $user->address) }}" required>
        </div>
        <div class="form-group">
            <label for="building_name">建物名</label>
            <input type="text" name="building_name" class="form-control" id="building_name" value="{{ old('building_name', $user->building_name) }}">
        </div>
        <button type="submit" class="btn btn-primary">更新する</button>
    </form>
</div>
@endsection
