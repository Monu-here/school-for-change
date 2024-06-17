@extends('backEnd.master')
@section('mainContent')
<div class="col-12" style="display: flex; justify-content: space-between;">
    {{-- <div>
        <input type="checkbox" name="abc" id="signgle" onchange="
        document.getElementById('select_student_div').style.display=this.checked?'flex':'none';
    ">
        <label for="relationFather">For Single Student</label>
    </div> --}}
    <div>
        <span class="primary-btn small fix-gr-bg" onclick="printDiv('printdiv');">Print</span>
    </div>
</div>

{{-- <div class="white-box mt-4">
    {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'mark_sheet_report_multiple_student', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'search_student']) }}
    <div class="row">
        <input type="hidden" name="url" id="url" value="{{URL::to('/')}}">

        <div class="col-lg-3 mt-30-md">
            <select class="w-100 bb niceSelect form-control{{ $errors->has('exam') ? ' is-invalid' : '' }}" name="exam">
                <option data-display="@lang('lang.select_exam') *" value="">@lang('lang.select_exam') *</option>
                @foreach($exams as $exam)
                <option value="{{$exam->id}}" {{isset($exam_id)? ($exam_id == $exam->id? 'selected':''):''}}>
                    {{$exam->title}}</option>
                @endforeach
            </select>
            @if ($errors->has('exam'))
            <span class="invalid-feedback invalid-select" role="alert">
                <strong>{{ $errors->first('exam') }}</strong>
            </span>
            @endif
        </div>
        <div class="col-lg-3 mt-30-md">
            <select class="w-100 bb niceSelect form-control {{ $errors->has('class') ? ' is-invalid' : '' }}"
                id="select_class" name="class">
                <option data-display="@lang('lang.select_class') *" value="">@lang('lang.select_class') *</option>
                @foreach($classes as $class)
                <option value="{{$class->id}}" {{isset($class_id)? ($class_id == $class->id? 'selected':''):''}}>
                    {{$class->class_name}}</option>

                @endforeach
            </select>
            @if ($errors->has('class'))
            <span class="invalid-feedback invalid-select" role="alert">
                <strong>{{ $errors->first('class') }}</strong>
            </span>
            @endif
        </div>
        <div class="col-lg-3 mt-30-md" id="select_section_div">
            <select
                class="w-100 bb niceSelect form-control{{ $errors->has('section') ? ' is-invalid' : '' }} select_section"
                id="select_section" name="section">
                <option data-display="Select section *" value="">Select section *</option>
            </select>
            @if ($errors->has('section'))
            <span class="invalid-feedback invalid-select" role="alert">
                <strong>{{ $errors->first('section') }}</strong>
            </span>
            @endif
        </div>
        <div class="col-lg-3 mt-30-md" id="select_student_div" style="display: none">
            <select class="w-100 bb niceSelect form-control{{ $errors->has('student') ? ' is-invalid' : '' }}"
                id="select_student" name="student">
                <option data-display="@lang('lang.select_student') *" value="">@lang('lang.select_student') *</option>
            </select>
            @if ($errors->has('student'))
            <span class="invalid-feedback invalid-select" role="alert">
                <strong>{{ $errors->first('student') }}</strong>
            </span>
            @endif
        </div>

        <div class="col-lg-3 mt-30-md">
            <select class="w-100 bb niceSelect form-control" name="search_type">
                <option value="">Select Search Type *</option>
                <option value="0">Result List</option>
                <option value="1">Result Marksheet</option>
            </select>
        </div>


        <div class="col-lg-12 mt-20 text-right">
            <button type="submit" class="primary-btn small fix-gr-bg">
                <span class="ti-search"></span>
                @lang('lang.search')
            </button>
        </div>
    </div>
    {{ Form::close() }}
</div> --}}
<div class="mt-4" id="printdiv">
    <div class="row text-center mb-5">
        <div class="col-2">
            <img src="{{ asset('public/logo.png') }}" alt="" style="width: 200px;">
        </div>
        <div class="col-10 pt-4">
            <h3 style="font-size:28px;">
                <strong>{{$name}}</strong>
                <br>
                <strong style="font-size: 20px;">{{$address}}</strong>
            </h3>

            <h5 style="padding-top:20px;"> <strong>Result-List</strong></h5>
        </div>

    </div>
    <h5 class="ml-5">Section Name : {{ $section->section_name }}</h5>
    <div class="card-body" style="height:{{env('printheight','1350px')}};">
        <div class="col-md-12">
            <table class="table table-bordered text-center">
                <thead>
                    <tr style="border:none;">
                        <th>Student Name</th>
                        <th>Symbol Number</th>
                        @foreach ($datas[0]['marks'] as $mark)
                            <th>{{$mark->name}} {{$mark->isop?"(Optional)":""}}</th>
                        @endforeach
                        {{-- <th></th> --}}
                        <th>GPA</th>
                        <th>Class</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($datas as $key => $data)
                    @php 
                        $std=$data['std']; 
                        $tt=0;
                        $totgrade=0;
                        $totalcredit=0;
                        @endphp
                        @if ($std->roll_no!='' && $std->roll_no!=null)
                            <tr>
                                <td>{{ $std->full_name}}</td>
                                <td>{{$std->roll_no}}</td>
                                @foreach ($data['marks'] as $mark)
                                    <td>{{ $mark->isabs?'ABS':$mark->finalgrade->gpa }}</td>
                                    @php
                                        if(!$mark->isabs && !$mark->isop){
                                            $totgrade+=$mark->finalgrade->gpa * $mark->credithour;
                                            $totalcredit+=$mark->credithour;
                                        }
                                    @endphp
                                @endforeach
                                <td>{{round(($totgrade/$totalcredit),2)}}</td>
                                {{-- <td>{{ round($data['marks']->finalgrade->grade_name)}}</td> --}}
                                <td>{{$std->class->class_name}}</td>
                            </tr>
                            
                        @endif
                    @endforeach
                </tbody>
            </table>

        </div>

    </div>
    <div class="fs"></div>
</div>

<script>
    function printDiv(id)
    {
        var divToPrint=document.getElementById(id);
        var newWin=window.open('Report','_blank');
        newWin.document.open();
        newWin.document.write('<html><head><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous"><link rel="stylesheet" href="{{ asset("public/backEnd/css/print.css") }}"></head><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');
        newWin.document.close();

    }
</script>
@endsection