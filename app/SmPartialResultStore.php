<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SmPartialResultStore extends Model
{
    //
    public function resultStore(){
        return $this->belongsTo('App\SmResultStore','result_store_id');
    }

    public function fullMark(){
        $markstore = SmMarkStore::find($this->mark_store_id);
        $es = SmExamSetup::find($markstore->exam_setup_id);
        return $es;
    }
}
