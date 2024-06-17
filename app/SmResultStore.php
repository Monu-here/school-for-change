<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\SmMarkStore;
use App\SmSubject;
class SmResultStore extends Model
{
    public function subject(){
        return $this->belongsTo(SmSubject::class,'subject_id','id');
        // $sub =  SmSubject::where('id',$this->subject_id)->orderBy('credit_hour','desc')->first();
        // return $sub;
    }

    
    public function studentInfo(){
    	return $this->belongsTo('App\SmStudent', 'student_id', 'id');
    }

    

    public static function  GetResultBySubjectId($class_id, $section_id, $subject_id,$exam_id,$student_id){
    	$data = SmMarkStore::where([
    		['class_id',$class_id],
    		['section_id',$section_id],
    		 ['exam_term_id',$exam_id],
    		['student_id',$student_id],
    		['subject_id',$subject_id]
    	])->get();
    	return $data;
    }

    public static function  GetFinalResultBySubjectId($class_id, $section_id, $subject_id,$exam_id,$student_id){
        $data = SmResultStore::where([
        ['class_id',$class_id],
        ['section_id',$section_id],
        ['exam_type_id',$exam_id],
        ['student_id',$student_id],
        ['subject_id',$subject_id]
        ])->first();

    	return $data;
    }

    public function partials(){
        $data = SmPartialResultStore::where('result_store_id',$this->id)->get();
        return $data;
    }






}
