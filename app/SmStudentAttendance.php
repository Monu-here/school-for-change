<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SmStudentAttendance extends Model
{
    protected $fillable =[
        'attendance_type'
    ];

    public function studentInfo(){
    	return $this->belongsTo('App\SmStudent', 'student_id', 'id');
    }
}
