<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true; // 認可の設定
    }

    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required|min:6', // 必要に応じてルールを調整
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'メールアドレスは必ず指定してください。',
            'email.email' => '有効なメールアドレスを入力してください。',
            'password.required' => 'パスワードは必ず指定してください。',
            'password.min' => 'パスワードは少なくとも6文字以上である必要があります。',
        ];
    }
}

