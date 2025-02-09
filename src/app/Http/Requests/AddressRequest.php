<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'postal_code' => 'required|string|regex:/^\d{3}-\d{4}$/',
            'address' => 'required|string|max:255', 
            'building_name' => 'nullable|string|max:100', 
        ];
    }

    public function messages()
    {
        return [
            'postal_code.required' => '郵便番号を入力してください',
            'postal_code.string' => '郵便番号は文字列で入力してください',
            'postal_code.regex' => '郵便番号はハイフン有りの形式（例: 123-4567）で入力してください',
            'address.required' => '住所を入力してください',
            'address.string' => '住所は文字列で入力してください',
            'address.max' => '住所は255文字以内で入力してください',
            'building_name.string' => '建物名は文字列で入力してください',
            'building_name.max' => '建物名は100文字以内で入力してください',
        ];
    }
}
