@extends('layouts.main')
@section('title','列車資訊')
@section('body','train-info')
@section('content')
	<div style="text-align: center;">
    	<input id="code" type="text" size="8" />
        <input type="button" value="查詢" onclick="location.href = '{{url('/train-info')}}/' + $('#code').val() ;" />
    </div>
    @if(!empty($train))
    	行駛星期:{{$train->week}}<br />
        <table class="table_style1">
        	<tr>
            	<th>車站</th>
            	<th>抵達時間</th>
            	<th>發車時間</th>
            </tr>
            @foreach($result as $value)
            	<tr>
                	@foreach($value as $value2)
                    	<td>{{$value2}}</td>
                    @endforeach
                </tr>
            @endforeach
        </table>
        <div style="text-align: center;"><input type="button" value="訂票" onclick="location.href = '{{route('order',[$train->code])}}';" /></div>
    @endif
@endsection
