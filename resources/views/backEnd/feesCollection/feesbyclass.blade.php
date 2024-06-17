@extends('backEnd.master')
@section('mainContent')
<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>Fees By Classes</h1>
            <div class="bc-pages">
                <a href="{{url('dashboard')}}">@lang('lang.dashboard')</a>
                <a href="#">@lang('lang.fees_collection')</a>
                <a href="#">Fees By Class</a>
            </div>
        </div>
    </div>
</section>


<section class="admin-visitor-area up_st_admin_visitor">
    <h4 class="text-center">Fees Structure By Class Lavel</h4>
        @if(session()->has('message-success'))
            <div class="alert alert-success">
                {{ session()->get('message-success') }}
            </div>
        @endif
    <div class="row">
        <div class="col-md-4" >
            <div style="background:white; padding:10px; border-radius:5px;">
                <form action="{{ route('fees_by_class_store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" placeholder="Enter title" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="classs">Choose Class|Level</label>
                        <select name="class_id" class="form-control" required>
                            <option value="">==== Select Class ====</option>
                            @foreach ($class as $c)
                                <option value="{{ $c->id }}">{{ $c->class_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="number" name="amount" class="form-control" placeholder="Enter Amount" required>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" onchange="
                        if(this.checked){
                            document.getElementById('istaxable').value=1;
                        }else{
                            document.getElementById('istaxable').value=0;
                        }
                        "> Is Taxable ?
                        <input type="hidden" name="istaxable" id="istaxable" value="0">
                    </div>

                    <div class="form-group">
                        <input type="checkbox" onchange="
                        if(this.checked){
                            document.getElementById('istransport').value=1;
                        }else{
                            document.getElementById('istransport').value=0;
                        }
                        "> Is Transportation ?
                        <input type="hidden" name="istransport" id="istransport" value="0">
                    </div>
                    <hr>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Save Data</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-8">
            <div style="background:white; padding:10px; border-radius:5px;">
                <table class="table table-bordered text-center">
                    <thead>
                        <th>Title</th>
                        <th>Amount</th>
                        <th>Class | Level</th>
                        <th>Tax</th>
                        <th>Transportation</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @foreach ($fees as $fee)
                            <tr>
                                <td>{{ $fee->text }}</td>
                                <td>Rs.{{ $fee->amount }}</td>
                                <td>{{ $fee->class->class_name }}</td>
                                <td>
                                    @if($fee->istaxable == 1)
                                       <span class="badge badge-success">Yes</span>
                                    @else
                                    <span class="badge badge-danger">No</span>
                                    @endif
                                </td>
                                <td>
                                    @if($fee->istransport == 1)
                                       <span class="badge badge-success">Yes</span>
                                    @else
                                    <span class="badge badge-danger">No</span>
                                    @endif
                                </td>
                                <td><a href="{{ route('fees_by_class_delete',$fee->id) }}" onclick="return confirm('Are you sure ?');">Delete</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center" style="margin-top:1rem;">
                {{ $fees->links() }}
            </div>
        </div>
    </div>
</section>


@endsection