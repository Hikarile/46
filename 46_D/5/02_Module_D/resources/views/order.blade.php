@extends('layouts.main')
@section('title','預訂車票')
@section('body','order')
@section('content')
   	<form action="{{ route('order.do') }}" method="POST">
   		{{ csrf_field() }}
        <fieldset>
            <legend>預訂車票</legend>
            <p>
                <label for="phone">手機</label>
                <input type="tel" required id="phone" name="phone"/>
            </p>
            <p>
                <label for="from">起程站</label>
                <select id="from" name="from">
                    @foreach(station_ec() as $key=>$value)
                        <option value="{{$value}}">{{$value}}站</option>
                    @endforeach
                </select>
            </p>
            <p>
                <label for="to">到達站</label>
                <select id="to" name="to">
                    @foreach(station_ec() as $key=>$value)
                        <option value="{{$value}}">{{$value}}站</option>
                    @endforeach
                </select>
            </p>
            <p>
                <label for="date">搭乘日期</label>
                <input type="date" value="{{ empty($date) ? '' : $date }}" id="date" name="date" required>
            </p>
            <p>
                <label for="code">車次代碼</label>
                <input type="number" value="{{ empty($code) ? '' : $code }}" id="code" name="code" required>
            </p>
            <p>
                <label for="count">車票張數</label>
                <input type="number" min="1" id="count" name="count" required>
            </p>
            <p>
                <button type="button" id="enterCode" onclick="$('#v_code').toggleClass('show');">回答驗證碼</button>
                <div id="v_code">
                	<div id="v_title">
                    	<p>標題標題文字標題</p>
                        <input type="button" value="X" style="position: absolute; top: 10px; right: 10px;" onclick="$('#v_code').removeClass('show')" />
                    </div>
                    <div id="v_content">
                    	<div class="v_box"></div>
                    	<div class="v_box"></div>
                    	<div class="v_box"></div><br />
                    	<div class="v_box"></div>
                    	<div class="v_box"></div>
                    	<div class="v_box"></div><br />
                    	<div class="v_box"></div>
                    	<div class="v_box"></div>
                    	<div class="v_box"></div>
                    </div>
                    <div id="v_footer">
                    	<img style="cursor:pointer;" onclick="reset_code();" src="{{asset('img/vcode/reset.png')}}"/>
                        <input type="button" value="驗證" onclick="vali();" style="position: absolute; right: 0; top: 0;" />
                        <p id="v_message"></p>
                    </div>
                </div>
            </p>
            <p>
                <input type="submit" value="送出"/>
            </p>
        </fieldset>
    </form>
    <script>
		@if(!empty($from))
    		$('#from [value="{{$from}}"]').prop('selected',true);
			$('#to [value="{{$to}}"]').prop('selected',true);
		@endif
		
		$('.v_box').each(function(n, o) {
            $(o).append('<img class="v_check" src="{{asset("img/vcode/v_check.png")}}"><div id="v'+ n +'"></div>');
        });
		
		$('.v_box').click(function(){
			$(this).toggleClass('checked');
			$(this).children('div').toggleClass('checked');
			$(this).children('.v_check').toggleClass('checked');
		});
		
		var v_type = 0;
		var v_title = ['選取圖片中含有小貨車的所有圖片','選取圖片中含有青草的所有圖片','選取圖片中含有公車的所有圖片','選取所有包含樹木的圖片'];
		var v_code = [0,1,2,3,4,5,6,7,8];
		var v_answer = ['256','1467','023','578'];
		var v_position = [
			'0 0',
			'-100px 0',
			'-200px 0',
			'0 -100px',
			'-100px -100px',
			'-200px -100px',
			'0 -200px',
			'-100px -200px',
			'-200px -200px',
		];
		
		function reset_code(){
			v_type = Math.floor(Math.random() * 4);
			v_code.sort(function(){return (Math.random() > 0.5 ? 1 : -1)});			
			
			$('#v_content *').removeClass('checked');
			$('#v_title p').text(v_title[v_type]);
			
			$('.v_box div').each(function(n, o) {
				var image = "url('{{asset('img/vcode')}}/"+v_type+".jpg')";
				var position = v_position[v_code[n]];
                $(o).css('background-image', image);
                $(o).css('background-position', position);
            });
		}
		function vali(){
			var ans = [];
			$('.v_box').each(function(n, o) {
                if($(o).hasClass('checked')){
					ans.push(v_code[n]);
				}
            });
			
			ans.sort();
			ans = ans.join('');
			
			if(ans == v_answer[v_type]){
				$('#enterCode').prop('disabled',true);
				$('#enterCode').after('<span style="color: #0f0">驗證碼正確</span><input name="v_success" type="hidden" value="1">');
				$('#v_code').removeClass('show');
			}else{
				$('#v_message').text('答案錯誤');
				reset_code();
			}
		}
		
		reset_code();
    </script>
@endsection
