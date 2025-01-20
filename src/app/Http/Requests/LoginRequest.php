<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'username_or_email' => 'required|string', // ユーザー名またはメールアドレス
            'password' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'username_or_email.required' => 'ユーザー名またはメールアドレスを入力してください',
            'password.required' => 'パスワードを入力してください',
        ];
    }
}