<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Train;
use App\Type;
use App\Order;

class OrderController extends Controller
{
    public function order($code='', $date='', $from='', $to='')
	{
		return view('order',compact('code','date','from','to'));
	}
    public function orderDo(Request $data)
	{
		$phone = $data->phone;
		$code = $data->code;
		$from = $data->from;
		$to = $data->to;
		$date = $data->date;
		$count = $data->count;
		$week = week_nc()[date('w',strtotime($date))];
		
		if(!$phone || !$from || !$to || !$date || !$count || $code == ''){
			return back()->withErrors('任一欄位為空');
		}
		
		if(empty($data->v_success)){
			return back()->withErrors('未通過驗證碼');
		}
		
		$order_date = date('Y-m-d');
		$order_time = date('H:i');
		
		$train = Train::where('week','like',"%$week%")->where('code',$code)->get();
		if(empty($train[0])){
			return back()->withErrors('當日無該車次列車');
		}
		
		$train = Train::find($code);
		
		$station = explode(',',$train->station);
		$start_time = explode(',',$train->start_time);
		
		if(strtotime($order_date . ' ' . $order_time) >= strtotime($date . ' ' . $start_time[array_search($from, $station)])){
			return back()->withErrors('發車時間已過');
		}
		
		if(!station_pass($from, $to, $station)){
			return back()->withErrors('該列車無行經起訖站');
		}
		
		$orders = Order::where('code',$code)->where('start_date',$date)->get();
		$total = $train->car_count * $train->per_car;
		$ordered = 0;
		foreach($orders as $value){
			$f1 = array_search($from, $station);
			$f2 = array_search($value->from, $station);
			$t2 = array_search($value->to, $station);
			if($f2 <= $f1 && $t2 > $f1){
				$ordered += $value->count;
			}	
		}
		if(($ordered + $count) > $total){
			return back()->withErrors('該區間已無空車位');
		}
		
		$rnd = array_merge(range(0,9),range(0,9),range(0,9),range('a','z'),range("A","Z"));
		shuffle($rnd);
		$unique = $rnd[0] . $rnd[1] . $rnd[2] . $rnd[3] . $rnd[4] . $rnd[5] . $rnd[6] . $rnd[7] . $rnd[8] . $rnd[9];
		
		$money = (array_search($to, $station) - array_search($from, $station)) * 100 * $count;
		
		$order = new Order;
		$order->unique = $unique;
		$order->code = $code;
		$order->phone = $phone;
		$order->order_date = $order_date;
		$order->order_time = $order_time;
		$order->start_date = $date;
		$order->start_time = $start_time[array_search($from, $station)];
		$order->from = $from;
		$order->to = $to;
		$order->count = $count;
		$order->money = $money;
		$order->save();
		
		$date2 = explode('-',$date);
		$date2 = $date2[1] . '/' . $date2[2];
		$f = fopen("SMS/{$phone}.txt",'a+');
		if(fgetc($f)){ fwrite($f,'========================================' . PHP_EOL); }
		fwrite($f, "列車訂位成功。訂票編號：{$unique}，{$date2} {$from}{$to} {$code}車次，{$count}張票，".$start_time[array_search($from, $station)]."開，共".number_format($money)."元");
		fclose($f);
		
		return redirect(route('order-done',[$order->id]));
	}
    public function orderDone($id)
	{
		$order = Order::find($id);	
		return view('order-done',compact('order'));
	}
    public function orderLog()
	{
		return view('order-log');
	}
    public function orderLogSearch(Request $data)
	{
		$unique = $data->unique ? $data->unique : '%';
		$phone = $data->phone ? $data->phone : '%';
		if($unique == '%' && $phone == '%'){ return back(); }
		
		$orders = Order::where('unique','like',$unique)->where('phone','like',$phone)->paginate(10);
		if(empty($orders[0])){
			return back()->withErrors('查無指定條件的訂票');
		}
		
		return view('order-log',compact('orders'));
	}
	public function orderCancel($id)
	{
		$order = Order::find($id);
		$order->cancel = 1;
		$order->save();
		
		return back();
	}
}
