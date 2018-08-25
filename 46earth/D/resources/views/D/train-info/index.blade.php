@extends('D/start')

@section('title', 'info')
@section('text')
	<script type="text/javascript" src="{{asset('./media/js/jquery.min.js')}}"></script>
	<script>
		$(function() {
			$('#sub').submit(function(){
				var number = $('#number').val();
				if(number != '' ){
					location.href="{{route('train_info')}}/"+number;
				}else{
					location.href="{{route('train_info')}}";
				}
				return false;
			});
		});
		function aa(number){
			alert(number);
			location.href='{{route("order")}}' + '/' + number;
			return false;
		}
	</script>
	
	<fieldset>
		<legend>列車資訊</legend>
		<form method="GET" id="sub">
			<p>
				<span>
					<label for="number" style="width:50px">車次</label>
					<input type="number" required id="number" name="number" value=""/>
				</span>

				<span><input type="submit" value="查詢"></span>
			</p>
		</form>
		
		@if(isset($train))
			<p>
			<label>行駛星期:</label>
			@if($train->Sun == 1)
				星期日,
			@endif
			@if($train->Mon == 1)
				星期一,
			@endif
			@if($train->Tue == 1)
				星期二,
			@endif
			@if($train->Wed == 1)
				星期三,
			@endif
			@if($train->Thu == 1)
				星期四,
			@endif
			@if($train->Fri == 1)
				星期五,
			@endif
			@if($train->Sat == 1)
				星期六,
			@endif
			</p>
			<p>
			<label>本週日期:</label>
			{{ date('Y-m-d', strtotime('sun last week')) . '至' . date('Y-m-d', strtotime(('sat this week'))) }}
			</p>
			<p>
			<label>發車時間:</label>
			{{ $train->stime }}
			</p>
			<p>
			<label>各車站抵達時間:</label>	
				@foreach($station as $stations)
					{{$stations->strtion}}
					({{$stations->times}})->
				@endforeach
			</p>
			<p>
			<input type="button" value="&nbsp;訂票&nbsp;" onclick="aa('{{$train->number}}')">
			</p>
		@endif
	</fieldset>
@endsection