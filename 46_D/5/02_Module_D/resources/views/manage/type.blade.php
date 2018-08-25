@extends('layouts.main')
@section('title','車種管理')
@section('body','manage_type')
@section('content')
	@if(!empty($insert))
    	<form method="post" action="{{route('manage.type.insert.do')}}">
        	{{ csrf_field() }}
            <table class="table_style1">
                <tr>
                    <th>車種名稱</th>
                    <th>最高時速(km/h)</th>
                    <th></th>
                </tr>
                <tr>
                    <td><input name="name" type="text" style="width: 100%;"></td>
                    <td><input name="speed" type="number" style="width: 100%;"></td>
                    <td>
                    	<input type="submit" value="送出">
                    </td>
                </tr>
            </table>
        </form>
    @elseif(!empty($update))
        <form method="post" action="{{route('manage.type.update.do')}}">
        	{{ csrf_field() }}
            <table class="table_style1">
                <tr>
                    <th>車種名稱</th>
                    <th>最高時速(km/h)</th>
                    <th></th>
                </tr>
                <tr>
                    <td><input name="name" type="text" style="width: 100%;" value="{{$type->name}}"></td>
                    <td><input name="speed" type="number" style="width: 100%;" value="{{$type->speed}}"></td>
                    <td>
                    	<input type="submit" value="送出">
                    </td>
                </tr>
            </table>
            <input name="or_name" type="hidden" value="{{$type->name}}">
            <input name="id" type="hidden" value="{{$type->id}}">
        </form>
    @else
    	<input type="button" value="新增車種" onclick="location.href = '{{route('manage.type.insert')}}';">
        <table class="table_style1">
        	<tr>
            	<th>車種名稱</th>
            	<th>最高時速(km/h)</th>
            	<th></th>
            </tr>
            @foreach(type_all() as $value)
            	<tr>
                	<td>{{$value->name}}</td>
                	<td>{{$value->speed}}</td>
                	<td>
                    	<input type="button" value="編輯" onClick="location.href = '{{ route('manage.type.update',[$value->id]) }}';" >
                        <input type="button" value="刪除" onClick="if(confirm('是否要刪除')){ location.href = '{{route('manage.type.delete',[$value->id])}}'; }" >
                    </td>
                </tr>
            @endforeach
        </table>
    @endif
@endsection
