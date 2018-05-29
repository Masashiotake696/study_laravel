@extends('layouts.default')

@component('components.header')
@slot('logoLink')
{{ url('/top') }}
@endslot
@slot('headerText')
ユーザ名：&emsp;<a href="{{ url('/products') }}">商品管理</a>&emsp;<a href="{{ url('/signout') }}">ログアウト</a>
@endslot
@endcomponent

@section('content')
<div class="container">
  <h1>ユーザ管理</h1>
  @if (session('message'))
  <p class="success">{{ session('message') }}</p>
  @endif
  <table>
    <thead>
      <th>名前</th>
      <th>権限</th>
    </thead>
    <tbody>
      @foreach ($users as $user)
      <tr>
        <td>{{ $user->name }}</td>
        <td>
          <form action="{{ url('/users/change_status', $user) }}" method="post">
            {{ csrf_field() }}
            {{ method_field('patch') }}
            <input type="submit" name="admin_status" value="{{ $user->showAdminStatus() }}">
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
