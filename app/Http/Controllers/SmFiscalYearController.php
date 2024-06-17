<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SmFiscalYear;

class SmFiscalYearController extends Controller
{
    public function index(){
        $fiscals = SmFiscalYear::latest()->paginate(10);
        return view('backEnd.fiscal.create',compact('fiscals'));
    }

    public function store(Request $request){
        
        if($request->is_default){
            $default = SmFiscalYear::where('is_default','=',1)->first(); 
            if($default != null){
                $default->is_default = 0;
                $default->save();
            }
        }

        $year = new SmFiscalYear();
        $year->name = $request->title;
        $year->start_date = $request->start_date;
        $year->end_date = $request->end_date;
        $year->is_active = $request->is_active;
        $year->is_default = $request->is_default;
        $year->save();
        return redirect()->back()->with('message-success','Fiscal year created succefully');
        // dd($year);
    }

    public function edit($id){
        $fiscals = SmFiscalYear::latest()->paginate(10);
        $fiscal = SmFiscalYear::where('id',$id)->first();
        return view('backEnd.fiscal.edit',compact('fiscals','fiscal'));
    }


    public function update(Request $request, $id){
        
        $year = SmFiscalYear::where('id',$id)->first();
        if($request->is_default){
            $default = SmFiscalYear::where('is_default','=',1)->first(); 
            if($default != null){
                $default->is_default = 0;
                $default->save();
            }
        }

        $year->name = $request->title;
        $year->start_date = $request->start_date;
        $year->end_date = $request->end_date;
        $year->is_active = $request->is_active;
        $year->is_default = $request->is_default;
        $year->save();
        return redirect()->back()->with('message-success','Fiscal year created succefully');
    }
}
