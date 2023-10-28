@foreach($data as $row)
      <tr>
                  <td>{{ $row->category}}</td>
                  <td>{{ $row->amount}}</td>
                  <td>
        @if($row->status == 1)
          <a href="#"  class="btn btn-success btn-sm">Show<a>
            @else
        <a href="#"  class="btn btn-danger btn-sm"> Hidden<a>
            @endif
         </td>

                  <td> <button type="button" value="{{ $row->id}}" class="edit_id btn btn-primary btn-sm">Edit</button> </td>
               
      </tr>
 @endforeach

      <tr class="pagin_link">
       <td colspan="9" align="center">
        {!! $data->links() !!}
       </td>
      </tr>  