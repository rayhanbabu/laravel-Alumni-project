@foreach($data as $row)
      <tr>
                  <td>{{ $row->id}}</td>
                  <td>{{ $row->member_card}}</td>
                  <td>{{ $row->name}}</td>
                  <td>{{ $row->category}}</td>
                  <td>{{ $row->total_amount}}</td>
            @if($row->payment_status == 1)
              <td> <button type="button" id="{{ $row->id}}" class="status_id btn btn-success btn-sm">Paid</button> </td>
            @else
             <td> <button type="button" id="{{ $row->id}}" class="status_id btn btn-warning btn-sm">Pending</button> </td>
           @endif
                  <td>{{ $row->payment_type}}</td>
                  <td>{{ $row->payment_method}} {{ $row->payment_time}}</td>
               
          <td> <button type="button" id="{{ $row->id}}" class="delete_id btn btn-danger btn-sm">Delete</button> </td>
         

     
      </tr>
 @endforeach

      <tr class="pagin_link">
       <td colspan="9" align="center">
        {!! $data->links() !!}
       </td>
      </tr>  