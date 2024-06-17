<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SmFeesClass extends Model
{
    //

    public function class(){
    	return $this->belongsTo('App\SmClass');
    }
}
