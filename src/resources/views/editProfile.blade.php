@extends('layouts.app')

@section('content')
<style>
.form-label {
    display: block; /* ラベルをブロック要素として表示 */
    margin-bottom: 0.5rem; /* 下の余白を調整 */
}
</style>


<div class="container">
    <h1>プロフィール設定</h1>
    
    <div class="profile">
        <img src="{{ asset('storage/profile_images/' . basename($user->profile_image)) }}" alt="プロフィール画像" class="profile__image">
        <h2 class="profile__name">{{ $user->name }}</h2>
    </div>

    <form action="{{ url('/mypage') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="profile_image" class="form-label">画像を選択する</label>
            <input type="file" name="profile_image" class="form-control" id="profile_image" style="display: none;">
            <script>
                function updateLabel() {
                    const input = document.getElementById('profile_image');
                    const label = document.getElementById('file-label');
    
                    if (input.files.length > 0) {
                        label.textContent = '画像が選択されました'; // 選択された場合のテキスト
                    } else {
                        label.textContent = '画像を選択する'; // 何も選択されていない場合のテキスト
                    }
                }
            </script>
            @error('profile_image')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="name">ユーザー名</label>
            <input type="text" name="name" class="form-control" id="name" value="{{ old('name', $user->name) }}" >
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="postal_code">郵便番号</label>
            <input type="text" name="postal_code" class="form-control" id="postal_code" value="{{ old('postal_code', $user->postal_code) }}" >
            @error('postal_code')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="address">住所</label>
            <input type="text" name="address" class="form-control" id="address" value="{{ old('address', $user->address) }}">
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
