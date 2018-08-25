<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Train extends Model
{
	protected $primaryKey = 'code';
	//protected $table = '';
	//protected $fillable = [];
	public function type(){
		return $this->belongsTo('App\models\Type','type','id');
	}
}
