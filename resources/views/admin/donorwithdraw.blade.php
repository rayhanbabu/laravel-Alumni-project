@extends('admin/dashboardheader')
@section('page_title','Admin Panel')
@section('donorwithdraw_select','active')
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
        <th  width="10%">Bank Informaation</th>
        <th width="10%" class="sorting" data-sorting_type="asc" data-column_name="amount" style="cursor: pointer">Withdraw Amount
         <span id="amount_icon"><i class="fas fa-sort-amount-up-alt"></span></th>
         <th  width="10%"> Withdraw Submitted time</th>
		     <th  width="10%">Withdraw Status</th>
         <th  width="10%">Withdraw Type</th>
         <th  width="10%">Withdraw Info</th>
         <th  width="10%">Image</th>
        <th  width="10%">Updated By</th>
        <th  width="10%">Updated By Time</th>
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
             url:'/admin/donorwithdraw_fetch',
             datType:'json',
             success:function(response){
                    $('tbody').html('');
                    $('.x_content tbody').html(response);
                }
            });
         }

    
          

   
$(document).on('submit', '#add_form', function(e){ 
        e.preventDefault();
        
         let formData=new FormData($('#add_form')[0]);
       
         $.ajax({
             type:'POST',
             url:'/admin/donorwithdraw',
             data:formData,
             contentType: false,
             processData:false,
             beforeSend : function()
               {
               $('.loader').show();
               $("#add_btn").prop('disabled', true)
               },
             success:function(response){
              //console.log(response);
             if(response.status == 700 ){
                   $('.err_withdraw_amount').text(response.message.dureg);
              }else if(response.status == 300){
                   $('.err_withdraw_amount').text(response.message);
               }else if(response.status == 200){
                    //console.log(response.message);
                    $('#add_form_errlist').html("");
                    $('#add_form_errlist').addClass('d-none');
                    $('#success_message').html("");
                    $('#success_message').addClass('alert alert-success');
                    $('#success_message').text(response.message)
                    $('#AddModal').modal('hide');
                    $("#add_form")[0].reset();
                    $('.err_withdraw_amount').text('');
                    fetch();
                 }  
                 $('.loader').hide();
                 $("#add_btn").prop('disabled', false)
             }

          });
      
    });  




    function fetch_data(page, sort_type="", sort_by="", search=""){
        $.ajax({
           url:"/admin/donorwithdraw/fetch_data?page="+page+"&sortby="+sort_by+"&sorttype="+sort_type+"&search="+search,
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
                    var withdraw_info = $(this).data("withdraw_info");
                    var withdraw_id = $(this).data("withdraw_id");
                    var withdraw_status = $(this).data("withdraw_status");
            
                    $('#edit_withdraw_info').val(withdraw_info);
                    $('#edit_withdarw_id').val(withdraw_id);
                    $('#edit_withdraw_status').val(withdraw_status);
                    $('#updatemodal').modal('show'); 
                });
    

});  
</script>   



  

<!-- Modal Edit -->
<div class="modal fade" id="updatemodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"> Edit</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
      <form method="post" action="{{url('maintain/donorwithdraw_update')}}"  class="myform"  enctype="multipart/form-data" >
         {!! csrf_field() !!}

         <input type="hidden" id="edit_withdarw_id" name="id" class="form-control">

         <div class="row px-3">

            <div class="form-group col-sm-12  my-2">
                <label class=""><b>Withdraw Information</b></label>
                <input type="text" name="withdraw_info" id="edit_withdraw_info" class="form-control" required>
            </div> 

            <div class="form-group col-sm-6  my-2">
               <label class=""><b>Bank  Document Image (max:500px)</b></label>
               <input type="file" name="image"  class="form-control" >
            </div> 
            
            <div class="form-group col-sm-6  my-2">
               <label class=""><b> Withdraw Status </b></label>
               <select class="form-select" name="withdraw_status" id="edit_withdraw_status"  aria-label="Default select example">
                    <option value="0">Pending</option>
                    <option value="1">Success</option>
                    <option value="5">Cencel</option>
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