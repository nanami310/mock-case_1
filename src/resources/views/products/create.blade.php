@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/products/create.css') }}">
@endsection

@section('content')
<div class="container">
    <h1>商品の出品</h1>
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="image" class="form-label">商品画像</label>
            <div class="form-group">
                <div class="outer-container" id="outer-container">
                    <div class="file-input-container">
                        <label for="image" id="file-label" class="file-input-label">画像を選択する</label>
                        <input type="file" name="image" class="form-control" id="image" style="display: none;" onchange="updateLabel()">
                    </div>
                </div>
                @error('image')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <h2>商品の詳細</h2>
        <div class="underline"></div>
        <div>
            <label class="form-label">カテゴリー</label>
            <div id="category-buttons">
                <button type="button" class="category-button" data-value="ファッション">ファッション</button>
                <button type="button" class="category-button" data-value="家電">家電</button>
                <button type="button" class="category-button" data-value="インテリア">インテリア</button>
                <button type="button" class="category-button" data-value="レディース">レディース</button>
                <button type="button" class="category-button" data-value="メンズ">メンズ</button>
                <button type="button" class="category-button" data-value="コスメ">コスメ</button>
                <button type="button" class="category-button" data-value="本">本</button>
                <button type="button" class="category-button" data-value="ゲーム">ゲーム</button>
                <button type="button" class="category-button" data-value="スポーツ">スポーツ</button>
                <button type="button" class="category-button" data-value="キッチン">キッチン</button>
                <button type="button" class="category-button" data-value="ハンドメイド">ハンドメイド</button>
                <button type="button" class="category-button" data-value="アクセサリー">アクセサリー</button>
                <button type="button" class="category-button" data-value="おもちゃ">おもちゃ</button>
                <button type="button" class="category-button" data-value="ベビー・キッズ">ベビー・キッズ</button>
            </div>
            <input type="hidden" name="category[]" id="selected-categories" value="{{ old('category') ? implode(',', old('category')) : '' }}">
            @error('category')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <input type="hidden" name="category[]" id="selected-categories" value="{{ old('category') ? implode(',', old('category')) : '' }}">
        @error('category')
            <div class="text-danger">{{ $message }}</div>
        @enderror

        <div>
            <label for="condition" class="form-label">商品の状態</label>
            <select name="condition" id="condition" class="product-condition form-control" >
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
        <div class="underline"></div>
        <div class="form-group">
            <label for="name" class="form-label">商品名</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" class="product-name form-control">
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="description" class="form-label">商品の説明</label>
            <textarea name="description" id="description" class="product-description form-control">{{ old('description') }}</textarea>
            @error('description')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="price" class="form-label">販売価格</label>
            <div class="input-container">
                <input type="number" name="price" id="price" min="0" value="{{ old('price') }}" class="form-control price-input">
            </div>
            @error('price')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit">出品する</button>
    </form>
</div>

<script>
    const buttons = document.querySelectorAll('.category-button');
    const selectedCategoriesInput = document.getElementById('selected-categories');

    buttons.forEach(button => {
        button.addEventListener('click', () => {
            button.classList.toggle('selected'); 
            updateSelectedCategories(); 
        });
    });

    function updateSelectedCategories() {
        const selectedCategories = Array.from(buttons)
            .filter(button => button.classList.contains('selected'))
            .map(button => button.getAttribute('data-value')); 

        selectedCategoriesInput.value = selectedCategories.join(',');
    }
</script>
@endsection