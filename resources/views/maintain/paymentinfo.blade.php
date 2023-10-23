@extends('maintain/dashboardheader')
@section('page_title','Payment View')
@section('payment_select','active')
@section('content')

<div class="row mt-4 mb-0">
               <div class="col-6"> <h4 class="mt-0"> Payment View</h4></div>
             
                     <div class="col-4">
                         <form action="{{url('/onlinepaymentpdf')}}" method="POST" enctype="multipart/form-data">
                         <div class="d-grid gap-2 d-md-flex justify-content-md-end"> 
                         <select class="form-select" name="status" id="status"  aria-label="Default select example" required >
                                      <option value="">Select</option>
                                      <option value="1">Paid</option>
                                      <option value="0">Not Paid</option>
                                  </select>
                                  <input type="month" name="month" class="form-control" value="" required>
                              
                         </div>
                     </div>
                     <div class="col-2">
                         <div class="d-grid gap-2 d-md-flex ">
                        
                                   {!! csrf_field() !!}
                                 
                                   <button type="submit" name="search" class="btn btn-primary">submit  </button>
					                     </form> 
                             
                         </div>
                     </div> 
             </div> 
           <br>

  <div class="card-block table-border-style">                     
    <div class="table-responsive">
      <table class="table table-bordered" id="employee_data">
          <thead>
               <tr> 
                  <th>Id</th>   
                   <th>Admin Name</th>   
                   <th>School</th>
                   <th>Phone</th>        
                   <th>Invoice Date</th> 
                   <th>Description</th>
                   <th>Discount</th>
                   <th>Payment Amount</th>
                   <th>Subscribtion </th>
                   <th>Expired Date </th>
                   <th>Edit</th>
                   <th>Payment Status</th>
                   <th>Payment Type</th>
                   <th>Payment Time</th>
                   
              </tr>
         </thead>
    <tbody> 
             @foreach($payment as $row)
          <tr>
                  <td>{{$row->id}}</td>
                  <td>{{$row->admin_name}}</td>
                  <td>{{$row->nameen}}</td>
                  <td>{{$row->mobile}}</td>
                  <td><?php echo date('d-M-Y',strtotime($row->created_date)) ?></td>
                  <td>{{$row->des1}}</td>
                  <td>{{$row->des2}}, {{$row->amount2}}TK</td>
                  <td>{{$row->payment}}TK</td>
                  <td>{{$row->subscribe}} Month</td>
                  <td><?php echo date('d-M-Y',strtotime($row->expired_date)) ?></td>

             <td> <button type="button" name="view" data-des2="{{ $row->des2 }}"
              data-amount2="{{ $row->amount2 }}" id="{{$row->id}}" class="btn btn-success btn-sm invoice "> Edit</button> </td>
           
                 <td>
                      @if($row->status==1)
                         <button type="button" name="view" data-status="1" id="{{$row->id}}" class="btn btn-success btn-sm view"> Paid </button>  
                      @else 
                        <button type="button" name="view" data-status="0" id="{{$row->id}}" class="btn btn-danger btn-sm view"> Not Paid </button>  
                      @endif
                </td>

                   <td>{{$row->payment_type}}</td>
                   <td>{{$row->payment_time}}</td>
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


        $(document).on('click','.view',function(){
             var invoice_id_view = $(this).attr("id");  
             var statuspay = $(this).data("status");  
             $('#viewmodal').modal('show');
            
              $('#invoice_id_view').val(invoice_id_view);
              $('#statuspay').val(statuspay);

             //alert(invoice_id_view);
                
          });


          $(document).on('click','.invoice',function(){
               var inv_id =$(this).attr("id");  
               var inv_des2  =$(this).data("des2");  
               var inv_amount2  =$(this).data("amount2");  
                 $('#invoice').modal('show');
               
                 $('#inv_id').val(inv_id);
                 $('#inv_des2').val(inv_des2);
                 $('#inv_amount2').val(inv_amount2);
              
               //alert(status);
                
          });

 </script>  
</div>
</div>      
             


  <!-- Modal  View -->
 <div class="modal fade" id="viewmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Payment Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

   <div class="modal-body">
        <form method="post" action="{{url('onlinepaymentstatus')}}"  class="myform"  enctype="multipart/form-data" >
       {!! csrf_field() !!}
            <h4>  Are  you  sure  update  payment  status ?? </h4>
              <input type="hidden" name="invoice_id_view" id="invoice_id_view" class="form-control">
              <input type="hidden" name="status" id="statuspay" class="form-control">

       <div class="mt-4">
          <button type="submit" id="add_employee_btn" class="btn btn-primary">Yes </button>
       </div>  
              
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>




<!-- Modal  View -->
<div class="modal fade" id="invoice" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Extra Pay Amount </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

   <div class="modal-body">
        <form method="post" action="{{url('maintain/paymentedit')}}"  class="myform"  enctype="multipart/form-data" >
         {!! csrf_field() !!}
          
          <input type="hidden" name="inv_id" id="inv_id" class="form-control">
             
           <label> Discount  2 </label>   
           <input type="text" name="des2" id="inv_des2" class="form-control">
               <br>  
           <label> Amount 2 No Need  </label> 
           <input type="number" name="amount2" id="inv_amount2" class="form-control" required>

           <div class="mt-4">
              <button type="submit" id="add_employee_btn" class="btn btn-primary">Update </button>
           </div>  
              
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


@endsection