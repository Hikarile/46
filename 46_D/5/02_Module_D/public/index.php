<?php
use App\Train;
use App\Type;
use App\Order;

function type_all(){
	$types = Type::all();
	return $types;
}
function type_form(){
	echo '<select id="type" name="type">';
		foreach(type_all() as $value){
			echo '<option value="'.$value->id.'">'.$value->name.'</option>';
		}
	echo '</select>';
}
function station_ec(){
	$result = array(
		'TAIPEI'=>    '台北',
		'TAOYUAN'=>   '桃園', 
		'HSINCHU'=>   '新竹', 
		'MIAOLI'=>    '苗栗',
		'TAICHUNG'=>  '台中',  
		'CHANGHUA'=>  '彰化',  
		'YUNLIN'=>    '雲林',
		'CHIAYI'=>    '嘉義',
		'TAINAN'=>    '台南',
		'KAOHSIUNG'=> '高雄',   
		'PINGTUNG'=>  '屏東',  
		'TAITUNG'=>   '台東', 
		'HUALIEN'=>   '花蓮', 
		'ILAN'=>      '宜蘭'
	);
	return $result;
}
function station_nc(){
	$result = array(
		'台北',
		'桃園',
		'新竹',
		'苗栗',
		'台中',
		'彰化',
		'雲林',
		'嘉義',
		'台南',
		'高雄',
		'屏東',
		'台東',
		'花蓮',
		'宜蘭'
	);
	return $result;
}
function station_pass($from, $to, $station){
	$pass = true;
	if(!in_array($from,$station) || !in_array($to,$station)){
		$pass = false;
	}
	
	if(array_search($from, $station) >= array_search($to, $station)){
		$pass = false;
	}
	return $pass;
}
function week_nc(){
	$result = array('日','一','二','三','四','五','六');
	return $result;
}

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylorotwell@gmail.com>
 */

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| our application. We just need to utilize it! We'll simply require it
| into the script here so that we don't have to worry about manual
| loading any of our classes later on. It feels nice to relax.
|
*/

require __DIR__.'/../bootstrap/autoload.php';

/*
|--------------------------------------------------------------------------
| Turn On The Lights
|--------------------------------------------------------------------------
|
| We need to illuminate PHP development, so let us turn on the lights.
| This bootstraps the framework and gets it ready for use, then it
| will load up this application so that we can run it and send
| the responses back to the browser and delight our users.
|
*/

$app = require_once __DIR__.'/../bootstrap/app.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request
| through the kernel, and send the associated response back to
| the client's browser allowing them to enjoy the creative
| and wonderful application we have prepared for them.
|
*/

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);
