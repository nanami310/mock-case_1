<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize()
    {
        return true; // 認可を許可
    }

    public function rules()
    {
        return [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category' => 'required|array',
            'condition' => 'required|string',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
        ];
    }

    public function messages()
    {
        return [
            'image.required' => '商品画像は必須です。',
            'category.required' => '商品のカテゴリーは必須です。',
            'condition.required' => '商品の状態は必須です。',
            'name.required' => '商品名は必須です。',
            'description.required' => '商品の説明は必須です。',
            'price.required' => '値段は必須です。',
        ];
    }
}