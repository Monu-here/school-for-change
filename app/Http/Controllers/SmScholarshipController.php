<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SmScholarship;
use App\SmStudent;
use App\SmClass;
use App\SmFeesClass;

class SmScholarshipController extends Controller
{
    public function index(){
        $scholarship = SmScholarship::latest()->paginate(10);
        $class = SmClass::all();
        $fees = SmFeesClass::all();
        $students = SmStudent::all();
        return view('backEnd.scholarship.create',compact('students','scholarship','class','fees'));
    }

    public function store(Request $request){
        $scholarship = new SmScholarship();
        $scholarship->title = $request->title;
        if($request->amount != null){
            $scholarship->amount = $request->amount;
        }else{
            $scholarship->amount = 0;
        }
        if($request->percentage != null){
            $scholarship->percentage = $request->percentage;
        }else{
            $scholarship->percentage = 0;
        }
        $scholarship->class_id = $request->class_id;
        $scholarship->fee_id = $request->fee_id;
        $scholarship->student_id = $request->student_id;
        // dd($scholarship);
        $scholarship->save();
        return redirect()->back()->with('message-success', 'Scholarship scheme has been created successfully');
    }

    public function edit($scholarship_id){
        $scholarship_edit = SmScholarship::where('id',$scholarship_id)->first();
        $scholarship = SmScholarship::latest()->paginate(10);
        $students = SmStudent::all();
        $class = SmClass::all();
        $fees = SmFeesClass::all();
        return view('backEnd.scholarship.edit',compact('students','scholarship','scholarship_edit','class','fees'));
    }

    public function update(Request $request, $scholarship_id){
        $scholarship = SmScholarship::where('id',$scholarship_id)->first();
        $scholarship->title = $request->title;
        if($request->amount != null){
            $scholarship->amount = $request->amount;
        }else{
            $scholarship->amount = 0;
        }
        if($request->percentage != null){
            $scholarship->percentage = $request->percentage;
        }else{
            $scholarship->percentage = 0;
        }
        $scholarship->class_id = $request->class_id;
        $scholarship->fee_id = $request->fee_id;
        $scholarship->student_id = $request->student_id;
        // dd($scholarship);
        $scholarship->save();
        return redirect()->back()->with('message-success', 'Scholarship scheme has been updated successfully');
    }

    public function delete($scholarship_id){
        $scholarship = SmScholarship::where('id',$scholarship_id)->first();
        $scholarship->delete();
        return redirect()->back()->with('message-success', 'Scholarship scheme has been deleted successfully');
    }
}
