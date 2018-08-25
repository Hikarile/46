@extends('layouts.main')
@section('title', '車種管理 - ')
@section('type','type_manage')
@section('content')	
		<script>
			function type_delete(name){
				if(confirm('確定要刪除此車種: '+ name +'?')){
					return true;
				}else{
					alert('取消刪除');
					return false;
				}	
			}
			function insert(){
				var name = $('#insert_name').val();
				var speed = $('#insert_speed').val();
				if(!name || !speed){
					alert('請正確填寫');
					return;
				}else{
					location.href = '{{ url("") }}/manage/type/insert/do/' + name + '/' + speed;
				}
			}
			function update(){
				var id = $('#update_id').val();
				var name = $('#update_name').val();
				var speed = $('#update_speed').val();
				if(!name || !speed){
					alert('請正確填寫');
					return;
				}else{
					location.href = '{{ url("") }}/manage/type/update/do/'+ id + '/'  + name + '/' + speed;
				}
			}
		</script>
		<div id="content">
        	@if(!empty($insert))
            	@if($errors->has())
                    <p class="message_error">
                        @foreach($errors->all() as $error)
                         	<?php $error = str_replace('name','車種名稱',$error); ?>
                            <?php $error = str_replace('speed','最高時速',$error); ?>
                            {{ $error }}<br>
                        @endforeach
                    </p>
                @endif
                <div style="text-align:right; margin: 30px 0 10px 0;"><input type="button" value="返回" onclick="location.href = '{{ route('type_select') }}';"></div>
                <table class="data_table">
                    <tr>
                        <th>車種名稱</th>
                        <th width="30%">最高時速(km/h)</th>
                        <th width="25%"></th>
                    </tr>
                    <tr>
                    	<td><input id="insert_name" name="name" style="width: 100%;"></td>
                        <td><input id="insert_speed" name="speed" style="width: 100%;"></td>
                        <td><input type="button" value="確定" style="width: 100%;" onclick="insert();"></td>
                    </tr>
                </table>
            @elseif(!empty($update))
            	@if($errors->has())
                    <p class="message_error">
                        @foreach($errors->all() as $error)
                         	<?php $error = str_replace('name','車種名稱',$error); ?>
                            <?php $error = str_replace('speed','最高時速',$error); ?>
                            {{ $error }}<br>
                        @endforeach
                    </p>
                @endif
                <div style="text-align:right; margin: 30px 0 10px 0;"><input type="button" value="返回" onclick="location.href = '{{ route('type_select') }}';"></div>
                <table class="data_table">
                    <tr>
                        <th>車種名稱</th>
                        <th width="30%">最高時速(km/h)</th>
                        <th width="25%"></th>
                    </tr>
                    <tr>
                    	<td><input id="update_name" style="width: 100%;" value="{{ $name }}"></td>
                        <td><input id="update_speed" style="width: 100%;" value="{{ $speed }}"></td>
                        <td><input type="button" value="確定" style="width: 100%;" onclick="update();"><input id="update_id" type="hidden" value="{{ $id }}"></td>
                    </tr>
                </table>
            @else
                <div style="text-align:right; margin: 30px 0 10px 0;"><input type="button" value="新增車種" style="font-size: 1.2em; padding: 0 30px;" onclick="location.href = '{{ route('type_insert') }}';"></div>
                <table class="data_table" width="100%">
                    <tr>
                        <th>車種名稱</th>
                        <th width="30%">最高時速(km/h)</th>
                        <th width="25%"></th>
                    </tr>
                    @foreach($types as $type)
                        <tr>
                            <td>{{ $type->name }}</td>
                            <td>{{ $type->speed }}</td>
                            <td>
                                <input type="button" value="更改" onclick="location.href = '{{ route('type_update',[$type->id]) }}';">
                                <input id="type_delete" type="button" value="刪除" onclick="if(type_delete('{{$type->name}}')){ location.href = '{{ route('type_delete',[$type->id]) }}'; }">
                            </td>
                        </tr>
                    @endforeach
                </table>
                {{ $types->links() }}
            @endif
		</div>
@endsection

