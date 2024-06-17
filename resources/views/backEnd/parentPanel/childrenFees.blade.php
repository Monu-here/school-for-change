@extends('backEnd.master')
@section('mainContent')
@php  $setting = App\SmGeneralSettings::find(1); if(!empty($setting->currency_symbol)){ $currency = $setting->currency_symbol; }else{ $currency = '$'; } @endphp
<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>Fees</h1>
            <div class="bc-pages">
                <a href="{{url('dashboard')}}">Dashboard</a>
                <a href="#">Fees</a>
                <a href="{{route('student_fees')}}">Pay Fees</a>
            </div>
        </div>
    </div>
</section>

<input type="hidden" id="url" value="{{URL::to('/')}}">
<input type="hidden" id="student_id" value="{{$student->id}}">
<section class="">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-lg-4 no-gutters">
                <div class="d-flex justify-content-between">
                    <div class="main-title">
                        <h3 class="mb-30">Student Information</h3>
                    </div>
                </div>
            </div>
        </div>
              @if(session()->has('message-success'))
                <div class="alert alert-success">
                  {{ session()->get('message-success') }}
              </div>
              @elseif(session()->has('message-danger'))
              <div class="alert alert-danger">
                  {{ session()->get('message-danger') }}
              </div>
              @endif

        <div class="row">
            <div class="col-md-3 col-lg-3">
                <!-- Start Student Meta Information -->
                <div class="student-meta-box">
                    <div class="student-meta-top"></div>
                    <img class="student-meta-img img-100" src="{{asset($student->student_photo)}}" alt="">
                    <div class="white-box radius-t-y-0">
                        <div class="single-meta mt-10">
                            <div class="d-flex justify-content-between">
                                <div class="name">
                                    Student Name
                                </div>
                                <div class="value">
                                    {{$student->first_name.' '.$student->last_name}}
                                </div>
                            </div>
                        </div>
                        <div class="single-meta">
                            <div class="d-flex justify-content-between">
                                <div class="name">
                                    Admission Number
                                </div>
                                <div class="value">
                                    {{$student->admission_no}}
                                </div>
                            </div>
                        </div>
                        <div class="single-meta">
                            <div class="d-flex justify-content-between">
                                <div class="name">
                                    Roll Number
                                </div>
                                <div class="value">
                                     {{$student->roll_no}}
                                </div>
                            </div>
                        </div>
                        <div class="single-meta">
                            <div class="d-flex justify-content-between">
                                <div class="name">
                                    Class
                                </div>
                                <div class="value">
                                    @if($student->className!="" && $student->session!="")
                                   {{$student->className->class_name}} ({{$student->session->session}})
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="single-meta">
                            <div class="d-flex justify-content-between">
                                <div class="name">
                                    Section
                                </div>
                                <div class="value">
                                    {{$student->section !=""?$student->section->section_name:""}}
                                </div>
                            </div>
                        </div>
                        <div class="single-meta">
                            <div class="d-flex justify-content-between">
                                <div class="name">
                                    Gender
                                </div>
                                <div class="value">
                                    {{$student->gender !=""?$student->gender->base_setup_name:""}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Student Meta Information -->

            </div>

            <div class="col-md-9 col-lg-9">
                <div style="margin-top:1rem;">
                    <h3 class="text-center">Student Fee Status Records</h3>
                </div>
                <hr>
                <nav>
                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                      <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Paid Fees</a>
                      <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">UnPaid Fees</a>
                      <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Payments</a>
                    </div>
                  </nav>


                  <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
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
                                            Pay Amount
                                        </th>
                                        <th colspan="4">
                                            <input id="pay" class="w-100 form-control" type="number" min="0"/>
                                        </th>
                                    </tr>
                                        <td colspan="7" class="text-right">
                                            <button  class="btn btn-primary btn-md" onclick="initKhaltiPay();"> Pay By Khalti</button>
                                        </td> 
                                    
                                </tfoot>
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
        </div>
    </div>
</section>

<div class="modal fade admin-query" id="deleteFeesPayment" >
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Delete Item</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <div class="text-center">
                    <h4>Are you sure to delete this item?</h4>
                </div>

                <div class="mt-40 d-flex justify-content-between">
                    <button type="button" class="primary-btn tr-bg" data-dismiss="modal">Cancel</button>
                     {{ Form::open(['url' => 'fees-payment-delete', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                     <input type="hidden" name="id" id="feep_payment_id">
                    <button class="primary-btn fix-gr-bg" type="submit">Delete</button>
                     {{ Form::close() }}
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
@section('script')
    <script src="https://khalti.com/static/khalti-checkout.js"></script>
    
    <script>
        
        function initKhaltiPay(){
            var amount=parseFloat( $("#pay").val());

            if(amount!=undefined && amount !=null && amount>0){
                axios.post("/generatebill",{
                    amount:amount,
                    student_id:{{$student->id}},
                    payment_type:3
                }).then(function(response){
                    console.log(response);
                    var config = {
                        // replace the publicKey with yours
                        "publicKey": "{{config('khalti.public_key')}}",
                        "productIdentity": response.data,
                        "productName": "Bill for {{$student->full_name}}",
                        "productUrl": "http://localhost:8080/bilview/"+response.data,
                        "eventHandler": {
                            onSuccess (payload) {
                                // hit merchant api for initiating verfication
                                console.log(payload);
                                payload.type='parent';
                                axios.post('/payemnt/Khalti/sucess',payload)
                                
                                .then(function(verify){
                                    console.log(verify);
                                    alert(verify.data);
                                    location.reload();
                                })
                                .catch(function(err){

                                });
                            },
                            onError (error) {
                                console.log(error);
                            },
                            onClose () {
                                console.log('widget is closing');
                            }
                        }
                    };
                    var checkout = new KhaltiCheckout(config);
                    checkout.show({amount: amount*100});
                   
                })
                .catch(function(error){

                });
            }
        }
    </script>
@endsection