@extends('backEnd.master')
@section('mainContent')

    @php
        function showPicName($data){
            $name = explode('/', $data);
            $number = count($name);
            return $name[$number-1];
        }
        function showTimelineDocName($data){
            $name = explode('/', $data);
            $number = count($name);
            return $name[$number-1];
        }
        function showDocumentName($data){
            $name = explode('/', $data);
            $number = count($name);
            return $name[$number-1];
        }
    @endphp 
@php  $setting = App\SmGeneralSettings::find(1);  if(!empty($setting->currency_symbol)){ $currency = $setting->currency_symbol; }else{ $currency = '$'; }   @endphp 

    <section class="sms-breadcrumb mb-40 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>@lang('lang.student_details')</h1>
                <div class="bc-pages">
                    <a href="{{url('dashboard')}}">@lang('lang.dashboard')</a>
                    <a href="{{route('student_list')}}">@lang('lang.student_list')</a>
                    <a href="#">@lang('lang.student_details')</a>
                </div>
            </div>
        </div>
    </section>

    <section class="student-details">
        <div class="container-fluid p-0">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="row">
                <div class="col-lg-3">
                    <!-- Start Student Meta Information -->
                    <div class="main-title">
                        <h3 class="mb-20">@lang('lang.student_details')</h3>
                    </div>
                    <div class="student-meta-box">
                        <div class="student-meta-top"></div>
                        
                        @if(!empty($student_detail->student_photo))
                            <img class="student-meta-img img-100" src="{{asset($student_detail->student_photo)}}"
                                 alt="">
                        @else
                            <img class="student-meta-img img-100" src="{{asset('public/uploads/sample.jpg')}}" alt="">
                        @endif
                        <div class="white-box radius-t-y-0">
                            <div class="single-meta mt-10">
                                <div class="d-flex justify-content-between">
                                    <div class="name">
                                        @lang('lang.student') @lang('lang.name')
                                    </div>
                                    {{-- {{ dd($student_detail) }} --}}
                                    <div class="value">
                                        {{$student_detail->first_name.' '.$student_detail->last_name}}
                                    </div>
                                </div>
                            </div>
                            <div class="single-meta">
                                <div class="d-flex justify-content-between">
                                    <div class="name">
                                        @lang('lang.admission') @lang('lang.number')
                                    </div>
                                    <div class="value">
                                        {{$student_detail->admission_no}}
                                    </div>
                                </div>
                            </div>
                            <div class="single-meta">
                                <div class="d-flex justify-content-between">
                                    <div class="name">
                                        @lang('lang.roll') @lang('lang.number')
                                    </div>
                                    <div class="value">
                                        {{$student_detail->roll_no}}
                                    </div>
                                </div>
                            </div>
                            <div class="single-meta">
                                <div class="d-flex justify-content-between">
                                    <div class="name">
                                        @lang('lang.class')
                                    </div>
                                    <div class="value">
                                        @if($student_detail->className!="" && $student_detail->session!="")
                                            {{$student_detail->className->class_name}}
                                            ({{$student_detail->session->session}})
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="single-meta">
                                <div class="d-flex justify-content-between">
                                    <div class="name">
                                        @lang('lang.section')
                                    </div>
                                    <div class="value">
                                        {{$student_detail->section->section_name}}
                                    </div>
                                </div>
                            </div>
                            <div class="single-meta">
                                <div class="d-flex justify-content-between">
                                    <div class="name">
                                        @lang('lang.gender')
                                    </div>
                                    <div class="value">

                                        {{$student_detail->gender !=""?$student_detail->gender->base_setup_name:""}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Student Meta Information -->
                    {{-- {{ dd($siblings) }} --}}
                    @if(count($siblings) >0 )
                        <!-- Start Siblings Meta Information -->
                        <div class="main-title mt-40">
                            <h3 class="mb-20">@lang('lang.sibling') @lang('lang.information') </h3>
                        </div>
                        @foreach($siblings as $sibling)
                            
                                <div class="student-meta-box mb-20">
                                    <div class="student-meta-top siblings-meta-top"></div>
                                    <img class="student-meta-img img-100" src="{{asset($sibling->student_photo)}}" alt="">
                                    <div class="white-box radius-t-y-0">
                                        <div class="single-meta mt-10">
                                            <div class="d-flex justify-content-between">
                                                <div class="name">
                                                    @lang('lang.sibling') @lang('lang.name')
                                                </div>
                                                 <div class="value">
                                                    {{isset($sibling->full_name)?$sibling->full_name:''}}
                                                </div> 
                                            </div>
                                        </div>
                                        <div class="single-meta">
                                            <div class="d-flex justify-content-between">
                                                <div class="name">
                                                    @lang('lang.admission') @lang('lang.number')
                                                </div>
                                                <div class="value">
                                                    {{$sibling->admission_no}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="single-meta">
                                            <div class="d-flex justify-content-between">
                                                <div class="name">
                                                    @lang('lang.roll') @lang('lang.number')
                                                </div>
                                                <div class="value">
                                                    {{$sibling->roll_no}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="single-meta">
                                            <div class="d-flex justify-content-between">
                                                <div class="name">
                                                    @lang('lang.class')
                                                </div>
                                                <div class="value">
                                                    {{$sibling->className->class_name}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="single-meta">
                                            <div class="d-flex justify-content-between">
                                                <div class="name">
                                                    @lang('lang.section')
                                                </div>
                                                <div class="value">
                                                    {{$sibling->section !=""?$sibling->section->section_name:""}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="single-meta">
                                            <div class="d-flex justify-content-between">
                                                <div class="name">
                                                    @lang('lang.gender')
                                                </div>
                                                <div class="value">
                                                    {{$sibling->gender!=""? $sibling->gender->base_setup_name:""}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                    
                @endforeach
                <!-- End Siblings Meta Information -->
                
                @endif
                </div>

                <!-- Start Student Details -->
                <div class="col-lg-9 student-details">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" href="#studentProfile" role="tab" data-toggle="tab">@lang('lang.profile')</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#studentFees" role="tab" data-toggle="tab">@lang('lang.fees')</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#studentExam" role="tab" data-toggle="tab">@lang('lang.exam')</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#studentDocuments" role="tab" data-toggle="tab">@lang('lang.document')</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#studentTimeline" role="tab" data-toggle="tab">@lang('lang.timeline')</a>
                        </li>
                        <li class="nav-item edit-button">
                            <a href="{{route('student_edit', [$student_detail->id])}}"
                               class="primary-btn small fix-gr-bg">@lang('lang.edit')
                            </a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <!-- Start Profile Tab -->
                        <div role="tabpanel" class="tab-pane fade  show active" id="studentProfile">
                            <div class="white-box">
                                <h4 class="stu-sub-head">@lang('lang.personal') @lang('lang.info')</h4>
                                <div class="single-info">
                                    <div class="row">
                                        <div class="col-lg-5 col-md-5">
                                            <div class="">
                                                @lang('lang.admission') @lang('lang.date')
                                            </div>
                                        </div>

                                        <div class="col-lg-7 col-md-6">
                                            <div class="">
                                                {{ !empty($student_detail->admission_date)? App\SmGeneralSettings::DateConvater($student_detail->admission_date):''}} 
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="single-info">
                                    <div class="row">
                                        <div class="col-lg-5 col-md-6">
                                            <div class="">
                                                @lang('lang.date_of_birth')
                                            </div>
                                        </div>

                                        <div class="col-lg-7 col-md-7">
                                            <div class="">
                                                {{ !empty($student_detail->date_of_birth)? App\SmGeneralSettings::DateConvater($student_detail->date_of_birth):''}}  
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="single-info">
                                    <div class="row">
                                        <div class="col-lg-5 col-md-6">
                                            <div class="">
                                                @lang('lang.type')
                                            </div>
                                        </div>

                                        <div class="col-lg-7 col-md-7">
                                            <div class="">
                                                {{$student_detail->category != ""? $student_detail->category->catgeory_name:""}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="single-info">
                                    <div class="row">
                                        <div class="col-lg-5 col-md-6">
                                            <div class="">
                                                @lang('lang.religion')
                                            </div>
                                        </div>

                                        <div class="col-lg-7 col-md-7">
                                            <div class="">
                                                {{$student_detail->religion != ""? $student_detail->religion->base_setup_name:""}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="single-info">
                                    <div class="row">
                                        <div class="col-lg-5 col-md-6">
                                            <div class="">
                                                @lang('lang.phone') @lang('lang.number')
                                            </div>
                                        </div>

                                        <div class="col-lg-7 col-md-7">
                                            <div class="">
                                                {{$student_detail->mobile}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="single-info">
                                    <div class="row">
                                        <div class="col-lg-5 col-md-6">
                                            <div class="">
                                                @lang('lang.email') @lang('lang.address')
                                            </div>
                                        </div>

                                        <div class="col-lg-7 col-md-7">
                                            <div class="">
                                                {{$student_detail->email}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="single-info">
                                    <div class="row">
                                        <div class="col-lg-5 col-md-6">
                                            <div class="">
                                                @lang('lang.present') @lang('lang.address')
                                            </div>
                                        </div>

                                        <div class="col-lg-7 col-md-7">
                                            <div class="">
                                                {{$student_detail->current_address}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="single-info">
                                    <div class="row">
                                        <div class="col-lg-5 col-md-6">
                                            <div class="">
                                                @lang('lang.permanent_address')
                                            </div>
                                        </div>

                                        <div class="col-lg-7 col-md-7">
                                            <div class="">
                                                {{$student_detail->permanent_address}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Start Parent Part -->
                                <h4 class="stu-sub-head mt-40">@lang('lang.Parent_Guardian_Details')</h4>
                                <div class="d-flex">
                                    <div class="mr-20 mt-20">
                                        <img class="student-meta-img img-100"
                                             src="{{asset($student_detail->parents->fathers_photo)}}" alt="">
                                    </div>
                                    <div class="w-100">
                                        <div class="single-info">
                                            <div class="row">
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="">
                                                        @lang('lang.father_name')
                                                    </div>
                                                </div>

                                                <div class="col-lg-8 col-md-7">
                                                    <div class="">
                                                        {{$student_detail->parents->fathers_name}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="single-info">
                                            <div class="row">
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="">
                                                        @lang('lang.occupation')
                                                    </div>
                                                </div>

                                                <div class="col-lg-8 col-md-7">
                                                    <div class="">
                                                        {{$student_detail->parents!=""?$student_detail->parents->fathers_occupation:""}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="single-info">
                                            <div class="row">
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="">
                                                        @lang('lang.phone') @lang('lang.number')
                                                    </div>
                                                </div>

                                                <div class="col-lg-8 col-md-7">
                                                    <div class="">
                                                        {{$student_detail->parents !=""?$student_detail->parents->fathers_mobile:""}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex">
                                    <div class="mr-20 mt-20">
                                        <img class="student-meta-img img-100"
                                             src="{{asset($student_detail->parents->mothers_photo)}}" alt="">
                                    </div>
                                    <div class="w-100">
                                        <div class="single-info">
                                            <div class="row">
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="">
                                                        @lang('lang.mother_name')
                                                    </div>
                                                </div>

                                                <div class="col-lg-8 col-md-7">
                                                    <div class="">
                                                        {{$student_detail->parents !=""?$student_detail->parents->mothers_name:""}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="single-info">
                                            <div class="row">
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="">
                                                        @lang('lang.occupation')
                                                    </div>
                                                </div>

                                                <div class="col-lg-8 col-md-7">
                                                    <div class="">
                                                        {{$student_detail->parents !=""?$student_detail->parents->mothers_occupation:""}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="single-info">
                                            <div class="row">
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="">
                                                        @lang('lang.phone') @lang('lang.number')
                                                    </div>
                                                </div>

                                                <div class="col-lg-8 col-md-7">
                                                    <div class="">
                                                        {{$student_detail->parents !=""?$student_detail->parents->mothers_mobile:""}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex">
                                    <div class="mr-20 mt-20">
                                        <img class="student-meta-img img-100"
                                             src="{{asset($student_detail->parents->guardians_photo)}}" alt="">
                                    </div>
                                    <div class="w-100">
                                        <div class="single-info">
                                            <div class="row">
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="">
                                                        @lang('lang.guardian_name')
                                                    </div>
                                                </div>

                                                <div class="col-lg-8 col-md-7">
                                                    <div class="">
                                                        {{$student_detail->parents !=""?$student_detail->parents->guardians_mobile:""}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="single-info">
                                            <div class="row">
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="">
                                                        @lang('lang.email') @lang('lang.address')
                                                    </div>
                                                </div>

                                                <div class="col-lg-8 col-md-7">
                                                    <div class="">
                                                        {{$student_detail->parents !=""?$student_detail->parents->guardians_email:""}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="single-info">
                                            <div class="row">
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="">
                                                        @lang('lang.phone') @lang('lang.number')
                                                    </div>
                                                </div>

                                                <div class="col-lg-8 col-md-7">
                                                    <div class="">
                                                        {{$student_detail->parents !=""?$student_detail->parents->guardians_phone:""}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="single-info">
                                            <div class="row">
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="">
                                                        @lang('lang.relation_with_guardian')
                                                    </div>
                                                </div>

                                                <div class="col-lg-8 col-md-7">
                                                    <div class="">
                                                        {{$student_detail->parents !=""?$student_detail->parents->guardians_relation:""}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="single-info">
                                            <div class="row">
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="">
                                                        @lang('lang.occupation')
                                                    </div>
                                                </div>

                                                <div class="col-lg-8 col-md-7">
                                                    <div class="">
                                                        {{$student_detail->parents !=""?$student_detail->parents->guardians_occupation:""}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="single-info">
                                            <div class="row">
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="">
                                                        @lang('lang.guardian_address')
                                                    </div>
                                                </div>

                                                <div class="col-lg-8 col-md-7">
                                                    <div class="">
                                                        {{$student_detail->parents !=""?$student_detail->parents->guardians_address:""}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Parent Part -->

                                <!-- Start Transport Part -->
                                <h4 class="stu-sub-head mt-40">@lang('lang.transport_and_dormitory_info')</h4>
                                
                                
                                @if (!empty($student_detail->route_list_id))
                                    
                                <div class="single-info">
                                    <div class="row">
                                        <div class="col-lg-5 col-md-5">
                                            <div class="">
                                                @lang('lang.route')
                                            </div>
                                        </div>

                                        <div class="col-lg-7 col-md-6">
                                            <div class="">
                                                {{isset($student_detail->route_list_id)? $student_detail->route->title: ''}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @endif

                                @if (isset($student_detail->vehicle))
                                    @if (!empty($vehicle_no))
                                    <div class="single-info">
                                        <div class="row">
                                            <div class="col-lg-5 col-md-5">
                                                <div class="">
                                                    @lang('lang.vehicle_number')
                                                </div>
                                            </div>
    
                                            <div class="col-lg-7 col-md-6">
                                                <div class="">
                                                    {{$student_detail->vehicle != ""? $student_detail->vehicle->vehicle_no: ''}}
                                                </div>
                                            </div>
                                        </div>
                                    </div> 


                                    @endif
                               
                                    
                                @endif
                               
                                
                                    @if (isset($driver_info))
                                        @if (!empty($driver_info->full_name))
                                        <div class="single-info">
                                            <div class="row">
                                                <div class="col-lg-5 col-md-5">
                                                    <div class="">
                                                        @lang('lang.driver_name')
                                                    </div>
                                                </div>
        
                                                <div class="col-lg-7 col-md-6">
                                                    <div class="">
                                                        {{$student_detail->vechile_id != ""? $driver_info->full_name:''}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        
                                    @endif
                                
                                    @if (isset($driver_info))
                                        @if (!empty($driver_info->mobile))
                                        <div class="single-info">
                                            <div class="row">
                                                <div class="col-lg-5 col-md-5">
                                                    <div class="">
                                                        @lang('lang.driver') @lang('lang.phone') @lang('lang.number')
                                                    </div>
                                                </div>
        
                                                <div class="col-lg-7 col-md-6">
                                                    <div class="">
                                                        {{$student_detail->vechile_id != ""? $driver_info->mobile:''}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    @endif
                               

                                    @if (isset($student_detail->dormitory))
                                        @if (!empty($student_detail->dormitory->dormitory_name))
                                        <div class="single-info">
                                            <div class="row">
                                                <div class="col-lg-5 col-md-5">
                                                    <div class="">
                                                        @lang('lang.dormitory') @lang('lang.name')
                                                    </div>
                                                </div>
        
                                                <div class="col-lg-7 col-md-6">
                                                    <div class="">
                                                        {{isset($student_detail->dormitory_id)? $student_detail->dormitory->dormitory_name: ''}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    @endif
                                
                                <!-- End Transport Part -->

                                <!-- Start Other Information Part -->
                                <h4 class="stu-sub-head mt-40">@lang('lang.Other') @lang('lang.information')</h4>
                                <div class="single-info">
                                    <div class="row">
                                        <div class="col-lg-5 col-md-5">
                                            <div class="">
                                                @lang('lang.blood_group')
                                            </div>
                                        </div>

                                        <div class="col-lg-7 col-md-6">
                                            <div class="">
                                                {{isset($student_detail->bloodgroup_id)? $student_detail->bloodGroup->base_setup_name: ''}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="single-info">
                                    <div class="row">
                                        <div class="col-lg-5 col-md-5">
                                            <div class="">
                                                @lang('lang.height')
                                            </div>
                                        </div>

                                        <div class="col-lg-7 col-md-6">
                                            <div class="">
                                                {{isset($student_detail->height)? $student_detail->height: ''}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="single-info">
                                    <div class="row">
                                        <div class="col-lg-5 col-md-5">
                                            <div class="">
                                                @lang('lang.Weight')
                                            </div>
                                        </div>

                                        <div class="col-lg-7 col-md-6">
                                            <div class="">
                                                {{isset($student_detail->weight)? $student_detail->weight: ''}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="single-info">
                                    <div class="row">
                                        <div class="col-lg-5 col-md-5">
                                            <div class="">
                                                @lang('lang.previous_school_details')
                                            </div>
                                        </div>

                                        <div class="col-lg-7 col-md-6">
                                            <div class="">
                                                {{isset($student_detail->previous_school_details)? $student_detail->previous_school_details: ''}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="single-info">
                                    <div class="row">
                                        <div class="col-lg-5 col-md-5">
                                            <div class="">
                                                @lang('lang.national_iD_number')
                                            </div>
                                        </div>

                                        <div class="col-lg-7 col-md-6">
                                            <div class="">
                                                {{isset($student_detail->national_id_no)? $student_detail->national_id_no: ''}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="single-info">
                                    <div class="row">
                                        <div class="col-lg-5 col-md-5">
                                            <div class="">
                                                @lang('lang.local_Id_Number')
                                            </div>
                                        </div>
                                        

                                        <div class="col-lg-7 col-md-6">
                                            <div class="">
                                                {{isset($student_detail->local_id_no)? $student_detail->local_id_no: ''}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="single-info">
                                    <div class="row">
                                        <div class="col-lg-5 col-md-5">
                                            <div class="">
                                                @lang('lang.bank_account_number')
                                            </div>
                                        </div>

                                        <div class="col-lg-7 col-md-6">
                                            <div class="">
                                                {{isset($student_detail->bank_account_no)? $student_detail->bank_account_no: ''}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="single-info">
                                    <div class="row">
                                        <div class="col-lg-5 col-md-5">
                                            <div class="">
                                                @lang('lang.bank_name')
                                            </div>
                                        </div>
                                        <div class="col-lg-7 col-md-6">
                                            <div class="">
                                                {{isset($student_detail->bank_name)? $student_detail->bank_name: ''}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="single-info">
                                    <div class="row">
                                        <div class="col-lg-5 col-md-5">
                                            <div class="">
                                                @lang('lang.IFSC_Code')
                                            </div>
                                        </div>

                                        <div class="col-lg-7 col-md-6">
                                            <div class="">
                                                UBC56987
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Other Information Part -->
                            </div>
                        </div>
                        <!-- End Profile Tab -->

                        <!-- Start Fees Tab -->
                        <div role="tabpanel" class="tab-pane fade" id="studentFees">
                            <div style="margin-top:1rem;">
                                <h3 class="text-center">Student Fee Status Record</h3>
                            </div>
                            <hr>
                            <nav>
                                <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                  <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Paid Fees</a>
                                  <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">UnPaid Fees</a>
                                  <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Payments</a>
                                </div>
                              </nav>


                              <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent" style="margin-left:2rem; margin-righ:2.5rem;">
                                {{-- paid fees section --}}
                                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                  <div style="background:white;padding:5px;">
                                      <table class="table table-bordered text-center">
                                          <thead>
                                              <th>Title</th>
                                              <th>Rate</th>
                                              <th>Quantity</th>
                                              <th>Total</th>
                                              <th>Taxable</th>
                                              <th>Tax</th>
                                              <th>Status</th>
                                          </thead>
                                          @php
                                              $total = 0;
                                              $tax = 0;
                                          @endphp
                                          <tbody>
                                              @if(isset($paiditems))
                                              @foreach ($paiditems as $item)
                                                  <tr>
                                                      <td>{{ $item->title }}</td>
                                                      <td>{{ $item->amount }}</td>
                                                      <td>{{ $item->qty }}</td>
                                                      <td>{{ $item->amount * $item->qty }}</td>
                                                      <td>{{ $item->taxable }}</td>
                                                      <td>{{ $item->taxable*0.01 }}</td>
                                                      <td> <span class="badge badge-success">Paid</span></td>
                                                  </tr>
                                                  @php
                                                      $total+=$item->amount * $item->qty;
                                                      $tax+=$item->taxable*0.01;
                                                  @endphp
                                                  @endforeach
                                                  @endif
                                                  <tfoot>
                                                      <tr>
                                                          <td colspan="3" class="text-right">Gross Total</td>
                                                          <td colspan="7">Rs. {{ $total }}</td>
                                                      </tr>
                                                      <tr>
                                                          <td colspan="3" class="text-right"> Total Tax</td>
                                                          <td colspan="7">Rs. {{ $tax }}</td>
                                                      </tr>
                                                      <tr>
                                                            <td colspan="3" class="text-right"> Net Total</td>
                                                            <td colspan="7">Rs. {{ $total+$tax }}</td>
                                                      </tr>
                                                  </tfoot>
                                          </tbody>
                                      </table>
                                  </div>
                                </div>
                                {{-- unpaid fees section --}}
                                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                    <div style="background:white;padding:5px;">
                                        <table class="table table-bordered text-center">
                                            <thead>
                                                
                                                <th>Title</th>
                                                <th>Rate</th>
                                                <th>Quantity</th>
                                                <th>Total</th>
                                                <th>Due</th>
                                                <th>Taxable</th>
                                                <th>Tax</th>
                                                
                                            </thead>
                                            <tbody>
                                                @php
                                                    $totaldue=0;
                                                    $totaltax=0;
                                                @endphp
                                                @if(isset($unpaiditems))
                                                @foreach ($unpaiditems as $item)
                                                    <tr>
                                                        
                                                        <td>{{ $item->title }}</td>
                                                        <td>{{ $item->amount }}</td>
                                                        <td>{{ $item->qty }}</td>
                                                        <td>{{ $item->total }}</td>
                                                        @php
                                                            $due=$item->total-$item->pay;
                                                            $taxable=$item->taxable;
                                                            $tax=0;
                                                            if($taxable>0){
                                                                $taxable=$due;
                                                                $tax=$taxable*0.01;
                                                            }
                                                            $totaldue+=$due;
                                                            $totaltax+=$tax;
                                                        @endphp
                                                        <td>{{$due}}</td>
                                                        <td>{{$taxable}}</td>
                                                        <td>{{$tax}}</td>
                                                        
                                                        
                                                    </tr>
                                                @endforeach
                                                @endif
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="4" class="text-right">Total Due</th>
                                                   <th colspan="4" >Rs.{{ $totaldue }}</th>
                                                </tr>
            
                                                <tr>
                                                    <th colspan="4" class="text-right">Total Tax</th>
                                                   <th colspan="4" >Rs.{{ $totaltax }}</th>
                                                </tr>
            
                                                <tr>
                                                    <th colspan="4" class="text-right">Net Amount</th>
                                                   <th colspan="4" >Rs.{{ $totaldue + $totaltax }}</th>
                                                </tr>
                                                <tr>
                                                    <th colspan="4" class="text-right">
                                                        Payment Types
                                                    </th>
                                                    <form action="{{ route('bill_by_admin') }}" method="POST">
                                                     @csrf
                                                    <td colspan="4" class="text-left">
                                                        <input type="radio" name='payment_type' id="bank" value="1" onchange="showForm(1);" /> On Bank Deposite <br>
                                                        <input type="radio" name='payment_type' id="cheque" value="2" onchange="showForm(2);" /> On Cheque Deposite <br>
                                                        <input type="radio" name='payment_type' id="cash" value="0" onchange="showForm(0);" checked/> On Cash <br>
                                                    </td>
                                                </tr>
                                                <input type="hidden" name="student_id" value="{{ $student_detail->id }}" />
                                                <tr id="fillable">
                                                    <th colspan="4" class="text-right">Feel The Form</th>
                                                    <td colspan="4">
                                                        <div class="text-left">
                                                                <div class="form-group">
                                                                    <label for="date">Date</label>
                                                                    <input type="date" class="form-control" name="date">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="bank">Bank Name</label>
                                                                    <input type="text" class="form-control" name="bank_name">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="acc">Account No.</label>
                                                                    <input type="number" class="form-control" name="acount_no">
                                                                </div>
                                                                <div class="form-group" id="chequeno">
                                                                    <label for="cheque">Cheque No.</label>
                                                                    <input type="number" class="form-control" name="cheque_no">
                                                                </div>
                                                                <div class="form-group" id="voucherno">
                                                                    <label for="voucher">Voucher No.</label>
                                                                    <input type="number" class="form-control" name="voucher_no">
                                                                </div>
                                                                <div class="form-group text-center">
                                                                    <label for="fery" >Is Verify</label>
                                                                    <input type="checkbox" class="form-control"  onchange="
                                                                    if(this.checked){
                                                                        $('#is_verify').val(1);
                                                                    }else{
                                                                        $('#is_verify').val(0);
                                                                    }">
                                                                    <input type="hidden" id="is_verify" name="is_verify" value="0">
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="4" class="text-right">
                                                            Pay Amount
                                                        </th>
                                                        <th colspan="4">
                                                            <input id="pay" name="total" class="w-100 form-control" type="number" min="0" required/>
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="7" class="text-right">
                                                            <button  class="btn btn-primary btn-md"> Pay Now</button>
                                                        </td> 
                                                    </tr>
                                                    <tr>
                                                        
                                                    </tr>
                                                </tfoot>
                                            </form>
                                        </table>
                                    </div>
                                </div>
                                {{-- payment fees section --}}
                                <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                                    <div style="background:white;padding:5px;">
                                        <table class="table table-bordered text-center">
                                            <thead>
                                                <th>Date</th>
                                                <th>Bill No.</th>
                                                <th>Payment Method</th>
                                                <th>Amount</th>
                                            </thead>
                                            @php
                                                $total = 0;
                                            @endphp
                                            <tbody>
                                                @if (isset($bills))
                                                    @foreach ($bills as $item)
                                                        <tr>
                                                            <td>{{ $item->date }}</td>
                                                            <td>{{ $item->billno }}</td>
                                                            <td>
                                                                @if($item->payment_type==0)
                                                                    Cash
                                                                @endif
                                                                @if($item->payment_type==1)
                                                                    Bank Deposit
                                                                @endif
                                                                @if($item->payment_type==2)
                                                                    Cheque Deposit
                                                                @endif
                                                                @if($item->payment_type==3)
                                                                    Khalti Pay
                                                                @endif
                                                            </td>
                                                            <td>{{$item->total}}</td>
                                                        </tr>
                                                        @php
                                                            $total+=$item->total;
                                                        @endphp
                                                    @endforeach
                                                @endif
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="3" class="text-right">Total</th>
                                                    <th>Rs. {{ $total }}</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                              </div>



                        </div>
                        <!-- End Profile Tab -->

                        <!-- Start Exam Tab -->
                        <div role="tabpanel" class="tab-pane fade" id="studentExam">
                           
                                @php
                                $exam_count= count($exams); 
                                @endphp
                                @if($exam_count<1)
                                <div class="white-box no-search no-paginate no-table-info mb-2">
                                   <table class="display school-table" cellspacing="0" width="100%">
                                        <thead>
                                                <tr>
                                                    <th>@lang('lang.subject')</th>
                                                    <th>@lang('lang.full_marks')</th>
                                                    <th>@lang('lang.passing_marks')</th>
                                                    <th>@lang('lang.obtained_marks')</th>
                                                    <th>@lang('lang.results')</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    
                                                </tbody>
                                   </table>
                                </div>
                                @endif
                       
                          
                            @foreach($exams as $exam)

                                <div class="white-box no-search no-paginate no-table-info mb-2">
                                    <div class="main-title">
                                        <h3 class="mb-0">{{$exam->exam != ""? $exam->exam->name:''}}</h3>
                                    </div>
                                    <table id="table_id" class="display school-table" cellspacing="0" width="100%">
                                        <thead>
                                        <tr>
                                            <th>@lang('lang.subject')</th>
                                            <th>@lang('lang.full_marks')</th>
                                            <th>@lang('lang.passing_marks')</th>
                                            <th>@lang('lang.obtained_marks')</th>
                                            <th>@lang('lang.results')</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                            
                                        @php
                                            $marks = App\SmStudent::marks($exam->exam_id, $student_detail->id);
                                            $grand_total = 0;
                                            $grand_total_marks = 0;
                                            $result = 0;

                                        @endphp
                                        @foreach($marks as $mark)
                                            @php
                                                $subject_marks = App\SmStudent::fullMarks($exam->id, $mark->subject_id);
                                                $result_subject = 0;
                                                $grand_total_marks += $subject_marks->full_mark;
                                                if($mark->abs == 0){
                                                    $grand_total += $mark->marks;
                                                    if($mark->marks < $subject_marks->pass_mark){
                                                       $result_subject++;
                                                       $result++;
                                                    }

                                                }else{
                                                    $result_subject++;
                                                    $result++;
                                                }
                                            @endphp
                                            <tr>
                                                <td>{{$mark->subject!=""?$mark->subject->subject_name:""}}</td>
                                                <td>{{$subject_marks->full_mark}}</td>
                                                <td>{{$subject_marks->pass_mark}}</td>
                                                <td>{{$mark->marks}}</td>
                                                <td>
                                                    @if($result_subject == 0)
                                                        <button
                                                            class="primary-btn small bg-success text-white border-0">
                                                            @lang('lang.pass')
                                                        </button>
                                                    @else
                                                        <button class="primary-btn small bg-danger text-white border-0">
                                                            @lang('lang.fail')
                                                        </button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        @if(count($marks) != "")
                                            <tfoot>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th> @lang('lang.grand_total'): {{$grand_total}}/{{$grand_total_marks}}</th>
                                                <th></th>
                                                <th>@lang('lang.grade'):
                                                    @php
                                                        if($result == 0 && $grand_total_marks != 0){
                                                            $percent = $grand_total/$grand_total_marks*100;


                                                            foreach($grades as $grade){
                                                               if(floor($percent) >= $grade->percent_from && floor($percent) <= $grade->percent_upto){
                                                                   echo $grade->grade_name;
                                                               }
                                                           }
                                                        }else{
                                                            echo "F";
                                                        }
                                                    @endphp
                                                </th>
                                            </tr>
                                            </tfoot>
                                        @endif
                                    </table>
                                </div>
                            @endforeach

                           
                        </div>
                        <!-- End Exam Tab -->

                        <!-- Start Documents Tab -->
                        <div role="tabpanel" class="tab-pane fade" id="studentDocuments">
                            <div class="white-box">
                                <div class="text-right mb-20">
                                    <button type="button" data-toggle="modal" data-target="#add_document_madal"
                                            class="primary-btn tr-bg text-uppercase bord-rad">
                                        @lang('lang.upload') @lang('lang.document')
                                        <span class="pl ti-upload"></span>
                                    </button>
                                </div>
                                <table id="" class="table simple-table table-responsive school-table"
                                       cellspacing="0">
                                    <thead class="d-block">
                                    <tr class="d-flex">
                                        <th class="col-6">@lang('lang.document') @lang('lang.title')</th>
                                        <th class="col-6">@lang('lang.action')</th>
                                    </tr>
                                    </thead>

                                    <tbody class="d-block">
                                    @if($student_detail->document_file_1 != "")
                                        <tr class="d-flex">
                                            <td class="col-6">{{$student_detail->document_title_1}}</td>
                                            <td class="col-6">
                                                <a class="primary-btn tr-bg text-uppercase bord-rad"
                                                   href="{{url('download-document/'.showDocumentName($student_detail->document_file_1))}}">
                                                    @lang('lang.download')<span class="pl ti-download"></span>
                                                </a>
                                            </td>
                                        </tr>
                                    @endif
                                    @if($student_detail->document_file_2 != "")
                                        <tr class="d-flex">
                                            <td class="col-6">{{$student_detail->document_title_2}}</td>
                                            <td class="col-6">
                                                <a class="primary-btn tr-bg text-uppercase bord-rad"
                                                   href="{{url('download-document/'.showDocumentName($student_detail->document_file_2))}}">
                                                    @lang('lang.download')<span class="pl ti-download"></span>
                                                </a>
                                            </td>
                                        </tr>
                                    @endif
                                    @if($student_detail->document_file_3 != "")
                                        <tr class="d-flex">
                                            <td class="col-6">{{$student_detail->document_title_3}}</td>
                                            <td class="col-6">
                                                <a class="primary-btn tr-bg text-uppercase bord-rad"
                                                   href="{{url('download-document/'.showDocumentName($student_detail->document_file_3))}}">
                                                    @lang('lang.download')<span class="pl ti-download"></span>
                                                </a>
                                            </td>
                                        </tr>
                                    @endif
                                    @if($student_detail->document_file_4 != "")
                                        <tr class="d-flex">
                                            <td class="col-6">{{$student_detail->document_title_4}}</td>
                                            <td class="col-6">
                                                <a class="primary-btn tr-bg text-uppercase bord-rad"
                                                   href="{{url('download-document/'.showDocumentName($student_detail->document_file_4))}}">
                                                    @lang('lang.download')<span class="pl ti-download"></span>
                                                </a>
                                            </td>
                                        </tr>
                                    @endif
                                    
                                    @foreach($documents as $document)
                         
                                    @php
                                //    $name = explode('/', $document->file);
                                //    dd($name);

                                    // if(!function_exists('showDocumentName')){
                                    //     function showDocumentName($data){
                                    //     $name = explode('/', $data);
                                    //     return $name[4];
                                    // }
                                    // }
                                    
                                @endphp 
                                        <tr class="d-flex">
                                            <td class="col-6">{{$document->title}}</td>
                                            <td class="col-6">
                                                <a class="primary-btn tr-bg text-uppercase bord-rad"
                                                   href="{{url('download-document/'.showDocumentName($document->file))}}">
                                                    @lang('lang.download')<span class="pl ti-download"></span>
                                                </a>
                                                <a class="primary-btn icon-only fix-gr-bg" data-toggle="modal"
                                                   data-target="#deleteDocumentModal{{$document->id}}" href="#">
                                                    <span class="ti-trash"></span>
                                                </a>

                                            </td>
                                        </tr>
                                        <div class="modal fade admin-query" id="deleteDocumentModal{{$document->id}}">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">@lang('lang.delete')</h4>
                                                        <button type="button" class="close" data-dismiss="modal">
                                                            &times;
                                                        </button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <div class="text-center">
                                                            <h4>@lang('lang.are_you_sure_to_delete')</h4>
                                                        </div>

                                                        <div class="mt-40 d-flex justify-content-between">
                                                            <button type="button" class="primary-btn tr-bg"
                                                                    data-dismiss="modal">@lang('lang.cancel')
                                                            </button>
                                                            <a class="primary-btn fix-gr-bg"
                                                               href="{{route('delete-student-document', [$document->id])}}">
                                                                @lang('lang.delete')</a>
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
                        <!-- End Documents Tab -->
                        <!-- Add Document modal form start-->
                        <div class="modal fade admin-query" id="add_document_madal">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title"> @lang('lang.upload') @lang('lang.document')</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="container-fluid">
                                            {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'upload_document',
                                                                'method' => 'POST', 'enctype' => 'multipart/form-data', 'name' => 'document_upload']) }}
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <input type="hidden" name="student_id"
                                                           value="{{$student_detail->id}}">
                                                    <div class="row mt-25">
                                                        <div class="col-lg-12">
                                                            <div class="input-effect">
                                                                <input class="primary-input form-control{" type="text"
                                                                       name="title" value="" id="title">
                                                                <label> @lang('lang.title')<span>*</span> </label>
                                                                <span class="focus-border"></span>

                                                                <span class=" text-danger" role="alert"
                                                                      id="amount_error">
                                                                    
                                                                </span>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 mt-30">
                                                    <div class="row no-gutters input-right-icon">
                                                        <div class="col">
                                                            <div class="input-effect">
                                                                <input class="primary-input" type="text"
                                                                       id="placeholderPhoto" placeholder="Document"
                                                                       disabled>
                                                                <span class="focus-border"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <button class="primary-btn-small-input" type="button">
                                                                <label class="primary-btn small fix-gr-bg" for="photo"> @lang('lang.browse')</label>
                                                                <input type="file" class="d-none" name="photo"
                                                                       id="photo">
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>


                                                <!-- <div class="col-lg-12 text-center mt-40">
                                                    <button class="primary-btn fix-gr-bg" id="save_button_sibling" type="button">
                                                        <span class="ti-check"></span>
                                                        save information
                                                    </button>
                                                </div> -->
                                                <div class="col-lg-12 text-center mt-40">
                                                    <div class="mt-40 d-flex justify-content-between">
                                                        <button type="button" class="primary-btn tr-bg"
                                                                data-dismiss="modal">@lang('lang.cancel')
                                                        </button>

                                                        <button class="primary-btn fix-gr-bg" type="submit">@lang('lang.save')
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            {{ Form::close() }}
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- Add Document modal form end-->
                        <!-- delete document modal -->

                        <!-- delete document modal -->
                        <!-- Start Timeline Tab -->
                        <div role="tabpanel" class="tab-pane fade" id="studentTimeline">
                            <div class="white-box">
                                <div class="text-right mb-20">
                                    <button type="button" data-toggle="modal" data-target="#add_timeline_madal"
                                            class="primary-btn tr-bg text-uppercase bord-rad">
                                        @lang('lang.add')
                                        <span class="pl ti-plus"></span>
                                    </button>

                                </div>
                                @foreach($timelines as $timeline)
                                    <div class="student-activities">
                                        <div class="single-activity">
                                            <h4 class="title text-uppercase">
                                                
{{$timeline->date != ""? App\SmGeneralSettings::DateConvater($timeline->date):''}}

                                            </h4>
                                            <div class="sub-activity-box d-flex">
                                                <h6 class="time text-uppercase">10.30 pm</h6>
                                                <div class="sub-activity">
                                                    <h5 class="subtitle text-uppercase"> {{$timeline->title}}</h5>
                                                    <p>
                                                        {{$timeline->description}}
                                                    </p>
                                                </div>

                                                <div class="close-activity">
                                                    
                                                    <a class="primary-btn icon-only fix-gr-bg" data-toggle="modal"
                                                       data-target="#deleteTimelineModal{{$timeline->id}}" href="#">
                                                        <span class="ti-trash text-white"></span>
                                                    </a>
                                                    
                                                    @if($timeline->file != "")
                                                        <a href="{{url('staff-download-timeline-doc/'.showTimelineDocName($timeline->file))}}"
                                                           class="primary-btn tr-bg text-uppercase bord-rad">
                                                            @lang('lang.download')<span class="pl ti-download"></span>
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal fade admin-query" id="deleteTimelineModal{{$timeline->id}}">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">@lang('lang.delete')</h4>
                                                        <button type="button" class="close" data-dismiss="modal">
                                                            &times;
                                                        </button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <div class="text-center">
                                                            <h4>@lang('lang.are_you_sure_to_delete')</h4>
                                                        </div>

                                                        <div class="mt-40 d-flex justify-content-between">
                                                            <button type="button" class="primary-btn tr-bg"
                                                                    data-dismiss="modal">@lang('lang.cancel')
                                                            </button>
                                                            <a class="primary-btn fix-gr-bg"
                                                               href="{{route('delete_timeline', [$timeline->id])}}">
                                                                @lang('lang.delete')</a>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                            </div>
                        </div>
                        <!-- End Timeline Tab -->
                    </div>
                </div>
                <!-- End Student Details -->
            </div>


        </div>
    </section>

    <!-- timeline form modal start-->
    <div class="modal fade admin-query" id="add_timeline_madal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('lang.add') @lang('lang.timeline')</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="container-fluid">
                        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'student_timeline_store',
                                            'method' => 'POST', 'enctype' => 'multipart/form-data', 'name' => 'document_upload']) }}
                        <div class="row">
                            <div class="col-lg-12">
                                <input type="hidden" name="student_id" value="{{$student_detail->id}}">
                                <div class="row mt-25">
                                    <div class="col-lg-12">
                                        <div class="input-effect">
                                            <input class="primary-input form-control{" type="text" name="title" value=""
                                                   id="title" maxlength="200">
                                            <label>@lang('lang.title') <span>*</span> </label>
                                            <span class="focus-border"></span>

                                            <span class=" text-danger" role="alert" id="amount_error">
                                                
                                            </span>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 mt-30">
                                <div class="no-gutters input-right-icon">
                                    <div class="col">
                                        <div class="input-effect">
                                            <input class="primary-input date form-control" readonly id="startDate" type="text"
                                                   name="date">
                                            <label>@lang('lang.date')</label>
                                            <span class="focus-border"></span>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <button class="" type="button">
                                            <i class="ti-calendar" id="start-date-icon"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 mt-30">
                                <div class="input-effect">
                                    <textarea class="primary-input form-control" cols="0" rows="3" name="description"
                                              id="Description"></textarea>
                                    <label>@lang('lang.description')<span></span> </label>
                                    <span class="focus-border textarea"></span>
                                </div>
                            </div>

                            <div class="col-lg-12 mt-40">
                                <div class="row no-gutters input-right-icon">
                                    <div class="col">
                                        <div class="input-effect">
                                            <input class="primary-input" type="text" id="placeholderFileFourName"
                                                   placeholder="Document"
                                                   disabled>
                                            <span class="focus-border"></span>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <button class="primary-btn-small-input" type="button">
                                            <label class="primary-btn small fix-gr-bg"
                                                   for="document_file_4">@lang('lang.browse')</label>
                                            <input type="file" class="d-none" name="document_file_4"
                                                   id="document_file_4">
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 mt-30">

                                <input type="checkbox" id="currentAddressCheck" class="common-checkbox"
                                       name="visible_to_student" value="1">
                                <label for="currentAddressCheck">@lang('lang.visible_to_this_person')</label>
                            </div>


                            <!-- <div class="col-lg-12 text-center mt-40">
                                <button class="primary-btn fix-gr-bg" id="save_button_sibling" type="button">
                                    <span class="ti-check"></span>
                                    save information
                                </button>
                            </div> -->
                            <div class="col-lg-12 text-center mt-40">
                                <div class="mt-40 d-flex justify-content-between">
                                    <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('lang.cancel')</button>

                                    <button class="primary-btn fix-gr-bg" type="submit">@lang('lang.save')</button>
                                </div>
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- timeline form modal end-->

@endsection

@section('script')
    <script>
        $('#fillable').hide();

        function showForm(val){
                
          if(val == 1){
            $('#fillable').show();
            $('#voucherno').show();
            $('#chequeno').hide();
          }else if(val == 2){
            $('#fillable').show();
            $('#chequeno').show();
            $('#voucherno').hide();
          }else{
            $('#fillable').hide();
          }
        }

    </script>
@endsection


