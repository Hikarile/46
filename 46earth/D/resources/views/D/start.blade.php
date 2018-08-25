<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>列車訂票系統</title>
<base href="./" />
<link rel="stylesheet" type="text/css" href="{{asset('./media/css/screen.css')}}" media="screen" />
<link rel="stylesheet" type="text/css" href="{{asset('./media/css/print.css')}}" media="print" />

<script type="text/javascript" src="{{asset('./media/js/jquery.min.js')}}"></script>

</head>
<body class="@yield('title')"><!-- class corresponds to current navigation menu -->
	
	<div id="canvas">
		<div id="header">
			<h1>
				<a href="./" title="列車訂票系統">
					<img alt="列車訂票系統" src="{{asset('./media/img/header.png')}}" />
				</a>
			</h1>
		</div>
		<ul id="menu">
			<li class="home"><a href="{{route('index')}}">首頁</a></li>
			<li class="order"><a href="{{route('order')}}">預訂車票</a></li>
			<li class="orderlog"><a href="{{route('order_log')}}">訂票查詢</a></li>
			<li class="info"><a href="{{route('train_info')}}">列車資訊</a></li>
			@if(session('dnlu')=='')
			<li class="login"><a href="{{route('login')}}">登入後台</a></li>
			@else
			<li class="png"><a href="{{route('png')}}">資料統計</a></li>
			<li class="type"><a href="{{route('type')}}">車種管理</a></li>
			<li class="train"><a href="{{route('train')}}">列車管理</a></li>
			<li class="ticket"><a href="{{route('ticket')}}">訂票紀錄查詢</a></li>
			<li class="out"><a href="{{route('out')}}">登出</a></li>
			@endif
		</ul>
		<div id="content">
            
			@section('text')
				
			@show</p>
			
		</div>
		<div id="footer">
			<p>Copyright &copy; 2016 &#183; All Rights Reserved</p>
		</div>
	</div>
	
</body>
</html>