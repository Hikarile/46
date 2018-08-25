<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ones as ones;
use App\Models\types as types;
use App\Models\trains as trains;
use App\Models\stations as stations;
use App\Models\train_stations as ts;
use App\Models\tickets as tickets;
use File;

class TrainsController extends Controller{
	
    public function index(){//首頁
		$type=types::all();
		$ts=ts::all();
		return view('D\index\index',['type'=>$type,'ts'=>$ts]);
	}
	public function look($station_E,$etation_E,$id,$date){//首頁-列車查詢
		$train_stations=ts::where('station_E',$station_E)->firstOrFail();
		$station=$train_stations->station_C;
		$train_stations=ts::where('station_E',$etation_E)->firstOrFail();
		$etation=$train_stations->station_C;
		
		$st=array();
		$yes=array();
		$train=array();
		$da=array();
		$s='';
		$e='';
		$l='';
		
		$day=date('D',strtotime($date));
		$type=types::find($id);
		$m=trains::where('type',$type->type)->where($day,'1')->get();
		
		foreach($m as $i=>$mm){
			$stations=stations::where('tid',$mm->id)->get();
			foreach($stations as $stat){
				if($station == $stat->strtion){
					$s=$stat->id;
				}
				if($etation == $stat->strtion){
					$e=$stat->id;
				}
			}
			if($s!='' && $e!=''){
				if($s < $e){
					$yes[]=$mm->id;
				}
			}
			$s='';
			$e='';
		}
		
		foreach($yes as $h=>$yess){
			$train[$h]=trains::where('id',$yess)->firstOrFail();
			$yy='yy';
		}
		
		$inquires['station_E']=$station_E;
		$inquires['etation_E']=$etation_E;
		$inquires['station']=$station;
		$inquires['etation']=$etation;
		$inquires['date']=$date;
		
		if(empty($yy)){
			session()->flash('error','error');
		}else{
			session()->flash('error','');
		}
		return view('D\look\index',['train'=>$train,'inquires'=>$inquires]);
	}
	
	public function order($number='',$date='',$from='',$to=''){//預訂車票
		$ts=ts::all();
		$into=['number'=>$number,'date'=>$date,'from'=>$from,'to'=>$to];
		return view('D\order\index',['ts'=>$ts,'into'=>$into]);
	}
	public function order_save(Request $post){//訂票
		if($post->from == $post->to){
			session()->flash('error','起訖站相同');
			return back()->withInput();
		}
		
		$train = trains::where('number', $post->number)->first();
		if(!$train) {
			session()->flash('error','查無此列車');
			return back()->withInput();
		}
		
		$station=stations::where('tid',$train->id)->where('strtion',$post->from)->first();
		if(strtotime($post->date .' '.$station->times)<strtotime('now')){
			return back()->with('error', '發車時間已過')->withInput();
		}
		
		$week=date('D',strtotime($post->date .' '.$train->stime));
		$train = trains::where($week,'1')->where('number',$post->number)->first();
		if($train->id == ''){
			session()->flash('error','當日無該車次列車');
			return back()->withInput();
		}
		
		$train = trains::where('number', $post->number)->first();
		$stations=stations::where('tid',$train->id)->get();
		foreach($stations as $stat){
			if($stat->strtion == $post->from){
				$s=$stat->id;
			}
			if($stat->strtion == $post->to){
				$e=$stat->id;
			}
		}
		if($e=='' or $s==''){
			session()->flash('error','該列車無行經起訖站');
			return back()->withInput();
		}
		
		$count='';
		$tickets=tickets::where('day',$post->date)->get();
		foreach($tickets as $ticket){
			$station_id=stations::where('tid',$train->id)->where('strtion',$ticket->station)->first();//已訂-開始站
			$etation_id=stations::where('tid',$train->id)->where('strtion',$ticket->etation)->first();//已訂-結束站
			$from_id=stations::where('tid',$train->id)->where('strtion',$post->from)->first();//正在訂-開始站
			$to_id=stations::where('tid',$train->id)->where('strtion',$post->to)->first();//正在訂-結束站
			
			if($from_id >= $station_id && $to_id >= $etation_id){
				$count=$count+$ticket->pag;
			}
		}
		$trains=trains::where('number',$post->number)->first();
		$type=types::where('type',$trains->type)->first();
		if($count >= $type->total){
			session()->flash('error','該區間已無空車位');
			return back()->withInput();
		}
		
		$train=trains::where('number',$post->number)->first();
		$stat=stations::where('tid',$train->id)->where('strtion',$post->from)->first();
		$etat=stations::where('tid',$train->id)->where('strtion',$post->to)->first();
		
		$from_id=stations::where('tid',$train->id)->where('strtion',$post->from)->first();
		$to_id=stations::where('tid',$train->id)->where('strtion',$post->to)->first();
		$station=stations::where('tid',$train->id)->get();
		$one_money='';
		foreach($station as $station){
			if($from_id->id <= $station->id &&  $station->id <= $to_id->id){
				$one_money++;
			}
		}
		
		
		$code = array_merge(range(0, 9), range('A', 'Z'), range('a', 'z'));
		shuffle($code);
		$code = array_slice($code, 0, 12);
		$a=new tickets;
		$a->day=$post->date;
		$a->number=join('', $code);
		$a->phone=$post->phone;
		$a->stime=$stat->times;
		$a->etime=$etat->times;
		$a->station_number=$post->number;
		$a->station=$post->from;
		$a->etation=$post->to;
		$a->pag=$post->count;
		$a->one_money=($one_money-1)*100;
		$a->all_money=$a->one_money*$post->count;
		$a->save();
		
		$day=explode("-",$a->day);
		$st=explode("站",$post->from);
		$et=explode("站",$post->to);
		//傳送簡訊(public/SMS)
		$email='SMS/'.$a->phone.'.txt';
		$text='========================================'."\r\n".'列車訂位成功。訂票編號:'.$a->number.'，'.$day[1].'/'.$day[2].'，'.$st[0].$et[0].' '.$post->number.'車次，'.$a->pag.'張票，'.$a->stime.'開，共'.$a->all_money.'元'."\r\n";
		$file=fopen($email,"a+"); //開啟檔案
		fwrite($file,$text);
		fclose($file);
		
		return redirect()->route('order_done', $a->id);
	}
	public function order_done($id){//訂票完成
		$tickets=tickets::where('id',$id)->first();
		return view('D\order\done\index',['ticket'=>$tickets]);
	}
	
