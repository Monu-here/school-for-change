@extends('backEnd.master')
@section('mainContent')
<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('lang.exam')</h1>
            <div class="bc-pages">
                <a href="{{url('dashboard')}}">@lang('lang.dashboard')</a>
                <a href="#">@lang('lang.examinations')</a>
                <a href="/exam-type">@lang('lang.exam')</a>
                <a href="/exam-marks-setup/{{$exam->id}}">{{$exam->title}}</a>

            </div>
        </div>
    </div>
</section>
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="white-box">
        <h1 class="text-center">
        {{$exam->title}}
        </h1>
    </div>
    @php
        $haspermission=in_array(215, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1 ;
    @endphp
    @if($haspermission)
        <form class="white-box mt-4" action="{{url('exam')}}" method="POST" enctype="multipart/form-data" onsubmit='return checkfornull()'>
           @csrf
            <div class="row">
                <input type="hidden" name="exams_types[]" value="{{$exam->id}}"/>

                <div class="col-md-6">
                    <select class="w-100 bb niceSelect form-control" name="class_ids" id="exam_class" required>
                        <option data-display="select class *">select class *</option>
                        @foreach ($classes as $class)
                            <option value="{{$class->id}}">{{$class->class_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6" id="exam_subejct">
                    
                </div>
               
            </div>

            <hr>
            <div class="row">
                <div class="col-lg-12">
                    <div class="white-box mt-10">
                        <div class="row">
                             <div class="col-lg-10">
                                <div class="main-title">
                                    <h2>Marks Distribution </h2>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <button type="button" class="primary-btn icon-only fix-gr-bg" onclick="addRowMark();" id="addRowBtn">
                                <span class="ti-plus pr-2"></span></button>
                            </div>
                        </div>
                        <hr>

                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif


                        <table class="table" id="productTable">
                            <thead>
                                <tr>
                                  <th>Title</th>
                                  <th>Fullmarks</th>
                                  <th>Passmarks</th>
                                  <th>@lang('lang.action')</th>
                                </tr>
                            </thead>
                            <tbody>
                              <tr id="row1" class="mt-40">
                                <td class="border-top-0">
                                    <input type="hidden" name="url" id="url" value="{{URL::to('/')}}">  
                                    <div class="input-effect">
                                        <input class="primary-input form-control{{ $errors->has('exam_title') ? ' is-invalid' : '' }}"
                                            type="text" id="exam_title" name="exam_title[]" autocomplete="off" value="{{isset($editData)? $editData->exam_title : 'Theory' }}" required  />
                                            <label>@lang('lang.title')</label>
                                    </div>
                                </td>
                                <td class="border-top-0">
                                    <div class="input-effect">
                                        <input class="primary-input form-control exam_mark"
                                        type="number" id="exam_mark" name="exam_mark[]" autocomplete="off"   value="{{isset($editData)? $editData->exam_mark : 0 }}" required />
                                    </div>
                                </td> 
                                <td>
                                    <div class="input-effect">
                                        <input class="primary-input form-control exam_pass_mark"
                                        type="number" id="exam_pass_mark" name="exam_pass_mark[]" autocomplete="off"   value="{{isset($editData)? $editData->pass : 0 }}" required />
                                    </div>
                                </td>
                                <td class="border-top">
                                     <button class="primary-btn icon-only fix-gr-bg" type="button">
                                         <span class="ti-trash"></span>
                                    </button>
                                   
                                </td>
                                </tr>
                                <tfoot>
                                    <tr>
                                       <td class="border-top-0">@lang('lang.total')</td>

                                       <td class="border-top-0" id="totalMark">
                                         <input type="text" class="primary-input form-control" id="i-totalmark" value="0" name="totalmark" readonly="true" required />
                                       </td>
                                       <td class="border-top-0" id="totalPassMark">
                                        <input type="text" class="primary-input form-control" id="i-totalpassmark" value="0" name="totalpassmark" readonly="true" required />
                                      </td>
                                       <td class="border-top-0"></td>
                                   </tr>
                                  
                               </tfoot>
                           </tbody>
                        </table>
                    </div>
                    <hr>
                    <button class="btn btn-primary btn-block"> Save Item </button>
                </div>
            </div>
        </form>
    @else
    <div class="white-box">
        <h1 class="text-center">
            You Don't have permissionn to manage Exams
        </h1>
    </div>
    @endif

    <div class="col-lg-12" style="margin-top:3rem;">
        <div class="row">
            <div class="col-lg-4 no-gutters">
                <div class="main-title">
                    <h3 class="mb-0">@lang('lang.exam') @lang('lang.list')</h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <table id="table_id" class="display school-table" cellspacing="0" width="100%">
                    <thead>
                                @if(session()->has('message-success-delete') != "" ||
                                session()->get('message-danger-delete') != "")
                                <tr>
                                    <td colspan="7">
                                        @if(session()->has('message-success-delete'))
                                        <div class="alert alert-success">
                                            {{ session()->get('message-success-delete') }}
                                        </div>
                                        @elseif(session()->has('message-danger-delete'))
                                        <div class="alert alert-danger">
                                            {{ session()->get('message-danger-delete') }}
                                        </div>
                                        @endif
                                    </td>
                                </tr>
                                @endif
                                <tr>
                                    <th>@lang('lang.sl')</th>
                                    <th>@lang('lang.exam_title')</th>
                                    <th>@lang('lang.class')</th>
                                    <th>@lang('lang.section')</th>
                                    <th>@lang('lang.subject')</th>
                                    <th>@lang('lang.total_mark')</th>
                                    <th>@lang('lang.mark_distribution')</th>
                                    <th>@lang('lang.action')</th>
                                </tr>
                    </thead>

                    <tbody>
                    @php $count =1 ; @endphp
                                @foreach($exams as $exam)
                                <tr>
                                    <td>{{$count++}}</td>

                                    <td>{{$exam->GetExamTitle !=""?$exam->GetExamTitle->title:""}}</td>
                                    <td>{{$exam->getClassName !=""?$exam->getClassName->class_name:""}}</td>
                                    <td>{{$exam->GetSectionName !=""?$exam->GetSectionName->section_name:""}}</td>
                                    <td>{{$exam->GetSubjectName !=""?$exam->GetSubjectName->subject_name:""}}</td>
                                    <td>{{$exam->exam_mark}}</td>

                                   <td>
                                        @php $mark_distributions = App\SmExam::getMarkDistributions($exam->exam_type_id, $exam->class_id,  $exam->section_id, $exam->subject_id);  @endphp                                  
                                      


                                        @foreach($exam->GetExamSetup as $row)
                                        <div class="row">
                                           <div class="col-sm-6"> {{$row->exam_title}} </div> <div class="col-sm-4"><b> {{$row->exam_mark}} </b></div> 
                                       </div>
                                        @endforeach
                                    </td>

                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                                                @lang('lang.select')
                                            </button>


                                            @php 

                                                $registered = App\SmExam::getMarkREgistered($exam->exam_type_id, $exam->class_id, $exam->section_id, $exam->subject_id);
                                                    

                                            @endphp
                                                @if($registered == "")


                                            <div class="dropdown-menu dropdown-menu-right">

                                                

                                                @if(in_array(397, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1 )

                                                    <a class="dropdown-item"
                                                        href="{{url('exam', $exam->id)}}">@lang('lang.edit')</a>
                                                 @endif

                                                @if(in_array(216, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1 )

                                                    <a class="dropdown-item" data-toggle="modal" data-target="#deleteExamModal{{$exam->id}}"
                                                        href="#">@lang('lang.delete')</a>
                                                 @endif
                                                 

                                            </div>
                                            @endif
                                        </div> 


                                    </td>
                                </tr>
                                    <div class="modal fade admin-query" id="deleteExamModal{{$exam->id}}" >
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">@lang('lang.delete') @lang('lang.exam')</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>

                                                <div class="modal-body">
                                                    <div class="text-center">
                                                        <h4>@lang('lang.are_you_sure_to_delete')</h4>
                                                    </div>

                                                    <div class="mt-40 d-flex justify-content-between">
                                                        <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('lang.cancel')</button>
                                                         {{ Form::open(['url' => 'exam/'.$exam->id, 'method' => 'DELETE', 'enctype' => 'multipart/form-data']) }}
                                                        <button class="primary-btn fix-gr-bg" type="submit">@lang('lang.delete')</button>
                                                         {{ Form::close() }}
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>


            </div>
</section>
@endsection
@section('script')
    <script>
        
        function checkfornull(){
            var q=true;
          if($("#exam_class").val()=='select class *'){
            toastr.error("Please Select a class");
            $("#exam_class").focus();
            q= false;  
          }
            var tfm=parseFloat($("#i-totalmark").val());
            var tpm=parseFloat($("#i-totalpassmark").val());
            if(tfm<=0 || tpm<=0 || tfm==undefined || tpm==undefined){
                toastr.error("Please Insert All Data");
                q= false;
            }

            var fms=document.querySelectorAll('.exam_mark');
            fms.forEach(element => {
                var fm=parseFloat( element.value);
                if(fm<=0|| fm==undefined){
                    toastr.error("Please Insert Full Marks");
                    element.focus();
                    q= false;
                }
            });

            var pms=document.querySelectorAll('.exam_pass_mark');
            pms.forEach(element => {
                var pm= parseFloat( element.value);
                if(pm<=0|| pm==undefined){
                    toastr.error("Please Insert Pass Marks");
                    element.focus();
                    q= false;
                }
            });

            var checked=false;
            var cs=document.querySelectorAll('.subject-checkbox');
            cs.forEach(element => {
                if(element.checked){
                    checked=true;
                }
            });
            if(!checked){
                toastr.error("Please Select At least One Subject");
                q= false;
            }
            

            return q;
        }
    </script>
@endsection
