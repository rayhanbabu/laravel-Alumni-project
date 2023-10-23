@extends('admin/dashboardheader')
@section('page_title','Appication')
@section('app_select','active')
@section('contentpay')

     <h4 class="mt-4">Company Payment View</h4>
               <ol class="breadcrumb mb-4">                        
               </ol>
           

  <div class="card-block table-border-style">                     
    <div class="table-responsive">
      <table class="table table-bordered" id="employee_data">
          <thead>
               <tr>    
                   <th>Invoice Date</th> 
                   <th>Description</th>
                   <th>Payment Amount</th>
                   <th>Subscribtion </th>
                   <th>Expired Date </th>
                   <th>Payment Status</th>
                   <th>Payment Type</th>
                   <th>Payment Time</th>
                   <th>Print </th>
                   <th>Payment </th>
              </tr>
         </thead>
    <tbody> 
            @foreach($companypay as $row)
         <tr>
                  <td><?php echo date('d-M-Y',strtotime($row->created_date)) ?></td>
                  <td>{{$row->des1}}</td>
                  <td>{{$row->payment}}</td>
                  <td>{{$row->subscribe}} Month</td>
                  <td><?php echo date('d-M-Y',strtotime($row->expired_date)) ?></td>
                  <td>
                     @if($row->status==1)
                      <button type="button" name="view" data-status="1" id="" class="btn btn-success btn-sm view"> Paid </button>  
                      @else 
                      <button type="button" name="view" data-status="0" id="" class="btn btn-danger btn-sm view"> Not Paid</button>  
                     @endif
                  </td>
                  <td>{{$row->payment_type}}</td>
                  <td>{{$row->payment_time}}</td>

                  <td>
		                   <a  class="btn btn-primary btn-sm" href="{{ url('paymentprint/'.$row->id)}}">Print</a> 
                 </td>

                 <td>
		                   <a  class="btn btn-primary btn-sm" href="{{ url('paymentprint/'.$row->id)}}">Pay Now</a> 
                 </td>
         </tr>   
            @endforeach
	
	</tbody>
   </table>

  <script>  
  $(document).ready(function(){  
      $('#employee_data').DataTable({
        "order": [[ 0, "asc" ]] ,
	   "lengthMenu": [[15, 50, 100, -1], [10, 50, 100, "All"]]
      }
	  );  
  });  
 </script>  
</div>
</div>      
               

@endsection 