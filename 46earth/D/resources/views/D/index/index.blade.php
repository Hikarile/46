@extends('D/start')
<script type="text/javascript" src="{{asset('./media/js/jquery.min.js')}}"></script>
<script>
	$(function(){
		$("#sub").submit(function (){
			var from1=$("#from").val();
			var to=$("#to").val();
			var type=$("#type").val();
			var date=$("#date").val();
			location.href='{{route("look")}}/'+from1+'/'+to+'/'+type+'/'+date;
			return false;
		})
	})
</script>
@section('title', 'home')
@section('text')
	<form id="sub" method="get">
		<fieldset>
			<legend>列車查詢</legend><p>
			
			<label for="from">起程站</label>
			<select name="from" id="from">
				@foreach($ts as $tss)
					<option value="{{$tss->station_E}}">{{$tss->station_C}}</option>
				@endforeach
			</select><p/>
			
			<label for="to">到達站</label>
			<select name="to" id="to">
				@foreach($ts as $tss)
					<option value="{{$tss->station_E}}">{{$tss->station_C}}</option>
				@endforeach
			</select><p/>
			
			<label for="type">車種</label>
			<select name="type" id="type">
				@foreach($type as $types)
					<option value="{{$types->id}}">{{$types->type}}</option>
				@endforeach
			</select><p/>
			
			<label for="date">搭乘日期</label>
			<input name="date" type="date" value="{{date('Y-m-d')}}" id="date" required><p/>
			
			<input type="submit" value="送出">

		</fieldset>
	</form>
@endsection