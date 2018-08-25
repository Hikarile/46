@extends('layouts.main')
@section('title', '查詢訂票 - ')
@section('type','order-log')
@section('content')
	<script>
    	function order_cancel(id){
			if(confirm('確定要取消此訂票?')){
				location.href = '{{ url('') }}/order/cancel/' + id;
			}else{
				alert('不取消');	
			}	
		}
    </script>
	<div id="content">
    	@if($errors->has())
            <p class="message_error">
                {{ $errors->first() }}
            </p>
        @endif
        <form method="GET" action="{{ route('order-log_do') }}" style="margin-bottom: 30px; width: 100%;">
        	<span style="margin-right: 15px;">
                <label for="number" style="width:50px">編號:</label>
                <input type="text" id="number" name="number" />
			</span>
            <span style="margin-right: 15px;">
                <label for="phone" style="width:50px">手機:</label>
                <input type="tel" id="phone" name="phone" />
            </span>
            <span><input type="submit" value="查詢" style="padding: 0 30px; font-size: 1.3em;"/></span>
        </form>
        @if(!empty($orders[0]))
        	<div style="overflow: auto;">
                <table class="data_table" style=" white-space: nowrap;">
                    <thead>
                        <tr>
                            <th>編號</th>
                            <th>訂票時間</th>
                            <th>發車時間</th>
                            <th>車次</th>
                            <th>起訖站</th>
                            <th>張數</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $n=>$value)
                            <tr>
                                <td>{{ $value->n }}</td>
                                <td>{{ $value->order_date }}<br />{{ $value->order_time }}</td>
                                <td>{{ $value->date }}<br />{{ $value->start_time }}</td>
                                <td>{{ $value->code }}</td>
                                <td>{{ $station_n_c[$value->from] . $station_n_c[$value->to] }}</td>
                                <td>{{ $value->count }}</td>
                                <td>@if($value->cancel == 0)
                                        <input type="button" value="取消訂票" onclick="order_cancel('{{ $value->id }}');">
                                    @else
                                        已取消於<br>{{ $value->created_at }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
        	</div>
            {{ $orders->render() }}
		@endif
    </div>
@endsection