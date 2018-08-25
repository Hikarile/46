<!DOCTYPE html>
<style>
	body{
		background-color:#6699FF;
		font-size:30px;
		text-align:center;
		font-weight:900;
	}
</style>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>頁面---@yield('title')</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
    </head>
    <body>
		My name is {{$na}}</br>
		身高{{$n}}</p>
		
		現在時間為:{{date('Y-m-d  H-i-s')}}</p>
		
		@for($i=0;$i<5;$i++)
			這是第{{$i}}筆</br>
		@endfor</p>
		
		@for($i=1;$i<=9;$i+=2)
			@for($j=1;$j<=9;$j+=2)
			{{$i}}*{{$j}}={{$i*$j}} &nbsp;&nbsp;
			@endfor
			</p>
		@endfor
		
		@section('text')
			He is a good boy.</br>
		@show</p>
		
		<div>
			@yield('cont')
			
		</div>
		
    </body>
</html>
