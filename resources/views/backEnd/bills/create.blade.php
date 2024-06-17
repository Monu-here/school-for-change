@extends('backEnd.master')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
@section('mainContent')
<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>Bill Issue</h1>
            <div class="bc-pages">
                <a href="{{url('dashboard')}}">@lang('lang.dashboard')</a>
                <a href="#">@lang('lang.fees_collection')</a>
                <a href="#">Bill Issue</a>
            </div>
        </div>
    </div>
</section>


<section class="admin-visitor-area up_st_admin_visitor">
    <h4 class="text-center">Credit Bill Issue</h4>
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        @if(session()->has('message-success'))
            <div class="alert alert-success">
                {{ session()->get('message-success') }}
            </div>
        @endif
        <form action="{{ route('bill_save') }}" method="POST">
            @csrf
    <div class="row">
        <div class="col-md-9" >
             <div class="form-group">
                <div class="d-flex justify-content-end">
                    <label for="date">Date :- <span style="visibility:hidden;">x</span></label>
                    <input type="Date" name="date" style="width:200px;" required>
                </div>
             </div>
            <div style="background:white; padding:10px; border-radius:5px;">
              
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="class"> Class | Lavel</label>
                                 <select class="form-control" id="class-std">
                                     <option value="">=== Choose Class ===</option>
                                     @foreach ($class as $c)
                                         <option value="{{ $c->id }}">{{ $c->class_name }}</option>
                                     @endforeach
                                 </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="class"> Section</label>
                                 <select id="section" class="form-control" id="section">
                                     <option value="">=== Choose Section ===</option>
                                 </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <label for="class">Fee Type</label>
                            <select id="fee" class="form-control">
                                <option value="0">=== Choose Fee ===</option>
                            </select>
                        </div>
                        <div class="col-md-8">
                            <label for="from">Title</label>
                            <input type="text"  placeholder="Enter title" id="title" class="form-control">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="rate">Rate</label>
                            <input type="number" class="form-control" id="rate" value="0">
                        </div>
                        <div class="col-md-4">
                            <label for="qty">Quantity</label>
                            <input type="number" value="0" id="qty" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="dummy" style="visibility: hidden;">hello</label>
                            <span class="btn btn-primary btn-block" onclick="addItem();">Add</span>
                        </div>
                    </div>

            
               
            </div>
            
            <div style="margin-top:2rem;">
                <div style="background:white; padding:10px; border-radius:5px;"
                >
                    <table class="table table-bordered text-center">
                        <thead>
                            <th>Title</th>
                            <th>Rate</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Action</th>
                        </thead>
                        <tbody id="data-intable">

                        </tbody>
                        <tfoot>
                            <tr>

                                <td colspan="3" class="text-right">
                                    Net Total
                                </td>
                                <td>
                                    <input type="number" id="nettotal" name="nettotal" value="0" class="form-control">
                                </td>
                                <td><span class="btn btn-danger btn-sm" onclick="
                                    $('#data-intable').empty();
                                    $('#nettotal').val(0);
                                    ">Clear</span></td>
                            </tr>
                            </tfoot>
                    </table>
                </div>
            </div>
            <hr>
            <button class="btn btn-primary btn-sm btn-block">Submit</button>
        </div>
        <div class="col-md-3">
            <div style="background:white; padding:10px; border-radius:5px;">
                <h3 class="text-center">Select Student</h3>
                <p><input id="selector" type="checkbox" onclick="
                    if(this.checked){
                        $('.std_select').prop('checked',true);
                    }else{
                        $('.std_select').prop('checked',false);
                    }
                    "> Select All</p>
                <hr>
                <div class="form-group" id="student">
                    Student dos not loaded !
                   
                </div>
            </div>
        </div>
       
    </div>
</form>

</section>


@endsection
@section('script')
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script> 
<script>
   
