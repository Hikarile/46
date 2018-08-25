@extends('layouts.main')
@section('title','訂票紀錄查詢')
@section('body','manage_order')
@section('content')
	<form method="get" action="{{ route('manage.order.search') }}">
    	<fieldset>
        	<legend>查詢條件</legend>
        	<table>
				<tr>
                	<td>發車日期:<input name="start_date" type="date" /></td>
                	<td>車次:<input name="code" type="text" size="8" /></td>
                </tr>            
				<tr>
                	<td>手機號碼:<input name="phone" type="tel" /></td>
                	<td>訂票編號:<input name="unique" type="text" /></td>
                </tr>            
				<tr>
                	<td>
                    	起站:
                    	<select name="from">
                        	<option value=""></option>
                        	@foreach(station_nc() as $value)
                            	<option value="{{$value}}">{{$value}}</option>
                            @endforeach
                        </select>    
                    </td>
                	<td>
                    	迄站:
                    	<select name="to">
                        	<option value=""></option>
                        	@foreach(station_nc() as $value)
                            	<option value="{{$value}}">{{$value}}</option>
                            @endforeach
                        </select>    
                    </td>
                </tr>            
            </table>
            <div style="text-align: center;"><input type="submit" value="送出" style="padding: 5px 70px;"/></div>
        </fieldset>
    </form>
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
    @if(isset($_GET['unique']))
		<script>
            $('.pagination li:first').remove();
            $('.pagination li:last').remove();
            $('.pagination a').each(function(n, o) {
                $(o).attr('href', $(o).attr('href') + '&phone={{$_GET["phone"]}}&unique={{$_GET["unique"]}}&code={{$_GET["code"]}}&start_date={{$_GET["start_date"]}}&from={{$_GET["from"]}}&to={{$_GET["to"]}}');
            });
        </script>
    @endif
@endsection
