@foreach($data as $row)
           <tr>
                  <td>{{ $row->tran_id}}</td>
                  <td>{{ $row->name}}</td>
                  <td>{{ $row->phone}}</td>
                  <td>{{ $row->email}}</td>
                  <td>{{ $row->subject}}</td>
                  <td>{{ $row->text}}</td>
                 
            <td>
           @if($row->feedback_status == 1)
             <a href="#"  class="btn btn-success btn-sm">Success<a>
           @elseif($row->withdraw_status == 5)
           <a href="#"  class="btn btn-danger btn-sm"> canceled<a>
            @else
             <a href="#"  class="btn btn-warning btn-sm"> Pending<a>
          @endif
         </td>

     <td>{{ $row->feedback}}</td>
     


        <td>{{ $row->updated_by}}</td>
        <td>{{ $row->updated_by_time}}</td>
               
      </tr>
 @endforeach

      <tr class="pagin_link">
       <td colspan="9" align="center">
        {!! $data->links() !!}
       </td>
      </tr>  