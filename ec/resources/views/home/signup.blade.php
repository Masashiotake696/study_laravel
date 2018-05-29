@extends('layouts.default')

@component('components.header')
@slot('logoLink')
{{ url('/signin') }}
@endslot
@slot('headerText')
<a href="{{ url('/signin') }}">ログイン</a>
@endslot
@endcomponent

@section('content')
<div class="home-container">
  <h1 class="text-center">ユーザ登録</h1>
  @if (session('message'))
  <p class="success">{{ session('message') }}</p>
  @endif
  <form action="{{ url('/signup/create') }}" method="post">
    {{ csrf_field() }}
    <p>
      ユーザー名:
      <input type="text" name="name" value="{{ old('name') }}">
    </p>
    @if ($errors->has('name'))
    <p class="error">{{ $errors->first('name') }}</p>
    @endif
    <p>
      パスワード:
      <input type="password" name="password" value="">
    </p>
    @if ($errors->has('password'))
    <p class="error">{{ $errors->first('password') }}</p>
    @endif
    <div class="text-center margin-top-and-bottom-10px">
      <input type="submit" value="登録">
    </p>
  </form>
</div>
@endsection
