@extends('D/start')

@section('title', 'train')
@section('text')
	<script src="{{asset('./media/js/jquery.min.js')}}"></script>
    <script>
		$(function (){
			var a=$("#a").val();
			aaa(a);
			
			$("#sstation").change(function(){//起始站下拉式選單
				dd=$("#sstation").val();
				$("#sstat").val(dd);
				if($("#"+dd).val()==dd){
					$("#"+dd).attr('disabled','disabled');
					$("#"+dd).css('background-color','#999');
				}
				if($("#sstation").val()!='' && $("#estation").val()!=''){
					$("#hid").show();
				}
				$("#sstation").attr('disabled','disabled');
			})
			$("#estation").change(function(){//終點站下拉式選單
				dd=$("#estation").val();
				$("#estat").val(dd);
				if($("#"+dd).val()==dd){
					$("#"+dd).attr('disabled','disabled');
					$("#"+dd).css('background-color','#999');
				}
				if($("#sstation").val()!='' && $("#estation").val()!=''){
					$("#hid").show();
				}
				$("#estation").attr('disabled','disabled');
			})
			for(i=0;i<=14;i++){
				$("[name='st"+i+"']").click(function(){//點擊車站按鈕
					var a=$("#a").val();
					a++;
					b=a-1;
					station=$(this).val();
					da='<li><input id="station'+a+'" type="text" name="station['+a+']" value="'+station+'" readonly> &nbsp;&nbsp;&nbsp;<input id="time'+a+'" type="time" name="times['+a+']"> &nbsp;&nbsp;&nbsp;<input type="button" value="刪除" id="c'+a+'" name="c'+a+'" onClick="c('+a+')"><p/></li>';
					$("#hidden").before(da);
					$(this).attr('disabled','readonly');
					$(this).css('background-color','#999');
					$("#c"+b).hide();
					$("#a").val(a);
				})
			}
			$("#sub").submit(function (){//送出表單
				if($("#number").val()==''){
					alert("列車代碼未填");
					return false;
				}
				if($("#stim").val()==''){
					alert("時間未填寫完成");
					return false;
				}
				if($("#etim").val()==''){
					alert("時間未填寫完成");
					return false;
				}
				for(i=1;i<=a;i++){
					if($("#time"+i).val()==''){
						alert("時間未填寫完成");
						return false;
					}
				}
				if($("#waittime").val() == ''){
					alert("停站時間未填");
					return false;
				}
				if($("#waittime").val() > 10){
					alert("停站時間不能大於10分鐘");
					return false;
				}
				a=parseInt($("#a").val())+2;
				if(a > 15){
					alert("不能超過15個站");
					return false;
				}
			})
		})
		function aaa(a){
			ddd=$("#sstation").val();
			$("#"+ddd).attr('disabled','disabled');
			$("#"+ddd).css('background-color','#999');
			
			dddd=$("#estation").val();
			$("#"+dddd).attr('disabled','disabled');
			$("#"+dddd).css('background-color','#999');
			
			for(i=1;i<=a;i++){
				var b=i-1;
				ddddd=$("[name='station["+i+"]']").val();
				$("#"+ddddd).attr('disabled','disabled');
				$("#"+ddddd).css('background-color','#999');
				$("#c"+b).hide();
			}
		}
		function scleared(){//起始站清除按鈕
			var dd=$("#sstat").val();
			$("#sstat").val('');
			$("#stim").val('');
			$("#"+dd).removeAttr('disabled');
			$("#"+dd).removeAttr('style');
			$("#sstation").val('');
			$("#sstation").removeAttr('disabled');
		}
		function ecleared(){//終點站清除按鈕
			var dd=$("#estat").val();
			$("#estat").val('');
			$("#etim").val('');
			$("#"+dd).removeAttr('disabled');
			$("#"+dd).removeAttr('style');
			$("#estation").val('');
			$("#estation").removeAttr('disabled');
		}
		function c(a){//刪除
			var station=$("[name='station["+a+"]']").val();
			var b=a-1;
			$("#c"+a).parent('li').remove();
			$("#c"+b).show();
			$("#"+station).removeAttr('disabled');
			$("#"+station).removeAttr('style');
			$("#a").val(b);
		}
    </script>
    
	<input type="button" value="返回" onClick="location.href='{{route('train')}}'">
	
    <form method="post" action="{{route('trainsave')}}" id="sub">
		<fieldset>
			<legend>新增列車</legend><p/>
            
            列車:
            <select name="type">
				@foreach($type as $types)
					@if($train->type == $types->type)
						<option value="{{$types->type}}" selected>{{$types->type}}</option>
					@else
						<option value="{{$types->type}}">{{$types->type}}</option>
					@endif
				@endforeach
			</select>
            <p>&nbsp;</p>
            
			列車代碼:
            <input type="number" name="number" value="{{$train->number}}">
            <p>&nbsp;</p>
			
            星期:<br/>
            <div>
			<input type="checkbox" name="Sun" id="Sun" value="1" @if($train->Sun == 1) checked @endif >星期日 &nbsp;
            <input type="checkbox" name="Mon" id="Mon" value="1" @if($train->Mon == 1) checked @endif >星期一 &nbsp;
            <input type="checkbox" name="Tue" id="Tue" value="1" @if($train->Tue == 1) checked @endif >星期二 &nbsp;
            <input type="checkbox" name="Wed" id="Wed" value="1" @if($train->Wed == 1) checked @endif >星期三 &nbsp;
            <input type="checkbox" name="Thu" id="Thu" value="1" @if($train->Thu == 1) checked @endif >星期四 &nbsp;
            <input type="checkbox" name="Fri" id="Fri" value="1" @if($train->Fri == 1) checked @endif >星期五 &nbsp;
            <input type="checkbox" name="Sat" id="Sat" value="1" @if($train->Sat == 1) checked @endif >星期六 &nbsp;
            <p>&nbsp;</p>
            </div>
			
			起始站:
			<select id="sstation" name="sstation" disabled>
			<option value=""></option>
				@foreach($tts as $ts)
                	@if($ts->station_C == $train->station)
                    	<option value="{{$ts->station_C}}" selected>{{$ts->station_C}}</option>
                    @else
                    	<option value="{{$ts->station_C}}">{{$ts->station_C}}</option>
                    @endif
				@endforeach
			</select><p/>
			終點站:
			<select id="estation" name="etation" disabled>
			<option value="" selected="selected"></option>
				@foreach($tts as $ts)
					@if($ts->station_C == $train->etation)
                    	<option value="{{$ts->station_C}}"selected>{{$ts->station_C}}</option>
                    @else
                    	<option value="{{$ts->station_C}}">{{$ts->station_C}}</option>
                    @endif
				@endforeach
			</select>
			<p>&nbsp;</p>
			
			<div id="hid">
            	<div id="test">
                    @foreach($tts as $i => $ts)
						<input id="{{$ts->station_C}}" type="button" name="st{{$i}}" value="{{$ts->station_C}}"> &nbsp;
	                @endforeach
				</div>
                <p>&nbsp;</p>
				
                起始站:
                <input id="sstat" type="text" name="sstat" value="{{$train->station}}" readonly> &nbsp;&nbsp;&nbsp;
                <input id="stim" type="time" name="stim" value="{{$train->stime}}"> &nbsp;&nbsp;&nbsp;
                <input type="button" value="清除" onClick="scleared()"><p/>
                
                @foreach($station as $x => $stations)
				@endforeach
                @foreach($station as $z => $stations)
					@if($z!=0 && $z!=$x)
                    	<li>
                            <input id="station{{$z}}'" type="text" name="station[{{$z}}]" value="{{$stations->strtion}}" readonly>&nbsp;&nbsp;&nbsp;
                            <input id="time{{$z}}" type="time" name="times[{{$z}}]" value="{{$stations->times}}"> &nbsp;&nbsp;&nbsp;
                            <input type="button" value="刪除" id="c{{$z}}" name="c{{$z}}" onClick="c({{$z}})"><p/>
                        </li>
					@endif
				@endforeach
                
                <input id="hidden" type="hidden" name="hidden">
                
                終點站:
                <input id="estat" type="text" name="estat" value="{{$train->etation}}" readonly> &nbsp;&nbsp;&nbsp;
                <input id="etim" type="time" name="etim" value="{{$train->etime}}"> &nbsp;&nbsp;&nbsp;
                <input type="button" value="清除" onClick="ecleared()"><p/>
				
				停站時間皆為<input type="waittime" name="waittime" value="{{$train->waittime}}">分鐘
				
				<p>&nbsp;</p>
            </div>
            
            <input type="hidden" name="aaa" value="2">
			@if(isset($z))
            	<input type="hidden" name="a" value="{{$z-1}}" id="a">
            @else
            	<input type="hidden" name="a" value="0" id="a">
            @endif
			<input type="hidden" name="id" value="{{$train->id}}">
            {{ csrf_field()}}
            <input type="submit" value="確定">
            
		</fieldset>
	</form>
@endsection