<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SignInRequest extends FormRequest
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
          'name' => 'required',
          'password' => 'required',
        ];
    }

    public function messages() {
      return [
        'name.required' => 'ユーザ名を入力してください',
        'password.required' => 'パスワードを入力してください',
      ];
    }
}
