@extends('D/start')

@section('title', 'ticket')
@section('text')
	<script type="text/javascript" src="{{asset('./media/js/jquery.min.js')}}"></script>
	<script>
		$(function(){
			$("#sub").submit(function(){
				var date=$("[name='date']").val();
				var number=$("[name='number']").val();
				var phone=$("[name='phone']").val();
				var from1=$("[name='from']").val();
				var to=$("[name='to']").val();
				if(date == ''){
					date='null';
				}
				if(number == ''){
					number='null';
				}
				if(phone == ''){
					phone='null';
				}
				if(from1 == ''){
					from1='null';
				}
				if(to == ''){
					to='null';
				}
				location.href='{{route("ticket")}}/'+date+'/'+number+'/'+phone+'/'+from1+'/'+to;
				return false;
			});
		})
		function butt(id){
			location.href='{{route("ticketd")}}/'+id;
		}
	</script>
	
	<form method="GET" id="sub">
		<fieldset>
			<legend>訂票紀錄查詢</legend>
			<p>
				<label for="date">搭乘日期</label>
				<input type="date" id="date" name="date">
			</p>
			<p>
				<label for="number">車次</label>
				<input type="number" id="number" name="number">
			</p>
			<p>
				<label for="phone">手機號碼</label>
				<input type="text" id="phone" name="phone">
			</p>
			<p>
				<label for="from">搭乘站</label>
				<select name="from" id="from">
					<option></option>
					@foreach($ts as $tss)
						<option value="{{$tss->station_E}}">{{$tss->station_C}}</option>
					@endforeach
				</select>
			</p>
			<p>
				<label for="to">到達站</label>
				<select name="to" id="to">
					<option></option>
					@foreach($ts as $tss)
						<option value="{{$tss->station_E}}">{{$tss->station_C}}</option>
					@endforeach
				</select>
			</p>
			<p>
				<input type="submit" value="查詢">
			</p>
		</fieldset>
	</form>
	
	@if(isset($ticket))
		<table border="1" cellspacing="0">
			<tr>
				<th>訂票編號</th>
				<th>訂票時間</th>
				<th>發車時間</th>
				<th>車次</th>
				<th>起訖站</th>
				<th>張數</th>
				<th>取消訂票</th>
			</tr>
			@foreach($ticket as $tickets)
			<tr>
				<td>{{$tickets->number}}</td>
				<td>{{$tickets->day}}</td>
				<td>{{$tickets->stime}}</td>
				<td>{{$tickets->station_number}}</td>
				<td>{{$tickets->station}}/{{$tickets->etation}}</td>
				<td>{{$tickets->pag}}</td>
				<td>
					@if($tickets->d != '')
						已刪除<br/>
						{{$tickets->d}}
					@else
						@if(strtotime('now') <= strtotime($tickets->day.' '.$tickets->stime))
							<input type="button" value="取消訂票" onClick="butt({{$tickets->id}})">
						@endif
					@endif
				</td>
			</tr>
			@endforeach
		</table>
		{{$ticket->links()}}
	@endif
	
@endsection