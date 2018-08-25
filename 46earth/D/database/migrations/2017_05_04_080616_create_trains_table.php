<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trains',function(Blueprint $a){
			$a->increments('id');
			$a->text('number');
			$a->text('type');
			$a->text('Mon');
			$a->text('Tue');
			$a->text('Wed');
			$a->text('Thu');
			$a->text('Fri');
			$a->text('Sat');
			$a->text('Sun');
			$a->text('stime');
			$a->text('station');
			$a->text('etime');
			$a->text('etation');
			$a->text('waittime');
			$a->text('money');
			$a->text('time');
			$a->timestamps();
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::droplfExists('trains');
    }
}
