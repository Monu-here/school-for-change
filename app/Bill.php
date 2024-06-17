<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    //
    public function fiscalYear(){
        return $this->belongsTo('App\SmFiscalYear','fiscalyear_id');
    }

    public function generateBillno(){
        $maxid=Bill::where('fiscalyear_id',$this->fiscalyear_id)->max('id');
        $maxb=Bill::find($maxid);
        $max=0;
        if($maxb!=null){
            $max=intval($maxb->billno);
        }
        $max=$max+1;
        $this->billno= strval($max);
    }
}
