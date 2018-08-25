<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\models\Order;

class OrderController extends Controller
{
	public $station_e_n = array('TAIPEI'=>0,'TAOYUAN'=>1,'HSINCHU'=>2,'MIAOLI'=>3,'TAICHUNG'=>4,'CHANGHUA'=>5,'YUNLIN'=>6,'CHIAYI'=>7,'TAINAN'=>8,'KAOHSIUNG'=>9,'PINGTUNG'=>10,'TAITUNG'=>11,'HUALIEN'=>12,'ILAN'=>13);
	public $station_n_c = array('台北','桃園','新竹','苗栗','台中','彰化','雲林','嘉義','台南','高雄','屏東','台東','花蓮','宜蘭');
		
		
    public function Order($code='',$from='',$to='',$date=''){
		session_start();
		$_SESSION['validate'] = false;
		return view('train.order',['code'=>$code,'from'=>$from,'to'=>$to,'date'=>$date]);
	}
	
	public function OrderDo(Request $data){
		session_start();
		$_SESSION['validate'] = false;
		
		$code = $data->code;
		$phone = $data->phone;
		$from = $this->station_e_n[$data->from];
		$to = $this->station_e_n[$data->to];
		$count = $data->count;
		$date = $data->date;
		
		$date2 = explode('-',$date);
		$week = date('w',mktime(0,0,0,$date2[1],$date2[2],$date2[0]));
		
		$validate2 = \Validator::make($data->all(),[
			'code'=>['required'],
			'phone'=>['required'],
			'from'=>['required'],
			'to'=>['required'],
			'count'=>['required'],
			'date'=>['required']
		]);
		$validate = \Validator::make([],[]);
		
		if($validate2->fails()){
			$validate->errors()->add('fail','任一欄位為空');
			return back()->withErrors($validate)->withInput();
		}
		
		if(!$_SESSION['validate']){
			$validate->errors()->add('fail','未通過驗證碼');
			return back()->withErrors($validate)->withInput();
		}
		
		$train = \App\models\Train::find($code);
		if(!in_array($week,explode(',',$train->week))){
			$validate->errors()->add('fail','當日無該車次列車');
			return back()->withErrors($validate)->withInput();
		}
		
		$pass = 1;
		foreach(explode(',',$train->station) as $n=>$value){
			if($pass == 1){
				if($value == $from){
					$pass = 2;
				}
			}elseif($pass == 2){
				if($value == $to){
					$pass = 3;
				}
			}			
			if($pass != 3 && $n == count(explode(',',$train->station)) - 1){
				$pass = false;
			}
		}
		if(!$pass){
			$validate->errors()->add('fail','該列車無行經起訖站');
			return back()->withErrors($validate)->withInput();	
		}
		
		$start_time = explode(',',$train->start_time);
		$time_total = $start_time[array_search($from,explode(',',$train->station))];
		$time_total_now = date('H')*60 + date('i');
		
		$minute = floor($time_total / 60);
		$second = $time_total % 60;
		$time = ($minute > 9 ? $minute : '0' . $minute) . ':' . ($second > 9 ? $second : '0' . $second);
		
		if(strtotime(date('Y-m-d')) >= strtotime($date)){
			if($time_total_now >= $time_total){
				$validate->errors()->add('fail','發車時間已過');
				return back()->withErrors($validate)->withInput();	
			}	
		}
	
		$order = \App\models\Order::where('code',$code)->where('date',$date)->where('cancel',0)->get();
		$total_order = 0;
		$station = explode(',',$train->station);
		$max = ($train->per_car) * ($train->car_count);
		foreach($order as $value){
			$op = array_search($value->from,$station);
			$ed = array_search($value->to,$station);
			if(array_search($from,$station) >= $op && array_search($from,$station) < $ed){
				$total_order += $value->count;
			}
		}
		if(($total_order + $count) > $max){
			$validate->errors()->add('fail','該區間已無空位');
			return back()->withErrors($validate)->withInput();
		}
		
		$ran = array('0','1','2','3','4','5','6','7','8','9',
		'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z',
		'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
		do{
			shuffle($ran);			
			$number = '';
			foreach(range(0,9) as $value){
				$number .= $ran[$value];
			}
			$test = \App\models\Order::where('n',$number)->get();
		}while(!empty($test[0]));
		
		$money = (array_search($to,$station) - array_search($from,$station)) * 100;	
		
		$new_order = new \App\models\Order;
		$new_order->n = $number;
		$new_order->phone = $phone;
		$new_order->code = $code;
		$new_order->date = $date;
		$new_order->start_time = $time;
		$new_order->order_date = date('Y-m-d');
		$new_order->order_time = date('H:i');
		$new_order->from = $from;
		$new_order->to = $to;
		$new_order->count = $count;
		$new_order->money = $money;
		$new_order->save();
		
		
		
		$date3 = $date2[1] . '/' . $date2[2];
		$from_c = $this->station_n_c[$from];
		$to_c = $this->station_n_c[$to];
		$total_money = number_format($count * $money);
		
		$path = "SMS/{$phone}.txt";
		$str = "列車訂位成功。訂票編號：{$number}，{$date3}{$from_c}{$to_c}{$code}車次，{$count}張票，{$time}開，共{$total_money}元" . PHP_EOL;
		$str .= '========================================' . PHP_EOL;
		$sms = fopen($path,'a+');
		fwrite($sms, $str);
		fclose($sms);
		return view('train.order-done',compact('number','phone','time','code','from','to','count','money','total_money'));
	}
	
	public function OrderLogDo(Request $data){
		$number = empty($data->number) ? '%' : $data->number;
		$phone = empty($data->phone) ? '%' : $data->phone;
		
		if($number == '%' && $phone == '%'){
			return back()->withErrors('請輸入查詢條件');
		}
		
		$orders = \App\models\Order::where('n','LIKE',$number)->where('phone','LIKE',$phone)->paginate(10);
		if(empty($orders[0])){
			return view('train.order-log')->withErrors('查無指定條件的紀錄，請更換條件再查詢');
		}
		
		return view('train.order-log',compact('orders'));
	}
	
	public function OrderCancel($id){
		$order = \App\models\Order::find($id);
		$order->cancel = 1;
		$order->save();
		
		return back();
	}
	
	public function OrderValidate(Request $data){
		session_start();		
		$_SESSION['validate'] = false;
		
		$answer = array('256','1467','023','578');
		$type = $data->type;
		$answer_user = $data->answer;
		
		if(!$answer_user){
			return 'error2';
		}
		
		$correct = 0;
		$error = 0;
		foreach($answer_user as $value){
			if(is_numeric(strpos($answer[$type], $value))){
				$correct++;
			}else{
				$error++;
			}
		}
		
		if($correct == strlen($answer[$type]) && $error == 0){
			$_SESSION['validate'] = true;
			echo 'success';
		}else{
			if($correct == (strlen($answer[$type]) - 1) && $error == 0){
				return 'error1';
			}else{
				return 'error2';
			}
		}
	}
}
