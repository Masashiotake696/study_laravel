<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SignUpRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
          'name' => 'required|regex:/^[0-9a-zA-Z]+$/|min:6|unique:users',
          'password' => 'required|regex:/^[0-9a-zA-Z]+$/|min:6',
        ];
    }

    public function messages() {
      return [
        'name.required' => 'ユーザ名を入力してください',
        'name.regex' => 'ユーザ名は半角英数字にしてください',
        'name.min' => 'ユーザ名は6文字以上にしてください',
        'name.unique' => '入力されたユーザー名は既に使用されています',
        'password.required' => 'パスワードを入力してください',
        'password.regex' => 'パスワードは半角英数字にしてください',
        'password.min' => 'パスワードは6文字以上にしてください',
      ];
    }
}
