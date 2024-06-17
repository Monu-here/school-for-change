<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SmClass;
use App\SmFeesClass;

class SmFeesByLavelController extends Controller
{
    public function index(){
        $fees = SmFeesClass::latest()->paginate(10);
        $class = SmClass::all();
        return view('backEnd.feesCollection.feesbyclass',compact('class','fees'));
    }

    public function store(Request $request){
        $fees = new SmFeeSClass();
        $fees->text = $request->title;
        $fees->amount = $request->amount;
        $fees->class_id = $request->class_id;
        $fees->istaxable = $request->istaxable;
        $fees->istransport = $request->istransport;
        $fees->save();
        // dd($fees);
        return redirect()->back()->with('message-success', 'New fee has been created successfully');
    }

    public function delete($fee_id){
        $fee = SmFeeSClass::where('id',$fee_id)->first();
        $fee->delete();
        return redirect()->back()->with('message-success', 'Fees has been deleted successfully');
    }
}
