@foreach($data as $row)
           <tr>
                  <td>{{ $row->id}}</td>
                  <td>{{ $row->admin_name}}</td>
                  <td>{{ $row->bank_name}}, {{ $row->bank_acount}}, {{ $row->bank_route}}</td>
                  <td>{{ $row->withdraw_amount}}</td>
                  <td>{{ $row->withdraw_submited_time}}</td>
                  <td> @if($row->withdraw_status==1){{ $row->current_balance}} @else @endif</td>
                  <td> @if($row->withdraw_status==1){{ $row->withdraw_time}} @else @endif</td>
            <td>
           @if($row->withdraw_status == 1)
             <a href="#"  class="btn btn-success btn-sm">Success<a>
           @elseif($row->withdraw_status == 5)
           <a href="#"  class="btn btn-danger btn-sm"> canceled<a>
            @else
             <a href="#"  class="btn btn-warning btn-sm"> Pending<a>
          @endif
         </td>

            <td>{{ $row->withdraw_type}}</td>
            <td>{{ $row->withdraw_info}}, {{ $row->withdraw_info_update}}</td>
            <td> <img src="{{ asset('/uploads/admin/'.$row->image) }}" width="100" class="img-thumbnail" alt="Image"></td>
            <td> <button type="button"  data-withdraw_id="{{$row->id}}"  data-withdraw_info="{{$row->withdraw_info}}"  class="edit btn btn-info btn-sm">Edit </button> </td>

       <td>
        @if($row->withdraw_status == 5)
        @else
           @if($row->withdraw_status == 1)
            <a href="{{ url('maintain/withdraw/status/deactive/'.$row->id) }}" onclick="return confirm('Are you sure you want you status change')" class="btn btn-success btn-sm">Paid<a>
                 @else
            <a href="{{ url('maintain/withdraw/status/active/'.$row->id) }}" onclick="return confirm('Are you sure you want to status change')" class="btn btn-danger btn-sm">unpaid<a>
                @endif
        </td>
        @endif

        <td>{{ $row->updated_by}}</td>
        <td>{{ $row->updated_by_time}}</td>
               
      </tr>
 @endforeach

      <tr class="pagin_link">
       <td colspan="9" align="center">
        {!! $data->links() !!}
       </td>
      </tr>  