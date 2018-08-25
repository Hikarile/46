@extends('D/start')

@section('title', 'order')
@section('text')
    <script src="{{asset('./media/js/jquery.min.js')}}"></script>
    <script>
    	$(function (){
			var be='';
			var af='';
			$("#reply").click(function(){//回答驗證碼
				$("#hid").show();
				$("#reappear").trigger('click');
				$("#reply").hide();
				
			});
			$('#reappear').click(function(){//產生新的驗證碼
				for(i=1;i<=3;i++){
						for(j=1;j<=3;j++){
						$("#box"+i+j).hide();
					}
				}
				$("#input").val('');
				var nu=Math.floor( Math.random() * (4 - 1 + 1) ) + 1;
				be=nu;
				if(be == af){
					$("#reappear").trigger('click');
					return false;
				}else{
					af=nu;
				}
				if(nu == 1){
					$("#topic").text('選取所有包含樹木的圖片');
					$("#answer").val('689');
				}
				if(nu == 2){
					$("#topic").text('選取圖片中含有小貨車的所有圖片');
					$("#answer").val('367');
				}
				if(nu == 3){
					$("#topic").text('選取圖片中含有青草的所有圖片');
					$("#answer").val('2578');
				}
				if(nu == 4){
					$("#topic").text('選取圖片中含有公車的所有圖片');
					$("#answer").val('134');
				}
				$("#img").attr("src","{{asset('recaptcha')}}/Q"+nu+".jpg");
			});
			$('#img').click(function(e) {//紅框顯示
				var x = (Math.floor(e.offsetX / 100))+1;
				var y = (Math.floor(e.offsetY / 100))+1;
				$('#box'+y+x).show();
				if(y==1 && x==1){
					var da=1;
				}if(y==1 && x==2){
					var da=2;
				}if(y==1 && x==3){
					var da=3;
				}if(y==2 && x==1){
					var da=4;
				}if(y==2 && x==2){
					var da=5;
				}if(y==2 && x==3){
					var da=6;
				}if(y==3 && x==1){
					var da=7;
				}if(y==3 && x==2){
					var da=8;
				}if(y==3 && x==3){
					var da=9;
				}
				var input=$("#input").val();
				$("#input").val(input+da);
				var a=parseInt($("#a").val());
				$("#a").val(a+1);
			});
			$("#ok").click(function(){//驗證--驗證碼
				var a=$("#a").val(); 
				var input=$("#input").val().split('').sort();
				var answer=$("#answer").val().split('').sort();
				if(input==''){
					alert("驗證碼未填");
					return false;
				}
				var n=0;
				for(i=1;i<=a;i++){
					if(input[i] != answer[i]){
						alert("驗證碼輸入錯誤");
						$("#reappear").trigger('click');
						return false;
					}
					n++;
				}
				if(n == a){
					$("#determine").val('determine');
					alert("驗證成功");
					return false;
				}
			})
			$("#sub").submit(function(){//送出表單的判斷
				if($("#input").val()==''){
					alert("驗證碼未填");
					return false;
				}
				if($("#determine").val() != 'determine'){
					alert("驗證碼未驗證");
					return false;
				}
			})
		})
    </script>
	
	@if(session('error'))
		<p class="message_error">
			{{session('error')}}
		</p>
	@endif
	
	<form method="POST" action="{{route('ordersave')}}" id="sub">
		<fieldset>
			<legend>預訂車票</legend>
			<p>
				<label for="phone">手機</label>
				<input type="tel" required id="phone" name="phone" pattern="[0-9]+" value="{{old('phone')}}">
			</p>
			<p>
				<label for="from">起程站</label>
				<select id="from" name="from">
					@foreach($ts as $tss)
						@if( $into['from'] == $tss->station_E)
							<option value="{{$tss->station_C}}" selected >{{$tss->station_C}}</option>
						@else
							<option value="{{$tss->station_C}}">{{$tss->station_C}}</option>
						@endif
					@endforeach
				</select>
			</p>
			<p>
				<label for="to">到達站</label>
				<select id="to" name="to">
					@foreach($ts as $tss)
						@if( $into['to'] == $tss->station_E)
							<option value="{{$tss->station_C}}" selected >{{$tss->station_C}}</option>
						@else
							<option value="{{$tss->station_C}}">{{$tss->station_C}}</option>
						@endif
					@endforeach
				</select>
			</p>
			<p>
				<label for="date">搭乘日期</label>
				@if( $into['date'])
					<input type="date" id="date" name="date" value="{{$into['date']}}">
				@else
					<input type="date" id="date" name="date">
				@endif
			</p>
			<p>
				<label for="number">車次代碼</label>
				@if($into['number'])
					<input type="number" id="number" name="number" value="{{$into['number']}}">
				@else
					<input type="number" id="number" name="number">
				@endif
			</p>
			<p>
				<label for="count">車票張數</label>
				<input type="number" min="1" max="1000" value="{{old('count')}}" id="count" name="count" required>
			</p>
			<p>
				<input id="reply" type="button" value="回答驗證碼"><p/>
                <div id="hid" hidden>
                	<div id="topic"></div>
					<div style="position: relative">
						@for ($i=1;$i<=3;$i++)
							@for ($j=1;$j<=3;$j++)
							<div id="box{{$i.$j}}" style="border:red solid 5px; position:absolute; width:90px; height:90px; top:{{($i-1)*100}}px; left:{{($j-1)*100}}px;" hidden></div>
							@endfor
						@endfor
						<img id="img"d="">
					</div>
					
                    <input type="hidden" name="a" id="a" value="0">
					<input type="hidden" name="answer" id="answer">
					<input type="hidden" name="input" id="input">
					<input type="button" id="reappear" value="產生新的驗證碼">
					<input type="button" id="ok" value="驗證">
					<input type="hidden" name="determine" id="determine">
                </div>
			</p>
			<p>
				{{ csrf_field()}}
				<input type="submit" name="ok" value="送出">
			</p>
		</fieldset>
	</form>
@endsection