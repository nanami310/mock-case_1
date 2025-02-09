<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'profile_image' => 'nullable|image|max:2048',
            'name' => 'required|string|max:255', 
            'postal_code' => 'required|string|max:10', 
            'address' => 'required|string|max:255',
            'building_name' => 'nullable|string|max:100', 
        ];
    }

    public function messages()
    {
        return [
            'profile_image.image' => 'プロフィール画像は画像ファイルでなければなりません',
            'profile_image.max' => 'プロフィール画像は2MB以下でなければなりません',
            'name.required' => 'ユーザー名を入力してください',
            'name.string' => 'ユーザー名は文字列で入力してください',
            'name.max' => 'ユーザー名は255文字以内で入力してください',
            'postal_code.required' => '郵便番号を入力してください',
            'postal_code.string' => '郵便番号は文字列で入力してください',
            'postal_code.max' => '郵便番号は10文字以内で入力してください',
            'address.required' => '住所を入力してください',
            'address.string' => '住所は文字列で入力してください',
            'address.max' => '住所は255文字以内で入力してください',
            'building_name.string' => '建物名は文字列で入力してください',
            'building_name.max' => '建物名は100文字以内で入力してください',
        ];
    }
}
