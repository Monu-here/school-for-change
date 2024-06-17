<tr id="std_{{$std->id}}" data-std="{{$std->toJson()}}">
    <td>
        {{$std->regno}}
    </td>
    <td>
        {{$std->roll_no}}
    </td>
    <td>
        {{$std->full_name}}
    </td>
    <td>
        {{$std->nepali_dob}}
    </td>
    <td>
        <span href="" class="btn btn-success btn-sm" data-std="{{$std->toJson()}}" onclick="initEdit(this)">Edit</span>
        <span href="" class="btn btn-danger btn-sm">Delete</span>
    </td>
</tr>