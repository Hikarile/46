@extends('layouts.main')
@section('title','訂票查詢')
@section('body','order-log')
@section('content')
    <form method="GET" action="{{ route('order-log.search') }}">
        <p>
            <span>
                <label for="unique" style="width:50px">編號</label>
                <input type="text" id="unique" name="unique"/>
            </span>
            
            <span>
                <label for="phone" style="width:50px">手機</label>
                <input type="tel" id="phone" name="phone"/>
            </span>
            
            <span><input type="submit" value="查詢" /></span>
        </p>
    </form>
    @if(!empty($orders))
    	<div style="overflow: auto;">
            <table class="table_style1" style="white-space: nowrap;">
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
                    @foreach($orders as $value)
                        <tr>
                            <td>{{$value->unique}}</td>
                            <td>{{$value->order_date}}<br />{{$value->order_time}}</td>
                            <td>{{$value->start_date}}<br />{{$value->start_time}}</td>
                            <td>{{$value->code}}</td>
                            <td>{{$value->from}}/{{$value->to}}</td>
                            <td>{{$value->count}}</td>
                            <td>
                                @if($value->cancel)
                                    已取消於<br />
                                    {{$value->updated_at}}
                                @else
                                    <input type="button" value="取消訂票" onclick="if(confirm('是否要取消訂票')){ location.href = '{{ route('order.cancel',[$value->id]) }}' };" />
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $orders->render() }}
		<script>
        	$('.pagination li:first').remove();
        	$('.pagination li:last').remove();
			$('.pagination a').each(function(n, o) {
                $(o).attr('href', $(o).attr('href') + '&phone={{$_GET["phone"]}}&unique={{$_GET["unique"]}}');
            });
        </script>
    @endif
@endsection
