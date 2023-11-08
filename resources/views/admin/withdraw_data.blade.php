@foreach($data as $row)
      <tr>
                  <td>{{ $row->id}}</td>
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
         @if($row->withdraw_status == 5 OR $row->withdraw_status ==1) 
              <td></td>
         @else
         <td> <button type="button" value="{{ $row->id}}" class="btn btn-danger btn-sm deleteIcon" >Canceled</button>  </td>
         @endif
               
      </tr>
 @endforeach

      <tr class="pagin_link">
       <td colspan="9" align="center">
        {!! $data->links() !!}
       </td>
      </tr>  