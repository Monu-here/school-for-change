@extends('backEnd.master')
@section('mainContent')
<style>
    th{
        border: 1px solid black;
        text-align: center;
    }
    td{
        text-align: center;
    }
    td.subject-name{
        text-align: left;
        padding-left: 10px !important;
    }
    table.marksheet{
        width: 100%;
        border: 1px solid #828bb2 !important;
    }
    table.marksheet th{
        border: 1px solid #828bb2 !important;
    }
    table.marksheet td{
        border: 1px solid #828bb2 !important;
    }
    table.marksheet thead tr{
        border: 1px solid #828bb2 !important;
    }
    table.marksheet tbody tr{
        border: 1px solid #828bb2 !important;
    }

    .studentInfoTable{
        width: 100%;
        padding: 0px !important;
    }

    .studentInfoTable td{
        padding: 0px !important;
        text-align: left;
        padding-left: 15px !important;
    }
    h4{
        text-align: left !important;
    }
</style>
<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('lang.mark_sheet_report') @lang('lang.student') </h1>
            <div class="bc-pages">
                <a href="{{url('dashboard')}}">@lang('lang.dashboard')</a>
                <a href="#">@lang('lang.reports')</a>
                <a href="#">@lang('lang.mark_sheet_report') @lang('lang.student')</a>
            </div>
        </div>
    </div>
