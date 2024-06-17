@extends('backEnd.master')
@section('mainContent')
<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>Fees By Classes</h1>
            <div class="bc-pages">
                <a href="{{url('dashboard')}}">@lang('lang.dashboard')</a>
                <a href="#">System Settings</a>
                <a href="#">General Settings</a>
            </div>
        </div>
    </div>
</section>


<section class="admin-visitor-area up_st_admin_visitor">
    <h4 class="text-center">Fiscal Year Manage</h4>
        @if(session()->has('message-success'))
            <div class="alert alert-success">
                {{ session()->get('message-success') }}
            </div>
        @endif
    <div class="row">
        <div class="col-md-4" >
            <div style="background:white; padding:10px; border-radius:5px;">
                <form action="{{ route('fiscal_store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" placeholder="Enter title" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="title">Start Date</label>
                        <input type="date" name="start_date" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="title">End Date</label>
                        <input type="date" name="end_date" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <input type="checkbox" onchange="
                        if(this.checked){
                            document.getElementById('is_default').value=1;
                        }else{
                            document.getElementById('is_default').value=0;
                        }
                        "> Is Default ?
                        <input type="hidden" name="is_default" id="is_default" value="0">
                    </div>

                    <div class="form-group">
                        <input type="checkbox" onchange="
                        if(this.checked){
                            document.getElementById('is_active').value=1;
                        }else{
                            document.getElementById('is_active').value=0;
                        }
                        "> Is Active ?
                        <input type="hidden" name="is_active" id="is_active" value="1">
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
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @foreach ($fiscals as $fis)
                           <tr>
                               <td>{{ $fis->name }}</td>
                               <td>{{ $fis->start_date }}</td>
                               <td>{{ $fis->end_date }}</td>
                               <td>
                                   @if($fis->is_default == 1)
                                       <span class="badge badge-success">Default</span>
                                   @endif
                               </td>
                               <td>
                                   <a href="{{ route('fiscal_year_edit',$fis->id) }}" class="badge badge-primary">Edit</a> |
                                   <a href="{{ route('fiscal_delete', $fis->id) }}" class="badge badge-danger" onclick=" return confirm('Are you sure ?');">Delete</a>
                               </td>
                           </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center" style="margin-top:1rem;">
                {{ $fiscals->links() }}
            </div>
        </div>
    </div>
</section>


@endsection