	public function order_log($su='',$phone=''){//訂票查詢
		$yes='';
		if($su=='' && $phone=='' || $su=='null' && $phone=='null'){//兩項都空值
			$tickets=tickets::paginate(3);
			return view('D\order_log\index',['ticket'=>$tickets]);
		}
		if($su!='' && $phone=='null'){//編號有值
			$tickets=tickets::where('number',$su)->get();
		}
		if($su=='null' && $phone!=''){//手機有值
			$tickets=tickets::where('phone',$phone)->get();
		}
		if($su!='' && $phone!='' && $su!='null' && $phone!='null'){//兩項都有值
			$tickets=tickets::where('number',$su)->where('phone',$phone)->get();
		}
		foreach($tickets as $ticket){
			if($ticket->id != ''){
				$yes='yyy';
			}
		}
		if($yes != 'yyy'){
			session()->flash('error','查無指定條件的紀錄，請更換條件再查詢');
		}else{
			session()->flash('error','');
		}
		
		return view('D\order_log\index',['ticket'=>$tickets]);
	}
	public function order_log_d($id){//訂票查詢-取消訂票
		$date=date('Y/m/d H:i:s');
		$a=tickets::where('id',$id)->first();
		$a->d=$date;
		$a->save();
		
		session()->flash('yes','已經成功取消');
		return redirect()->route('order_log');
	}
	
	public function train_info($number=''){//列車資訊
		if($number!=''){
			$trains=trains::where('number',$number)->first();
			$stations=stations::where('tid',$trains->id)->get();
			return view('D\train-info\index',['train'=>$trains,'station'=>$stations]);
		}else{
			return view('D\train-info\index');
		}
	}
	
