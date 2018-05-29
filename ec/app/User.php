<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class User extends Model
{
  protected $fillable = ['name', 'password', 'admin_status'];

  /*
  * 新規ユーザー登録
  * @param $request SignUpRequest ユーザー登録リクエスト
  * @return bool
  */
  public function signup($request) {
    try {
      // リクエストの取得
      $this->name = $request->name;
      $this->password = Hash::make($request->password);

      // ユーザー登録
      $this->save();

      return true;
    } catch(\Exception $e) {
      return false;
    }
  }

  /*
  * ログイン
  * @param $request Request ログインリクエスト
  * @return bool
  */
  public static function login($request) {
    $user = User::where('name', $request->name)->first();
    if(!is_null($user)) {
      return Hash::check($request->password, $user->password);
    }
    return false;
  }

  /*
  * 一覧表示用にステータスを文字列整形して返す
  * @return string 文字列整形したステータス
  */
  public function showAdminStatus() {
    if($this->admin_status === 0) {
      return '一般ユーザ→管理者';
    } else {
      return '管理者→一般ユーザ';
    }
  }

  /*
  * 特定のユーザの管理者権限を変更してフラッシュメッセージを返す
  * @param $user User 変更したいユーザレコード
  * @return $message string 完了または未完フラッシュメッセージ
  */
  public function changeStatus($user) {
    $message = '';
    try {
      // 管理者権限を変更
      $user->admin_status = ($user->admin_status + 1) % 2;
      $user->save();

      // 変更完了メッセージを格納
      $message = '管理者権限の変更が完了しました';
    } catch(\Exception $e) {
      // 変更未完メッセージを格納
      $message = 'DBエラー: 管理者権限の変更に失敗しました';
    }

    // フラッシュメッセージを返す
    return $message;
  }

  /*
  * ログイン済みかを判定
  * @return bool
  */
  public static function SignIned() {
    // セッションがNULLでない場合にtrueを返す
    return !is_null(session('user_id'));
  }

  /*
  * 管理者権限かを判定
  * @return bool
  */
  public static function isAdmin() {
    // セッションを取得
    $user_id = session('user_id');

    // 該当するユーザー情報を取得
    $user = User::find($user_id);

    // 管理者権限の場合にtrueを返す
    return $user->admin_status === 1;
  }
}
