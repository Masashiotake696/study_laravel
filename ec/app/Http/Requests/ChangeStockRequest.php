<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangeStockRequest extends FormRequest
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
          'change_stock' => 'required|integer|min:0',
        ];
    }

    public function messages() {
      return [
        'change_stock.required' => '変更する在庫数を入力してください',
        'change_stock.integer' => '変更する在庫数は整数を入力してください',
        'change_stock.min' => '変更する在庫数は正の整数にしてください',
      ];
    }
}
