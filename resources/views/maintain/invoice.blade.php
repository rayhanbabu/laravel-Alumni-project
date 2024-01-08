@extends('maintain/dashboardheader')
@section('page_title','Maintain Panel')
@section('withdraw_select','active')
@section('content')

  <div class="row mt-4 mb-3">
          <div class="col-6"> <h4 class="mt-0"> Withdraw Payment  View</h4></div>
                     <div class="col-3">
                          <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            
                          </div>
                      </div>
                      <div class="col-3">
                         <div class="d-grid gap-2 d-md-flex ">           
                </div>
          </div> 
    </div> 

    <div class="form-group  mx-2 my-2">
                           @if(Session::has('fail'))
                   <div  class="alert alert-danger"> {{Session::get('fail')}}</div>
                                @endif
                             </div>

                             <div class="form-group  mx-2 my-2">
                           @if(Session::has('success'))
                   <div  class="alert alert-success"> {{Session::get('success')}}</div>
                                @endif
                             </div>



<div id="success_message"></div>
 <div class="row mb-2">
    <div class="col-md-9">

    </div>
    <div class="col-md-3">
     <div class="form-group">
      <input type="text" name="search" id="search" placeholder="Enter Search " class="form-control"  autocomplete="off"  />
     </div>
    </div>
   </div>


   <div class="card-block table-border-style">                     
 <div class="table-responsive">
 <div class="x_content">
 <table class="table table-bordered" id="employee_data">
 <thead>
    <tr>
       <th  width="10%">Id</th>
       <th  width="10%">Admin Name</th>
       <th width="35%" class="sorting" data-sorting_type="asc" data-column_name="tran_id" style="cursor: pointer">Invoice Id
         <span id="tran_id_icon"><i class="fas fa-sort-amount-up-alt"></span></th>
       <th  width="10%"> Name</th>
       <th  width="10%">Card No</th>
       <th  width="10%">Phone</th>
		   <th  width="10%">Amount</th>
       <th  width="10%">Payment Status</th>
       <th  width="10%">Payment Type</th>
       <th  width="10%">Payment Time</th>
       <th  width="10%">Problem Status</th>
       <th  width="10%">Problem Update Time</th>
       <th  width="10%">Problem Update By</th>
       <th  width="10%">Edit</th>
		 
      
  </tr>
    </thead>
    <tbody>
       
    </tbody>
  </table>
    <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
    <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="id" />
    <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc" />
 
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


       fetch();
       function fetch(){
            $.ajax({
             type:'GET',
             url:'/maintain/invoice_fetch',
             datType:'json',
             success:function(response){
                    $('tbody').html('');
                    $('.x_content tbody').html(response);
                }
            });
         }

  

    function fetch_data(page, sort_type="", sort_by="", search=""){
        $.ajax({
           url:"/maintain/invoice/fetch_data?page="+page+"&sortby="+sort_by+"&sorttype="+sort_type+"&search="+search,
           success:function(data)
        {
           $('tbody').html('');
           $('.x_content tbody').html(data);
        }
        });
         }
   
       
    $(document).on('keyup', '#search', function(){
        var search = $('#search').val();
        var column_name = $('#hidden_column_name').val();
        var sort_type = $('#hidden_sort_type').val();
        var page = $('#hidden_page').val();
        fetch_data(page, sort_type, column_name, search);
      });


      $(document).on('click', '.pagin_link a', function(event){
           event.preventDefault();
           var page = $(this).attr('href').split('page=')[1];
           var column_name = $('#hidden_column_name').val();
           var sort_type = $('#hidden_sort_type').val();
           var search = $('#serach').val();
          fetch_data(page, sort_type, column_name, search);
        }); 


        $(document).on('click', '.sorting', function(){
          var column_name = $(this).data('column_name');
          var order_type = $(this).data('sorting_type');
          var reverse_order = '';
            if(order_type == 'asc')
             {
            $(this).data('sorting_type', 'desc');
            reverse_order = 'desc';
            $('#'+column_name+'_icon').html('<i class="fas fa-sort-amount-down"></i>');
             }
            else
            {
            $(this).data('sorting_type', 'asc');
            reverse_order = 'asc';
            $('#'+column_name+'_icon').html('<i class="fas fa-sort-amount-up-alt"></i>');
            }
           $('#hidden_column_name').val(column_name);
           $('#hidden_sort_type').val(reverse_order);
           var page = $('#hidden_page').val();
           var search = $('#serach').val();
          fetch_data(page, reverse_order, column_name, search);
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
      <form method="post" action="{{url('maintain/invoice_update')}}"  class="myform"  enctype="multipart/form-data" >
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