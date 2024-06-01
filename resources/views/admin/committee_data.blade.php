@foreach($data as $row)
           <tr>
                  <td>{{ $row->id}}</td>
                  <td> <img src="{{ asset('/uploads/admin/'.$row->image) }}" width="100" class="img-thumbnail" alt="Image"></td>
                  <td>{{ $row->serial}}</td>
                  <td>{{ $row->designation}}</td>
                  <td>{{ $row->name}}</td>
                  <td>{{ $row->link}}</td>
                  <td>
          @if($row->status == 1)
             <a href="#"  class="btn btn-success btn-sm">Show<a>
            @else
             <a href="#"  class="btn btn-danger btn-sm"> Hidden<a>
          @endif
         </td>

                  <td> <button type="button" value="{{ $row->id}}" class="edit_id btn btn-primary btn-sm">Edit</button> </td>
                  <td> <button type="button" value="{{ $row->id}}" class="delete_id btn btn-danger btn-sm">Delete</button> </td>
               
      </tr>
 @endforeach

      <tr class="pagin_link">
       <td colspan="9" align="center">
        {!! $data->links() !!}
       </td>
      </tr>  