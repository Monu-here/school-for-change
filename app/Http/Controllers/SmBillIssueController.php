<?php

namespace App\Http\Controllers;

use App\BankDeposite;
use App\Bill;
use App\ChequeDeposite;
use App\SmBillIssue;
use Illuminate\Http\Request;
use App\SmClass;
use App\SmClassSection;
use App\SmSection;
use App\SmFeesClass;
use App\SmGeneralSettings;
use App\SmRoute;
use App\SmScholarship;
use App\SmStudent;
use App\SmBillIssueItem;
use App\SmFiscalYear;
use App\SmKhaltiPayment;
use App\SmParent;
use App\TempBill;

class SmBillIssueController extends Controller
{
    public function index()
    {
        $class = SmClass::all();
        return view('backEnd.bills.create', compact('class'));
    }

    public function getSection($class_id)
    {
        $section = SmClassSection::where('class_id', $class_id)->get();
        $sections = [];
        foreach ($section as  $value) {
            $s = SmSection::find($value->section_id);
            array_push($sections, ['id' => $s->id, 'name' => $s->section_name]);
        }
        return response()->json($sections);
    }


    public function getFees($class_id)
    {
        $fee = SmFeesClass::where('class_id', $class_id)->select('id', 'text')->get();
        return response()->json($fee);
    }

    // student get by class id
    public function getStudent($class_id)
    {
        $student = SmStudent::where('class_id', $class_id)->select('id', 'full_name')->get();
        return response()->json($student);
    }


    // studnet get By section id
    public function getStudentBySection($class_id, $section_id)
    {
        $student = SmStudent::where('class_id', $class_id)->where('section_id', $section_id)->select('id', 'full_name')->get();
        // dd($student);
        return response()->json($student);
    }

    // get fee rate
    public function getFeeTypeRate($fee_id)
    {
        $fee_rate = SmFeesClass::where('id', $fee_id)->select('id', 'amount')->first();
        // dd($fee_rate);
        return response()->json($fee_rate);
    }

    public function creditBillSave(Request $request)
    {
        $request->validate([
            'feetitle' => 'required',
            'student_id' => 'required'
        ]);
        $student_ids = $request->student_id;
        $items = count($request->fee_id);
        $setting = SmGeneralSettings::first();
        $usetax = env('TAX_USETAX', false);
        $taxpercentage = env("TAX_PERCENTAGE", 1);

        $academic_id = $setting->session_id;

        $stdpays = [];

        foreach ($student_ids as  $student_id) {
            $total = 0;
            $taxable = 0;
            $tax = 0;
            $student = SmStudent::find($student_id);
            $stdpay = new SmBillIssue();
            $stdpay->academicyear_id = $academic_id;
            $stdpay->student_id = $student_id;
            $stdpay->save();
            for ($i = 0; $i < $items; $i++) {
                $fee = SmFeesClass::find($request->fee_id[$i]);
                $price = $request->rate[$i];
                $title = $request->feetitle[$i];
                $qty = $request->qty[$i];

                if ($fee->istransport) {
                    $route = SmRoute::find($student->route_id);
                    if ($route != null) {
                        $price = $route->far;
                    } else {
                        continue;
                    }
                }


                $scholorship = SmScholarship::where('fee_id', $fee->id)->where("student_id", $student_id)->first();
                if ($scholorship != null) {
                    if ($scholorship->percentage == 1) {
                        $price -= $price * $scholorship->amount / 100;
                    } else {
                        $price -= $scholorship->amount;
                    }
                }

                $stdpayitem = new SmBillIssueItem();
                $stdpayitem->title = $title;
                $stdpayitem->amount = $price;
                $stdpayitem->qty = $qty;
                $stdpayitem->total = $price * $qty;
                if ($fee->istaxable && $usetax) {
                    $stdpayitem->taxable = $stdpayitem->total;
                    $tax += $stdpayitem->taxable * $taxpercentage / 100;
                } else {
                    $stdpayitem->taxable = 0;
                    $tax += 0;
                }
                $stdpayitem->fee_id = $fee->id;
                $stdpayitem->bill_id = $stdpay->id;
                $stdpayitem->pay = 0;
                $stdpayitem->save();
                $total += $stdpayitem->total;
                $taxable += $stdpayitem->taxable;
            }
            $stdpay->amount = $total;
            $stdpay->taxable = $taxable;
            $stdpay->taxamount = $tax;

            if ($usetax) {
                $stdpay->total = $total + $tax;
            } else {
                $stdpay->total = $total;
            }
            $stdpay->due = $stdpay->total;
            $stdpay->date = $request->date;

            $stdpay->previousdue = SmBillIssue::where('student_id', $student_id)->where('due', '>', '0')->sum('due');
            $stdpay->save();
            array_push($stdpays, $stdpay);
        }
        return redirect()->back()->with('message-success', 'Credit bill has been created successfully !');
        // dd($stdpays);
    }


