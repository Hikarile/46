<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function	train(){
		return $this->belongsTo('\App\models\Train','code','code');
	}
}
