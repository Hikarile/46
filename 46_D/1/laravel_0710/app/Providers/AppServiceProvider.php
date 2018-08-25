<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
       $station_e_n = array('TAIPEI'=>0,'TAOYUAN'=>1,'HSINCHU'=>2,'MIAOLI'=>3,'TAICHUNG'=>4,'CHANGHUA'=>5,'YUNLIN'=>6,'CHIAYI'=>7,'TAINAN'=>8,'KAOHSIUNG'=>9,'PINGTUNG'=>10,'TAITUNG'=>11,'HUALIEN'=>12,'ILAN'=>13);
	   $station_n_c = array('台北','桃園','新竹','苗栗','台中','彰化','雲林','嘉義','台南','高雄','屏東','台東','花蓮','宜蘭');
	   $week_n_c = array('日','一','二','三','四','五','六');
	   
	   
	   view()->share('station_e_n',$station_e_n);
	   view()->share('station_n_c',$station_n_c);
	   view()->share('week_n_c',$week_n_c);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