    ///Generate Bill When Payment
    public function generateBill(Request $request)
    {
        $student_id = $request->student_id;
        $amount = $request->amount;
        
        $temp = new TempBill();
        $temp->student_id = $student_id;
        $temp->total = $amount;
        $temp->type = $request->payment_type;
        $temp->save();
        return response()->json($temp->id);
    }

    // payment success controller
    public function paymentKhaltiSuccess(Request $request)
    {

        $temp_id = $request->product_identity;
        $temp_bill = TempBill::where('id', $temp_id)->first();

        $args = http_build_query(array(
            'token' => $request->token,
            'amount'  => $temp_bill->total*100
        ));

        $url = "https://khalti.com/api/v2/payment/verify/";

        # Make the call using API.
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $headers = ['Authorization: Key ' . config('khalti.secert_key')];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // Response
        $response = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        $str="";
        if ($status_code == 200) {
           
            // bill save
                $type = $request->type;
                $bill = new Bill();

                $bill->student_id = $temp_bill->student_id;
                $bill->total = $temp_bill->total;
                $bill->amount = 0;
                $bill->taxable = 0;
                $bill->tax = 0;
                $student = SmStudent::where('id', $temp_bill->student_id)->first();
                if ($type == 'parent') {
                    $bill->customer_name = $student->parents->fathers_name;
                    $bill->customer_phone = $student->parents->fathers_mobile;
                    $bill->customer_address = $student->parents->guardians_address;
                    $bill->customer_pan = "";
                } else {
                    $bill->customer_name = $student->full_name;
                    $bill->customer_phone = $student->mobile;
                    $bill->customer_address = $student->current_address;
                    $bill->customer_pan = "";
                }

                $bill->student_name = $student->full_name;
                $bill->student_rollno = $student->roll_no;
                $bill->student_class = $student->className->class_name;
                $bill->student_regno = $student->id;
                $fiscalyear = SmFiscalyear::where('is_default', 1)->first();
                if ($fiscalyear == null) {
                    abort(404, 'No Fiscal Year Set');
                }
                $bill->fiscalyear_id = $fiscalyear->id;
                $bill->fiscal_year = $fiscalyear->name;
                $bill->billno = "";
                $bill->printed_by = "";
                $bill->date = date("Y-m-d");
                

            // end bill save

            $totalamt = 0;
            $totaltaxable = 0;
            $totaltax = 0;
            $tempamt = $bill->total;
            foreach (SmBillIssue::where('student_id', $bill->student_id)->get() as $billissue) {
                foreach (SmBillIssueItem::where('bill_id',$billissue->id)->whereColumn('total', '>', 'pay')->get() as $bi) {
                    if ($tempamt <= 0) {
                        break;
                    }
                    $due = $bi->total - $bi->pay;
                    $taxable = 0;
                    $tax = 0;
                    if ($bi->taxable > 0) {
                        $taxable = $due;
                        $tax = $taxable * 0.01;
                    }
                    $ttdue = $due + $tax;

                    if ($tempamt > $ttdue) {
                        $bi->pay = $bi->total;
                        $bi->save();
                    } else if ($tempamt < $ttdue) {
                        if ($tax > 0) {
                            $due = round($tempamt / 1.01, 2);
                            $taxable = $due;
                            $tax = $tempamt - $due;
                            $bi->pay += $due;
                        } else {
                            $due = $tempamt;
                            $taxable = 0;
                            $tax = 0;
                        }
                        $bi->pay += $due;
                        $bi->save();
                    } else {
                        $bi->pay = $bi->total;
                        $bi->save();
                    }
                    $totalamt += $due;
                    $tempamt -= $due;
                    $totaltaxable += $taxable;
                    $totaltax += $tax;
                }
            }
            $bill->amount = $totalamt;
            $bill->taxable = $totaltaxable;
            $bill->tax = $totaltax;
            $bill->is_active = 1;
            $bill->generateBillno();
            
            $res = new SmKhaltiPayment();
            $res->idx = $request->idx;
            $res->token = $request->token;
            $res->amount = $bill->total;
            $res->bill_no = $bill->billno;
            $res->fiscalyear_id = $bill->fiscalyear_id;
            $res->status = 1;
            $res->save();
            $bill->payment_type = 3;
            $bill->payment_id = $res->id;
            $bill->save();
            return response(1, 200);
        } else {
            abort(404, 'Payment Cannot be verified');
        }
    }

