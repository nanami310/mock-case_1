@extends('layouts.app')

@section('content')
<style>
    .input-container {
        position: relative;
    }

    .price-input {
        padding-left: 30px; /* 左側の余白を追加 */
    }

    .input-container::before {
        content: '￥';
        position: absolute;
        left: 10px; /* ￥マークの位置 */
        top: 50%;
        transform: translateY(-50%); /* 縦中央揃え */
        font-size: 16px; /* フォントサイズを調整 */
        color: #000; /* 色を調整 */
    }
</style>

<h1>商品の出品</h1>
<form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div>
        <label for="image">商品画像</label>
        <div class="form-group">
        <label for="image" class="form-label" id="file-label">画像を選択する</label>
        <input type="file" name="image" class="form-control" id="image" style="display: none;" onchange="updateLabel()">
        @error('image')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <script>
        // ラベルをクリックしたときにファイル選択ダイアログを開く
        document.getElementById('file-label').addEventListener('click', function() {
            document.getElementById('image').click();
        });

        function updateLabel() {
            const input = document.getElementById('image');
            const label = document.getElementById('file-label');
            if (input.files.length > 0) {
                label.textContent = '画像が選択されました'; // 選択された場合のテキスト
            } else {
                label.textContent = '画像を選択する'; // 何も選択されていない場合のテキスト
            }
        }
    </script>

    <h2>商品の詳細</h2>
        <div>
            <label for="category">商品のカテゴリー</label>
            <select name="category[]" id="category" multiple>
                <option value="ファッション" {{ (old('category') && in_array('ファッション', old('category'))) ? 'selected' : '' }}>ファッション</option>
                <option value="家電" {{ (old('category') && in_array('家電', old('category'))) ? 'selected' : '' }}>家電</option>
                <option value="インテリア" {{ (old('category') && in_array('インテリア', old('category'))) ? 'selected' : '' }}>インテリア</option>
                <option value="レディース" {{ (old('category') && in_array('レディース', old('category'))) ? 'selected' : '' }}>レディース</option>
                <option value="メンズ" {{ (old('category') && in_array('メンズ', old('category'))) ? 'selected' : '' }}>メンズ</option>
                <option value="コスメ" {{ (old('category') && in_array('コスメ', old('category'))) ? 'selected' : '' }}>コスメ</option>
                <option value="本" {{ (old('category') && in_array('本', old('category'))) ? 'selected' : '' }}>本</option>
                <option value="ゲーム" {{ (old('category') && in_array('ゲーム', old('category'))) ? 'selected' : '' }}>ゲーム</option>
                <option value="スポーツ" {{ (old('category') && in_array('スポーツ', old('category'))) ? 'selected' : '' }}>スポーツ</option>
                <option value="キッチン" {{ (old('category') && in_array('キッチン', old('category'))) ? 'selected' : '' }}>キッチン</option>
                <option value="ハンドメイド" {{ (old('category') && in_array('ハンドメイド', old('category'))) ? 'selected' : '' }}>ハンドメイド</option>
                <option value="アクセサリー" {{ (old('category') && in_array('アクセサリー', old('category'))) ? 'selected' : '' }}>アクセサリー</option>
                <option value="おもちゃ" {{ (old('category') && in_array('おもちゃ', old('category'))) ? 'selected' : '' }}>おもちゃ</option>
                <option value="ベビー・キッズ" {{ (old('category') && in_array('ベビー・キッズ', old('category'))) ? 'selected' : '' }}>ベビー・キッズ</option>
            </select>
            @error('category')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="condition">商品の状態</label>
            <select name="condition" id="condition">
                <option value="" disabled selected>選択してください</option>
                <option value="良好" {{ old('condition') == '良好' ? 'selected' : '' }}>良好</option>
                <option value="目立った傷や汚れなし" {{ old('condition') == '目立った傷や汚れなし' ? 'selected' : '' }}>目立った傷や汚れなし</option>
                <option value="やや傷や汚れあり" {{ old('condition') == 'やや傷や汚れあり' ? 'selected' : '' }}>やや傷や汚れあり</option>
                <option value="状態が悪い" {{ old('condition') == '状態が悪い' ? 'selected' : '' }}>状態が悪い</option>
            </select>
            @error('condition')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

    <h2>商品名と説明</h2>
        <div>
            <label for="name">商品名</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}">
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="description">商品の説明</label>
            <textarea name="description" id="description">{{ old('description') }}</textarea>
            @error('description')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="price">販売価格</label>
            <div class="input-container">
                <input type="number" name="price" id="price" min="0" value="{{ old('price') }}" class="form-control price-input">
            </div>
            @error('price')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit">出品する</button>
</form>
@endsection
