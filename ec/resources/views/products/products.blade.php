@extends('layouts.default')

@component('components.header')
@slot('logoLink')
{{ url('/top') }}
@endslot
@slot('headerText')
ユーザ名：&emsp;<a href="{{ url('/users') }}">ユーザ管理</a>&emsp;<a href="{{ url('/signout') }}">ログアウト</a>
@endslot
@endcomponent

@section('content')
<div class="container">
  <h1>商品管理</h1>
  <section>
    <h1>商品登録</h1>
    @if (session('message'))
    <p class="success">{{ session('message') }}</p>
    @endif
    <form action="{{ url('/products/store') }}" method="post" enctype="multipart/form-data">
      {{ csrf_field() }}
      <p>
        商品名:
        <input type="text" name="name" value="{{ old('name') }}">
      </p>
      @if ($errors->has('name'))
      <span class="error">{{ $errors->first('name') }}</span>
      @endif
      <p>
        値段:
        <input type="text" name="price" value="{{ old('price') }}">
      </p>
      @if ($errors->has('price'))
      <span class="error">{{ $errors->first('price') }}</span>
      @endif
      <p>
        在庫数:
        <input type="text" name="stock" value="{{ old('stock') }}">
      </p>
      @if ($errors->has('stock'))
      <span class="error">{{ $errors->first('stock') }}</span>
      @endif
      <p>
        公開ステータス:
        <select name="status">
          <option value="0">非公開</option>
          <option value="1">公開</option>
        </select>
      </p>
      @if ($errors->has('status'))
      <span class="error">{{ $errors->first('status') }}</span>
      @endif
      <p>
        商品画像:
        <input type="file" name="image">
      </p>
      @if ($errors->has('image'))
      <span class="error">{{ $errors->first('image') }}</span>
      @endif
      <p>
        <input type="submit" value="商品追加">
      </p>
    </form>
  </section>
  <hr>
  <section>
    <h1>商品一覧</h1>
    <table>
      <thead>
        <th>商品画像</th>
        <th>商品名</th>
        <th>値段</th>
        <th>在庫数</th>
        <th>公開ステータス</th>
        <th>削除</th>
      </thead>
      <tbody>
        @foreach ($products as $product)
        @if ($product->status === 0)
        <tr class="background-gray">
        @else
        <tr>
        @endif
          <td><img src="images/{{ $product->image }}" art="{{ $product->image }}"></td>
          <td>{{ $product->name }}</td>
          <td>{{ $product->price }}円</td>
          <td>
            <form action="{{ url('/products/change_stock', $product) }}" method="post">
              {{ csrf_field() }}
              {{ method_field('patch') }}
              <input type="text" name="change_stock" value="{{ $product->stock->stock }}">
              <input type="submit" value="変更">
            </form>
          </td>
          <td>
            <form action="{{ url('/products/change_status', $product) }}" method="post">
              {{ csrf_field() }}
              {{ method_field('patch') }}
              <input type="submit" value="{{ $product->showStatus() }}">
            </form>
          </td>
          <td>
            <form action="{{ url('/products', $product)}}" method="post" id="form_{{ $product->id }}">
              {{ csrf_field() }}
              {{ method_field('delete') }}
            </form>
            <button type="button" class="delete" data-id="{{ $product->id }}">削除</button>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </section>
</div>
<script src="/js/main.js"></script>
@endsection