	public function png(Request $post){//資料統計
		$types=types::all();
		return view('D\png\index',['type'=>$types]);
	}
	public function img($date='',$type=''){//繪製統計圖
		$img=imagecreate(580,260);
		$bg=imagecolorallocate($img,255,255,255);
		$black=imagecolorallocate($img,0,0,0);
		
		$type=types::where('type',$type)->first();//抓車種
		$tickets=tickets::where([
				['day',$date],
				['d','']
		])->join('trains','trains.number','=','tickets.station_number')
		->join('types','types.type','=','trains.type')
		->where('types.id', '=', $type->id)
		->get();
		
		if(sizeof($tickets)){
			$start='23:59';  $end='00:00';
			foreach($tickets as $ticket){
				if($ticket->stime < $start){
					$start=$ticket->stime;
				}
				if($ticket->etime > $end){
					$end=$ticket->etime;
				}
			}
			
			$ts=ts::all();
			$color=array();
			foreach($ts as $t=> $tss){
				$color[$t]=imagecolorallocate($img,rand(50,250),rand(50,250),rand(50,250));
			}
			$time=array();
			$people=array();
			$max='';
			for($i=strtotime($start)-strtotime($start)%(30*60);$i<=strtotime($end)-strtotime($end)%(30*60);$i+=30*60){
				foreach($ts as $tss){
					$people[$tss->station_C][date('H:i',$i)]=0;
				}
				$times[]=date('H:i',$i);
			}
			
			foreach($tickets as $ticket){
				$stime=strtotime($ticket->stime);
				$stime=date('H:i',$stime-$stime%(30*60));
				$people[$ticket->station][$stime]+=$ticket->pag;//訂票站每分上車的人
				if($max <= $people[$ticket->station][$stime]){
					$max=$people[$ticket->station][$stime];
				}
				
				$etime=strtotime($ticket->etime);
				$etime=date('H:i',$etime-$etime%(30*60));
				$people[$ticket->etation][$etime]+=$ticket->pag;//訂票站每分下車的人
				if($max <= $people[$ticket->etation][$etime]){
					$max=$people[$ticket->etation][$etime];
				}
			}
			
			$st=strtotime('0:0')-strtotime('0:0')%(30*60);
			$et=strtotime('23:59')-strtotime('23:59')%(30*60);
			$tt=array();
			for($i=$st;$i<=$et;$i+=(30*60)){
				$tt[]=date('H:i',$i);
			}
			$ga=floor(540/47);
			$for=20;
			$x=array();
			foreach($tt as $k=>$ttt){
				$x[$ttt]=$for;
				$for+=$ga;
			}
			$h=floor(180/$max);
			$w=5;
			$aaa=0;
			foreach($ts as $ii=>$tss){
				$den=array();
				foreach($tt as $ttt){
					$den[]=$x[$ttt];
					if(isset($people[$tss->station_C][$ttt])){
						if($people[$tss->station_C][$ttt] != 0){
							if($aaa == 0){
								imagettftext($img,7,0,$x[$ttt],210,$black,'text.ttf',$ttt);
								$aaa+=1;
							}else{
								imagettftext($img,7,0,$x[$ttt],220,$black,'text.ttf',$ttt);
								$aaa=0;
							}
						}
						$den[]=180-($h*$people[$tss->station_C][$ttt])+20;
					}else{
						$den[]=200;
					}
				}
				
				$den[]=546;
				$den[]=200;
				
				$den[]=20;
				$den[]=200;
				imagefilledpolygon($img,$den,sizeof($den)/2,$color[$ii]);
				imagettftext($img,10,0,$w,255,$color[$ii],'text.ttf',$tss->station_C);
				$w+=40;
			}
			
			imageline($img,20,20,580,20,$black);//界線上面
			imageline($img,20,200,580,200,$black);////界線下面
			imagettftext($img,22,0,0,95,$black,'text.ttf','人');
			imagettftext($img,22,0,0,120,$black,'text.ttf','數');
			imagettftext($img,15,0,3,210,$black,'text.ttf','0');
			imagettftext($img,15,0,0,25,$black,'text.ttf',$max);
			
		}
		
		header("Content-type:image/png");
		imagepng($img);
		imagedestroy($img);
	}
	public function json($date='',$type=''){//json下載
		$stations=array();
		$records=array();
		
		$ts=ts::all();
		foreach($ts as $tss){
			$stations[]=[
				'id'=>$tss->id,
				'code'=>$tss->station_E,
				'title'=>$tss->station_C
			];
			
			$start_tickets=tickets::join('trains','trains.number','=','tickets.station_number')
			->where('station',$tss->station_C)
			->where('day',$date)
			->get();
			
			$end_tickets=tickets::join('trains','trains.number','=','tickets.station_number')
			->where('etation',$tss->station_C)
			->where('day',$date)
			->get();
			
			$trains=trains::where('type',$type)->get();
			
			foreach($trains as $i=>$train){
				$speople=0;
				$epeople=0;
				foreach($start_tickets as $sticket){
					if($train->id == $sticket->id){
						if($sticket->pag){
							$speople+=$sticket->pag;
						}
					}
				}
				foreach($end_tickets as $eticket){
					if($train->id == $sticket->id){
						if($eticket->pag){
							$epeople+=$eticket->pag;
						}
					}
				}
				$recoed=['type_id'=>$train->id,'exit'=>$speople,'entrance'=>$epeople];
			} 
			$records[]=[
				'station_id'=>$tss->id,
				'recoed'=>$recoed,
				'time'=>$date
			];
		}
		
		$data=json_encode(['stations'=>$stations,'records'=>$records]);
		$file='export_'.$date.'.json';
		File::put('json/'.$file,$data);
		return response()->download('json/'.$file);
	}
	
