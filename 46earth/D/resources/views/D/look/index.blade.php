@extends("D/start")

@section('title', 'home')
@section('text')
	<script>
		$(function() {
			$("button").click(function(){
				$('#number').val($(this).val());
			})
			$("#sub").submit(function(){
				var number = $('#number').val();
				var date = $('#date').val();
				var from = $('#from').val();
				var to = $('#to').val();
				location.href='{{ asset('order') }}/'+number+'/'+date+'/'+from+'/'+to;
				return false;
			})
		});
	</script>
	
	@if(session('error'))
		<p class="message_error">
			查無指定條件的車次，請更換條件再查詢
		</p>
	@else
		<p class="message_ok">
			您查詢<b>{{$inquires['date']}}</b>班次，從<b>{{$inquires['station']}}</b>到<b>{{$inquires['etation']}}</b>的班次如下
		</p>
	@endif
	
	<form method="GET" id="sub">
		<table border="1" cellspacing="0" style="">
			<thead>
				<tr>
					<th>車種</th>
					<th>列車編號</th>
					<th>發車/終點站</th>
					<th>開車時間</th>
					<th>到達時間</th>
					<th>行駛時間</th>
					<th>票價</th>
					<th>訂票</th>
				</tr>
			</thead>
			<tbody>
				@foreach($train as $i=>$trains)
				<tr>
					<td>{{$trains->type}}</td>
					<td>{{$trains->number}}</td>
					<td>{{$trains->start_station}}/{{$trains->end_station}}</td>
					<td>{{$trains->start_time}}</td>
					<td>{{$trains->end_time}}</td>
					<td>{{$trains->time}}分鐘</td>
					<td>{{$trains->money}}</td>
					<td><button id="ss" type="submit" value="{{ $trains->number }}">訂票</button></td>
				</tr>
				@endforeach
			</tbody>
		</table>
		<input type="hidden" name="number" id="number"/>
		<input type="hidden" name="date" id="date" value="{{$inquires['date']}}"/>
		<input type="hidden" name="from" id="from" value="{{$inquires['station_E']}}"/>
		<input type="hidden" name="to" id="to" value="{{$inquires['etation_E']}}"/>
	</form>
	
@endsection