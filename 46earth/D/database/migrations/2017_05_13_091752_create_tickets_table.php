<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("tickets",function (Blueprint $a){
			$a->increments('id');
			$a->text('day');
			$a->text('number');
			$a->text('phone');
			$a->text('stime');
			$a->text('etime');
			$a->text('station_number');
			$a->text('station');
			$a->text('etation');
			$a->text('pag');
			$a->text('one_money');
			$a->text('all_money');
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
        Schema::droplfExists('tickets');
    }
}
