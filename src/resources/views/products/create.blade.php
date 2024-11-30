@extends('layouts.app')

@section('content')
    <h1>商品出品</h1>
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div>
            <label for="image">商品画像:</label>
            <input type="file" name="image" id="image" >
            @error('image')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="category">商品のカテゴリー:</label>
            <select name="category[]" id="category" multiple >
                <option value="ファッション">ファッション</option>
                <option value="家電">家電</option>
                <option value="インテリア">インテリア</option>
                <option value="レディース">レディース</option>
                <option value="メンズ">メンズ</option>
                <option value="コスメ">コスメ</option>
                <option value="本">本</option>
                <option value="ゲーム">ゲーム</option>
                <option value="スポーツ">スポーツ</option>
                <option value="キッチン">キッチン</option>
                <option value="ハンドメイド">ハンドメイド</option>
                <option value="アクセサリー">アクセサリー</option>
                <option value="おもちゃ">おもちゃ</option>
                <option value="ベビー・キッズ">ベビー・キッズ</option>
            </select>
            @error('category')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="condition">商品の状態:</label>
            <select name="condition" id="condition" >
                <option value="良好">良好</option>
                <option value="目立った傷や汚れなし">目立った傷や汚れなし</option>
                <option value="やや傷や汚れあり">やや傷や汚れあり</option>
                <option value="状態が悪い">状態が悪い</option>
            </select>
            @error('condition')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="name">商品名:</label>
            <input type="text" name="name" id="name" >
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="description">商品の説明:</label>
            <textarea name="description" id="description" ></textarea>
            @error('description')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="price">値段:</label>
            <input type="number" name="price" id="price" min="0">
            @error('price')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit">出品する</button>
    </form>
@endsection