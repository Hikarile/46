@extends('D/start')

@section('title', 'png')
@section('text')
    <fieldset>
		<legend>資料統計</legend>
        <form method="get" action="{{route('png')}}">
        	日期:&nbsp;&nbsp;&nbsp;
            <input type="date" name="date" value="{{app('request')->input('date')}}">
				
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			
            車種:&nbsp;&nbsp;&nbsp;
            <select name="type">
                @foreach($type as $types)
					@if(app('request')->input('date') == $types->type)
						<option value="{{$types->type}}" selected>{{$types->type}}</option>
					@else
						<option value="{{$types->type}}">{{$types->type}}</option>
					@endif
                @endforeach
            </select>	
			
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			
			<input type="submit" value="查詢">
			
        </form>
    </fieldset>
	
	<p>&nbsp;</p>
	
	<input type="button" value="&nbsp;檢視JSON檔案&nbsp;" onclick="location.href='{{ route('json')}}/{{app('request')->input('date')}}/{{app('request')->input('type')}}">
	<img id="img" src="{{route('img')}}/{{app('request')->input('date')}}/{{app('request')->input('type')}}">
    
@endsection