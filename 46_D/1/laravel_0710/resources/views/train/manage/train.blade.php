@extends('layouts.main')
@section('title', '列車管理 - ')
@section('type','train_manage')
@section('content')	
	<script>
		$(function(){
			@if(!empty($update))
				$('#update_form [name="code"]').val('{{ $code }}');
				$('#update_form [name="type"] option[value="{{ $type }}"]').prop('selected',true);
				$('#update_form [name="per_car"]').val('{{ $per_car }}');
				$('#update_form [name="car_count"]').val('{{ $car_count }}');
				@foreach($week as $value)
					$('#update_form [name="week[]"][value="{{ $value }}"]').prop('checked', true);
				@endforeach
				@foreach($station as $n=>$value)
					$('#update_form [name="station[]"]:eq({{ $n }}) option[value="{{ $value }}"]').prop('selected',true);
					$('#update_form [name="start_time[]"]:eq({{ $n }})').val('{{ $start_time[$n] }}');
				@endforeach
			@endif
		})
    	function train_delete(code){
			if(confirm('確定要刪除' + code + '列車?')){
				location.href = '{{ url('') }}/manage/train/delete/' + code;
			}else{
				alert('取消刪除');
			}
		}
    </script>
    <div id="content">
    	@if(!empty($insert))
        	@if($errors->has())
            	<p class="message_error">
                	{{ $errors->first() }}
                </p>
            @endif
        	<form method="get" action="{{ route('train_insert_do') }}">
                <table class="data_table">
                    <tr>
                        <td>列車代碼</td>
                        <td><input id="insert_code" name="code" style="width: 100%;"></td>
                    </tr>
                    <tr>
                        <td>行車星期</td>
                        <td>
                            <label><input name="week[]" type="checkbox" value="1" />一&nbsp;&nbsp;</label>
                            <label><input name="week[]" type="checkbox" value="2" />二&nbsp;&nbsp;</label>
                            <label><input name="week[]" type="checkbox" value="3" />三&nbsp;&nbsp;</label>
                            <label><input name="week[]" type="checkbox" value="4" />四&nbsp;&nbsp;</label>
                            <label><input name="week[]" type="checkbox" value="5" />五&nbsp;&nbsp;</label>
                            <label><input name="week[]" type="checkbox" value="6" />六&nbsp;&nbsp;</label>
                            <label><input name="week[]" type="checkbox" value="0" />七&nbsp;&nbsp;</label>
                        </td>
                    </tr>
                </table>
                <br />
                <table class="data_table"> 
                    <tr>
                        <td>
                            車種:<select name="type">
                                @foreach($types as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>    
                        </td>
                        <td>
                            每車廂人數:<input name="per_car" style="width: 50px;" type="number">
                        </td>
                        <td>
                            車廂數量:<input name="car_count" style="width: 50px;" type="number">
                        </td>
                    </tr>
                </table>
                <br />
                <div style="overflow: auto; width: 600px; height: 350px;">
                <table class="data_table">
                    <tr>
                        @for($i=0;$i<=13;$i++)
                            <td>
                                第{{$i+1}}站:
                                <select name="station[]">
                                	<option value="false"></option>
                                    @for($j=0;$j<=13;$j++)
                                        <option value="{{ $j }}">{{ $station_n_c[$j] }}站</option>
                                    @endfor
                                </select><br />
                                發車時間:<input type="time" name="start_time[]">
                            </td>
                            @if(($i+1) % 3 == 0 && $i != 13)
                                </tr><tr>
                            @endif
                        @endfor
                    </tr>
                </table>
                </div>
                <div style="text-align: center;"><input type="submit" value="送出" style="font-size: 1.3em; padding: 0 40px;" /></div>
        	</form>
        @elseif(!empty($update))
            @if($errors->has())
            	<p class="message_error">
                	{{ $errors->first() }}
                </p>
            @endif
        	<form id="update_form" method="get" action="{{ route('train_update_do') }}">
                <table class="data_table">
                    <tr>
                        <td>列車代碼</td>
                        <td><input id="update_code" name="code" style="width: 100%;"></td>
                    </tr>
                    <tr>
                        <td>行車星期</td>
                        <td>
                            <label><input name="week[]" type="checkbox" value="1" />一&nbsp;&nbsp;</label>
                            <label><input name="week[]" type="checkbox" value="2" />二&nbsp;&nbsp;</label>
                            <label><input name="week[]" type="checkbox" value="3" />三&nbsp;&nbsp;</label>
                            <label><input name="week[]" type="checkbox" value="4" />四&nbsp;&nbsp;</label>
                            <label><input name="week[]" type="checkbox" value="5" />五&nbsp;&nbsp;</label>
                            <label><input name="week[]" type="checkbox" value="6" />六&nbsp;&nbsp;</label>
                            <label><input name="week[]" type="checkbox" value="0" />七&nbsp;&nbsp;</label>
                        </td>
                    </tr>
                </table>
                <br />
                <table class="data_table"> 
                    <tr>
                        <td>
                            車種:<select name="type">
                                @foreach($types as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>    
                        </td>
                        <td>
                            每車廂人數:<input name="per_car" style="width: 50px;" type="number">
                        </td>
                        <td>
                            車廂數量:<input name="car_count" style="width: 50px;" type="number">
                        </td>
                    </tr>
                </table>
                <br />
                <div style="overflow: auto; width: 600px; height: 350px;">
                <table class="data_table">
                    <tr>
                        @for($i=0;$i<=13;$i++)
                            <td>
                                第{{$i+1}}站:
                                <select name="station[]">
                                	<option value="false"></option>
                                    @for($j=0;$j<=13;$j++)
                                        <option value="{{ $j }}">{{ $station_n_c[$j] }}站</option>
                                    @endfor
                                </select><br />
                                發車時間:<input type="time" name="start_time[]">
                            </td>
                            @if(($i+1) % 3 == 0 && $i != 13)
                                </tr><tr>
                            @endif
                        @endfor
                    </tr>
                </table>
                </div>
                <div style="text-align: center;"><input type="submit" value="送出" style="font-size: 1.3em; padding: 0 40px;" /></div>
        	</form>
        @else    
        	<div style="text-align:right; margin: 30px 0 10px 0;"><input type="button" value="新增列車" style="font-size: 1.2em; padding: 0 30px;" onclick="location.href = '{{ route('train_insert') }}';"/></div>
            <table class="data_table" width="100%">
                <tr>
                    <th>列車代碼</th>
                    <th>行車星期</th>
                    <th>發車時間</th>
                    <th>行經車站</th>    
                    <th width="100"></th>    
                </tr>
                @foreach($trains as $i => $train)
                    <tr>
                        <td>{{ $train->code }}</td>
                        <td>{{ $train->week }}</td>
                        <td>
                            @foreach($train->start_time as $n=>$value)
                                {{ $value }} @if(($n+1) % 2 == 0) <br> @endif 
                            @endforeach
                        </td>
                        <td>
                            @foreach($train->station as $n=>$value)
                                {{ $value }} @if(($n+1) % 2 == 0) <br> @endif
                            @endforeach
                        </td>
                        <td>
                            <input type="button" value="修改" onclick="location.href = '{{ route('train_update',[$train->code]) }}';" />
                            <input type="button" value="刪除" onclick="train_delete('{{ $train->code }}');" />
                        </td>
                    </tr>
                @endforeach
            </table>
            {{ $trains->render() }}
		@endif
	</div>
@endsection