	public function type(){//車種管理
		$type=types::all();
		return view('D\login\type\type',['type'=>$type]);
	}
	public function typeadd(){//新增頁面
		return view('D\login\type\typeadd');
	}
	public function typef($id){//修改頁面
		$post=types::find($id);
		return view('D\login\type\typef',['post'=>$post]);
	}
	public function typesave(Request $post){//date新增修改
		$aaa=$post->aaa;
		$total=$post->car*$post->singlecar;
		
		if($aaa==1){
			$a=new types;
		}elseif($aaa==2){
			$a=types::find($post->id);
		}
		
		$a->type=$post->type;
		$a->car=$post->car;
		$a->singlecar=$post->singlecar;
		$a->total=$total;
		$a->save();
			
		return redirect('type');
	}
	
	public function train(){//列車管理
		$train=trains::all();
		$station=stations::all();
		
		return view('D\login\train\train',['trains'=>$train,'stations'=>$station]);
	}
	public function trainadd(){//新增頁面
		$types=types::all();
		$tss=ts::all();
		return view('D\login\train\trainadd',['type'=>$types,'tts'=>$tss]);
	}
	public function trainf($id){//修改頁面
		$types=types::all();
		$tss=ts::all();
		$trains=trains::find($id);
		$stations=stations::where('tid','=',$id)->get();
		return view('D\login\train\trainf',['type'=>$types,'tts'=>$tss,'train'=>$trains,'station'=>$stations]);
	}
	public function trainsave(Request $post){//date新增修改
		$aaa=$post->aaa;
		if($aaa==1){
			$t=new trains;
			$t->number=$post->number;
			$t->type=$post->type;
			$days = array('Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun');
			foreach ($days as $day) {
				if($post->$day ==''){
					$t->$day ='null';
				}else{
					$t->$day = $post->$day;
				}
			}
			
			$sstime=(date("h",strtotime($post->etim))*60+ date("i",strtotime($post->etim)))-(date("h",strtotime($post->stim))*60+ date("i",strtotime($post->stim)));
			$t->station_time=$post->stim;
			$t->station=$post->sstat;
			$t->end_time=$post->etim;
			$t->etation=$post->estat;
			$t->waittime=$post->waittime;
			$t->money=(100*(2+$post->a))-100;
			$t->time=$sstime;
			$t->save();
			
			$id=$t->id;
			
			$b=new stations;
			$b->tid=$id;
			$b->strtion=$post->sstat;
			$b->times=$post->stim;
			$b->save();
			
			for($i=1;$i<=$post->a;$i++){
				if($post->station[$i]!=''){
					$b=new stations;
					$b->tid=$id;
					$b->strtion=$post->station[$i];
					$b->times=$post->times[$i];
					$b->save();
				}
			}
			$b=new stations;
			$b->tid=$id;
			$b->strtion=$post->estat;
			$b->times=$post->etim;
			$b->save();
			
		}elseif($aaa==2){
			$t=trains::find($post->id);
			stations::where('tid',$post->id)->delete();
			
			$t->number=$post->number;
			$t->type=$post->type;
			$days = array('Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun');
			foreach ($days as $day) {
				if($post->$day ==''){
					$t->$day ='null';
				}else{
					$t->$day = $post->$day;
				}
			}
			
			$sstime=(date("h",strtotime($post->etim))*60+ date("i",strtotime($post->etim)))-(date("h",strtotime($post->stim))*60+ date("i",strtotime($post->stim)));
			$t->station_time=$post->stim;
			$t->station=$post->sstat;
			$t->end_time=$post->etim;
			$t->etation=$post->estat;
			$t->waittime=$post->waittime;
			$t->money=(100*(2+$post->a))-100;
			$t->time=$sstime;
			$t->save();
			
			$id=$post->id;
			
			$b=new stations;
			$b->tid=$id;
			$b->strtion=$post->sstat;
			$b->times=$post->stim;
			$b->save();
			for($i=1;$i<=$post->a;$i++){
				if($post->station[$i]!=''){
					$b=new stations;
					$b->tid=$id;
					$b->strtion=$post->station[$i];
					$b->times=$post->times[$i];
					$b->save();
				}
			}
			$b=new stations;
			$b->tid=$id;
			$b->strtion=$post->estat;
			$b->times=$post->etim;
			$b->save();
		}
		return redirect('train');
	}
	public function traind($id){//刪除列車
		$trains=trains::where('id',$id)->first();
		$new=strtotime(date('H:i',strtotime('now')));
		$st=strtotime(date('H:i',strtotime($trains->stime)));
		$et=strtotime(date('H:i',strtotime($trains->etime)));
		$text['id']=$id;
		if($new > $st && $et > $new){
			return view('D\login\train\traind',['text'=>$text]);
		}else{
			trains::find($id)->delete();
			stations::where('tid',$id)->delete();
			return redirect('train');
		}
	}
	
