<?php
   use Illuminate\Support\Facades\URL;
?>
@foreach($data as $row)
<tr>
  @if(!empty($row->profile_image))
  <td><a href="<?php echo URL::to('uploads/admin/'.$row->profile_image) ?>">Profile Image</a></td>
  @else <td><a href="">{{$row->profile_image}}</a></td> @endif

  @if(!empty($row->certificate_image))
  <td><a href="<?php echo URL::to('uploads/admin/'.$row->certificate_image) ?>">Certificate</a></td>
  @else <td><a href="">{{$row->certificate_image}}</a></td> @endif

  <td>{{ $row->member_card}}</td>
  <td>{{ $row->serial}}</td>
  <td>{{ $row->name}}</td>
  <td>{{ $row->email}}</td>
  <td>{{ $row->phone}}</td>
 
  <td> <button type="button" value="{{ $row->id}}" class="edit btn btn-info btn-sm">Edit </button> </td>
  <td> <button type="button" value="{{ $row->id}}" class="view_all btn btn-primary btn-sm">View</button> </td>



  <td>
    @if($row->email_verify == 1)
    <a href="{{ url('admin/member/email/deactive/'.$row->id) }}" onclick="return confirm('Are you sure you want to Change this status')" class="btn btn-success btn-sm">verified<a>
        @else
        <a href="{{ url('admin/member/email/active/'.$row->id) }}" onclick="return confirm('Are you sure you want to Move this status')" class="btn btn-danger btn-sm"> Pending verification<a>
            @endif
  </td>

  <td>
    @if($row->member_verify == 1)
    <a href="{{ url('admin/member/verify/deactive/'.$row->id) }}" onclick="return confirm('Are you sure Hall Varification this profile')" class="btn btn-success btn-sm">verifed<a>
        @else
        <a href="{{ url('admin/member/verify/active/'.$row->id) }}" onclick="return confirm('Are you sure Hall Varification this profile')" class="btn btn-danger btn-sm">Pending verification<a>
            @endif
  </td>

  <td>
    @if($row->status == 1)
    <a href="{{ url('admin/member/status/deactive/'.$row->id) }}" onclick="return confirm('Are you sure you want to Change this status')" class="btn btn-success btn-sm">Active<a>
        @else
        <a href="{{ url('admin/member/status/active/'.$row->id) }}" onclick="return confirm('Are you sure you want to Change this status')" class="btn btn-danger btn-sm"> Inactive<a>
            @endif
   </td>

  <td><a href="/admin/member_delete/{{ $row->id }}" onclick="return confirm('Are you sure you want to dalete  this item?')"  class="btn btn-danger btn-sm">Delete</a> </td> 

  <td>{{ show_category($row->batch_id)}}</td>
  <td>{{ show_category($row->session_id)}}</td>
  <td>{{ show_category($row->profession_id)}}</td>
  <td>{{ $row->member_password}}</td>
  <td>{{ $row->id}}</td>
  




  @endforeach
</tr>

<tr class="pagin_link">
  <td colspan="13" align="center">
    {!! $data->links() !!}
  </td>
</tr>