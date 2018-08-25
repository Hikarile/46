<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Train;
use App\Type;
use App\Order;

class TrainController extends Controller
{
    public function trainLookup($date, $from, $to, $type)
	{
		$week = week_nc()[date('w',strtotime($date))];
		$from = station_ec()[$from];
		$to = station_ec()[$to];
		
		$trains = Train::where('week','like',"%$week%")->where('type',$type)->get();
		$result = array();
		$n = 0;
		foreach($trains as $value){
			$station = explode(',',$value->station);
			$start_time = explode(',',$value->start_time);
			
			if(station_pass($from, $to, $station)){
				$result[$n][] = Type::find($type)->name;
				$result[$n][] = $value->code;
				$result[$n][] =	$station[0] .'/'. end($station);
				$result[$n][] = $start_time[array_search($from, $station)];
				$result[$n][] =	date('H:i',strtotime($start_time[array_search($to, $station)]) - 60);
				$s = strtotime($start_time[array_search($to, $station)]) - 60 - strtotime($start_time[array_search($from, $station)]);
				$i = floor(($s % 3600) / 60);
				$h = floor($s / 3600);
				$result[$n][] =	($h > 9 ? $h : '0' . $h) . ':' . ($i > 9 ? $i : '0' . $i);
				$result[$n][] =	(array_search($to, $station) - array_search($from, $station)) * 100;
				$code = $value->code;
				$result[$n][] = '<input type="button" value="訂票" onclick="location.href = \''.route('order',compact('code','date','from','to')).'\';">';
				$n++;
			}
		}
		
		if($n == 0){
			return back()->withErrors('查無指定條件的車次，請更換條件後再查詢');
		}
		return view('train-lookup',compact('result','date','from','to'));
	}
    public function trainInfo()
	{
		return view('train-info');
	}
    public function trainInfoSearch($code)
	{
		$train = Train::find($code);
		if(empty($train)){
			return back()->withErrors('查無此列車');
		}	
		$station = explode(',',$train->station);
		$start_time = explode(',',$train->start_time);
		$result = array();
		foreach($station as $n=>$value){
			$result[$n][] = $value;
			$result[$n][] = $n==0 ? '' : date('H:i',strtotime($start_time[$n]) - 60);
			$result[$n][] = $n==count($station)-1 ? '' : $start_time[$n];
		}
		return view('train-info',compact('train','result'));
	}

}