</section>
<section class="admin-visitor-area">
    <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-8 col-md-6">
                    <div class="main-title">
                        <h3 class="mb-30">@lang('lang.select_criteria')</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                @if(session()->has('message-success') != "")
                    @if(session()->has('message-success'))
                    <div class="alert alert-success">
                        {{ session()->get('message-success') }}
                    </div>
                    @endif
                @endif
                 @if(session()->has('message-danger') != "")
                    @if(session()->has('message-danger'))
                    <div class="alert alert-danger">
                        {{ session()->get('message-danger') }}
                    </div>
                    @endif
                @endif
                <div class="white-box">
                    {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'mark_sheet_report_student', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'search_student']) }}
                        <div class="row">
                            <input type="hidden" name="url" id="url" value="{{URL::to('/')}}">
                            
                            <div class="col-lg-3 mt-30-md">
                                <select class="w-100 bb niceSelect form-control{{ $errors->has('exam') ? ' is-invalid' : '' }}" name="exam">
                                    <option data-display="@lang('lang.select_exam') *" value="">@lang('lang.select_exam') *</option>
                                    @foreach($exams as $exam)
                                        <option value="{{$exam->id}}" {{isset($exam_id)? ($exam_id == $exam->id? 'selected':''):''}}>{{$exam->title}}</option>
                                       
                                    @endforeach
                                </select>
                                @if ($errors->has('exam'))
                                <span class="invalid-feedback invalid-select" role="alert">
                                    <strong>{{ $errors->first('exam') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-lg-3 mt-30-md">
                                <select class="w-100 bb niceSelect form-control {{ $errors->has('class') ? ' is-invalid' : '' }}" id="select_class" name="class">
                                    <option data-display="@lang('lang.select_class') *" value="">@lang('lang.select_class') *</option>
                                    @foreach($classes as $class)
                                    <option value="{{$class->id}}" {{isset($class_id)? ($class_id == $class->id? 'selected':''):''}}>{{$class->class_name}}</option>
                                   
                                    @endforeach
                                </select>
                                @if ($errors->has('class'))
                                <span class="invalid-feedback invalid-select" role="alert">
                                    <strong>{{ $errors->first('class') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-lg-3 mt-30-md" id="select_section_div">
                                <select class="w-100 bb niceSelect form-control{{ $errors->has('section') ? ' is-invalid' : '' }} select_section" id="select_section" name="section">
                                    <option data-display="Select section *" value="">Select section *</option>
                                </select>
                                @if ($errors->has('section'))
                                <span class="invalid-feedback invalid-select" role="alert">
                                    <strong>{{ $errors->first('section') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-lg-3 mt-30-md" id="select_student_div">
                                <select class="w-100 bb niceSelect form-control{{ $errors->has('student') ? ' is-invalid' : '' }}" id="select_student" name="student">
                                    <option data-display="@lang('lang.select_student') *" value="">@lang('lang.select_student') *</option>
                                </select>
                                @if ($errors->has('student'))
                                <span class="invalid-feedback invalid-select" role="alert">
                                    <strong>{{ $errors->first('student') }}</strong>
                                </span>
                                @endif
                            </div>

                            
                            <div class="col-lg-12 mt-20 text-right">
                                <button type="submit" class="primary-btn small fix-gr-bg">
                                    <span class="ti-search"></span>
                                    @lang('lang.search')
                                </button>
                            </div>
                        </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
</section>


@if(isset($is_result_available))
@php 
    $generalSetting= App\SmGeneralSettings::find(1);
    if(!empty($generalSetting)){
        $school_name =$generalSetting->school_name;
        $site_title =$generalSetting->site_title;
        $school_code =$generalSetting->school_code;
        $address =$generalSetting->address;
        $phone =$generalSetting->phone; 
    }

@endphp
                  
<section class="student-details">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-lg-4 no-gutters">
                <div class="main-title">
                    <h3 class="mb-30 mt-30">@lang('lang.mark_sheet_report')</h3>
                    <span class="primary-btn small fix-gr-bg" onclick="printDiv('printdiv');">Print</span>

                </div>
            </div>
            <div class="col-lg-8 pull-right">
                {{-- <div class="main-title">
                     <div class="print_button pull-right mt-30">
                        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'url' => 'mark-sheet-report/print', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'mark_sheet_report']) }}
                          <input type="hidden" name="exam" value="{{$input['exam_id']}}">
                          <input type="hidden" name="class" value="{{$input['class_id']}}">
                          <input type="hidden" name="section" value="{{$input['section_id']}}"> 
                          <input type="hidden" name="student" value="{{$input['student_id']}}"> 
                          <button type="submit" class="primary-btn small fix-gr-bg">  <i class="ti-printer"> </i> Print </button> 
                        {!! Form::close() !!}
                        
                    </div>  
                </div> --}}
            </div> 
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="white-box">
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="single-report-admit">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="d-flex">
                                            <div>
                                                <img class="logo-img" src="{{url($generalSetting->logo) }}" alt=""> 
                                            </div>
                                            <div class="ml-30">
                                                <h3 class="text-white"> {{isset($school_name)?$school_name:'Infix School Management ERP'}} </h3>
                                                <p class="text-white mb-0"> {{isset($address)?$address:'Infix School Adress'}} </p>
                                            </div>
                                            
                                        </div>
                                        <div>
                                            <img class="report-admit-img" src="{{asset($studentDetails->student_photo)}}" width="100" height="100" alt="{{asset($studentDetails->student_photo)}}">
                                        </div> 
                                    </div>
                                    <div class="card-body" id="printdiv">
                                        <div class="row text-center">
                                            <div class="col-md-2">
                                                logo
                                            </div>
                                            <div class="col-md-8">
                                                <h5>GOVERNMENT OF NEPAL</h5>
                                                <h5>NATIONAL EXAMINATIONS BOARD</h5>
                                                <h5 style="font-size:25px;">SCHOOL LEAVING CERTIFICATE EXAMINATION <br> GRADE-SHEET</h5>
                                            </div>
                                            <div class="col-md-2">
                                                logo
                                            </div>
                                        </div>
                                       <div class="p-3">
                                           <h5>THE GRADE(S) SECURED BY : {{$student_detail->full_name}}<br>
                                               DATE OF BIRTH : {{$student_detail->date_of_birth}} <br>
                                               REGISTRATION NO. : {{$student_detail->admission_no}} SYMBOL NO. : {{$student_detail->roll_no}} GRADE : {{$class_name->class_name}} <br>
                                               OF...............................................................................................................................................................................................<br>
                                           <span>IN THE EXAMINATION CONDUCTED BY THE NATIONAL EXAMINATIONS BOARD IN.................... ARE GIVEN BELOW.</h5>
                                       </div>
                                        <div class="col-md-12">
        
                                        <table class="w-100 mt-30 mb-20 table   table-bordered marksheet">
                                            <thead>
                                                <tr>
                                                    <th rowspan="2">S.N</th>
                                                    <th rowspan="2">Subject Name</th>
                                                    <th colspan="2">Full Marks</th>
                                                    <th colspan="2">Pass Marks</th>
                                                    <th colspan="2">Obtain Marks</th>
                                                    <th rowspan="2">Total</th>
                                                    <th rowspan="2">Letter Grade</th>
                                                    <th rowspan="2">Grade Point</th>
                                                    
                                                </tr>
                                                <tr>
                                                    <th>Theory</th>
                                                    <th>Practical</th>
                                                    <th>Theory</th>
                                                    <th>Practical</th>
                                                    <th>Theory</th>
                                                    <th>Practical</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            @php $sum_gpa= 0;  $resultCount=1; $subject_count=1; $tota_grade_point=0; $this_student_failed=0; @endphp
                                            @foreach($subjects as $data) 
                                                <tr>
                                                    <?php
                                                        $storemarks=App\SmAssignSubject::getMarkStore($student_detail->id, $data->subject_id, $class_id, $section_id, $exam_type_id);
                                                    ?>
                                                    <td>{{$subject_count++}}</td>
                                                    <td class="subject-name">{{$data->subject->subject_name}} </td>
                                                    @if($storemarks==null)
                                                     <?php $examdata = App\SmExam::where([['class_id',$class_id],['section_id',$section_id],['subject_id',$data->subject_id],['exam_type_id',$exam_type_id]])->first(); 
                                                     $metadata = $examdata->GetExamSetup;
                                                     ?>
                                                        <td>{{$metadata[0]!=null?$metadata[0]->exam_mark:"-"}}</td>
                                                        <td>{{$metadata[1]!=null?$metadata[1]->exam_mark:"-"}}</td>
                                                        <td>{{$metadata[0]!=null?$metadata[0]->passmark:"-"}}</td>
                                                        <td>{{$metadata[1]!=null?$metadata[1]->passmark:"-"}}</td>
                                                        <td>-</td><td>-</td><td>-</td><td>-</td><td>-</td>
                                                    @else
                                                        <?php
                                                            $partialstoremarks=$storemarks->partials();
                                                            // print_r($partialstoremarks);
                                                            $count=$partialstoremarks->count();
                                                        ?>
                                                        @if($count==0)
                                                        <td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td>

                                                        @elseif($count==1)
                                                            <?php $metadata=$partialstoremarks->values()->get(0)->fullMark();?>
                                                        <td>{{ $metadata->exam_mark }}</td><td>-</td>
                                                        <td>{{ $metadata->passmark }}</td><td>-</td>
                                                        <td>{{$partialstoremarks[0]->marks}}</td><td>-</td>
                                                        <td>{{$storemarks->total_marks}}</td>
                                                        <td>{{$storemarks->total_gpa_grade}}</td>
                                                        <td>{{$storemarks->total_gpa_point}}</td>
                                                       
                                                        @else
                                                        <?php 
                                                            $metadata1=$partialstoremarks->values()->get(0)->fullMark();
                                                            $metadata2=$partialstoremarks->values()->get(1)->fullMark();
                                                        ?>
                                                        <td>{{ $metadata1->exam_mark }}</td>
                                                        <td>{{ $metadata2->exam_mark }}</td>
                                                        <td>{{ $metadata1->passmark }}</td>
                                                        <td>{{ $metadata2->passmark }}</td>
                                                        <td>{{$partialstoremarks[0]->marks}}</td>
                                                        <td>{{$partialstoremarks[1]->marks}}</td>
                                                        <td>{{$storemarks->total_marks}}</td>
                                                        <td>{{$storemarks->total_gpa_grade}}</td>
                                                        <td>{{$storemarks->total_gpa_point}}</td>
                                                        
                                                        @endif
                                                    @endif
                                                    
                                                </tr>

                                            @endforeach

                                            </tbody>
                                        </table>
                                            
                                        <table class="w-100 mt-30 mb-20 table table-bordered marksheet">
                                            <thead>
                                                <tr>
                                                    <th>Code</th>
                                                    <th>Subject</th>
                                                    <th>Credit Hour</th>
                                                    <th>Grade Point</th>
                                                    <th>Grade</th>
                                                    <th>Final Grade</th>
                                                    <th>Remarks</th>
                                                </tr>
                                                <tbody>
                                                    @foreach ($subjects as $data)
                                                        <tr>
                                                            <td>{{ $data->subject->subject_code }}</td>
                                                            <td>{{$data->subject->subject_name}}</td>
                                                            <td>{{$data->subject->credit_hour}}</td>
                                                            <td>{{$storemarks->total_gpa_point}}</td>
                                                            <td>{{$storemarks->total_gpa_grade}}</td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </thead>
                                        </table>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <p class="result-date">
                                                    @php
                                                     $data = App\SmMarkStore::select('created_at')->where([
                                                        ['student_id',$student_detail->id],
                                                        ['class_id',$class_id],
                                                        ['section_id',$section_id],
                                                        ['exam_term_id',$exam_type_id],
                                                    ])->first();

                                                    @endphp
                                                    Date of Publication of Result : <b> {{date_format(date_create($data->created_at),"F j, Y, g:i a")}}</b>
                                                </p>
                                            </div>
                                        </div>


                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endif
            

<script>
    function printDiv(id)
    {
        var divToPrint=document.getElementById(id);
        var newWin=window.open('Report','_blank');
        newWin.document.open();
        newWin.document.write('<html><head><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous"><link rel="stylesheet" href="{{ asset("backEnd/css/print.css") }}"></head><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');
        newWin.document.close();

    }
</script>
@endsection
