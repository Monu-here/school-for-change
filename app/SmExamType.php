<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SmExamType extends Model
{
    //
    public function session()
    {
        $this->belongsTo(SmSession::class,'session_id','id');
    }
}
