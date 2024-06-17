<?php

namespace App\Http\Controllers;

use DB;
use App\SmExam;
use App\SmClass;
use App\SmSection;
use App\SmStudent;
use App\SmSubject;
use App\SmExamType;
use App\SmExamSetup;
use App\SmMarkStore;
use App\ApiBaseMethod;
use App\SmResultStore;
use App\SmClassSection;
use App\SmAssignSubject;
use App\SmMarksGrade;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;


class SmExamController extends Controller
{
    public function __construct()
    {
        $this->middleware('PM');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $exams = SmExam::all();
        $exam = SmExam::where('id',2)->first();
        $exams_types = SmExamType::all();
        $classes = SmClass::where('active_status', 1)->get();
        $subjects = SmSubject::where('active_status', 1)->get();
        $sections = SmSection::where('active_status', 1)->get();
        return view('backEnd.examination.exam', compact('exam','exams', 'classes', 'subjects', 'exams_types', 'sections'));
    }


    public function exam_setup($id)
    {
        $exams = SmExam::where('exam_type_id',$id)->get();
        $exam_groups=[];
        foreach ($exams as $key => $exam) {
            if(!isset($exam_groups['class_'.$exam->class_id])){
                $exam_groups['class_'.$exam->class_id]=['group'=>[],'class'=>SmClass::find($exam->class_id)];
            }
            if(!isset($exam_groups['class_'.$exam->class_id]['group']['sec_'.$exam->section_id])){
                $exam_groups['class_'.$exam->class_id]['group']['sec_'.$exam->section_id]=['group'=>[],'section'=>SmSection::find($exam->section_id)];
            }
            array_push($exam_groups['class_'.$exam->class_id]['group']['sec_'.$exam->section_id]['group'],$exam);


        }
        // $exam_groups=$exams->groupBy('section_id');
        // dd($exam_groups);
        $exams_types = SmExamType::all();
        $exam=SmExamType::find($id);
        $classes = SmClass::where('active_status', 1)->get();
        $subjects = SmSubject::where('active_status', 1)->get();
        $sections = SmSection::where('active_status', 1)->get();
        $selected_exam_type_id = $id;

        return view('backEnd.examination.exam', compact('id','exams', 'classes', 'subjects', 'exams_types', 'sections','exam','exam_groups'));
    }



