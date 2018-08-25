@extends('D/start')

@section('title', 'train')
@section('text')
	<p>&nbsp;<p/>
    
	<center>
		<input type="button" value="新增列車" onClick="location.href='{{route('trainadd')}}'">
	</center><p/>
	
	<table border="1">
    	<tr bgcolor="#CCCCCC">
        	<th>列車代碼</th>
            <th>車種</th>
            <th>行車星期</th>
            <th>發車時間</th>
            <th>行經車站/抵達時間/停留時間</th>
            <th>編輯</th>
        </tr>
		@if(isset($trains))
		@foreach($trains as $train)
        <tr>
        	<th>{{$train->number}}</th>
            <th>{{$train->type}}</th>
            <th>
				@if($train->Mon == 1)星期一<br/>@endif
				@if($train->Tue == 1)星期二<br/>@endif
				@if($train->Wed == 1)星期三<br/>@endif
				@if($train->Thu == 1)星期四<br/>@endif
				@if($train->Fri == 1)星期五<br/>@endif
				@if($train->Sat == 1)星期六<br/>@endif
				@if($train->Sun == 1)星期日<br/>@endif
			</th>
            <th>{{$train->stime}}</th>
            <th>
            	@foreach($stations as $station)
					@if($station->tid == $train->id)
						{{$station->strtion}}->
						{{$station->times}}->
						{{$train->waittime}}分鐘<p/>
						到<p/>
					@endif
				@endforeach
            </th>
			<th>
				<input type="button" value="修改" onClick="location.href='{{route('trainf')}}/{{$train->id}}'">
                <input type="button" value="刪除" onClick="location.href='{{route('traind')}}/{{$train->id}}'">
			</th>
        </tr>
		@endforeach
		@endif
    </table>
    
@endsection