    // bill pay through 
    public function billPayByAdmin(Request $request){
        if($request->payment_type == 0){

        }else if($request->payment_type == 1){
            $request->validate([
                'bank_name' => 'required',
                'acount_no' => 'required',
                'date' => 'required',
                'voucher_no' => 'required'
            ]);
            $paytype = new BankDeposite();
            $paytype->bank_name = $request->bank_name;
            $paytype->acount_no = $request->acount_no;
            $paytype->date = $request->date;
            $paytype->voucher_no = $request->voucher_no;
            $paytype->is_varify = $request->is_verify;
            $paytype->save();
            // dd($paytype);
        }else{
            $request->validate([
                'bank_name' => 'required',
                'acount_no' => 'required',
                'date' => 'required',
                'cheque_no' => 'required'
            ]);
            $paytype = new ChequeDeposite();
            $paytype->bank_name = $request->bank_name;
            $paytype->acount_no = $request->acount_no;
            $paytype->date = $request->date;
            $paytype->cheque_no = $request->cheque_no;
            $paytype->is_varify = $request->is_verify;
            $paytype->save();
        }
        // bill save
        $bill = new Bill();
        $bill->student_id = $request->student_id;
        $bill->total = $request->total;
        $bill->amount = 0;
        $bill->taxable = 0;
        $bill->tax = 0;
        $student = SmStudent::where('id', $request->student_id)->first();
        // dd($student->full_name);
            $bill->customer_name = $student->full_name;
            $bill->customer_phone = $student->mobile;
            $bill->customer_address = $student->current_address;
            $bill->customer_pan = "";
        $bill->student_name = $student->full_name;
        $bill->student_rollno = $student->roll_no;
        $bill->student_class = $student->className->class_name;
        $bill->student_regno = $student->id;
        $fiscalyear = SmFiscalyear::where('is_default', 1)->first();
        if ($fiscalyear == null) {
            abort(404, 'No Fiscal Year Set');
        }
        $bill->fiscalyear_id = $fiscalyear->id;
        $bill->fiscal_year = $fiscalyear->name;
        $bill->billno = "";
        $bill->printed_by = "";
        $bill->date = date("Y-m-d");
    // end bill save

    // reduce amount form due
    $totalamt = 0;
        $totaltaxable = 0;
        $totaltax = 0;
        $tempamt = $bill->total;
        foreach (SmBillIssue::where('student_id', $bill->student_id)->get() as $billissue) {
            foreach (SmBillIssueItem::where('bill_id',$billissue->id)->whereColumn('total', '>', 'pay')->get() as $bi) {
                if ($tempamt <= 0) {
                    break;
                }
                $due = $bi->total - $bi->pay;
                $taxable = 0;
                $tax = 0;
                if ($bi->taxable > 0) {
                    $taxable = $due;
                    $tax = $taxable * 0.01;
                }
                $ttdue = $due + $tax;

                if ($tempamt > $ttdue) {
                    $bi->pay = $bi->total;
                    $bi->save();
                } else if ($tempamt < $ttdue) {
                    if ($tax > 0) {
                        $due = round($tempamt / 1.01, 2);
                        $taxable = $due;
                        $tax = $tempamt - $due;
                        $bi->pay += $due;
                    } else {
                        $due = $tempamt;
                        $taxable = 0;
                        $tax = 0;
                    }
                    $bi->pay += $due;
                    $bi->save();
                } else {
                    $bi->pay = $bi->total;
                    $bi->save();
                }
                $totalamt += $due;
                $tempamt -= $due;
                $totaltaxable += $taxable;
                $totaltax += $tax;
            }
        }
        $bill->amount = $totalamt;
        $bill->taxable = $totaltaxable;
        $bill->tax = $totaltax;
        $bill->is_active = 1;
        $bill->generateBillno();
        
        $bill->payment_type = $request->payment_type;
        $bill->payment_id = $request->payment_type;
        $bill->save();
        // echo 'hhh';
        return redirect()->back();
    //  end of reduece  
    }


    // esewa integration 

    public function esewaPay(){
        return view('backEnd.esewa.page');
    }
}
