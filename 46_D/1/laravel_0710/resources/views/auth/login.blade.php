@extends('layouts.main')
@section('title', '登入後台 - ')
@section('type','login')
@section('content')
	<div id="content">
        @if($errors->has('email'))
			<p class="message_error">
				@if($errors->first('email') == 'required') {{ '帳號為必填欄位' }} @endif
				@if($errors->first('email') == 'length') {{ '帳號長度有誤' }} @endif
				@if($errors->first('email') == 'fault') {{ '帳號或密碼有誤' }} @endif
			</p>		
		@elseif($errors->has('password'))
			<p class="message_error">
				@if($errors->first('password') == 'required') {{ '密碼為必填欄位' }} @endif
				@if($errors->first('password') == 'length') {{ '密碼長度有誤' }} @endif
				@if($errors->first('password') == 'fault') {{ '帳號或密碼有誤' }} @endif
				@if($errors->first('password') == 'confirmed') {{ '密碼確認錯誤' }} @endif
			</p>
		@endif
		<form method="post" action="{{ url('/login') }}">
			{!! csrf_field() !!}
            <fieldset>
                <p>
                    <label for="user">帳號:</label>
                    <input type="text" class="form-control" name="email">
                    <span class="message"></span>
                </p>
                <p>
                    <label for="password">密碼:</label>
                    <input type="password" class="form-control" name="password">
                    <span class="message"></span>
                </p>
                <p>
                    <input type="submit" value="登入">
                </p>
            </fieldset>

        </form>
    </div>
@endsection
