<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SmScholarship extends Model
{
    //
    public function student(){
        return $this->belongsTo('App\SmStudent');
    }

    public function fee(){
        return $this->belongsTo('App\SmFeesClass');
    }

    public function class(){
        return $this->belongsTo('App\SmClass');
    }
}
