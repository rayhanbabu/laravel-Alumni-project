@foreach($data as $row)
           <tr>
                  <td>{{ $row->id}}</td>
                  <td>{{ $row->admin_name}}</td>
                  <td>{{ $row->bank_name}}, {{ $row->bank_acount}}, {{ $row->bank_route}}</td>
                  <td>{{ $row->withdraw_amount}}</td>
                  <td>{{ $row->withdraw_submited_time}}</td>
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
            <td> <button type="button"  data-withdraw_id="{{$row->id}}" data-withdraw_info="{{$row->withdraw_info}}"
            data-withdraw_status="{{$row->withdraw_status}}"  class="edit btn btn-info btn-sm">Edit </button> </td>

     

        <td>{{ $row->updated_by}}</td>
        <td>{{ $row->updated_by_time}}</td>
               
      </tr>
 @endforeach

      <tr class="pagin_link">
       <td colspan="9" align="center">
        {!! $data->links() !!}
       </td>
      </tr>  