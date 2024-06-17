@extends('backEnd.master')
@section('mainContent')

@php
    function showPicName($data){
        $name = explode('/', $data);
        return $name[4];
    }
@endphp
<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>Examinations</h1>
            <div class="bc-pages">
                <a href="{{url('dashboard')}}">Dashboard</a>
                <a href="#">Examinations</a>
                <a href="{{route('student_result')}}">Result</a>
            </div>
        </div>
    </div>
</section>

<section class="student-details">
    <div class="container-fluid p-0">
        <div class="row">

            <!-- Start Student Details -->
            <div class="col-lg-12">
                <div class="main-title">
                    <h3 class="mb-20">Exam Result</h3>
                </div>

                      <!-- Start Student Details -->
            <div class="col-lg-12">
                <div class="accordion" id="accordionExample">
                    @foreach ($datas as $item)
                    <div class="card">
                      <div class="card-header" id="headingThree">
                        <h2 class="mb-0">
                          <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            {{ $item['name'] }}
                          </button>
                        </h2>
                      </div>
                      <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                          <div class="card-body">
                            <button class="btn btn-primary" onclick="
                            myWindow=window.open('','MsgWindow','width=200,height=100');
                            myWindow.document.write($('#mark').html());
                            myWindow.document.close();
                            myWindow.onafterprint=function(){
                                myWindow.close();
                            };
                            myWindow.print();
                            ">Print</button>
                            <div id="mark">

                                <table  class="w-100 mb-20 table table-bordered marksheet text-center">
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
                                        @php
                                            $sn=1;
                                        @endphp
                                        @foreach ($item['results'] as $result)
                                            @foreach ($result as $i)
                                            <tr>
                                                <td>{{ $sn++ }}</td>
                                                <td>{{ $i['subject'] }}</td>
                                                <td>{{ isset($i['partial'][0])!=null?$i['partial'][0]['full']:"-" }}</td>
                                                <td>{{ isset($i['partial'][1])!=null?$i['partial'][1]['full']:"-" }}</td>
                                                <td>{{ isset($i['partial'][0])!=null?$i['partial'][0]['pass']:"-" }}</td>
                                                <td>{{ isset($i['partial'][1])!=null?$i['partial'][1]['pass']:"-" }}</td>
                                                <td>{{ isset($i['partial'][0])!=null?$i['partial'][0]['mark']:"-" }}</td>
                                                <td>{{ isset($i['partial'][1])!=null?$i['partial'][1]['mark']:"-" }}</td>
                                                <td>{{ $i['total_marks'] }}</td>
                                                <td>{{ $i['total_gpa_grade'] }}</td>
                                                <td>{{ $i['total_gpa_point'] }}</td>
                                            </tr> 
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                      </div>
                    </div>
                    @endforeach   
                  </div>  
            </div>
            <!-- End Student Details -->
                    
            </div>
            <!-- End Student Details -->
        </div>

            
    </div>
</section>






@endsection
