@extends('D\start')

@section('title', 'type')
@section('text')
	<p>&nbsp;</p>
    @if(session('error'))
		<p class="message_error">
			{{session('error')}}
		</p>
	@endif
    <div style="text-align:center;">
    	<input type="button" value="新增車種" name="new" onClick="location.href='{{route('typeadd')}}'"><p/>
    </div>
	
	<form method="post">
		<table border="1" width="50%">
        	<tr bgcolor="#CCCCCC">
            	<th>名稱</th>
				<th>車廂數量</th>
				<th>單一車廂量</th>
                <th>乘載量</th>
                <th>編輯</th>
            </tr>
			@if (isset($type))
            @foreach($type as $ty)
            <tr>
            	<th>{{$ty->type}}</th>
                <th>{{$ty->car}}</th>
				<th>{{$ty->singlecar}}</th>
				<th>{{$ty->total}}</th>
                <th>
                	<input type="button" value="修改" name="f" onClick="location.href='{{route('typef')}}/{{$ty->id}}'">
                    <input type="button" value="刪除" name="d" onClick="location.href='{{route('d')}}/1/{{$ty->id}}'">
                </th>
            </tr>
			@endforeach
			@endif
        </table>
	</form>
	
@endsection