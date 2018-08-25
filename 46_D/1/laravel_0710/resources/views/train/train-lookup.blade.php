@extends('layouts.main')
@section('title', '查詢結果 - ')
@section('type','home')
@section('content')
	<div id="content">
    	@if(count($result) < 1)
            <p class="message_error">
                查無指定條件的車次，請更換條件再查詢
            </p>
        @else
            <p class="message_ok">
                您查詢<b>{{ $date }}</b>班次，從<b>{{ $from_c }}</b>到<b>{{ $to_c }}</b>的班次如下
            </p>
  		@endif
        <form method="GET">
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
					@foreach($result as $n=>$row)
						<tr>
							@foreach($row as $value)
                            	<td>{{ $value }}</td>
                            @endforeach
                            <td><input type="button" value="訂票" onclick="location.href = '{{ route('order',[$codes[$n],$from,$to,$date]) }}';"></td>
						</tr>
					@endforeach
				</tbody>
			</table>
        </form>
    </div>
@endsection