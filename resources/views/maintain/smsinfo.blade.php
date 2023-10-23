@extends('maintain/dashboardheader')
@section('page_title','SMS Info')
@section('smsinfo_select','active')
@section('content')

<div class="row mt-4 mb-0">
               <div class="col-6"> <h4 class="mt-0"> SMS View</h4></div>
             
                     <div class="col-4">
                         <form action="{{url('/onlinesmspdf')}}" method="POST" enctype="multipart/form-data">
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
                     <th>Adminname</th>
                     <th>name</th>
                     <th>SMS</th>
                     <th>Payment</th>
                     <th>Requested  at</th>
                     <th>Status</th>
                     <th>Verify Status</th>
                     <th>Payment Type</th>
                     <th>Payment Time</th>                  
                </tr>
          </thead>
    <tbody> 
             @foreach($data as $row)
             <tr>
                  <td>{{$row->admin_name}}</td>
                  <td>{{$row->nameen}}</td>
                  <td>{{$row->smsno }}</td>
                  <td>{{$row->payment}}TK</td>
                  <td>{{$row->created_at}}</td>
                
                  <td>
                      @if($row->status==1)
                         <button type="button" name="view" data-smsno="{{$row->smsno}}" data-admin_name="{{$row->admin_name}}" data-statuspay="1" id="{{$row->id}}" class="btn btn-success btn-sm view"> Paid </button>  
                       @else 
                         <button type="button" name="view" data-smsno="{{$row->smsno}}" data-admin_name="{{$row->admin_name}}"  data-statuspay="0" id="{{$row->id}}" class="btn btn-danger btn-sm view"> Not Paid </button>  
                       @endif
                  </td>

             <td>
                @if($row->verify_status == 1)         
                <a href="{{ url('maintain/sms/verify_status/deactive/'.$row->id) }}" class="btn btn-success btn-sm" >Active<a>     
               @else
                <a href="{{ url('maintain/sms/verify_status/active/'.$row->id) }}" class="btn btn-danger btn-sm" >Deactive<a>       
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
             var statuspay = $(this).data("statuspay");  
             var admin_name = $(this).data("admin_name");
             var smsno = $(this).data("smsno");    
             $('#viewmodal').modal('show');
            
              $('#invoice_id_view').val(invoice_id_view);
              $('#statuspay').val(statuspay);
              $('#admin_name').val(admin_name);
              $('#smsno').val(smsno);

             //alert(statuspay);
                
          });


  </script>  


    <!-- Modal  View -->
 <div class="modal fade" id="viewmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Payment Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

   <div class="modal-body">
        <form method="post" action="{{url('maintain/smspayment')}}"  class="myform"  enctype="multipart/form-data" >
              {!! csrf_field() !!}
              <h4> Are  you  sure  update  payment  status ?? </h4>
              <input type="hidden" name="invoice_id_view" id="invoice_id_view" class="form-control">
              <input type="hidden" name="status" id="statuspay" class="form-control">
              <input type="hidden" name="admin_name" id="admin_name" class="form-control">
              <input type="hidden" name="smsno" id="smsno" class="form-control">

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

@endsection