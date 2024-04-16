<?php
 use Illuminate\Support\Facades\URL;
?>
@foreach($data as $row)
      <tr>
                  <td>{{ $row->tran_id}}</td>
                  
                  <td> 
                    
                      <a  target="_blank"  href="<?php echo URL::to('epay/'.$row->admin_name.'/'.$row->tran_id) ?>">
                      <?php echo URL::to('epay/'.$row->admin_name.'/'.$row->tran_id) ?></a> 
                    
                  </td>
                  <td>{{ $row->member_card}} <br> {{ $row->uid}}</td>
                  <td>{{ $row->name}} <br> {{ $row->phone}}</td>
                  <td>{{ $row->category}}</td>
                  <td>{{ $row->amount}}</td>
            @if($row->payment_status == 1)
              <td> <button type="button" id="{{ $row->id}}" class="status_id btn btn-success btn-sm">Paid</button> </td>
            @else
             <td> <button type="button" id="{{ $row->id}}" class="status_id btn btn-warning btn-sm">Unpaid</button> </td>
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

    
     