	public function ticket($date='',$number='',$phone='',$from='',$to=''){//訂票紀錄查詢
		$yes='';
		$arr = array();
		if($date != '' && $date != 'null'){
			$arr[] = ['day', $date];
		}
		if($number != '' && $number != 'null'){
			$arr[] = ['station_number', $number];
		}
		if($phone != '' && $phone != 'null'){
			$arr[] = ['phone', $phone];
		}
		if($from != '' && $from != 'null'){
			$from=ts::where('station_E',$from)->first();
			$arr[] = ['station',$from->station_C];
		}
		if($to != '' && $to != 'null'){
			$to=ts::where('station_E',$to)->first();
			$arr[] = ['etation',$to->station_C];
		}
		foreach($arr as $ar){
			$yes='yyyyy';
		}
		if($yes==''){
			$tickets=tickets::where($arr)->paginate(5);
			$tss=ts::all();
			return view('D\login\ticket\ticket',['ticket'=>$tickets,'ts'=>$tss]);
		}else{
			$tickets=tickets::where($arr)->get();
			$tss=ts::all();
			return view('D\login\ticket\ticket',['ticket'=>$tickets,'ts'=>$tss]);
		}
	}
	public function ticketd($id){//訂票紀錄查詢-刪除
		$tickets=tickets::where('id',$id)->first();
		$date=date('Y/m/d');
		$day=explode("-",$tickets->day);
		$st=explode("站",$tickets->station);
		$et=explode("站",$tickets->etation);
		$email='SMS/'.$tickets->phone.'.txt';
		$text="========================================\r\n您的訂票紀錄已被管理員取消。訂票編號:".$tickets->number."，".$day[1]."/".$day[2]."，".$st[0].$et[0].' '.$tickets->station_number."車次，取消時間:".$date."\r\n";
		$file=fopen($email,"a+"); //開啟檔案
		fwrite($file,$text);
		fclose($file);
		
		$tickets->d=$date;
		$tickets->save();
		
		return redirect('ticket');
	}
	
	public function login(){//登入後台
		return view('D\login\index');
	}
	public function dnlu(Request $post){//登入判斷
		$ac=$post->ac;
		$ps=$post->ps;
		if($ac==''){
			return back()->with('error', '帳號未填');
		}if($ps==''){
			return back()->with('error', '密碼未填');
		}
		$one=ones::where('ac','=',$ac)->first();
		if($one){
			if($one->ps==$ps){
				session(['dnlu'=>'ttt']);
				return redirect('index');
			}else{
				return back()->with('error', '密碼錯誤');
			}
		}else{
			return back()->with('error', '帳號錯誤');
		}
	}
	public function out(){//登出
		session()->forget('dnlu');
		return redirect('login');
	}
	
	public function d($type,$id){//所有項目的刪除
		if($type==1){
			$yes='';
			$types=types::find($id);
			$trains=trains::where('type',$types->type)->get();
			foreach($trains as $train){
				$yes='yyyy';
			}
			if($yes == ''){
				session()->flash('error','');
				types::find($id)->delete();
				return redirect('type');
			}else{
				session()->flash('error','無法刪除');
				return back();
			}
		}
		if($type==2){
			$trains=trains::where('id',$id)->first();
			$tickets=tickets::where('station_number',$trains->number)->get();
			$date=date('Y/m/d H:i:s');
			foreach($tickets as $tickst){
				$day=explode("-",$tickst->day);
				$st=explode("站",$tickst->station);
				$et=explode("站",$tickst->etation);
				$email='SMS/'.$tickst->phone.'.txt';
				$text="========================================\r\n您所訂的列車已取消發車。訂票編號:".$tickst->number."，".$day[1]."/".$day[2]."，".$st[0].$et[0].' '.$tickst->station_number."車次，請改搭其他列車。\r\n";
				$file=fopen($email,"a+"); //開啟檔案
				fwrite($file,$text);
				fclose($file);
				$tickst->d=$date;
				$tickst->save();
			}
			trains::find($id)->delete();
			stations::where('tid',$id)->delete();
			
			return redirect('train');
		}
		if($type==3){
			return redirect('train');
		}
	}
	
}