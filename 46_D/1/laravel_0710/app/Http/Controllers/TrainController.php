<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\models\Train;

use App\models\Type;


class TrainController extends Controller
{
	public $station_e_n = array('TAIPEI'=>0,'TAOYUAN'=>1,'HSINCHU'=>2,'MIAOLI'=>3,'TAICHUNG'=>4,'CHANGHUA'=>5,'YUNLIN'=>6,'CHIAYI'=>7,'TAINAN'=>8,'KAOHSIUNG'=>9,'PINGTUNG'=>10,'TAITUNG'=>11,'HUALIEN'=>12,'ILAN'=>13);
	public $station_n_c = array('台北','桃園','新竹','苗栗','台中','彰化','雲林','嘉義','台南','高雄','屏東','台東','花蓮','宜蘭');

	
	public $type_n_c = array('區間列車','快速列車','磁浮列車');
	
    function TrainSearch($date, $from, $to, $type){
		$validate = \Validator::make(['from'=>$from,'to'=>$to,'date'=>$date,'type'=>$type],[
			'from'=>['required', 'different:to', 'regex:/^[A-Z]+$/'],
			'to'=>['required', 'regex:/^[A-Z]+$/'],
			'date'=>['required', 'date'],
			'type'=>['required', 'regex:/^\d+$/'],
		]);
		if($validate->fails()){
			return back()->withErrors($validate)->withInput();
		}
		
		
		$date2 = explode('-',$date);
		$week = date('w',mktime(0,0,0,$date2[1],$date2[2],$date2[0]));
		$from_n = $this->station_e_n[$from];
		$to_n = $this->station_e_n[$to];
		$from_c = $this->station_n_c[$from_n];
		$to_c = $this->station_n_c[$to_n];
		
		$codes = array();
		foreach(Train::all() as $row){
			$pass = true;
			$station_l = explode(',',$row['station']);
			$week_l = explode(',',$row['week']);
			if($type != $row['type']){ $pass = false; };
			if(!in_array($week,$week_l)){ $pass = false; };
			if(!in_array($from_n,$station_l)){ $pass = false; };
			if(!in_array($to_n,$station_l)){ $pass = false; };
			
			$pass_2 = 1;
			foreach($station_l as $n => $row_2){
				if($pass_2 == 1){
					if($row_2 == $from_n){
						$pass_2 = 2;
					}
				}elseif($pass_2 == 2){
					if($row_2 == $to_n){
						$pass_2 = 3;
					}
				}			
				if($pass_2 != 3 && $n == count($station_l) - 1){
					$pass = false;
				}
			}
			if($pass){
				$codes[] = $row['code'];
			}
		}
		
		$result = array();

		foreach($codes as $n=>$code){
			$train = Train::find($code);
			$station_l = explode(',',$train->station);
			$time_l = explode(',',$train->start_time);
			
			$time_op = $time_l[array_search($from_n,$station_l)];
			$time_ed = $time_l[array_search($to_n,$station_l)] - 1;
			$time_sp = $time_ed - $time_op;
			$min_op = floor($time_op / 60);
			$sec_op = $time_op % 60;
			$min_ed = floor($time_ed / 60);
			$sec_ed = $time_ed % 60;
			$min_sp = floor($time_sp / 60);
			$sec_sp = $time_sp % 60;
			
			$money = (array_search($to_n,$station_l) - array_search($from_n,$station_l)) * 100;

			$result[$n][] = $this->type_n_c[$type];
			$result[$n][] = $code;
			$result[$n][] = $this->station_n_c[$station_l[0]] . '/' . $this->station_n_c[end($station_l)];
			$result[$n][] = ($min_op > 9 ? $min_op : '0' . $min_op) . ':' . ($sec_op > 9 ? $sec_op : '0' . $sec_op);
			$result[$n][] = ($min_ed > 9 ? $min_ed : '0' . $min_ed) . ':' . ($sec_ed > 9 ? $sec_ed : '0' . $sec_ed);
			$result[$n][] = ($min_sp > 9 ? $min_sp : '0' . $min_sp) . ':' . ($sec_sp > 9 ? $sec_sp : '0' . $sec_sp) ;
			$result[$n][] = $money;
		}
		
		if(count($result) < 1){
			$validate = \Validator::make([],[]);
			$validate->errors()->add('not_find','查無指定條件的車次 , 請更換條件再查詢');
			return back()->withErrors($validate)->withInput();
		}
	
		return view('train.train-lookup',compact('result','codes','date','from_c','to_c','from','to'));
	}
	
	public function SearchTrainInfo($code){
		$train = \App\models\Train::find($code);
		if(!empty($train)){
			$search_result = 'true';
			$week = explode(',',$train->week);	
			$start_time = explode(',',$train->start_time);
			$station = explode(',',$train->station);
			$time = array();
			foreach($start_time as $n=>$value){
				if($n != 0){
					$minute_arr = floor(($value - 1) / 60);
					$second_arr = ($value - 1) % 60;
					$time2_arr = ($minute_arr > 9 ? $minute_arr : '0' . $minute_arr) . ':' . ($second_arr > 9 ? $second_arr : '0' . $second_arr);
				}else{
					$time2_arr = '';	
				}
				if($n != count($start_time) - 1){
					$minute_st = floor($value / 60);
					$second_st = $value % 60;
					$time2_st = ($minute_st > 9 ? $minute_st : '0' . $minute_st) . ':' . ($second_st > 9 ? $second_st : '0' . $second_st);
				}else{
					$time2_st = '';
				}
				$time[$n] = array($time2_arr,$time2_st);
			}
		}else{
			$not_find = 'true';			
		}
		return view('train.train-info',compact('search_result','not_find','code','week','station','time'));
	}
}
