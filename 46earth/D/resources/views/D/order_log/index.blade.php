@extends('D/start')

@section('title', 'orderlog')
@section('text')
	
    <script src="{{asset('./media/js/jquery.js')}}"></script>
    <script>
		$(function (){
			$("#sub").submit(function (){
				var sn=$("#sn").val();
				var phone=$("#phone").val();
				if(sn==''){
					sn=null;
				}
				if(phone==''){
					phone=null;
				}
				location.href='{{route("order_log")}}/'+sn+'/'+phone;
				return false;
			})
		})
		
		function butt(id){
			location.href='{{route("order_log_d")}}/'+id;
		}
		
    </script>
    
    @if(session('error') != '')
		<p class="message_error">
			{{session('error')}}
		</p>
	@endif
	 @if(session('yes') != '')
		<p class="message_ok">
			{{session('yes')}}
		</p>
	@endif
	
	<form id="sub" method="get">
		<p>
			<span>
				<label for="sn" style="width:50px">編號</label>
				<input type="text" id="sn" name="sn" value="{{old('sn')}}"/>
			</span>
			
			<span>
				<label for="phone" style="width:50px">手機</label>
				<input type="tel" id="phone" name="phone" value="{{old('phone')}}"/>
			</span>
			
			<span><input type="submit" value="送出"></span>
		</p>
	</form>
	
	<table border="1" cellspacing="0">
		<tr>
			<th>編號</th>
			<th>訂票時間</th>
			<th>發車時間</th>
			<th>車次</th>
			<th>起訖站</th>
			<th>張數</th>
			<th></th>
		</tr>
		@if(isset($ticket))
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
						{{$tickets->d}}
					@else
						<input type="button" value="取消訂票" onClick="butt({{$tickets->id}})">
					@endif
				</td>
			</tr>
			@endforeach
		@endif
	</table>
	
	{{$ticket->links()}}
	
@endsection