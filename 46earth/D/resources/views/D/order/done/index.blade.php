@extends("D/start")

@section('title', 'order')
@section('text')
	<p class="message_ok">
		訂票成功
	</p>
	<p>
		<label>訂票編號</label>
		<span>{{$ticket['number']}}</span>
	</p>
	<p>
		<label>手機號碼</label>
		<span>{{$ticket['phone']}}</span>
	</p>
	<p>
		<label>發車時間</label>
		<span>{{$ticket['stime']}}</span>
	</p>
	<p>
		<label>車次</label>
		<span>{{$ticket['station_number']}}</span>
	</p>
	<p>
		<label>起訖站</label>
		<span>{{$ticket['station']}} 到 {{$ticket['etation']}}</span>
	</p>
	<p>
		<label>張數</label>
		<span>{{$ticket['pag']}}張/每張{{$ticket['one_money']}}</span>
	</p>
	<p>
		<label>總票價</label>
		<span>{{$ticket['all_money']}}</span>
	</p>
@endsection