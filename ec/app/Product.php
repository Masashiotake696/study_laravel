<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
  protected $fillable = ['name', 'price', 'image', 'status'];

  /*
  * ProductモデルとStockモデルを一対一とする
  * @return Stockモデルに関連したProductモデル
  */
  public function stock() {
    return $this->hasOne('App\Stock');
  }

  /*
  * 商品を保存してフラッシュメッセージを返す
  * @param $request AddProductRequest バリデーション済みのPOSTリクエスト
  * @return $message string 完了または未完フラッシュメッセージ
  */
  public function storeProduct($request) {
    $message = '';

    // リクエストの取得
    $this->name = $request->name; // 商品名
    $this->price = $request->price; // 価格
    $this->image = $request->file('image')->getClientOriginalName(); // 画像(ファイル名)
    $this->status = $request->status; // 公開ステータス
    $stock = $request->stock;

    // imagesディレクトリに画像の保存
    $request->file('image')->move('images/', $this->image);

    // トランザクションの開始
    DB::beginTransaction();
    try {
      // productsテーブルに新規保存
      $this->save();

      // stocksテーブルに新規保存
      $newStock = new Stock(['stock' => $stock]);
      $this->stock()->save($newStock);

      // 例外が発生しなかった場合はコミット
      DB::commit();

      // 登録完了メッセージを格納
      $message = '商品の登録が完了しました';
    } catch(\Exception $e) {
      // 例外が発生した場合はロールバック
      DB::rollback();

      // 登録未完メッセージを格納
      $message = 'DBエラー: 商品の登録に失敗しました';
    }

    // フラッシュメッセージを返す
    return $message;
  }

  /*
  * 在庫数を変更してフラッシュメッセージを返す
  * @param1 $stock int 変更後の在庫数
  * @param2 $id int stocksテーブルの変更するレコードのproduct_id
  * @return $message string 完了または未完フラッシュメッセージ
  */
  public function changeStock($stock, $id) {
    $message = '';
    try {
      // 在庫数を更新
      $newStock = Stock::where('product_id', $id)->first();
      $newStock->stock = $stock;
      $newStock->save();

      // 変更完了メッセージを格納
      $message = '在庫数の変更が完了しました';
    } catch(\Exception $e) {
      // 変更未完メッセージを格納
      $message = 'DBエラー: 在庫数の更新に失敗しました';
    }

    // フラッシュメッセージを返す
    return $message;
  }

  /*
  * 公開ステータスを変更してフラッシュメッセージを返す
  * @param $product Product 変更するproductsレコード
  * @return $message string 完了または未完フラッシュメッセージ
  */
  public function changeStatus($product) {
    $message = '';
    try {
      // 公開ステータスを変更
      $product->status = ($product->status + 1) % 2;
      $product->save();

      // 変更完了メッセージを格納
      $message = '公開ステータスの変更が完了しました';
    } catch(\Exception $e) {
      // 変更未完メッセージを格納
      $message = 'DBエラー: 公開ステータスの変更に失敗しました';
    }

    // フラッシュメッセージを返す
    return $message;
  }

  /*
  * 特定の商品レコードを削除してフラッシュメッセージを返す
  * @param $product Product 削除したい商品レコード「
  * @return $message string 完了または未完フラッシュメッセージ
  */
  public function destroyProduct($product) {
    $message = '';
    try {
      // レコードの削除
      $product->delete();

      // 削除完了メッセージを格納
      $message = '削除が完了しました';
    } catch(\Exception $e) {
      // 削除未完メッセージを格納
      $message = 'DBエラー: 削除に失敗しました';
    }

    // フラッシュメッセージを返す
    return $message;
  }

  /*
  * 一覧表示用にステータスを文字列整形して返す
  * @return string 文字列整形したステータス
  */
  public function showStatus() {
    if($this->status === 0) {
      return '非公開→公開';
    } else {
      return '公開->非公開';
    }
  }
}
