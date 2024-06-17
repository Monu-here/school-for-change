<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SmClass extends Model
{


    // public function sections(){
    // 	return $this->belongsTo('App\SmSection', 'id', 'section_id');
    // }
    public function classSection(){
    	return $this->hasMany('App\SmClassSection', 'class_id');
    }
    public function sectionName(){
    	return $this->belongsTo('App\SmSection', 'section_id');
    }
    public function sections()
	{
	return $this->hasMany('App\SmSection', 'id', 'section_id');
    }
    public function classfee(){
        return $this->hasMany('App\SmFeesClass');
    }

    public function subjects(){
       $data= SmAssignSubject::where('class_id',$this->id)->get();
       
    }
}
