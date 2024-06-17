<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SmBillIssueItem extends Model
{
    //
    public function bill(){
        return $this->belongsTo('App\SmBillIssue');
    }

    public function fee(){
        return $this->belongsTo('App\SmFeesClass','fee_id','id');

    }
}
