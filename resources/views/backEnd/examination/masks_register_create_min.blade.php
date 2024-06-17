@extends('backEnd.master')
@section('mainContent')
<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>Examinations </h1>
            <div class="bc-pages">
                <a href="{{url('dashboard')}}">Dashboard</a>
                <a href="#">Examinations</a>
                <a href="{{route('marks_register')}}">Marks Register</a>
                <a href="{{route('marks_register_create')}}">Fill Marks</a>
            </div>
        </div>
    </div>
</section>


@if(isset($students))

{{-- {{ dd($students->section_id) }} --}}
<section class="mt-20">
    <div class="container-fluid p-0">
        <div class="row mt-40">
            <div class="col-lg-6 col-md-6">
                <div class="main-title">
                    <h3 class="mb-30">Fill Marks</h3>
                </div>
            </div>
        </div>


    {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'marks_register_store', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'marks_register_store']) }} 

        
        <input type="hidden" name="hasdata" value="{{$exam->exam_type_id}}">
        <input type="hidden" name="isop" value="{{$exam->isop}}">
        <input type="hidden" name="exam_id" value="{{$exam->exam_type_id}}">
        <input type="hidden" name="class_id" value="{{$exam->class_id}}">
        <input type="hidden" name="section_id" value="{{$exam->section_id}}">
        <input type="hidden" name="subject_id" value="{{$exam->subject_id}}"> 

        <div class="row">
            <div class="col-lg-12">
                <table class="display school-table school-table-style" cellspacing="0" width="100%" >
                    <thead>
                        <tr>
                            <th rowspan="2" >Admission No./ Registration No</th>
                            <th rowspan="2" >Roll No. / Symbol No</th>
                            <th rowspan="2" >Student</th>
                            <th colspan="{{$number_of_exam_parts}}"> {{$subjectNames->subject_name}}</th> 
                            <th rowspan="2">Is Absent</th>
                        </tr>
                        <tr>
                            @foreach($marks_entry_form as $part)
                            <th>{{$part->exam_title}} ( {{$part->exam_mark}} ) </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>                        
                        @php $colspan = 3; $counter = 0;  @endphp
                        @foreach($students as $student)
                        <tr>
                            <td>
                                
                                <input type="hidden" name="student_ids[]" value="{{$student->id}}">
                                <input type="hidden" name="student_rolls[{{$student->id}}]" value="{{$student->roll_no}}">
                                <input type="hidden" name="student_admissions[{{$student->id}}]" value="{{$student->admission_no}}">
                                {{$student->admission_no??$student->regno}}
                            </td>
                            <td>{{$student->roll_no}}</td>
                            <td>{{$student->full_name}}</td>
                            @php 
                                $entry_form_count=0; //dd($marks_entry_form); 
                            @endphp

                            <?php
                                $is_absent=false;
                            ?>
                            @foreach($marks_entry_form as $part)
                           
                            <td>
                                <div class="input-effect mt-10">
                                <input type="hidden" name="exam_setup_ids[]" value="{{$part->id}}">
                                <?php 
                                    $search_mark = App\SmMarkStore::get_mark_by_part($student->id, $exam->exam_type_id, $exam->class_id, $exam->section_id, $exam->subject_id, $part->id); 
                                    $is_absent=App\SmMarkStore::get_is_absent_by_part($student->id, $exam->exam_type_id, $exam->class_id, $exam->section_id, $exam->subject_id, $part->id)
                                ?>
                                    <input class="primary-input marks_input" type="text" name="marks[{{$student->id}}][{{$part->id}}]" value="{{!empty($search_mark)?$search_mark:0}}">
                                    <input class="primary-input marks_input" type="hidden" name="exam_Sids[{{$student->id}}][{{$entry_form_count++}}]" value="{{$part->id}}">
                                    <label>{{$part->exam_title}} Mark</label>
                                    <span class="focus-border"></span>
                                </div>                                
                            </td>
                            @endforeach

                            <td>
                                <div class="input-effect">
                                    <input type="checkbox" id="subject_{{$student->id}}_{{$student->admission_no}}" class="common-checkbox" name="abs[{{$student->id}}]" value="1" <?php if($is_absent){echo 'checked';} ?> >
                                    <label for="subject_{{$student->id}}_{{$student->admission_no}}">Yes</label>
                                </div>
                                    
                            </td>

                        </tr>
                        @endforeach 
                    </tbody>
                </table>

                @if(in_array(224, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)

                                <div class="col-lg-12 mt-20 text-right">
                                    <button type="submit" class="primary-btn fix-gr-bg">
                                        <span class="ti-check"></span>
                                        Save
                                    </button>
                                </div>
@endif
              {{--  <table class="display school-table school-table-style" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Admission No.</th>
                            <th>Roll No.</th>
                            <th>Student</th>
                            @php $alreday_registered = [];@endphp
                            @foreach($marks_register_subjects as $marks_register_child)
                                @if(in_array($marks_register_child->subject_id, $assign_subject_ids))
                                    @php $alreday_registered[] = $marks_register_child->subject_id;@endphp
                                    <th>{{$marks_register_child->subject->subject_name}}</th>
                                    <input type="hidden" name="subjects[]" value="{{$marks_register_child->subject_id}}">
                                @endif
                            @endforeach
                            @foreach($exam_schedule_subjects as $exam_schedule_subject)
                                @if(in_array($exam_schedule_subject->subject_id, $assign_subject_ids) && !in_array($exam_schedule_subject->subject_id, $alreday_registered))
                                    <th>{{$exam_schedule_subject->subject->subject_name}}</th>
                                    <input type="hidden" name="subjects[]" value="{{$exam_schedule_subject->subject_id}}">
                                @endif
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @php $colspan = 3; $counter = 0;  @endphp
                        @foreach($students as $student)
                        <tr>
                            <td>{{$student->admission_no}}<input type="hidden" name="student_ids[]" value="{{$student->id}}"></td>
                            <td>{{$student->roll_no}}</td>
                            <td>{{$student->full_name}}</td>
                            @php
                                $marks_register_childs = App\SmMarksRegister::marksRegisterChild($student->id, $exam_id, $class_id, $section_id);
                                
                            @endphp
                            @if(count($marks_register_childs) != 0)
                                @foreach($marks_register_childs as $marks_register_child)
                                    @if(in_array($marks_register_child->subject_id, $assign_subject_ids))
                                    @php $colspan++; $counter++; @endphp
                                    <td>
                                        <div class="no-gutters input-right-icon">
                                            <div class="col">
                                                <div class="input-effect">
                                                    <input type="checkbox" 
                                                    id="subject_{{$student->id}}_{{$marks_register_child->id}}" class="common-checkbox" name="abs_{{$counter}}" value="1" {{$marks_register_child->abs == 1? 'checked': ''}}>
                                                    <label for="subject_{{$student->id}}_{{$marks_register_child->id}}">Abs</label>
                                                </div>
                                                <div class="input-effect mt-10">
                                                    <input class="primary-input marks_input" type="text" name="marks_{{$counter}}" value="{{$marks_register_child->marks != ""? $marks_register_child->marks: 0}}">
                                                    <label>Enter Marks</label>
                                                    <span class="focus-border"></span>
                                                </div>
                                        </div>
                                        </div>
                                    </td>
                                    @endif
                                @endforeach
                            @else    
                                @foreach($exam_schedule_subjects as $exam_schedule_subject)
                                    
                                    @php $colspan++; $counter++;  @endphp
                                    <td>
                                        <div class="no-gutters input-right-icon">
                                            <div class="col">
                                                <div class="input-effect">
                                                    <input type="checkbox" id="subject_{{$student->id}}_{{$exam_schedule_subject->id}}" class="common-checkbox" name="abs_{{$counter}}" value="1">
                                                    <label for="subject_{{$student->id}}_{{$exam_schedule_subject->id}}">Abs</label>
                                                </div>
                                                <div class="input-effect mt-10">
                                                    <input class="primary-input marks_input" type="text" name="marks_{{$counter}}" value="0" >
                                                    <label>Enter Marks</label>
                                                    <span class="focus-border"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    
                                @endforeach
                            @endif
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="{{$colspan}}">
                                <div class="col-lg-12 mt-20 text-right">
                                    <button type="submit" class="primary-btn fix-gr-bg">
                                        <span class="ti-check"></span>
                                        Save
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
        
                </table> --}}
            </div>
        </div>
    </div>
</section>

@endif

@endsection
