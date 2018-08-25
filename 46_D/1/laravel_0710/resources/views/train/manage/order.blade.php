@extends('layouts.main')
@section('title', '訂票紀錄查詢 - ')
@section('type','order_manage')
@section('content')
	<script>
    	function order_cancel(id){
			if(confirm('確定要取消此訂票?')){
				location.href = '{{ url('') }}/order/cancel/' + id;
			}else{
				alert('不取消');	
			}	
		}
    </script>
	<style>
    	label.title{
			width: 80px;
			display: inline-block;
			text-align: right;
		}
    </style>
    <div id="content">
		<form method="get" action="{{ route('manage_order_search') }}">
        	{{ csrf_field() }}
        	<table style="border: 3px #036 solid; width: 100%;">
            	<tr>
                	<td>
                    	<label class="title">發車日期:</label>
                        <input name="date" type="date" />
                    </td>
                	<td>
                    	<label class="title">車次:</label>
                        <input name="code" type="text" />
                    </td>
                </tr>
            	<tr>
                	<td>
                    	<label class="title">手機號碼:</label>
                        <input name="phone" type="text" />
                    </td>
                	<td>
                    	<label class="title">訂票編號:</label>
                        <input name="number" type="text" />
                    </td>
                </tr>
                <tr>
                	<td>
                    	<label class="title">起站:</label>
                    	<select name="from">
                            <option value=""></option>
                            <option value="0">台北站</option> 
                            <option value="1">桃園站</option> 
                            <option value="2">新竹站</option> 
                            <option value="3">苗栗站</option> 
                            <option value="4">台中站</option> 
                            <option value="5">彰化站</option> 
                            <option value="6">雲林站</option> 
                            <option value="7">嘉義站</option>  
                            <option value="8">台南站</option> 
                            <option value="9">高雄站</option> 
                            <option value="10">屏東站</option> 
                            <option value="11">台東站</option> 
                            <option value="12">花蓮站</option> 
                            <option value="13">宜蘭站</option>
                        </select>
                    </td>
                	<td>
                    	<label class="title">迄站:</label>
                    	<select name="to">
                            <option value=""></option>
                            <option value="0">台北站</option> 
                            <option value="1">桃園站</option> 
                            <option value="2">新竹站</option> 
                            <option value="3">苗栗站</option> 
                            <option value="4">台中站</option> 
                            <option value="5">彰化站</option> 
                            <option value="6">雲林站</option> 
                            <option value="7">嘉義站</option>  
                            <option value="8">台南站</option> 
                            <option value="9">高雄站</option> 
                            <option value="10">屏東站</option> 
                            <option value="11">台東站</option> 
                            <option value="12">花蓮站</option> 
                            <option value="13">宜蘭站</option>
                        </select>
                    </td>
                </tr>
                <tr>
                	<td colspan="2" style="text-align: center;"><input type="submit" value="查詢" style="padding: 0 40px;"></td>
                </tr>
            </table>
        </form><br />
		@if(!empty($orders[0]))
        	<div style="overflow: auto;">
                <table class="data_table" style=" white-space: nowrap;">
                    <thead>
                        <tr>
                            <th>發車日期</th>
                            <th>車次</th>
                            <th>手機號碼</th>
                            <th>訂票編號</th>
                            <th>起訖站</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $n=>$value)
                            <tr>
                                <td>{{ $value->date }}<br />{{ $value->start_time }}</td>
                                <td>{{ $value->code }}</td>
                                <td>{{ $value->phone }}</td>
                                <td>{{ $value->n }}</td>
                                <td>{{ $station_n_c[$value->from] }}/{{ $station_n_c[$value->to] }}</td>
                                <td>@if($value->cancel == 0)
                                        <input type="button" value="取消訂票" onclick="order_cancel('{{ $value->id }}');">
                                    @else
                                        已取消於<br>{{ $value->created_at }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
        	</div>
            {{ $orders->render() }}
		@endif
	</div>
@endsection

