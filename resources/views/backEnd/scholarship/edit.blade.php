@extends('backEnd.master')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
@section('mainContent')
<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>Schoolarship Scheme</h1>
            <div class="bc-pages">
                <a href="{{url('dashboard')}}">@lang('lang.dashboard')</a>
                <a href="#">@lang('lang.fees_collection')</a>
                <a href="#">Scholarship</a>
            </div>
        </div>
    </div>
</section>


<section class="admin-visitor-area up_st_admin_visitor">
    <h4 class="text-center">List of Scholarship Scheme</h4>
        @if(session()->has('message-success'))
            <div class="alert alert-success">
                {{ session()->get('message-success') }}
            </div>
        @endif
    <div class="row">
        <div class="col-md-4" >
            <div style="background:white; padding:10px; border-radius:5px;">
                <form action="{{ route('scholarship_update',$scholarship_edit->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" value="{{ $scholarship_edit->title }}" name="title" placeholder="Enter title" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="classs">Choose Student</label>
                        <select name="student_id" class="selectpicker" data-width="auto" data-live-search="true" data-size="10" required>
                            <option value="">==== Select Student ====</option>
                           @foreach ($students as $stds)
                               <option value="{{ $stds->id }}" {{ $stds->id == $scholarship_edit->student_id ? 'selected' : '' }}>{{ $stds->full_name }}</option>
                           @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="class">Choose Class</label>
                        <select name="class_id" class="form-control" required>
                            <option value="">=== Choose Class ===</option>
                            @foreach ($class as $c)
                                <option value="{{ $c->id }}" {{ $c->id == $scholarship_edit->class_id ? 'selected' : '' }}>{{ $c->class_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="class">Choose Fees</label>
                        <select name="fee_id" class="form-control" required>
                            <option value="">=== Choose Fee Type ===</option>
                            @foreach ($fees as $f)
                                <option value="{{ $f->id }}" {{ $f->id == $scholarship_edit->fee_id ? 'selected' : '' }}>{{ $f->text }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Scholarship Scheme Type</label>
                        <br>
                        <input type="checkbox" name="scheme" value="1" onchange="

                        if(this.checked){
                            document.getElementById('inper').disabled = false;
                        }else{
                            document.getElementById('inper').disabled = true;
                        }
                        " id="per" checked>
                        <label for="per">In Percentage (%)</label>
                        <br>
                        <input type="checkbox" name="scheme" onchange="
                        if(this.checked){
                            document.getElementById('inamt').disabled = false;
                        }else{
                            document.getElementById('inamt').disabled = true;
                        }
                        " id="amt" checked>
                        <label for="amt">In Amount</label>
                      
                    </div>
                    <div class="form-group">
                        <label for="amount">In Percentage</label>
                        <input type="number" value="{{ $scholarship_edit->percentage }}" name="percentage" class="form-control" id="inper" placeholder="Enter percentage" >
                    </div>
                    <div class="form-group">
                        <label for="amount">In Amount</label>
                        <input type="number" value="{{ $scholarship_edit->amount }}" name="amount" class="form-control" id="inamt" placeholder="Enter Amount" >
                    </div>
                    <hr>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Update Data</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-8">
            <div style="background:white; padding:10px; border-radius:5px;">
                <table class="table table-bordered text-center">
                    <thead>
                        <th>Title</th>
                        <th>Fee Type</th>
                        <th>Amount</th>
                        <th>Percentage (%)</th>
                        <th>Student Name</th>
                        <th> Class | Lavel</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @foreach ($scholarship as $s)
                            <tr>
                                <td>{{ $s->title }}</td>
                                <td>{{ $s->fee->text }}</td>
                                <td>Rs.{{ $s->amount }}</td>
                                <td>{{ $s->percentage }}</td>
                                <td>{{ $s->student->full_name }}</td>
                                <td>{{ $s->class->class_name }}</td>
                                <td><a href="{{ route('scholarship_edit',$s->id) }}"><small>Edit</small></a> | <a href="{{ route('scholarship_delete',$s->id) }}" onclick="return confirm('Are you sure ?');"><small>Delete</small></a></td>
                            </tr>
                        @endforeach
                       
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center" style="margin-top:1rem;">
                {{ $scholarship->links() }}
            </div>
        </div>
    </div>
</section>


@endsection
@section('script')
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script> 
<script>
   
</script>
@endsection