$('#class-std').on('change', function(e){
    var class_id = e.target.value;
    axios.get('/section-'+class_id)
      .then(function (response) {
          var section = response.data;
          $('#rate').val(0);
          $('#section').empty();
          $('#section').append('<option value="0" disable="true" selected="true">=== Choose Section ===</option>');
          section.forEach(element => {
            $('#section').append('<option value="'+ element.id +'">'+ element.name +'</option>');
         });

      console.log(response);
    })
    .catch(function (error) {
        console.log(error);
    })

// feee load
    axios.get('/fee-'+class_id)
      .then(function (response) {
          var fee = response.data;
          $('#fee').empty();
          $('#fee').append('<option value="0" id="fee" selected="true">=== Choose fee ===</option>');
          fee.forEach(element => {
            $('#fee').append('<option value="'+ element.id +'">'+ element.text +'</option>');
         });
        
      console.log(response);
    })
    .catch(function (error) {
        console.log(error);
    })

//  studnets load
   $('#student').empty();
   $('#selector').prop('checked',false);

    axios.get('/student-'+class_id)
      .then(function (response) {
          var student = response.data;
          $('#student').empty();
          student.forEach(element => {
            $('#student').append('<input type="checkbox" class="std_select" name="student_id[]" value="'+element.id+'"/> <strong>'+ element.full_name +'</strong><hr>');
         });

      console.log(response);
    })
    .catch(function (error) {
        console.log(error);
    })
  });

// get single type rate
  $('#fee').on('change', function(e){     
        var fee_id = e.target.value;
        axios.get('/rate-'+fee_id)
      .then(function (response) {
          var rate = response.data;
          $('#rate').val(rate.amount);

      console.log(response);
    })
    .catch(function (error) {
        console.log(error);
    })
  });


//   student get by section
    
    $('#section').on('change', function(f){
        var class_id = $('#class-std').val();
        var section_id = f.target.value;
        $('#student').empty();
        $('#selector').prop('checked',false);
        axios.get('/students-'+class_id+'-'+section_id)
            .then(function (response) {
                var student = response.data;
                $('#student').empty();
                 student.forEach(element => {
                   $('#student').append('<input type="checkbox" name="student_id[]" class="std_select" value="'+element.id+'"> <strong>'+ element.full_name +'</strong><hr>');
                 });

            console.log(response);
            })
            .catch(function (error) {
                console.log(error);
            })
        });


        function addItem(){
            if($("#fee").val()== '0'){
                alert("Please enter fee type");
                $("#fee").focus();
                return false;
            }
            if($("#title").val()==""){
                alert("Please insert title");
                $("#title").focus();
                return false;
            }
            if($("#qty").val()== 0){
                alert("Please enter quantity");
                $("#qty").focus();
                return false;
            }
            var feetype=$( "#fee option:selected" ).text();
            var fee_id=$("#fee").val();
            var title=$("#title").val();
            var rate = $("#rate").val();
            var qty=$("#qty").val();
            
            var htm = '<tr id="data-'+fee_id+'">';
            htm+="<td><input name='fee_id[]' type='hidden' value='"+fee_id+"' />"+"<input name='rate[]' type='hidden' value='"+rate+"' />"+"<input name='qty[]' type='hidden' value='"+qty+"' />"+"<input name='feetitle[]' type='hidden' value='"+feetype+" "+title+"'/>"+feetype+" "+title+"</td>";
            htm+="<td>"+rate+"</td>";
            htm+="<td>"+qty+"</td>";
            htm+="<td>"+rate*qty+"</td><td><span class='btn btn-danger btn-sm' onclick='$(\"#data-"+fee_id+"\").remove();'>Del</span></td></tr>";
            $('#nettotal').val(parseFloat($('#nettotal').val())+(rate*qty));
            $('#data-intable').append(htm);
            
            $("#fee").val(0);
            $("#title").val('');
            $("#rate").val(0);
            $("#qty").val(0);
        }


 
</script>
@endsection


