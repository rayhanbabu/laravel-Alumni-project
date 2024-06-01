@extends('admin/dashboardheader')
@section('page_title','Appication')
@section('app_select','active')
@section('content')



<div class="row mt-2 mb-0 mx-1 shadow p-1">
    
       <div class="col-sm-6 my-2">
           <form  method="get" enctype="multipart/form-data">   
             <label> Select Committee </label>
              <select name="committee_id" id="committee_id" class="js-example-disabled-results" style="width:300px;" aria-label="Default select example" required>
                     <option value=""> Select Committee </option>
                      @foreach($committee as $row)  
                          @if($row->id==($committee_id?$committee_id->id:0))
                                <option  value="{{$row->id}}" selected> 
                               {{$row->category}}</option>
                           @else
                             <option value="{{$row->id}}">{{$row->category}}</option>
                           @endif
                      @endforeach
              </select>


      </div>
    

        <div class="col-sm-2 mt-2">
              <button type="submit" name="search" class="btn btn-primary btn-sm">Search</button>
         </div>
      </form>
    </div>


  @if($committee_id!="")    
  <div class="row mt-4 mb-3">
          <div class="col-6"> <h4 class="mt-0">{{$admin_category}} {{$committee_id?$committee_id->category:"" }} </h4></div>
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



      <!-- Modal Add -->
   <div class="modal fade" id="AddModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
     <div class="modal-dialog">
       <div class="modal-content">
         <div class="modal-header">
           <h5 class="modal-title" id="staticBackdropLabel"> Add</h5>
           <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

   <form method="post" id="add_form" enctype="multipart/form-data" >
      <div class="modal-body">
            <ul class="alert alert-warning d-none"  id="add_form_errlist"></ul>

     <div class="form-group  my-2">
	      	<label><b>Name</b></label>
	        <input name="name" id="name" type="text"   class="form-control"  required/>
          <p class="text-danger err_name"></p>
     </div>

      <div class="form-group  my-2">
	       	<label><b>Designation</b></label>
	         <input name="designation" id="designation" type="text"   class="form-control"  required/>
           <p class="text-danger err_designation"></p>
      </div>

      <div class="form-group  my-2">
	       	<label><b>Link</b></label>
	         <input name="link" id="link" type="text"   class="form-control"  />
           <p class="text-danger err_link"></p>
      </div>


        <input type="hidden" name="category"  id="admin_category" value="{{$admin_category}}" >
        <input type="hidden" name="committee_id"  id="admin_category" value="{{$committee_id->id}}" >

    
       <div class="form-group  my-2">
	        	<label><b>Serial No</b></label>
	          <input name="serial" id="serial" type="number"   class="form-control"  />
            <p class="text-danger err_category"></p>
        </div>
   

    <div class="form-group  my-2">
         <label for="lname">Category Show Member</label>
                <select class="form-select" name="status" id="status" aria-label="Default select example"  >
                      <option value="1">Show</option>
                      <option value="0">Hidden</option>
                </select>
     </div>         


          <div class="form-group  my-2">
                <label for="roll"> Image (Max:400KB)</label>
                <input type="file" name="image" id="image" class="form-control" placeholder="" >
                <p class="text-danger error_building_image"></p>
            </div>
	  
   

    
      <div class="loader">
                  <img src="{{ asset('images/abc.gif') }}" alt="" style="width: 50px;height:50px;">
			 </div><br>
	 
    
     <button type="submit"  id="add_btn"   class=" btn btn-success">Submit</button>

   </div>
   </form> 


      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>   

 <!-- Modal Add  End-->



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
	      	<label><b>Name</b></label>
	        <input name="name" id="edit_name" type="text"   class="form-control"  required/>
          <p class="text-danger err_name"></p>
     </div>

       <div class="form-group  my-2">
	        	<label><b>Designation</b></label>
	          <input name="designation" id="edit_designation" type="text"   class="form-control"  required/>
            <p class="text-danger err_designation"></p>
       </div>

      <div class="form-group  my-2">
	       	<label><b>Link</b></label>
	         <input name="link" id="edit_link" type="text"   class="form-control"  />
           <p class="text-danger err_link"></p>
      </div>

       <div class="form-group  my-2">
	        	<label><b>Serial No</b></label>
	          <input name="serial" id="edit_serial" type="number"   class="form-control"  />
            <p class="text-danger err_category"></p>
        </div>
   
      <div class="form-group  my-2">
         <label for="lname">Category Show Member</label>
                <select class="form-select" name="status" id="edit_status" aria-label="Default select example"  >
                      <option value="1">Show</option>
                      <option value="0">Hidden</option>
                </select>
     </div>     
     
     <div class="form-group  my-2">
                <label for="roll"> Image (Max:400KB)</label>
                <input type="file" name="image" id="image" class="form-control" placeholder="" >
                <p class="text-danger error_building_image"></p>
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
             <th  width="10%">Id</th>
             <th  width="10%">Image</th>
              <th width="10%" class="sorting" data-sorting_type="asc" data-column_name="serial" style="cursor: pointer" >Serial 
              <span id="serial_icon" ><i class="fas fa-sort-amount-up-alt"></i></span> </th>

              <th width="15%" class="sorting" data-sorting_type="asc" data-column_name="designation" style="cursor: pointer" >Designation 
              <span id="designation_icon" ><i class="fas fa-sort-amount-up-alt"></i></span> </th>
             
              <th width="35%" class="sorting" data-sorting_type="asc" data-column_name="name" style="cursor: pointer">Name
              <span id="name_icon"><i class="fas fa-sort-amount-up-alt"></span></th>
              <th  width="10%">Web Link</th>
              <th  width="10%">Status</th>
		          <th  width="10%"></th>
		          <th  width="10%"></th>
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

      $('.js-example-basic-multiple').select2();
       $(".js-example-disabled-results").select2();

     $('#add').click(function(){  
           $('#submit').val("Submit");  
           $('#add_form')[0].reset();   			   
      }); 


         fetch();

         var admin_category=$('#admin_category').val();
         function fetch(){
            $.ajax({
             type:'GET',
             url:'/admin/committee_fetch/{{$admin_category}}/{{$committee_id->id}}',
             datType:'json',
             success:function(response){
                    $('tbody').html('');
                    $('.x_content tbody').html(response);
                }
            });
         }
    


           $(document).on('click', '.delete_id', function(e){ 
            e.preventDefault(); 
            var delete_id = $(this).val(); 
            if(confirm("Are you sure you want to delete this?"))
                 {
                   $.ajax({
                   type:'DELETE',
                   url:'/admin/committee_delete/'+delete_id,
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





        $(document).on('submit', '#edit_form', function(e){ 
        e.preventDefault(); 
        var edit_id=$('#edit_id').val();

        let editData=new FormData($('#edit_form')[0]);
        $.ajax({
             type:'POST',
             url:'/admin/committee_update/'+edit_id,
             data:editData,
             contentType: false,
             processData:false,
             beforeSend : function()
               {
               $('.loader').show();
               $("#edit_btn").prop('disabled', true)

               },
             success:function(response){
                   // console.log(response);
                   if(response.status == 400){
                    $('.edit_err_phone').text(response.validate_err.phone);
                    $('.edit_err_dureg').text(response.validate_err.dureg);
                       //  $('#edit_form_errlist').html("");
                       //  $('#edit_form_errlist').removeClass('d-none');
                       //  $.each(response.errors,function(key,err_values){ 
                       //  $('#edit_form_errlist').append('<li>'+err_values+'</li>');
                       //  });
                  }else{
                    $('#edit_form_errlist').html("");
                    $('#edit_form_errlist').addClass('d-none');
                    $('#success_message').html("");
                    $('#success_message').addClass('alert alert-success');
                    $('#success_message').text(response.message)
                    $('#EditModal').modal('hide');
                    $('.err_phone').text('');
                    $('.err_dureg').text('');
                    fetch();
                  }
                  $("#edit_btn").prop('disabled', false)
                  $('.loader').hide();
             }
          });
       });




           $(document).on('click', '.edit_id', function(e){ 
            e.preventDefault(); 
            var edit_id = $(this).val(); 
            //alert(edit_id)
            $('#EditModal').modal('show');
            $.ajax({
             type:'GET',
             url:'/admin/committee_edit/'+edit_id,
             success:function(response){
             
                if(response.status == 404){
                  $('#success_message').html("");
                  $('#success_message').addClass('alert alert-danger');
                  $('#success_message').text(response.message);
                }else{
                  $('#edit_status').val(response.edit_value.status);
                  $('#edit_name').val(response.edit_value.name);
                  $('#edit_designation').val(response.edit_value.designation);
                  $('#edit_serial').val(response.edit_value.serial);
                  $('#edit_link').val(response.edit_value.link);
                  $('#edit_id').val(edit_id);
                }
             }
             });
           });

  


     $(document).on('submit', '#add_form', function(e){ 
          e.preventDefault();
        
          let formData=new FormData($('#add_form')[0]);
       
          $.ajax({
             type:'POST',
             url:'/admin/committee',
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
             if(response.status == 400){
                   $('.err_phone').text(response.validate_err.phone);
                   $('.err_dureg').text(response.validate_err.dureg);
                 }else if(response.status == 500){
                  Swal.fire("Du reg  already exist ", "Please try again", "warning");
                 }else{
                    //console.log(response.message);
                    $('#add_form_errlist').html("");
                    $('#add_form_errlist').addClass('d-none');
                    $('#success_message').html("");
                    $('#success_message').addClass('alert alert-success');
                    $('#success_message').text(response.message)
                    $('#AddModal').modal('hide');
                    $("#add_form")[0].reset();
                    $('.err_phone').text('');
                    $('.err_dureg').text('');
                    fetch();
                 }  
                 $('.loader').hide();
                 $("#add_btn").prop('disabled', false)
             }

            });
        });  



    function fetch_data(page, sort_type="", sort_by="", search=""){
        $.ajax({
        url:"/admin/committee/fetch_data/{{$admin_category}}/{{$committee_id->id}}?page="+page+"&sortby="+sort_by+"&sorttype="+sort_type+"&search="+search,
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


    
       
    


});  
</script>   

@endif

<script type="text/javascript">
        $('.js-example-basic-multiple').select2();
        $(".js-example-disabled-results").select2();
</script>


 @endsection             