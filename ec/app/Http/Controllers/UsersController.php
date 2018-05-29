<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{
  // ユーザー一覧を表示
  public function index() {
    // ログイン済みか判定
    if(User::SignIned()) {
      // 管理者ユーザーか判定
      if(User::isAdmin()) {
        // ユーザー一覧を取得
        $users = User::all();

        // ビューの表示
        return view('users.users')->with('users', $users);
      } else {
        // 管理者ユーザーでない場合はtopページへリダイレクト
        return redirect('/top');
      }
    } else {
      // ログイン済みでない場合はログインページへリダイレクト
      return redirect('/signin');
    }
  }

  // 管理者権限の変更
  public function change_status(User $user) {
    // 管理者権限を変更してフラッシュメッセージを取得
    $message = $user->changeStatus($user);

    // フラッシュメッセージ付きでリダイレクト
    return redirect('/users')->with('message', $message);
  }
}
