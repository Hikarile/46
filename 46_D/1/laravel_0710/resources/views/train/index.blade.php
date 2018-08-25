@extends('layouts.main')
@section('type','home')
@section('content')	
    <div id="content">
        @if($errors->has())
            <p class="message_error">
            	@foreach($errors->all() as $error)
                	{{ $error }}<br>
                @endforeach
            </p>
        @endif
        <form method="GET" id="train_search_form">
            <fieldset>
                <legend>列車查詢</legend>
                <p>
                    <label for="from">起程站</label>
                    <select id="from">
                    	<option value=""></option>
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
                    <select id="to">
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
                    <label for="type">車種</label>
                    <select id="type">
                        <option value="1" selected>區間列車</option>
                        <option value="2">快速列車</option>
                        <option value="3">磁浮列車</option>
                    </select>
                </p>
                <p>
                    <label for="date">搭乘日期</label>
                    <input type="date" value="{{ date('Y-m-d') }}" id="date" required>
                </p>
                <p>
                    <button type="button" id="train_search_btn">&nbsp;送出&nbsp;</button>
                </p>
            </fieldset>
        </form>
    </div>
@endsection

