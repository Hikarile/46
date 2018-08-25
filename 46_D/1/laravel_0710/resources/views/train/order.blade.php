@extends('layouts.main')
@section('title', '預訂車票 - ')
@section('type','order')
@section('content')
	<script>
		var v_position = ['0 0', '-100px 0', '-200px 0', '0 -100px', '-100px -100px', '-200px -100px', '0 -200px', '-100px -200px', '-200px -200px'];
		var v_question = ['選取圖片中含有小貨車的所有圖片', '選取圖片中含有青草的所有圖片', '選取圖片中含有公車的所有圖片', '選取所有包含樹木的圖片'];
		var v_answer = ['256','1467','023','578'];
		var v_answer_user = [];
		var code = new Array;
		var type = new Number;
		$(function(){
		/***********************************/	
			@if(!empty($code))
				$('#code').val('{{ $code }}');
			@endif
			@if(!empty($from))
				$('#from>option[value={{ $from }}]').prop('selected',true);
			@endif
			@if(!empty($to))
				$('#to>option[value={{ $to }}]').prop('selected',true);
			@endif
			@if(!empty($date))
				$('#date').val('{{ $date }}');
			@endif	
		/***********************************/	
			$("#enterCode").click(function(){
				$("#vcode").addClass('show');
			});
			$("#vcode_title").click(function(){
				$('#vcode').removeClass('show');
			});
			
			for(var i=0; i<=8; i++){
				var ob = $('<div id="v'+ i +'"></div>');
				$(ob).append('<div class="v"></div><div class="check"></div>');
				$('#vcode_content').append(ob);
			}
			
			$('#vcode_content>div').on('click',function(){
				$(this).toggleClass('answer_user');
				$(this).children('.v').toggleClass('select');
				$(this).children('.check').toggleClass('show');
			});
			
			$('#vcode_control_reset').on('click',vcode_reset);
			
			$('#vcode_control_submit').on('click',vcode_submit);
			
			vcode_reset();
		/***********************************/
		})
		function vcode_reset(){			
			$('#vcode_content>div').removeClass('answer_user');
			$('#vcode_content .v').removeClass('select');
			$('#vcode_content .check').removeClass('show');
		
			type = Math.floor(Math.random() * 4);
			code = [0,1,2,3,4,5,6,7,8].sort(function(a,b){ return Math.random() > 0.5 ? 1 : -1; });
			
			$('#vcode_title>p').text(v_question[type]);
			for(var i=0; i<=8; i++){
				var bg_url = "url('{{ asset('img/vcode/') }}/" + type + ".jpg')";
				var bg_xy = v_position[code[i]];
				$('#v' + i).attr('code',code[i]);
				$('#v' + i + '>.v').css('background-image',bg_url);
				$('#v' + i + '>.v').css('background-position',bg_xy);
			}
		}
		
		function vcode_submit(){
			var test_answer = new Array();
			$('#vcode_content>div').each(function(n, ob) {
                if($(ob).hasClass('answer_user')){
					test_answer.push(code[n]);
				}
            });
			
			$.ajax({
				url: '{{ url("") }}/order/validate',
				data: {type: type, answer:test_answer},
				type: 'GET',
				success: function(msg){
					console.log(msg);
					if(msg == 'error1'){
						$('#vcode_control_message').text('請選取所有相符的圖片');
					}
					if(msg == 'error2'){
						$('#vcode_control_message').text('需要提供多個答案 - 請回答更多問題');
						vcode_reset();
					}
					if(msg == 'success'){
						$('#vcode_success').text('驗證碼正確');
						$('#vcode').removeClass('show');
						$('#vcode').attr('disabled','disabled');
					}
				}
			})
			
		}
	</script>
    <style>
    	#vcode_content .check{
			background-image: url('{{ asset('img/vcode/check.png') }}');
			height: 20px;
			width: 20px;
			z-index: 9;
			position: absolute;
			display: none;
		}
		#vcode_content .check.show{
			display: block;
		}
		#vcode_control_reset{
			position: absolute;
			width: 30px;
			height: 30px;
			background-image: url('{{ asset('img/vcode/reset.png') }}');
			background-size: 30px;
			opacity: 0.5;
			cursor: pointer;
		}
		#vcode_control_reset:hover{
			opacity: 1;
		}
		#vcode_control_message{
			position: absolute;
			margin: 0;
			top: 35px;
			left: 50%;
			transform: translateX(-50%);
			color: #f00;
			width: 300px;
		}
    </style>
    <div id="content">
        @if($errors->has())
            <p class="message_error">
                {{ $errors->first() }}
            </p>
        @endif
        <form action="{{ route('order_do') }}" method="POST">
        	{!! csrf_field() !!}
            <fieldset>
                <legend>預訂車票</legend>
                <p>
                    <label for="phone">手機</label>
                    <input type="tel" id="phone" name="phone" value="" required />
                </p>
                <p>
                    <label for="from">起程站</label>
                    <select id="from" name="from">
                        <option selected value="TAIPEI">台北站</option> 
                        <option value="TAOYUAN">桃園站</option> 
                        <option value="HSINCHU">新竹站</option> 
                        <option value="MIAOLI">苗栗站</option> 
                        <option value="TAICHUNG">台中站</option> 
                        <option value="CHANGHUA">彰化站</option> 
                        <option value="YUNLIN">雲林站</option> 
                        <option value="CHIAYI">嘉義站</option>  
                        <option value="TAINAN">台南站</option>
                        <option value="KAOHSIUNG">高雄站</option> 
                        <option value="PINGTUNG">屏東站</option> 
                        <option value="TAITUNG">台東站</option> 
                        <option value="HUALIEN">花蓮站</option> 
                        <option value="ILAN">宜蘭站</option>
                    </select>
                </p>
                <p>
                    <label for="to">到達站</label>
                    <select id="to" name="to">
                        <option value="TAIPEI">台北站</option>
                        <option value="TAOYUAN">桃園站</option>
                        <option value="HSINCHU">新竹站</option>
                        <option value="MIAOLI">苗栗站</option>
                        <option value="TAICHUNG">台中站</option>
                        <option value="CHANGHUA">彰化站</option>
                        <option value="YUNLIN">雲林站</option>
                        <option value="CHIAYI">嘉義站</option>
                        <option value="TAINAN">台南站</option>
                        <option value="KAOHSIUNG">高雄站</option>
                        <option value="PINGTUNG">屏東站</option>
                        <option value="TAITUNG">台東站</option>
                        <option value="HUALIEN">花蓮站</option>
                        <option selected value="ILAN">宜蘭站</option>
                    </select>
                </p>
                <p>
                    <label for="date">搭乘日期</label>
                    <input type="date" id="date" name="date" required>
                </p>
                <p>
                    <label for="code">車次代碼</label>
                    <input type="number" id="code" name="code" required>
                </p>
                <p>
                    <label for="count">車票張數</label>
                    <input type="number" min="1" max="100" value="1" id="count" name="count" required>
                </p>
                <p>
                    <button type="button" id="enterCode">回答驗證碼</button><span id="vcode_success"></span>
                </p>
                <p>
                    <input type="submit" value="訂票">
                </p>
            </fieldset>
        </form>
        <div id="vcode">
        	<div id="vcode_title">
            	<p></p>
            </div>
            <div id="vcode_content"></div>
            <div id="vcode_control">
            	<div id="vcode_control_reset"></div>
                <p id="vcode_control_message"></p>
                <input id="vcode_control_submit" type="button" value="驗證"/>
            </div>
        </div>
    </div>
@endsection