<?php
 use Illuminate\Support\Facades\URL;
?>
@foreach($data as $row)
      <tr>
                  <td>{{ $row->id}}</td>
                  <td>{{ $row->tran_id}}</td>
                  
                  <td> 
                    
                      <a  target="_blank"  href="<?php echo URL::to('nonmember_epay/'.$row->admin_name.'/'.$row->tran_id) ?>">
                      <?php echo URL::to('nonmember_epay/'.$row->admin_name.'/'.$row->tran_id) ?></a> 
                    
                  </td>
                  <td>{{ $row->name}} <br> {{ $row->phone}}</td>
                  <td>{{ $row->category}}</td>
                  <td>{{ $row->email}} , {{ $row->passing_year}} </td>
                  <td>{{ $row->amount}}</td>
            @if($row->payment_status == 1)
              <td> <button type="button" id="{{ $row->id}}" class="status_id btn btn-success btn-sm">Paid</button> </td>
            @else
             <td> <button type="button" id="{{ $row->id}}" class="status_id btn btn-warning btn-sm">Pending</button> </td>
           @endif
                  <td>{{ $row->payment_type}}</td>
                  <td>{{ $row->payment_method}} {{ $row->payment_time}}</td>
               
         
   
     
      </tr>
 
 @endforeach

      <tr class="pagin_link">
       <td colspan="9" align="center">
        {!! $data->links() !!}
       </td>
      </tr>  

    
     