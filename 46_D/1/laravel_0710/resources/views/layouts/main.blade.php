<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>@yield('title')列車訂票系統</title>
        <link rel="stylesheet" type="text/css" href="{{ asset('css/screen.css') }}" media="screen" />
        <link rel="stylesheet" type="text/css" href="{{ asset('css/print.css') }}"/>
        <script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/Tag.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/rating.js') }}"></script>
        <script>
        	$(function(){
				/*
				$('#nav_right_top').on('mouseover',function(){
					$('#nav_right_top').animate({height:'300px'},'fast');
				});
				$('#nav_right_top').on('mouseleave',function(){
					$('#nav_right_top').animate({height:'30px'},'fast');
				});
				*/
			})
        </script>
    </head>
    <body class="@yield('type')"><!-- class corresponds to current navigation menu -->
        <div id="canvas">
            <div id="header">
                <h1>
                    <a href="{{ url('/') }}" title="列車訂票系統">
                        <img alt="列車訂票系統" src="{{ asset('img/header.png') }}" />
                    </a>
                </h1>
            </div>
            <div id="nav_right_top">
				<ul>
                	<div id="nav_right_top_lead">▼</div>
                    <li class="home"><a href="{{ url('/') }}">首頁</a></li>
                    <li class="order"><a href="{{ url('/order') }}">預訂車票</a></li>
                    <li class="order-log"><a href="{{ url('/order-log') }}">訂票查詢</a></li>
                    <li class="info"><a href="{{ url('/train-info') }}">列車資訊</a></li>
                    @if(Auth::guest())
                        <li class="login"><a href="{{ url('/login') }}">登入後台</a></li>
                    @else
                        <li class="type_manage"><a href="{{ url('/manage/type') }}">車種管理</a></li>	
                        <li class="train_manage"><a href="{{ url('/manage/train') }}">列車管理</a></li>
                        <li class="order_manage"><a href="{{ url('/manage/order') }}">訂票紀錄查詢</a></li>
                        <li class="logout"><a href="{{ url('/logout') }}">登出</a></li>			
                    @endif
                </ul>
			</div>
            <ul id="menu">
                <li class="home"><a href="{{ url('/') }}">首頁</a></li>
                <li class="order"><a href="{{ url('/order') }}">預訂車票</a></li>
                <li class="order-log"><a href="{{ url('/order-log') }}">訂票查詢</a></li>
                <li class="info"><a href="{{ url('/train-info') }}">列車資訊</a></li>
                @if(Auth::guest())
					<li class="login"><a href="{{ url('/login') }}">登入後台</a></li>
				@else
                	<li class="type_manage"><a href="{{ url('/manage/type') }}">車種管理</a></li>	
                    <li class="train_manage"><a href="{{ url('/manage/train') }}">列車管理</a></li>
                    <li class="order_manage"><a href="{{ url('/manage/order') }}">訂票紀錄查詢</a></li>
					<li class="logout"><a href="{{ url('/logout') }}">登出</a></li>			
				@endif
			</ul>
            @yield('content')
            <div id="footer">
                <p>Copyright &copy; 2016 &#183; All Rights Reserved</p>
            </div>
        </div>
    </body>
</html>