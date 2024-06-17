<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SmBillIssue extends Model
{
    //
    public function billitem(){
        return $this->hasMany('App\SmBillIssueItem','bill_id');
    }
}
