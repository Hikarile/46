@extends('layouts.main')
@section('title','登入後台')
@section('body','login')
@section('content')
    <form role="form" method="POST" action="{{ url('/login') }}">
        {!! csrf_field() !!}
        <fieldset>
            <p>
                <label for="user">帳號:</label>
                <input type="text" name="email" id="email">
                <span class="message"></span>
            </p>
            <p>
                <label for="password">密碼:</label>
                <input type="password" name="password" id="password">
                <span class="message"></span>
            </p>
            <p>
                <input type="submit" value="登入">
            </p>
        </fieldset>
    </form>
@endsection
