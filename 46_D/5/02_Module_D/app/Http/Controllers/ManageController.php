<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Train;
use App\Type;
use App\Order;

class ManageController extends Controller
{
	//判斷登入權限
    public function __construct()
    {
        $this->middleware('auth');
    }
	
	//車種管理
	public function type()
	{
		return view('manage.type');
	}
	public function typeInsert()
	{
		$insert = 1;
		return view('manage.type',compact('insert'));
	}
	public function typeInsertDo(Request $data)
	{
		$name = $data->name;
		$speed = $data->speed;
		
		$type = Type::where('name',$name)->get();
		if(!empty($type[0])){
			return back()->withErrors('車種名稱已經存在');
		}
		
		$type = new Type;
		$type->name = $name;
		$type->speed = $speed;
		$type->save();
		
		return redirect(route('manage.type'));
	}
	public function typeUpdate($id)
	{
		$update = 1;
		$type = Type::find($id);
		return view('manage.type',compact('update','type'));
	}
	public function typeUpdateDo(Request $data)
	{
		$id = $data->id;
		$or_name = $data->or_name;
		$name = $data->name;
		$speed = $data->speed;
		
		$type = Type::where('name',$name)->get();
		if(!empty($type[0]) && $or_name != $name){
			return back()->withErrors('車種名稱已經存在');
		}
		
		$type = Type::find($id);
		$type->name = $name;
		$type->speed = $speed;
		$type->save();
		
		return redirect(route('manage.type'));
	}
	public function typeDelete($id)
	{
		Type::destroy($id);
		$trains = Train::where('type',$id)->get();
		foreach($trains as $value){
			Order::where('code',$value->code)->delete();
			Train::find($value->code)->delete();
		}
		return redirect(route('manage.type'));
	}

	//列車管理
	public function train()
	{
		$trains = Train::all();
		foreach($trains as $value){
			$value->station = explode(',',$value->station);
			$value->start_time = explode(',',$value->start_time);
		}
		return view('manage.train',compact('trains'));
	}
	public function trainInsert()
	{
		$insert = 1;
		return view('manage.train',compact('insert'));
	}
	public function trainInsertDo(Request $data)
	{
		$code = $data->code;
		$week = implode(',',$data->week);
		$type = $data->type;
		$car_count = $data->car_count;
		$per_car = $data->per_car;
		$sort = $data->sort;
		$time = $data->time;
		
		$train = Train::find($code);
		if($train){
			return back()->withErrors('列車代碼已經存在');
		}
		
		$station = '';
		$start_time = '';
		$sort = array_filter($sort);
		asort($sort);
		foreach($sort as $n=>$value){
			$station .= station_nc()[$n] . ',';
			$start_time .= $time[$n] . ',';
		}		
		$start_time = substr($start_time, 0, -1);
		$station = substr($station, 0, -1);
		
		$train = new Train;
		$train->code = $code;
		$train->type = $type;
		$train->week = $week;
		$train->car_count = $car_count;
		$train->per_car = $per_car;
		$train->station = $station;
		$train->start_time = $start_time;
		$train->save();
		
		return redirect(route('manage.train'));
	}
	public function trainUpdate($code)
	{
		$update = 1;
		$train = Train::find($code);
		$train->station = explode(',',$train->station);
		$train->start_time = explode(',',$train->start_time);
		return view('manage.train',compact('update','train'));
	}
	public function trainUpdateDo(Request $data)
	{
		$or_code = $data->or_code;
		$code = $data->code;
		$week = implode(',',$data->week);
		$type = $data->type;
		$car_count = $data->car_count;
		$per_car = $data->per_car;
		$sort = $data->sort;
		$time = $data->time;
		
		$train = Train::find($code);
		if($train && $or_code != $code){
			return back()->withErrors('列車代碼已經存在');
		}
		
		$station = '';
		$start_time = '';
		$sort = array_filter($sort);
		asort($sort);
		foreach($sort as $n=>$value){
			$station .= station_nc()[$n] . ',';
			$start_time .= $time[$n] . ',';
		}		
		$start_time = substr($start_time, 0, -1);
		$station = substr($station, 0, -1);
		
		$train = Train::find($or_code);
		$train->code = $code;
		$train->type = $type;
		$train->week = $week;
		$train->car_count = $car_count;
		$train->per_car = $per_car;
		$train->station = $station;
		$train->start_time = $start_time;
		$train->save();
		
		return redirect(route('manage.train'));
	}
	public function trainDelete($code)
	{
		Train::destroy($code);
		Order::where('code',$code)->delete();
		return redirect(route('manage.train'));
	}
	
	//訂票紀錄查詢
	public function order()
	{
		$orders = Order::paginate(10);
		return view('manage.order',compact('orders'));
	}
	public function orderSearch(Request $data)
	{
		$unique = $data->unique ? $data->unique : '%';
		$phone = $data->phone ? $data->phone : '%';
		$code = $data->code != '' ? $data->code : '%';
		$start_date = $data->date ? $data->date : '%';
		$from = $data->from ? $data->from : '%';
		$to = $data->to ? $data->to : '%';
		
		$orders = Order::where('unique','like',$unique)
						->where('phone','like',$phone)
						->where('code','like',$code)
						->where('start_date','like',$start_date)
						->where('from','like',$from)
						->where('to','like',$to)
						->paginate(10);
		if(empty($orders[0])){
			return back()->withErrors('查無指定條件的訂票');
		}
		
		return view('manage.order',compact('orders'));
	}
}
