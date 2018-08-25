<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Train extends Model
{
    public $primaryKey = 'code';
	public $increment = false;
}