    public function exam_reset()
    {

        $exams = SmExam::all();
        SmExam::query()->truncate();


        $exams_types = SmExamType::all();
        SmExamType::query()->truncate();

        $exam_mark_stores = SmMarkStore::all();
        SmMarkStore::query()->truncate();

        $exam_results_stores = SmResultStore::all();
        SmResultStore::query()->truncate();

        SmExamSetup::query()->truncate();

        $classes = SmClass::where('active_status', 1)->get();
        $subjects = SmSubject::where('active_status', 1)->get();
        $sections = SmSection::where('active_status', 1)->get();
        return view('backEnd.examination.exam', compact('exams', 'classes', 'subjects', 'exams_types', 'sections'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $request->validate(
            [
                'class_ids' => 'required',
                'subjects_ids' => 'required|array',
                'exams_types' => 'required|array',
              
            ],
            [
                'class_ids.required' => 'The Class Field is required!',
                'subjects_ids.required' => 'At least one checkbox required!',
                'exams_types.required' => 'At least one checkbox required!--',
            ]
        );

       
        DB::beginTransaction();

        try {

            $sections = SmClassSection::where('class_id', $request->class_ids)->get();

         
            foreach ($request->exams_types as $exam_type_id) {

                foreach ($sections as $section) {


                    $subject_for_sections = SmAssignSubject::where('class_id', $request->class_ids)->where('section_id', $section->section_id)->get();


                    $eligible_subjects = [];

                    foreach ($subject_for_sections as $subject_for_section) {
                        $eligible_subjects[] = $subject_for_section->subject_id;
                    }


                    foreach ($request->subjects_ids as $subject_id) {

                        if (in_array($subject_id, $eligible_subjects)) {
                            $exam=SmExam::where([
                                ['subject_id',$subject_id],
                                ['class_id',$request->class_ids],
                                ['section_id',$section->section_id],
                                ['exam_type_id',$exam_type_id],
                            ])->first();
                            if($exam==null){
                                $exam = new SmExam();
                            }
                            $exam->isop = $request->filled('isop')?1:0;
                            $exam->exam_type_id = $exam_type_id;
                            $exam->class_id = $request->class_ids;
                            $exam->section_id = $section->section_id;
                            $exam->subject_id = $subject_id;
                            $exam->passmark=$request->totalpassmark;
                            $exam->exam_mark = $request->totalmark;
                            $exam->save();
                            $exam->toArray();


                            $exam_term_id = $exam->id;


                            $length = count($request->exam_title);


                            for ($i = 0; $i < $length; $i++) {

                                $ex_title = $request->exam_title[$i];
                                $ex_mark = $request->exam_mark[$i];
                                $ex_passmarks=$request->exam_pass_mark[$i];
                                $newSetupExam=SmExamSetup::where([
                                    ['subject_id',$subject_id],
                                    ['class_id',$request->class_ids],
                                    ['section_id',$section->section_id],
                                    ['exam_term_id',$exam_type_id],
                                    ['exam_id',$exam->id],
                                ])->first();

                                if($newSetupExam==null){
                                    $newSetupExam = new SmExamSetup();
                                }

                                $newSetupExam->exam_id = $exam->id;
                                $newSetupExam->class_id = $request->class_ids;
                                $newSetupExam->section_id = $section->section_id;
                                $newSetupExam->subject_id = $subject_id;
                                $newSetupExam->exam_term_id = $exam_type_id;
                                $newSetupExam->exam_title = $ex_title;
                                $newSetupExam->exam_mark = $ex_mark;
                                $newSetupExam->passmarks = $ex_passmarks;
                                $newSetupExam->passmark = $ex_passmarks;

                                $result = $newSetupExam->save();
                            } //end loop exam setup loop
                        }
                    }
                }
            }

            DB::commit();
            Toastr::success('Operation successful', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            dd($e->getMessage(), $e->errorInfo);
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $exams = SmExam::all();
        $exams_types = SmExamType::all();
        $exam = SmExam::find($id);
        $classes = SmClass::where('active_status', 1)->get();
        $subjects = SmAssignSubject::where('active_status', 1)->where('class_id', $exam->class_id)->where('section_id', $exam->section_id)->get();
        $sections = SmClassSection::where('class_id', $exam->class_id)->get();

        return view('backEnd.examination.examEdit', compact('exam', 'exams', 'classes', 'subjects', 'sections', 'exams_types'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            'exam_marks' => "required",
        ]);


        DB::beginTransaction();

        try {

            DB::statement('SET FOREIGN_KEY_CHECKS=0;');

            $exam = SmExam::find($id);
            $exam->exam_mark = $request->exam_marks;
            $exam->isop = $request->filled('isop')?1:0;
            $exam->save();

            SmExamSetup::where('exam_id', $id)->delete();
            $length = count($request->exam_title);

            for ($i = 0; $i < $length; $i++) {

                $ex_title = $request->exam_title[$i];
                $ex_mark = $request->exam_mark[$i];
                $ex_passmarks=$request->pass_mark[$i];
                $newSetupExam = new SmExamSetup();
                $newSetupExam->exam_id = $exam->id;
                $newSetupExam->exam_title = $ex_title;
                $newSetupExam->exam_mark = $ex_mark;
                $newSetupExam->passmark = $ex_passmarks;
                $newSetupExam->passmarks = $ex_passmarks;

                $newSetupExam->save();
            } //end loop exam setup loop


            DB::commit();
            Toastr::success('Operation successful', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('message-danger', 'Something went wrong, please try again');
        }
    }
    public function examSetup($id)
    {
        $exam = SmExam::find($id);

        $exams = SmExam::all();
        $classes = SmClass::where('active_status', 1)->get();
        $subjects = SmSubject::where('active_status', 1)->get();
        $sections = SmSection::where('active_status', 1)->get();
        return view('backEnd.examination.exam_setup', compact('exam', 'exams', 'classes', 'subjects', 'sections'));
    }


    public function examSetupStore(Request $request)
    {


        $class_id = $request->class;
        $section_id = $request->section;
        $subject_id = $request->subject;
        $exam_title = $request->name;
        $exam_term_id = $request->exam_term_id;

        $total_exam_mark = $request->total_exam_mark;
        $totalMark = $request->totalMark;

        if ($total_exam_mark == $totalMark) {
            $length = count($request->exam_title);
            for ($i = 0; $i < $length; $i++) {
                $ex_title = $request->exam_title[$i];
                $ex_mark = $request->exam_mark[$i];

                $newSetupExam = new SmExamSetup();
                $newSetupExam->class_id = $class_id;
                $newSetupExam->section_id = $section_id;
                $newSetupExam->subject_id = $subject_id;
                $newSetupExam->exam_term_id = $exam_term_id;
                $newSetupExam->exam_title = $ex_title;
                $newSetupExam->exam_mark = $ex_mark;
                $result = $newSetupExam->save();
                if ($result) {
                    Toastr::success('Operation successful', 'Success');
                    return redirect('exam');
                } else {
                    Toastr::error('Operation Failed', 'Failed');
                    return redirect()->back();
                }
            }
        } else {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {

        $id_key = 'exam_id';

        $tables = \App\tableList::getTableList($id_key);

        DB::beginTransaction();

        try {

            DB::statement('SET FOREIGN_KEY_CHECKS=0;');



            SmExamSetup::where('exam_id', $id)->delete();

            $delete_query = SmExam::destroy($id);

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                if ($delete_query) {
                    return ApiBaseMethod::sendResponse(null, 'Exam has been deleted successfully');
                } else {
                    return ApiBaseMethod::sendError('Something went wrong, please try again.');
                }
            } else {

                if ($delete_query) {
                    DB::commit();
                    Toastr::success('Operation successful', 'Success');
                    return redirect()->back();
                } else {
                    Toastr::error('Operation Failed', 'Failed');
                    return redirect()->back();
                }
            }
        } catch (\Illuminate\Database\QueryException $e) {
            $msg = 'This data already used in  : ' . $tables . ' Please remove those data first';

            return redirect()->back()->with('message-danger-delete', $msg);
        } catch (\Exception $e) {
            //dd($e->getMessage(), $e->errorInfo);
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function getClassSubjects(Request $request)
    {

        $subjects = SmAssignSubject::where('class_id', $request->id)->get();
        $subjects = $subjects->groupBy('subject_id');

        $assinged_subjects = [];
        foreach ($subjects as $key => $subject) {
            $assinged_subjects[] = SmSubject::find($key);
        }

        return response()->json($assinged_subjects);
    }

    public function subjectAssignCheck(Request $request)
    {

        $exam = [];
        $assigned_subjects = [];
        foreach ($request->exam_types as $exam_type) {
            $exam = SmExam::where('exam_type_id', $exam_type)->where('class_id', $request->class_id)->where('subject_id', $request->id)->first();

            if ($exam != "") {
                $exam_title = SmExamType::find($exam_type);

                $assigned_subjects[] = $exam_title->title;
            }
        }



        return response()->json($assigned_subjects);
    }

    public function data($id)
    {
        $exam=SmExam::where('id',$id)->first();
        // dd($exam);
        $subjectNames = SmSubject::where('id', $exam->subject_id)->first();


        $students = SmStudent::where('active_status', 1)->where('class_id', $exam->class_id)->where('section_id', $exam->section_id)->get();

   

        // if ($students->count() < 1) {
        //     return redirect()->back()->with('message-danger', 'Student is not found in according this class and section! Please add student in this section of that class.');
        // } else {

        // }
        $marks_entry_form = SmExamSetup::where('exam_id',$exam->id)->get();
        // dd($marks_entry_form);
        if ($marks_entry_form->count() > 0) {


            $number_of_exam_parts = count($marks_entry_form);

            return view('backEnd.examination.masks_register_create_min', compact('exam',  'students', 'subjectNames', 'number_of_exam_parts', 'marks_entry_form'));
        } else {
            return redirect()->back()->with('message-danger', 'No result found or exam setup is not done!');
        }
    }

    public function sheet1($exam,$class,$section,$type){
        // dd($request->all());
        
          
                $gpamap=[
                    'NG'=>'-',
                    'A+'=>'4.0',
                    'A'=>'3.6',
                    'B+'=>'3.2',
                    'B'=>'2.8',
                    'C+'=>'2.4',
                    'C'=>'2.0',
                    'D+'=>'1.6',
                    'D'=>'1.2',
                    'E'=>'0.8',
                ];
                $students=SmResultStore::where('exam_type_id',$exam)->where('class_id',$class)->where('section_id',$section)->select('student_id')->distinct()->get()->toArray();
                $datas=[];
                foreach($students as $student){
                    // dd($student);
                    $data=[];
                    $data['std']=SmStudent::find($student['student_id']);
                    
                    $marks=SmResultStore::join('sm_subjects','sm_result_stores.subject_id','=','sm_subjects.id')->where('sm_result_stores.exam_type_id',$exam)->where('sm_result_stores.student_id',$student['student_id'])->orderBy('sm_subjects.subject_code','ASC')->select('sm_result_stores.*')->get();
                    // dd($marks);
                    //for compulsary subject
                    $group=[];
                    foreach($marks->where('isop',0) as $mark){
                        $sub=$mark->subject;
                        if($sub->identifier!=null){
                            if(!isset($group['mark_'.$sub->identifier])){
                                $group['mark_'.$sub->identifier]=[];
                            }
                            array_push($group['mark_'.$sub->identifier],$mark);
                        }else{
                            if(!isset($group['mark_'.$sub->subject_code])){
                                $group['mark_'.$sub->subject_code]=[];
                            }
                            array_push($group['mark_'.$sub->subject_code],$mark);
                        }
                    }
                    
    
                    $group1=[];
                    $totalmaingp=0;
                    $totalmainch=0;
                    foreach ($group as $group_item) {
                        $totalgp=0;
                        $totalsmgp=0;
                        $totalch=0;
                        $c=0;
                        foreach($group_item as $item){
                            // dd($item);
                            $sub=$item->subject;
                            $totalsmgp+=$item->total_gpa_point;
                            $totalgp+=$item->total_gpa_point*$sub->credit_hour;
                            $totalch+=$sub->credit_hour;
                            $totalmaingp+=$item->total_gpa_point*$sub->credit_hour;
                            $totalmainch+=$sub->credit_hour;
                            $c+=1;
                        }
    
                        // $group_item[0]->finalgrade=$totalsmgp/$c;
                        $group_item[0]->finalgrade=$totalgp/$totalch;

                        $gpa=SmMarksGrade::where('gpa','<=',$group_item[0]->finalgrade)->orderBy('gpa','DESC')->first();
                        $group_item[0]->finalgradel=$gpa->grade_name;
                        $group_item[0]->finalgrade=$gpamap[ $gpa->grade_name];

                        $group_item[0]->gp=$totalgp;
                        $group_item[0]->cp=$totalch;
                        array_push($group1,$group_item);
                    }
                    $data['marks']=$group1;
                    // $data['gpa']=$totalmaingp/$totalmainch;

                    //for optional subbject 
                    $group_op=[];
                    foreach($marks->where('isop',1) as $mark){
                        $sub=$mark->subject;
                        if($sub->identifier!=null){
                            if(!isset($group_op['mark_'.$sub->identifier])){
                                $group_op['mark_'.$sub->identifier]=[];
                            }
                            array_push($group_op['mark_'.$sub->identifier],$mark);
                        }else{
                            if(!isset($group_op['mark_'.$sub->subject_code])){
                                $group_op['mark_'.$sub->subject_code]=[];
                            }
                            array_push($group_op['mark_'.$sub->subject_code],$mark);
                        }
                    }
                    $group2=[];
                    $totalmaingp2=0;
                    $totalmainch2=0;
                    // dd($group_op);
                    foreach ($group_op as $group_item) {
                        $totalgp=0;
                        $totalsmgp=0;
                        $totalch=0;
                        $c=0;
                        foreach($group_item as $item){
                            $sub=$item->subject;
                            $totalsmgp+=$item->total_gpa_point;
                            $totalgp+=$item->total_gpa_point*$sub->credit_hour;
                            $totalch+=$sub->credit_hour;
                            $totalmaingp2+=$item->total_gpa_point*$sub->credit_hour;
                            $totalmainch2+=$sub->credit_hour;
                            $c+=1;
                        }
                        // $group_item[0]->finalgrade=$totalsmgp/$c;
                        
                        $group_item[0]->finalgrade=$totalgp/$totalch;
                        $gpa=SmMarksGrade::where('gpa','<=',$group_item[0]->finalgrade)->orderBy('gpa','DESC')->first();
                        $group_item[0]->finalgradel=$gpa->grade_name;
                        $group_item[0]->finalgrade=$gpamap[ $gpa->grade_name];

                        $group_item[0]->gp=$totalgp;
                        $group_item[0]->cp=$totalch;
                        array_push($group2,$group_item);
                    }
                    $data['marks_op']=$group2;
                    // $data['gpa_op']= $totalmainch2==0?0:$totalmaingp2/$totalmainch2;
                    array_push($datas,$data);
                }
                // dd($datas);
                // for forms
                $exams = SmExamType::where('active_status', 1)->get();
                $classes = SmClass::where('active_status', 1)->get();

                // if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                //     $data = [];
                //     $data['exams'] = $exams->toArray();
                //     $data['classes'] = $classes->toArray();
                //     return ApiBaseMethod::sendResponse($data, null);
                // }

                $name=env('SCHOOL_NAME',"NAragram");
                $address=env('SCHOOL_ADDRESS',"bIRATNAGAR");
                if($type==0){
                    $section = SmSection::where('id',$section)->first();
                    return view('backEnd.reports.resultlist',compact('name','address','datas','exams','classes','section'));
                }else{
                    return view('backEnd.reports.multiple_student_report',compact('name','address','datas','exams','classes'));
                }
    
            
    }
    public function sheet($exam,$class,$section,$type){
        // dd($request->all());
        
          
                $gpamap=[
                    'NG'=>'-',
                    'A+'=>'4.00',
                    'A'=>'3.60',
                    'B+'=>'3.20',
                    'B'=>'2.80',
                    'C+'=>'2.40',
                    'C'=>'2.00',
                    'D+'=>'1.60',
                    'D'=>'1.20',
                    'E'=>'0.80',
                    'F'=>'0'
                ];
                $students=SmResultStore::where('exam_type_id',$exam)->where('class_id',$class)->where('section_id',$section)->select('student_id')->distinct()->get()->toArray();
                $datas=[];
                foreach($students as $student){
                    // dd($student);
                    $data=[];
                    $data['std']=SmStudent::find($student['student_id']);
                    
                    $marks=SmResultStore::join('sm_subjects','sm_result_stores.subject_id','=','sm_subjects.id')->where('sm_result_stores.exam_type_id',$exam)->where('sm_result_stores.student_id',$student['student_id'])->orderBy('sm_subjects.subject_code','ASC')->select('sm_result_stores.*','sm_subjects.subject_name as name','sm_subjects.subject_code as code','sm_subjects.credit_hour')->get();
                    //for compulsary subject
                    $group=[];
                    foreach($marks as $mark){
                        $sub=$mark->subject;
                        if($sub->identifier!=null){
                            if(!isset($group['mark_'.$sub->identifier])){
                                $group['mark_'.$sub->identifier]=[];
                            }
                            array_push($group['mark_'.$sub->identifier],$mark);
                        }else{
                            if(!isset($group['mark_'.$sub->subject_code])){
                                $group['mark_'.$sub->subject_code]=[];
                            }
                            array_push($group['mark_'.$sub->subject_code],$mark);
                        }
                    }
                        
                    $group1=[];
                  
                    // foreach ($group as $group_item) {
                    //     $totalgp=0;
                    //     $totalsmgp=0;
                    //     $totalch=0;
                    //     $totalmarks=0;
                    //     $grades=[];
                    //     $c=0;
                    //     $isop=false;
                    //     $isabs=false;
                    //     foreach($group_item as $item){
                    //         // dd($item);
                    //         $sub=$item->subject;
                    //         // dd($sub);
                    //         // $totalsmgp+=$item->total_gpa_point;
                    //         // $totalgp+=$item->total_gpa_point*$sub->credit_hour;
                    //         $totalch+=$sub->credit_hour;
                    //         $totalmarks+=$item->total_marks;
                    //         array_push($grades,$item->is_absent==1?'ABS':$item->total_gpa_grade);
                    //         if(!$isop){
                    //             $isop=$item->isop!=0;
                    //         }
                    //         if(!$isabs){
                    //             $isabs=$item->is_absent!=0;
                    //         }
                    //         $c+=1;
                    //     }
    
                    //     // $group_item[0]->finalgrade=$totalsmgp/$c;
                    //     // $group_item[0]->finalgrade=$totalgp/$totalch;
                    //     // $group_item[0]->totalmarks=$totalmarks;

                    //     // $gpa=SmMarksGrade::where('gpa','<=',$group_item[0]->finalgrade)->orderBy('gpa','DESC')->first();
                    //     // $group_item[0]->finalgradel=$gpa->grade_name;
                    //     // $group_item[0]->finalgrade=$gpamap[ $gpa->grade_name];

                    //     // $group_item[0]->gp=$totalgp;
                    //     // $group_item[0]->cp=$totalch;
                    //     $per=($totalmarks/100) * 100;
                    //     $_data=(object)[
                    //         "code"=>$group_item[0]->subject->subject_code,
                    //         "name"=>$group_item[0]->subject->subject_name,
                    //         'credithour'=>$totalch,
                    //         "grades"=>$grades,
                    //         'totalmarks'=>$totalmarks,
                    //         "per"=>$per ,
                    //         "isop"=>$isop ,
                    //         "isabs"=>$isabs ,
                    //         'finalgrade'=>SmMarksGrade::where('percent_upto','>=',(int)$per)->where('percent_from','<=',(int)$per)->first()
                    //     ];
                    //     // dd($_data);
                    //     // array_push($group1,$group_item);
                    //     array_push($group1,$_data);
                    // }
                    // $data['marks']=$group1;

                    $data['marks_old']=$group;
                    // dd($data);
                    array_push($datas,$data);

                }
                // dd($datas);
            
                $exams = SmExamType::where('active_status', 1)->get();
                $classes = SmClass::where('active_status', 1)->get();

                $grades=DB::table('sm_marks_grades')->get();

                $name=env('SCHOOL_NAME',"NAragram");
                $address=env('SCHOOL_ADDRESS',"bIRATNAGAR");
                if($type==0){
                    // dd($datas[0]);
                    $section = SmSection::where('id',$section)->first();
                    return view('backEnd.reports.resultlist',compact('name','address','datas','exams','classes','section'));
                }else{
                    return view('backEnd.reports.min_multiple_student_report',compact('name','address','datas','exams','classes','grades'));
                }
    
            
    }
}
