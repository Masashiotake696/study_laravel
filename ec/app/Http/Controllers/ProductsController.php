<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Http\Requests\AddProductRequest;
use App\Http\Requests\ChangeStockRequest;
use App\User;

class ProductsController extends Controller
{
  // 商品管理ページの表示
  public function index() {
    // ログイン済みか判定
    if(User::SignIned()) {
      // 管理者ユーザーか判定
      if(User::isAdmin()) {
        // 商品一覧を取得
        $products = Product::all();

        // ビューの表示
        return view('products.products')->with('products', $products);
      } else {
        // 管理者ユーザーでない場合はtopページへリダイレクト
        return redirect('/top');
      }
    } else {
      // ログイン済みでない場合はログインページへリダイレクト
      return redirect('/signin');
    }
  }

  // 商品登録
  public function store(AddProductRequest $request) {
    $message = '';

    // ファイルアップロードができたか確認
    if($request->file('image')->isValid()) {
      $product = new Product;
      // 商品の保存処理を行い、完了か未完メッセージを取得
      $message = $product->storeProduct($request);
    } else {
      $message = 'ファイルアップロードに失敗しました';
    }

    // フラッシュデータを保存してリダイレクト
    return redirect('/products')->with('message', $message);
  }

  // 在庫数の変更
  public function change_stock(ChangeStockRequest $request, Product $product) {
    // 在庫数を変更してフラッシュメッセージを取得
    $message = $product->changeStock($request->change_stock, $product->id);

    // フラッシュメッセージ付きでリダイレクト
    return redirect('/products')->with('message', $message);
  }

  // 公開ステータスの変更
  public function change_status(Product $product) {
    // 公開ステータスを変更してフラッシュメッセージを取得
    $message = $product->changeStatus($product);

    // フラッシュメッセージ付きでリダイレクト
    return redirect('/products')->with('message', $message);
  }

  public function destroy(Product $product) {
    // 該当するレコードを削除してフラッシュメッセージを取得
    $message = $product->destroyProduct($product);

    // フラッシュメッセージ付きでリダイレクト
    return redirect('/products')->with('message', $message);
  }

  // トップぺージの表示
  public function top() {
    // 公開ステータスが公開の商品一覧を取得する
    $products = Product::where('status', '1')->get()->toArray();

    // トップページを表示
    return view('products.top')->with('products', $products);
  }
}
