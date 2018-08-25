@extends('layouts.main')
@section('title', '列車資訊 - ')
@section('type','info')
@section('content')
	<script>
    	function search(){
			var code = $('#search_code').val();
			if(code){
				location.href = '{{ url('') }}/train-info/' + code;
			}	
		}
    </script>
	<div id="content">
        @if(!empty($not_find))
            <p class="message_error">
                查無該列車資訊
            </p>
        @endif
        <div style="text-align: center; margin: 20px 0;">車次代碼:<input id="search_code">&nbsp;<input type="button" value="查詢" onclick="search();"></div>
        @if(!empty($search_result))
       		<div style="text-align: center; margin: 20px 0;">
                行駛星期:
                @foreach($week as $n=>$value)
                    @if($n != 0) , @endif
                    {{ $week_n_c[$value] }}
                @endforeach
        	</div>
            <table class="data_table">
            	<tr>
                	<th>車站</th>
                    <th>抵達時間</th>
                    <th>發車時間</th>
                </tr>
            	@foreach($station as $n=>$value)
                	<tr>
                    	<td>{{ $station_n_c[$value] }}</td>
                        <td>{{ $time[$n][0] }}</td>
                        <td>{{ $time[$n][1] }}</td>
                    </tr>
                @endforeach
            </table>
            <br />
        	<div style="text-align: center;"><input type="button" value="訂票" style="font-size: 1.3em; padding: 0 30px;" onclick="location.href = '{{ route('order',[$code]) }}';" /></div>
        @endif
        
    </div>
@endsection