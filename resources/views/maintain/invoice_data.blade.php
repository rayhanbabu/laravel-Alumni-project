@foreach($data as $row)
           <tr>
                  <td>{{ $row->id}}</td>
                  <td>{{ $row->admin_name}}</td>
                  <td>{{ $row->tran_id}}</td>
                  <td>{{ $row->name}}</td>
                  <td>{{ $row->card}}</td>
                  <td>{{ $row->phone}}</td>
                  <td>{{ $row->total_amount}}</td>

               <td>
                   @if($row->payment_status == 1)
                    <a href="#"  class="btn btn-success btn-sm">Paid<a>
                   @else
                    <a href="#"  class="btn btn-warning btn-sm"> Unpaid<a>
                   @endif
              </td>

             <td>{{ $row->payment_type}}  {{ $row->payment_method}}</td>
             <td>{{ $row->payment_time}}</td>
             <td>{{ $row->problem_status}}</td>
             <td>{{ $row->problem_update_time }}</td>
             <td>{{ $row->problem_update_by }}</td>

        <td> <button type="button"  data-payment_method="{{$row->payment_method}}"  
            data-payment_status="{{$row->payment_status}}" data-bank_tran="{{$row->bank_tran}}"  
            data-invoice_id="{{$row->id}}"   data-name="{{$row->name}}" 
         class="edit btn btn-info btn-sm">Edit </button> </td>
     
          </tr>
 @endforeach

      <tr class="pagin_link">
       <td colspan="9" align="center">
        {!! $data->links() !!}
       </td>
     </tr>  