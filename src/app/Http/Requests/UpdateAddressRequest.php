<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAddressRequest extends FormRequest
{
    public function authorize()
    {
        return true; // 認可を許可する場合はtrue
    }

    public function rules()
    {
        return [
            'postal_code' => 'required|string|max:10', // 郵便番号は必須、文字列、最大10文字
            'address' => 'required|string|max:255', // 住所は必須、文字列、最大255文字
            'building_name' => 'nullable|string|max:100', // 建物名は任意、最大100文字
        ];
    }

    public function messages()
    {
        return [
            'postal_code.required' => '郵便番号は必須です。',
            'postal_code.string' => '郵便番号は文字列でなければなりません。',
            'postal_code.max' => '郵便番号は10文字以内でなければなりません。',
            'address.required' => '住所は必須です。',
            'address.string' => '住所は文字列でなければなりません。',
            'address.max' => '住所は255文字以内でなければなりません。',
            'building_name.string' => '建物名は文字列でなければなりません。',
            'building_name.max' => '建物名は100文字以内でなければなりません。',
        ];
    }
}
