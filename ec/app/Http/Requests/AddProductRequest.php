<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddProductRequest extends FormRequest
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
          'price' => 'required|integer|min:0',
          'stock' => 'required|integer|min:0',
          'status' => 'required|integer|between:0,1',
          'image' => 'required|file|mimes:jpeg,png',
        ];
    }

    public function messages() {
      return [
        'name.required' => '商品名を入力してください',
        'price.required' => '価格を入力してください',
        'price.integer' => '価格は整数を入力してください',
        'price.min' => '価格は正の整数にしてください',
        'stock.required' => '在庫数を入力してください',
        'stock.integer' => '在庫数は整数を入力してください',
        'stock.min' => '在庫数は正の整数にしてください',
        'status.required' => '公開ステータスを選択してください',
        'status.integer' => '公開ステータスに不正なリクエストがあります',
        'status.between' => '公開ステータスに不正なリクエストがあります',
        'image.required' => '商品画像を選択してください',
        'status.file' => '商品画像を選択してください',
        'status.memes' => '商品画像はJPEGかPNGを指定してください',
      ];
    }
}
