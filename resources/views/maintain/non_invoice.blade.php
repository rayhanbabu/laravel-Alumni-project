@extends('maintain/dashboardheader')
@section('page_title','Maintain Panel')
@section('non_invoice_select','active')
@section('content')

<div class="card mt-2 mb-2 shadow-sm">
       <div class="card-header">
       <div class="row ">
               <div class="col-4">  <h5 class="mt-0">Non Member Invoice Details </h5>  </div>
                       <div class="col-4">
                          
                         </div>
                   

                    
                     <div class="col-2">
                         <div class="d-grid gap-2 d-md-flex ">
                      
                         </div>
                     </div> 
         </div>
           
         @if(Session::has('fail'))
             <div  class="alert alert-danger"> {{Session::get('fail')}}</div>
         @endif
                        
        @if(Session::has('success'))
              <div  class="alert alert-success"> {{Session::get('success')}}</div>
            @endif


                  
      
        </div>

      
    <div class="card-body">   
    <div class="row">
         <div class="col-md-12">
           <div class="table-responsive">
                <table class="table  table-bordered data-table">
                   <thead>
                     <tr>
                     <th  width="10%">Id</th>
                     <th  width="10%">Admin Name</th>
                     <th >Invoice ID</th>
                     <th  width="10%"> Name</th> 
                     <th  width="10%">Phone</th>
		                 <th  width="10%">Amount</th>
                    <th  width="10%">Payment Status</th>
                    <th  width="10%">Payment Type</th>
                    <th >Payment Method</th>
                  
                  
                     <th  width="10%">Edit</th>    
                     <th  width="10%">Payment Time</th>
                     <th  width="10%">Problem Status</th>
                     <th  width="10%">Problem Update Time</th>
                     <th  width="10%">Problem Update By</th>
                     <th  width="10%"> bank_tran </th>
                        
                      </tr>
                   </thead>
                   <tbody>

                   </tbody>

                </table>
               
          </div>
       </div>
    </div>
    </div>


</div>




<script>  
$(document).ready(function(){ 

   
  $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} });

     $('#add').click(function(){  
           $('#submit').val("Submit");  
           $('#add_form')[0].reset();   			   
      }); 



      $(function() {
   var table = $('.data-table').DataTable({
       processing: true,
       serverSide: true,
       ajax: {
           url: "{{ url('/maintain/non_invoice') }}",
           error: function(xhr, error, code) {
               console.log(xhr.responseText);
           }
       },
       order: [[0, 'desc']],
       columns: [
            {data: 'id', name: 'id'},
            {data: 'admin_name', name: 'admin_name'},
            {data: 'tran_id', name: 'tran_id'},
            {data: 'name', name: 'name'},
            {data: 'phone', name: 'phone'},
            {data: 'total_amount', name: 'total_amount'},
            {data: 'payment_status', name: 'payment_status'},
            {data: 'payment_type', name: 'payment_type'},
            {data: 'payment_method', name: 'payment_method'},
         
          
            {data: 'edit', name: 'edit'},
            {data: 'payment_time', name: 'payment_time'},
            {data: 'problem_status', name: 'problem_status'},
            {data: 'problem_update_time', name: 'problem_update_time'},
            {data: 'problem_update_by', name: 'problem_update_by'},
            {data: 'bank_tran', name: 'bank_tran'},
          
       ]
   });
});
      

    
          $(document).on('click','.edit',function(){
                  
                  
                    var payment_method = $(this).data("payment_method");
                    var payment_status = $(this).data("payment_status");
                    var bank_tran = $(this).data("bank_tran");
                    var invoice_id = $(this).data("invoice_id");
                    var name = $(this).data("name");
            
                     $('#edit_payment_method').val(payment_method);
                     $('#edit_payment_status').val(payment_status);
                     $('#edit_bank_tran').val(bank_tran);
                     $('#edit_invoice_id').val(invoice_id);
                     $('#edit_name').val(name);

                
                     $('#updatemodal').modal('show');

                  
                });
    

});  
</script>   



  

<!-- Modal Edit -->
<div class="modal fade" id="updatemodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"> Edit</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
      <form method="post" action="{{url('maintain/non_invoice_update')}}"  class="myform"  enctype="multipart/form-data" >
         {!! csrf_field() !!}

            <input type="hidden" id="edit_invoice_id" name="id" class="form-control">

         <div class="row px-3">

         <div class="form-group col-sm-12  my-2">
               
                <input type="text" name="name" id="edit_name" class="form-control" readonly>
         </div> 

          <div class="form-group col-sm-12  my-2">
                <label class=""><b>Payment Method</b></label>
                <input type="text" name="payment_method" id="edit_payment_method" class="form-control" required>
         </div> 

         <div class="form-group col-sm-12  my-2">
                <label class=""><b> Bank Tran Id</b></label>
                <input type="text" name="bank_tran" id="edit_bank_tran" class="form-control" required>
         </div> 

          <div class="form-group col-sm-12  my-2">
           <label class=""><b>Payment Status</b></label>
             <select class="form-select" id="edit_payment_status"  name="payment_status" aria-label="Default select example" required>
                   <option value="0">Unpaid</option>
                   <option value="1">paid</option>
             </select>
         </div>   
  

    </div>

     <br>
      <input type="submit"   id="insert" value="Update" class="btn btn-success" />
	  
              
   </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>





 @endsection             