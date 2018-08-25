<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>列車訂票系統 - @yield('title')</title>
		<link rel="stylesheet" type="text/css" href="{{ asset('css/screen.css') }}" />
		<link rel="stylesheet" type="text/css" href="{{ asset('css/print.css') }}" />

		<script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('js/rating.js') }}"></script>
	</head>
	<body class="@yield('body')">
		<div id="canvas">
			<div id="header">
				<h1>
					<a href="./" title="列車訂票系統">
						<img alt="列車訂票系統" src="{{ asset('img/header.png') }}" />
					</a>
				</h1>
			</div>
			<ul id="menu">
				<li class="home"><a href="{{ url('/') }}">首頁</a></li>
				<li class="order"><a href="{{ url('/order') }}">預訂車票</a></li>
				<li class="order-log"><a href="{{ url('/order-log') }}">訂票查詢</a></li>
				<li class="train-info"><a href="{{ url('/train-info') }}">列車資訊</a></li>
				@if(Auth::guest())
					<li class="login"><a href="{{ url('/login') }}">登入後台</a></li>	
				@else						
					<li class="manage_type"><a href="{{ route('manage.type') }}">車種管理</a></li>
					<li class="manage_train"><a href="{{ route('manage.train') }}">列車管理</a></li>
					<li class="manage_order"><a href="{{ route('manage.order') }}">訂票紀錄查詢</a></li>
					<li class="logout"><a href="{{ url('/logout') }}">登出</a></li>
				@endif
			</ul>
			<div id="content">
				@if($errors->has())
					<p class="message_error">{{$errors->first()}}</p>
				@endif
				@yield('content')
			</div>
			<div id="footer">
				<p>Copyright &copy; 2016 &#183; All Rights Reserved</p>
			</div>
		</div>
		
	</body>
</html>