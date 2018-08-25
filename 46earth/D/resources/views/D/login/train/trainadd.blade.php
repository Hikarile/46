@extends('D/start')

@section('title', 'train')
@section('text')
	<script src="{{asset('./media/js/jquery.min.js')}}"></script>
    <script>
		$(function (){
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
					<option value="{{$types->type}}">{{$types->type}}</option>
				@endforeach
			</select>
            <p>&nbsp;</p>
            
			列車代碼:
            <input type="number" name="number">
            <p>&nbsp;</p>
			
            星期:<br/>
            <div>
			<input type="checkbox" name="Sun" id="Sun" value="1"checked>星期日 &nbsp;
            <input type="checkbox" name="Mon" id="Mon" value="1"checked>星期一 &nbsp;
            <input type="checkbox" name="Tue" id="Tue" value="1"checked>星期二 &nbsp;
            <input type="checkbox" name="Wed" id="Wed" value="1"checked>星期三 &nbsp;
            <input type="checkbox" name="Thu" id="Thu" value="1"checked>星期四 &nbsp;
            <input type="checkbox" name="Fri" id="Fri" value="1"checked>星期五 &nbsp;
            <input type="checkbox" name="Sat" id="Sat" value="1"checked>星期六 &nbsp;
            <p>&nbsp;</p>
            </div>
			
			起始站:
			<select id="sstation" name="sstation">
			<option value=""></option>
				@foreach($tts as $ts)
                    <option value="{{$ts->station_C}}">{{$ts->station_C}}</option>
				@endforeach
			</select><p/>
			終點站:
			<select id="estation" name="etation">
			<option value="" selected="selected"></option>
				@foreach($tts as $ts)
                    <option value="{{$ts->station_C}}">{{$ts->station_C}}</option>
				@endforeach
			</select>
			<p>&nbsp;</p>
			
			<div id="hid" hidden>
            	<div id="test">
                    @foreach($tts as $i => $ts)
						<input id="{{$ts->station_C}}" type="button" value="{{$ts->station_C}}" name="st{{$i}}"> &nbsp;
	                @endforeach
				</div>
                <p>&nbsp;</p>
				
                起始站:
                <input id="sstat" type="text" name="sstat" readonly> &nbsp;&nbsp;&nbsp;
                <input id="stim" type="time" name="stim"> &nbsp;&nbsp;&nbsp;
                <input type="button" value="清除" onClick="scleared()"><p/>
                
                <input id="hidden" type="hidden" name="hidden">
                
                終點站:
                <input id="estat" type="text" name="estat" readonly> &nbsp;&nbsp;&nbsp;
                <input id="etim" type="time" name="etim"> &nbsp;&nbsp;&nbsp;
                <input type="button" value="清除" onClick="ecleared()"><p/>
				
				停站時間皆為<input type="waittime" name="waittime">分鐘
				
				<p>&nbsp;</p>
            </div>
            
            <input type="hidden" name="aaa" value="1">
            <input type="hidden" name="a" value="0" id="a">
            {{ csrf_field()}}
            <input type="submit" value="確定">
            
		</fieldset>
	</form>
@endsection