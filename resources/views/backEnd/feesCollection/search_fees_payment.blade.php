@extends('backEnd.master')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
@section('mainContent')
@php  $setting = App\SmGeneralSettings::find(1); if(!empty($setting->currency_symbol)){ $currency = $setting->currency_symbol; }else{ $currency = '$'; } @endphp

<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('lang.search_fees_payment')</h1>
            <div class="bc-pages">
                <a href="{{url('dashboard')}}">@lang('lang.dashboard')</a>
                <a href="#">@lang('lang.fees_collection')</a>
                <a href="#">@lang('lang.search_fees_payment')</a>
            </div>
        </div>
    </div>
</section>
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-lg-3">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-title">
                            <h3 class="mb-30">
                                @lang('lang.select_criteria')
                            </h3>
                        </div>
                                <div class="row" style="background: white; padding:3rem 0rem;">
                                    <div class="col-lg-12">
                                        <div class="form-goroup">
                                            <label for="student">Select Student</label>
                                            <select name="student_id" class="selectpicker" data-width="auto" data-live-search="true" data-size="18" id="student">
                                                <option value="">Select Student</option>
                                               @foreach ($students as $stds)
                                                   <option value="{{ $stds->id }}">{{ $stds->full_name }}</option>
                                               @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-9">
                <div class="row">
                    <div class="col-lg-4 no-gutters">
                        <div class="main-title">
                            <h3 class="mb-0"> Fees Payments Details</h3>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12" >
                        <div style="background: white; padding:1rem; margin-top:1.4rem;">
                            <table class="table table-bordered text-center" >
    
                               <thead>
                                    <tr>
                                        <th>Fee Title</th>
                                        <th>Rate</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                        <th>Taxble</th>
                                        <th>Tax</th>
                                        <th>Status</th>
                                    </tr>
                               </thead>
                               <tbody id="paiditems">
                               </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('script')
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script> 
<script>
    $('#student').on('change', function(e){
    var student_id = e.target.value;
    console.log(student_id);
    $('#paiditems').empty();
    axios.get('/paid/fees/'+student_id)
      .then(function (response) {
          var items = response.data.paidfee;
          if(items.length == 0){
            $('#paiditems').append("<tr><td colspan='7'>Payments are not available yet !</td></tr>");
          }
          var total = 0;
          var tax = 0;
          var html;
          items.forEach(element => {
                  html = "<tr> <td>"+element.title+"</td>";
                  html+="<td>"+element.amount+"</td>";
                  html+="<td>"+element.qty+"</td>";
                  html+="<td>"+element.amount*element.qty+"</td>";
                  html+="<td>"+element.taxable+"</td>";
                  html+="<td>"+element.taxable*0.01+"</td>";
                  html+="<td><span class='badge badge-success'>Paid</span></td></tr>";
                  $('#paiditems').append(html);
                  total+=element.amount*element.qty;
                  tax+=element.taxable*0.01;
         });
         $('#paiditems').append("<tr><td colspan='3' class='text-right'>Gross Total</td><td colspan='5'>Rs."+total+"</td></tr>");
         $('#paiditems').append("<tr><td colspan='3' class='text-right'>Total Tax</td><td colspan='5'>Rs."+tax+"</td></tr>");
         $('#paiditems').append("<tr><td colspan='3' class='text-right'>Net Total</td><td colspan='5'>Rs."+(total+tax)+"</td></tr>");

      console.log(response);
    })
    .catch(function (error) {
        console.log(error);
    })
    });
</script>
@endsection
