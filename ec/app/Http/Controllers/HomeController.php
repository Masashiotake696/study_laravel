<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\SignUpRequest;
use App\Http\Requests\SignInRequest;
use Validator;
use Auth;

class HomeController extends Controller
{
  // ユーザー登録画面の表示
  public function signup() {
    return $this::decideRedirect('signup');
  }

  // ユーザ登録
  public function create(SignUpRequest $request) {
    $user = new User();
    // リクエストを元にユーザー登録
    if($user->signup($request)) {
      // 登録完了後にtopページにリダイレクト
      return redirect('/top');
    } else {
      // フラッシュメッセージ付きでリダイレクト
      return redirect('/signup')->with('message', 'DBエラー: ユーザー登録に失敗しました');
    }
  }

  // ログイン画面の表示
  public function signin() {
    return $this::decideRedirect('signin');
  }

  // ログイン
  public function login(SignInRequest $request) {
    // バリデーション後に認証
    if(User::login($request)) {
      $user = User::where('name', $request->name)->first();

      // セッションの保存
      $request->session()->put('user_id', $user->id);

      // 管理者権限の場合は商品管理ページに、それ以外はトップページにリダイレクト
      if($user->admin_status === 1) {
        return redirect('/products');
      } else {
        return redirect('/top');
      }
    } else {
      // 認証が通らない場合はフラッシュメッセージとともにログインページにリダイレクト
      return redirect('/signin')->with('message', 'ユーザー名またはパスワードが違います')->withInput();
    }
  }

  public function signout() {
    session()->forget('user_id');
    return redirect('/signin');
  }

  // ログイン済みか確認してリダレクト先の決定
  private function decideRedirect($redirect) {
    if(User::SignIned()) {
      if(User::isAdmin()) {
        return redirect('/products');
      } else {
        return redirect('/top');
      }
    } else {
      // ユーザー登録画面を表示
      return view('home.' . $redirect);
    }
  }
}
