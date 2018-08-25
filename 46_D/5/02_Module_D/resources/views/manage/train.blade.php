@extends('layouts.main')
@section('title','列車管理')
@section('body','manage_train')
@section('content')
	<style>
    	input[type="number"]{
			width: 70px;
		}
    </style>
	@if(!empty($insert))
    	<form method="post" action="{{route('manage.train.insert.do')}}">
        	{{ csrf_field() }}
            列車代碼:<input name="code" type="text" size="6" /><br />
            行車星期:
            	@foreach(week_nc() as $value)
                	<label><input name="week[]" type="checkbox" value="{{$value}}" />{{$value}}&nbsp;</label>
                @endforeach<br />
            車種: {{type_form()}}&nbsp;
            車廂數量: <input name="car_count" type="number" />&nbsp;
            每車廂人數: <input name="per_car" type="number" /><br />
            <table class="table_style1">
            	<tr>
                	<th>車站</th>
                	<th>行經順序</th>
                	<th>發車時間</th>
                </tr>
                @foreach(station_nc() as $key=>$value)
                	<tr>
                    	<td><label><input name="select[]" type="checkbox" value="{{$key}}" />{{$value}}</label></td>
                    	<td><input name="sort[]" type="number" /></td>
                    	<td><input name="time[]" type="time" /></td>
                    </tr>
                @endforeach
            </table>
            <div style="text-align: center;"><input type="submit" value="送出'" style="padding: 5px 50px;"></div>
        </form>
    @elseif(!empty($update))
        <form method="post" action="{{route('manage.train.update.do')}}">
        	{{ csrf_field() }}
            列車代碼:<input name="code" type="text" size="6" value="{{$train->code}}"/><br />
            行車星期:
            	@foreach(week_nc() as $value)
                	<label><input name="week[]" type="checkbox" value="{{$value}}" @if(strstr($train->week,$value))checked @endif />{{$value}}&nbsp;</label>
                @endforeach<br />
            車種: {{type_form()}}&nbsp;
            車廂數量: <input name="car_count" type="number" value="{{$train->car_count}}"/>&nbsp;
            每車廂人數: <input name="per_car" type="number" value="{{$train->per_car}}"/><br />
            <table class="table_style1">
            	<tr>
                	<th>車站</th>
                	<th>行經順序</th>
                	<th>發車時間</th>
                </tr>
                @foreach(station_nc() as $key=>$value)
                	<tr>
                    	<td><label><input name="select[]" type="checkbox" value="{{$key}}" />{{$value}}</label></td>
                    	<td><input name="sort[]" type="number" /></td>
                    	<td><input name="time[]" type="time" /></td>
                    </tr>
                @endforeach
            </table>
            <div style="text-align: center;"><input type="submit" value="送出'" style="padding: 5px 50px;"></div>
            <input name="or_code" type="hidden" value="{{$train->code}}" />
        </form>
        <script>
        	$('#type [value="{{$train->type}}"]').prop('checked',true);
			@foreach($train->station as $n=>$value)
				$('[name="select[]"]:eq({{array_search($value, station_nc())}})').prop('checked',true);
				$('[name="sort[]"]:eq({{array_search($value, station_nc())}})').val('{{$n+1}}');
				$('[name="time[]"]:eq({{array_search($value, station_nc())}})').val('{{$train->start_time[$n]}}');
			@endforeach
        </script>
    @else
    	<input type="button" value="新增列車" onclick="location.href = '{{route('manage.train.insert')}}';">
        <table class="table_style1">
        	<tr>
            	<th>列車代碼</th>
            	<th>行車星期</th>
            	<th>發車時間</th>
            	<th>行經車站</th>
            	<th></th>
            </tr>
            @foreach($trains as $value)
            	<tr>
                	<td>{{$value->code}}</td>
                	<td>{{$value->week}}</td>
                    <td>
                    	@foreach($value->start_time as $n=>$value2)
                        	{{$value2}}@if(($n+1)%2 == 0)<br />@endif
                        @endforeach
                    </td>
                    <td>
                    	@foreach($value->station as $n=>$value2)
                        	{{$value2}}@if(($n+1)%2 == 0)<br />@endif
                        @endforeach
                    </td>
                	<td>
                    	<input type="button" value="編輯" onClick="location.href = '{{ route('manage.train.update',[$value->code]) }}';" >
                        <input type="button" value="刪除" onClick="if(confirm('是否要刪除')){ location.href = '{{route('manage.train.delete',[$value->code])}}'; }" >
                    </td>
                </tr>
            @endforeach
        </table>
    @endif
@endsection
