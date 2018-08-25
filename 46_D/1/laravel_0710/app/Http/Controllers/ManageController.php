<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class ManageController extends Controller
{
	public $station_e_n = array('TAIPEI'=>0,'TAOYUAN'=>1,'HSINCHU'=>2,'MIAOLI'=>3,'TAICHUNG'=>4,'CHANGHUA'=>5,'YUNLIN'=>6,'CHIAYI'=>7,'TAINAN'=>8,'KAOHSIUNG'=>9,'PINGTUNG'=>10,'TAITUNG'=>11,'HUALIEN'=>12,'ILAN'=>13);
	//public $station_n_e = array('TAIPEI','TAOYUAN','HSINCHU','MIAOLI','TAICHUNG','CHANGHUA','YUNLIN','CHIAYI','TAINAN','KAOHSIUNG','PINGTUNG','TAITUNG','HUALIEN','ILAN');
	public $station_n_c = array('台北','桃園','新竹','苗栗','台中','彰化','雲林','嘉義','台南','高雄','屏東','台東','花蓮','宜蘭');
	public $week_n_c = array('日','一','二','三','四','五','六');
	
	public function __construct()
    {
        $this->middleware('auth');
    }

    public function SelectType(){
		$types = \DB::table('types')->paginate(3);
		return view('train.manage.type',compact('types'));
    }
	
	public function DeleteType($id){
		$type = \App\models\Type::find($id);
		$type->delete();
		\DB::delete("delete from `trains` where `type`='$id'");
		return redirect(route('type_select'));
	}
	
	public function InsertType(){
		return view('train.manage.type',['insert'=>'insert']);	
	}
	public function InsertTypeDo($name, $speed){
		$validate = \Validator::make(compact('name','speed'),[
			'name'=>['unique:Types,name', 'regex:/^.+$/'],
			'speed'=>'regex:/^\d+$/',
		]);
		
		if($validate->fails()){
			return back()->withErrors($validate)->withInput();
		}
		
		$type = new \App\models\Type;
		$type->name = $name;
		$type->speed = $speed;
		$type->save();
		return redirect(route('type_select'));
	}
	
	public function UpdateType($id){
		$update = 'update';
		$type = \App\models\Type::find($id);
		$name = $type->name;
		$speed = $type->speed;
		return view('train.manage.type',compact('update','id','name','speed'));	
	}
	public function UpdateTypeDo($id,$name,$speed){
		$validate = \Validator::make(compact('name','speed'),[
			'name'=>['unique:Types,name,' . $id, 'regex:/^.+$/'],
			'speed'=>'regex:/^\d+$/',
		]);
		
		if($validate->fails()){
			return back()->withErrors($validate);
		}
		
		$type = \App\models\Type::find($id);
		$type->name = $name;
		$type->speed = $speed;
		$type->save();
		return redirect(route('type_select'));	
	}
	
	/************Train************/
	public function SelectTrain(){
		$trains = \App\models\Train::paginate(3);
		foreach($trains as $train){
			$start_time = explode(',',$train->start_time);
			$station = explode(',',$train->station);
			$week = explode(',',$train->week);
			
			foreach($start_time as $n=>$op){
				$op_m = floor($op / 60);
				$op_s = $op % 60;
				$start_time[$n] = ($op_m > 9 ? $op_m : '0' . $op_m) . ':' . ($op_s > 9 ? $op_s : '0' . $op_s);
			}
			$train->start_time = $start_time;
			
			foreach($station as $n=>$value){
				$station[$n] = $this->station_n_c[$value];
			}
			$train->station = $station;

			foreach($week as $n=>$value){
				$week[$n] = $this->week_n_c[$value];
			}
			$train->week = implode(',',$week);
		}
		
		return view('train.manage.train',compact('trains'));
	}
	public function InsertTrain(){
		$insert = 'insert';
		$types = \App\models\Type::all();
		return view('train.manage.train',compact('insert','types'));
	}
	public function InsertTrainDo(Request $data){
		$code = $data->code;
		$week = $data->week;
		$type = $data->type;
		$per_car = $data->per_car;
		$car_count = $data->car_count;
		
		$station = array();
		$n = 0;
		foreach($data->station as $value){
			if($value != 'false'){
				$station[$n] = $value;
				$n++;
			}
		}
		
		$start_time = array();
		$n = 0;
		foreach($data->start_time as $value){
			if($value){
				$start_time[$n] = $value;
				$n++;
			}
		}
		
		$validate = \Validator::make($data->input(),[
			'code'=>['required','unique:trains,code','regex:/^\d+$/'],
		]);
		
		if($validate->fails()){
			$validate->errors()->add('fail','輸入資料錯誤');
			return back()->withErrors($validate);	
		}
		
		$pass = true;
		foreach($start_time as $n=>$value){
			if($n > 0){
				if(strtotime($value) < strtotime($start_time[$n-1])){
					$pass = false;
				}
			}
		}
		if(!$pass){  
			$validate->errors()->add('fail','輸入資料錯誤');
			return back()->withErrors($validate);	
		}
				
		$dire = 0;
		$pass = true;
		foreach($station as $n=>$value){
			if($n > 0){
				if($dire == -1 && $value - $station[$n-1] > 0){
					$pass = false;
				}elseif($dire == 1 && $value - $station[$n-1] < 0){
					$pass = false;	
				}
				
				if($value - $station[$n-1] < 0){
					$dire = -1;
				}elseif($value - $station[$n-1] > 0){
					$dire = 1;
				}elseif($value == $station[$n-1]){
					$pass = false;
				}
			}			
		}
		if(!$pass){
			$validate->errors()->add('fail','輸入資料錯誤');
			return back()->withErrors($validate);	
		}
		
		foreach($start_time as $n=>$value){
			$value2 = explode(':',$value);
			$start_time[$n] = $value2[0] * 60 + $value2[1];
		}
		
		$train = new \App\models\Train;
		$train->code = $code;
		$train->type = $type;
		$train->week = implode(',',$week);
		$train->per_car = $per_car;
		$train->car_count = $car_count;
		$train->station = implode(',',$station);
		$train->start_time = implode(',',$start_time);
		$train->save();
		
		return redirect(route('train_select'));
	}
	
	public function UpdateTrain($code){
		$update = 'update';
		$types = \App\models\Type::all();
				
		$train = \App\models\Train::find($code);
		$code = $train->code;
		$type = $train->type;
		$week = explode(',',$train->week);
		$per_car = $train->per_car;
		$car_count = $train->car_count;
		$start_time = explode(',',$train->start_time);
		$station = explode(',',$train->station);
		
		foreach($start_time as $n=>$value){
			$mm = floor($value / 60);
			$ss = $value % 60;
			$start_time[$n] = ($mm > 9 ? $mm : '0' . $mm) . ':' . ($ss > 9 ? $ss : '0' . $ss);	
		}
		
		return view('train.manage.train',compact('update','types','code','type','week','per_car','car_count','start_time','station'));
	}
	public function UpdateTrainDo(Request $data){
		
		$code = $data->code;
		$week = $data->week;
		$type = $data->type;
		$per_car = $data->per_car;
		$car_count = $data->car_count;
		
		$station = array();
		$n = 0;
		foreach($data->station as $value){
			if($value != 'false'){
				$station[$n] = $value;
				$n++;
			}
		}
		
		$start_time = array();
		$n = 0;
		foreach($data->start_time as $value){
			if($value){
				$start_time[$n] = $value;
				$n++;
			}
		}
		
		$validate = \Validator::make($data->input(),[
			'code'=>['required','unique:trains,code,' . $code .',code','regex:/^\d+$/'],
		]);
		
		if($validate->fails()){
			$validate->errors()->add('fail','輸入資料錯誤');
			return back()->withErrors($validate);	
		}
		
		$pass = true;
		foreach($start_time as $n=>$value){
			if($n > 0){
				if(strtotime($value) < strtotime($start_time[$n-1])){
					$pass = false;
				}
			}
		}
		if(!$pass){  
			$validate->errors()->add('fail','輸入資料錯誤');
			return back()->withErrors($validate);	
		}
				
		$dire = 0;
		$pass = true;
		foreach($station as $n=>$value){
			if($n > 0){
				if($dire == -1 && $value - $station[$n-1] > 0){
					$pass = false;
				}elseif($dire == 1 && $value - $station[$n-1] < 0){
					$pass = false;	
				}
				
				if($value - $station[$n-1] < 0){
					$dire = -1;
				}elseif($value - $station[$n-1] > 0){
					$dire = 1;
				}elseif($value == $station[$n-1]){
					$pass = false;
				}
			}			
		}
		if(!$pass){
			$validate->errors()->add('fail','輸入資料錯誤');
			return back()->withErrors($validate);	
		}
		
		foreach($start_time as $n=>$value){
			$value2 = explode(':',$value);
			$start_time[$n] = $value2[0] * 60 + $value2[1];
		}
		
		$train = \App\models\Train::find($code);
		$train->code = $code;
		$train->type = $type;
		$train->week = implode(',',$week);
		$train->per_car = $per_car;
		$train->car_count = $car_count;
		$train->station = implode(',',$station);
		$train->start_time = implode(',',$start_time);
		$train->save();
		
		return redirect(route('train_select'));
	}
	
	public function DeleteTrain($code){
		$train = \App\models\Train::find($code);
		$train->delete();
		
		return redirect(route('train_select'));
	}
	
	public function SearchOrder(Request $data){
		$date = empty($data->date) ? '%' : $data->date;
		$code = empty($data->code) ? '%' : $data->code;
		$phone = empty($data->phone) ? '%' : $data->phone;
		$number = empty($data->number) ? '%' : $data->number;
		$from = ($data->from >= 0) ? '%' : $data->from;
		$to = ($data->to >= 0) ? '%' : $data->to;
		
		$orders = \App\models\Order::
			where('date','LIKE',$date)
			->where('code','LIKE',$code)
			->where('phone','LIKE',$phone)
			->where('n','LIKE',$number)
			->where('from','LIKE',$from)
			->where('to','LIKE',$to)->paginate();
		
		return view('train.manage.order',compact('orders'));
	}
}
