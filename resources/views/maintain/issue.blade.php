@extends('maintain/dashboardheader')
@section('page_title','Maintain Panel')
@section('issue_select','active')
@section('content')

  <div class="row mt-4 mb-3">
          <div class="col-6"> <h4 class="mt-0">Payment Issue  View</h4></div>
                     <div class="col-3">
                          <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            
                          </div>
                      </div>
                      <div class="col-3">
                         <div class="d-grid gap-2 d-md-flex ">
                          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AddModal">
                           Add
                         </button>         
                </div>
          </div> 
    </div> 




  <!-- Modal Edit -->
  <div class="modal fade" id="EditModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Edit</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

<form method="post" id="edit_form" enctype="multipart/form-data" >
   <div class="modal-body">
 

      <input type="hidden" name="edit_id"  id="edit_id" >

                                
      <div class="form-group  my-2">
	      	<label><b>Category name</b></label>
	        <input name="category" id="edit_category" type="text"   class="form-control"  required/>
          <p class="text-danger err_category"></p>
     </div>

     <div class="form-group  my-2">
	      	<label><b> Amount (TK)</b></label>
	        <input name="amount" id="edit_amount" type="number"   class="form-control"  required/>
          <p class="text-danger err_amount"></p>
     </div>

    <div class="form-group  my-2">
         <label for="lname">Category Show Member</label>
                <select class="form-select" name="status" id="edit_status" aria-label="Default select example"  >
                      <option value="1">Show</option>
                      <option value="0">Hidden</option>
                </select>
     </div>         


    <div class="loader">
            <img src="{{ asset('images/abc.gif') }}" alt="" style="width: 50px;height:50px;">
        </div><br>
 
<input type="submit" id="edit_btn"  value="Update" class="btn btn-success" />


   </div>
   </form> 


      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>   

 <!-- Modal Edit End-->



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
          <th width="10%" class="sorting" data-sorting_type="asc" data-column_name="tran_id" style="cursor: pointer">Invoice ID 
             <span id="tran_id_icon"><i class="fas fa-sort-amount-up-alt"></span></th>
          <th  width="10%">Admin Username</th>
           <th  width="10%">Member Name</th>
          <th  width="10%">Phone </th>
          <th  width="10%">E-mail </th>
          <th  width="15%">Subject</th>
          <th  width="25%">Text</th>
		      <th  width="10%">Feedback Status</th>
          <th  width="10%">Feedback </th>
          <th  width="10%">Edit</th>
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
             url:'/maintain/issue_fetch',
             datType:'json',
             success:function(response){
                    $('tbody').html('');
                    $('.x_content tbody').html(response);
                }
            });
         }

    
           $(document).on('click', '.deleteIcon', function(e){ 
            e.preventDefault(); 
            var delete_id = $(this).val(); 
            if(confirm("Are you sure you want to delete this?"))
                 {
                   $.ajax({
                   type:'DELETE',
                   url:'/maintain/issue_delete/'+delete_id,
                   success:function(response){    
                       //console.log(response); 
                       $('#success_message').html("");
                       $('#success_message').addClass('alert alert-success');
                       $('#success_message').text(response.message)
                       $('#deleteexampleModal').modal('hide');
                       fetch();
                      }
                   }); 
                
                 }
                 else
                  {
                  return false; 
                  }
            });



   



    function fetch_data(page, sort_type="", sort_by="", search=""){
        $.ajax({
           url:"/maintain/issue/fetch_data?page="+page+"&sortby="+sort_by+"&sorttype="+sort_type+"&search="+search,
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
                  
                    var feedback = $(this).data("feedback");
                    var feedback_id = $(this).data("feedback_id");
                    var feedback_status = $(this).data("feedback_status");
            
                     $('#edit_feedback').val(feedback);
                     $('#edit_feedback_id').val(feedback_id);
                     $('#edit_feedback_status').val(feedback_status);

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
      <form method="post" action="{{url('maintain/issue_update')}}"  class="myform"  enctype="multipart/form-data" >
         {!! csrf_field() !!}

            <input type="hidden" id="edit_feedback_id" name="id" class="form-control">

         <div class="row px-3">

            <div class="form-group col-sm-12  my-2">
                <label class=""><b>Feedback Information</b></label>
                <input type="text" name="feedback" id="edit_feedback" class="form-control" required>
            </div> 

            <div class="col-lg-6 my-2">
                  <label class=""><b> Feedback Status </b></label>
                   <select class="form-select" name="feedback_status" id="edit_feedback_status" aria-label="Default select example">
                      <option value="0">Pending</option>
                      <option value="1">Successfull</option>
                      <option value="5">Cencel</option>
                  </select>
            </div>

            <div class="form-group col-sm-6  my-2">
               <label class=""><b>  Document Image (max:500px)</b></label>
               <input type="file" name="image"  class="form-control" >
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