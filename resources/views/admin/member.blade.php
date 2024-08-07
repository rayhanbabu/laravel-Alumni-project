@extends('admin/dashboardheader')
@section('page_title','Admin Panel')
@section($category_id.'_select','active')
@section('content')

   <div class="row mt-3 mb-0 mx-2">
                <div class="col-sm-3 my-2"> <h5 class="mt-0"><?php if($category->category){ echo $category->category;}else{ echo "";}?> View </h5></div>
                     
                 <div class="col-sm-6 my-2">
                 <div class="d-grid gap-2 d-flex justify-content-end"> 
                      Verified:<span class="text-success">{{$verify}}</span>, 
                      E-mail Verify Pending:<span class="text-danger">{{$email_verify}}</span>,
                      Verify Pending:<span class="text-danger">{{$not_verify}}</span> 
                </div>    
                </div>

                <div class="col-sm-3 my-2 ">
                 <div class="d-grid gap-3 d-flex justify-content-end">
                 <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AddModal">
                           Add
                         </button>  
                 </div>
                </div>

                @if(Session::has('success'))
                  <div  class="alert alert-success"> {{Session::get('success')}}</div>
                   @endif
 
                     @if(Session::has('fail'))
                 <div  class="alert alert-danger"> {{Session::get('fail')}}</div>
                  @endif
       </div>             

   
    <div class="row my-2">
    <div class="col-md-3 p-2">
      <select class="form-select form-select-sm" id="range" name="range" aria-label="Default select example " required>
                     <option  value="10">10 </option>
                    <option  value="20">20 </option>
                    <option  value="50">50 </option>
                    <option  value="100">100 </option>
              </select>             
    
    </div>
    <div class="col-md-6 "> </div>

    <div class="col-md-3 p-2">
     <div class="form-group">
      <input type="text" name="search" id="search" placeholder="Enter Search " class="form-control form-control-sm"  autocomplete="off"  />
     </div>
    </div>
   </div>

   <div id="success_message"></div>
				
<div class="overflow">		
<div class="x_content">
 <table id="employee_data"  class="table table-bordered table-hover">
    <thead>
       <tr>
       <th width="15%"> Profile Image </th>
		   <th width="15%">Certificate</th>
      
           <th width="8%" class="sorting" data-sorting_type="asc" data-column_name="member_card" style="cursor: pointer">
           M No  <span id="member_card_icon"> <i class="fas fa-sort-amount-up-alt"></i></span> </th>
           <th width="8%" class="sorting" data-sorting_type="asc" data-column_name="serial" style="cursor: pointer">
           SL <span id="serial_icon"> <i class="fas fa-sort-amount-up-alt"></i></span> </th>
		       <th width="35%">Name</th>
	         <th width="20%">Email </th>
           <th width="35%">Mobile</th>
          
           <th width="15%">Edit</th>
           <th width="5%">View</th>		
          
          <th width="8%" class="sorting" data-sorting_type="asc" data-column_name="email_verify" style="cursor: pointer">
          Email Verification <span id="email_verify_icon" ><i class="fas fa-sort-amount-up-alt"></i></span> </th>

           <th width="8%" class="sorting" data-sorting_type="asc" data-column_name="member_verify" style="cursor: pointer">
           Member Verification <span id="member_verify_icon" ><i class="fas fa-sort-amount-up-alt"></i></span> </th>
          <th width="5%" >Status</th>
          <th width="5%" >Delete</th>
          <th width="15%">Batch</th>
          <th width="15%">Session</th>
          <th width="15%">Profession</th>
          <th width="5%">Password</th>
          <th width="15%">UId</th>
      </tr>

      <tr>
          <td colspan="19">
            <div  class="loader_page text-center">
                <img src="{{ asset('images/abc.gif') }}" alt="" style="width: 50px;height:50px;">
            </div>
         </td>
      </tr>
    </thead>
    <tbody>
       
    </tbody>
  </table>

     <input type="hidden" name="hidden_page" id="hidden_page" value="1"/>
     <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="member_verify" />
     <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="desc" />

     <input type="hidden" name="category_id" id="category_id" value="{{$category_id}}"/>
 
 
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
	        	<label>Name <span style="color:red;"> * </span></label>
	         <input name="name" id="name" type="text" class="form-control"  required/>
           <p class="text-danger err_name"></p>
       </div>

     <div class="form-group  my-2">
	      	<label>Membership Number <span style="color:red;"> * </span></label>
	        <input name="member_card" type="text"   class="form-control"  required/>
          <p class="text-danger err_member_card"></p>
     </div>

       <div class="form-group  my-2">
           <label for="lname">Batch<span style="color:red;"> * </span></label>
                 <select class="form-select" name="batch_id" id="batch_id" aria-label="Default select example"  required>
                       <option value="">Select One</option>
                   @foreach(batch_category() as $category) 
                         <option value="{{$category->id}}">{{$category->category}}</option>
                     @endforeach
                </select>
         </div>
         
         
          <div class="form-group  my-2">
                 <label for="lname"> Session </label>
                 <select class="form-select" name="session_id" id="session_id" aria-label="Default select example">
                         <option value="">Select One</option>
                      @foreach(session_category() as $category) 
                         <option value="{{$category->id}}">{{$category->category}}</option>
                       @endforeach
                 </select>
           </div>     

        <div class="form-group  my-2">
               <label> Phone No <span style="color:red;"> * </span></label>
                  <input name="phone"  type="text" id="phone" pattern="[0][1][3 4 5 6 7 8 9][0-9]{8}" class="form-control" value="" required />
                 <p class="text-danger err_phone"></p>
        </div>

       <div class="form-group  my-2">
           <label>E-mail<span style="color:red;"> * </span></label>
                <input name="email"  type="email" id="email" class="form-control" value="" required />
                <p class="text-danger err_email"></p>
        </div>

      <input type="hidden" name="category_id"  id="category_id" value="{{$category_id}}" >
        
  
     
    
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










<script>  
  $(document).ready(function(){ 

    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} });

              var category=$('#category').val();

        fetchAll();
         function fetchAll(){
            $.ajax({
              type:'GET',
              url:'/admin/member_fetch/{{$category_id}}',
              datType:'json',
              success:function(response){
                    $('tbody').html('');
                    $('.x_content tbody').html(response);
                 }
              });
         }
 
     

         $(document).on('click', '.edit', function(e){ 
            e.preventDefault(); 
            var view_id = $(this).val(); 
            $('#EditModal').modal('show');
            $.ajax({
             type:'GET',
             url:'/admin/member_view/'+view_id,
             success:function(response){
                //console.log(response);
                if(response.status == 404){
                  $('#success_message').html("");
                  $('#success_message').addClass('alert alert-danger');
                  $('#success_message').text(response.message);
                }else{
                  $('#edit_id').val(response.value.id);
                  $('#edit_name').val(response.value.name);
                  $('#edit_serial').val(response.value.serial);
                  $('#edit_category_id').val(response.value.category_id);
                  $('#edit_member_card').val(response.value.member_card);
                  $('#edit_blood').val(response.value.blood);
                  $('#edit_email').val(response.value.email);
                  $('#edit_phone').val(response.value.phone);
                  $('#edit_designation').val(response.value.designation);
                  $("#edit_blood_status").val(response.value.blood_status);
                  $("#edit_phone_status").val(response.value.phone_status);
                  $("#edit_email_status").val(response.value.email_status);
                  $('#edit_village').val(response.value.village);
                  $('#edit_profession_id').val(response.value.profession_id);
                  $('#edit_batch_id').val(response.value.batch_id);
                  $('#edit_session_id').val(response.value.session_id);
                  $('#edit_organization').val(response.value.organization);
                  $("#avatar_image").html(
                `<img src="/uploads/admin/${response.value.profile_image}" width="100" class="img-fluid img-thumbnail">`);
                }
             }
             });
           });




      $(document).on('click', '.view_all', function(e){ 
            e.preventDefault(); 
            var view_id = $(this).val(); 
            //alert(edit_id)
            $('#ViewModal').modal('show');
            $.ajax({
             type:'GET',
             url:'/admin/member_view/'+view_id,
             success:function(response){
                //console.log(response);
                if(response.status == 404){
                  $('#success_message').html("");
                  $('#success_message').addClass('alert alert-danger');
                  $('#success_message').text(response.message);
                }else{
                  $('#view_name').text(response.value.name);
                  $('#view_member_card').text(response.value.member_card);
                  $('#view_category_id').text(response.value.category_id);
                  $('#view_email').text(response.value.email);
                  $('#view_phone').text(response.value.phone);
                  $('#view_degree_category').text(response.value.degree_category);
                  $('#view_passing_year').text(response.value.passing_year);
                  $('#view_gender').text(response.value.gender);
                  $('#view_birth_date').text(response.value.birth_date);
                  $('#view_blood').text(response.value.blood);
                  $('#view_country').text(response.value.country);
                  $('#view_city').text(response.value.city);
                  $('#view_occupation').text(response.value.occupation);
                  $('#view_organization').text(response.value.organization);
                  $('#view_designation').text(response.value.designation);
                  if(response.value.profile_image){
                    $("#avatar").html(
             `<img src="/uploads/admin/${response.value.profile_image}" width="100" class="img-fluid img-thumbnail">`);
                  }else{
                    $("#avatar").html("");
                  }
              
                }
             }
             });
           });




       // update employee ajax request
       $("#edit_employee_form").submit(function(e){
         e.preventDefault();
            const fd = new FormData(this);
         $.ajax({
          type:'POST',
          url:'/admin/member_update',
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          beforeSend : function()
               {
               $('.loader').show();
               },
          success: function(response){
            if (response.status == 200){
               $('#success_message').html("");
               $('#success_message').addClass('alert alert-success');
               $('#success_message').text(response.message);
               $("#edit_employee_form")[0].reset();
               $("#EditModal").modal('hide');
               $('.edit_err_dureg').text('');
               $('.edit_err_phone').text('');
               $('.edit_err_email').text('');
               fetchAll();
             }else if(response.status == 300){
                Swal.fire("Warning",response.message, "warning");
             }else if(response.status == 500){
                Swal.fire("Warning",response.message, "warning");
             }else if(response.status == 400){
                    $('.edit_err_serial').text(response.validate_err.serial);
                    $('.edit_err_phone').text(response.validate_err.phone);
                    $('.edit_err_email').text(response.validate_err.email);
                    $('.edit_err_member_card').text(response.validate_err.member_card);
                    
              }
          
            $('.loader').hide();
          }
         
        });
      
      });


        
       






      function fetch_data(page, sort_type="", sort_by="", search="",range=""){
        $.ajax({
        url:"/admin/member/fetch_data/{{$category_id}}"+"?page="+page+"&sortby="+sort_by+"&sorttype="+sort_type+"&search="+search+"&range="+range,
        beforeSend : function()
               {
               $('.loader_page').show();
               },
        success:function(data)
        {
         $('tbody').html('');
         $('.loader_page').hide();
         $('.x_content tbody').html(data);
        }
        });
         }
   
       
    $(document).on('keyup', '#search', function(){
        var search = $('#search').val();
        var column_name = $('#hidden_column_name').val();
        var sort_type = $('#hidden_sort_type').val();
        var page = $('#hidden_page').val();
        var range = $('#range').val();
        fetch_data(page, sort_type, column_name, search,range);
      });


      $(document).on('click', '.pagin_link a', function(event){
           event.preventDefault();
           var page = $(this).attr('href').split('page=')[1];
           var column_name = $('#hidden_column_name').val();
           var sort_type = $('#hidden_sort_type').val();
           var search = $('#search').val();
           var range = $('#range').val();
          fetch_data(page, sort_type, column_name, search,range);
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
           var search = $('#search').val();
           var range = $('#range').val();
          fetch_data(page, reverse_order, column_name, search,range);
          });


	
          $(document).on('change', '#range', function(){
               var search = $('#search').val();
               var column_name = $('#hidden_column_name').val();
               var sort_type = $('#hidden_sort_type').val();
               var page = $('#hidden_page').val();
              var range = $('#range').val();
             fetch_data(page, sort_type, column_name, search,range);
  });


  $(document).on('submit', '#add_form', function(e){ 
        e.preventDefault();
        
         let formData=new FormData($('#add_form')[0]);
       
         $.ajax({
             type:'POST',
             url:'/admin/member_add',
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
                   $('.err_email').text(response.validate_err.email);
                   $('.err_member_card').text(response.validate_err.member_card);
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
                    $('.err_email').text('');
                    $('.err_member_card').text('');
                    fetch();
                 }  
                 $('.loader').hide();
                 $("#add_btn").prop('disabled', false)
             }

          });
      
    });  





});

</script>


{{-- edit employee modal start --}}
<div class="modal fade" id="EditModal" tabindex="-1" aria-labelledby="exampleModalLabel"
  data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Member</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form  method="POST" id="edit_employee_form" enctype="multipart/form-data">
        <input type="hidden" name="edit_id" id="edit_id">
         <div class="modal-body p-4 bg-light">
          <div class="row">

              <div class="col-lg-3 my-2">
                    <label> Serial Number<span style="color:red;"> * </span></label>
                    <input name="serial"  type="text" id="edit_serial" class="form-control" value="" required />
                    <p class="text-danger edit_err_serial"></p>
              </div>

             
             <div class="col-lg-3 my-2">
                    <label> MemberShip Number <span style="color:red;"> * </span></label>
                    <input name="member_card"  type="text" id="edit_member_card" class="form-control" value="" required />
                    <p class="text-danger edit_err_member_card"></p>
              </div>

              <div class="col-lg-3 my-2">
              <label for="lname">Member Category<span style="color:red;"> * </span></label>
                 <select class="form-select" name="category_id" id="edit_category_id" aria-label="Default select example"  required >
                    @foreach(member_category() as $category) 
                      <option value="{{$category->id}}">{{$category->category}}</option>
                    @endforeach
                </select>
              </div>


              <div class="col-lg-3 my-2">
              <label for="lname">Session</label>
                 <select class="form-select" name="session_id" id="edit_session_id" aria-label="Default select example"   >
                    @foreach(session_category() as $category) 
                      <option value="{{$category->id}}">{{$category->category}}</option>
                    @endforeach
                </select>
              </div>


              <div class="col-lg-7 my-2">
                    <label>Name <span style="color:red;"> * </span></label>
                    <input name="name"  type="text" id="edit_name" class="form-control" value="" required />
                    <p class="text-danger edit_err_name"></p>
              </div>  
              
              <div class="col-lg-5 my-2">
              <label for="lname">Profession</label>
                 <select class="form-select" name="profession_id" id="edit_profession_id" aria-label="Default select example"   >
                     <option value="">Select One</option>
                 @foreach(profession_category() as $category) 
                      <option value="{{$category->id}}">{{$category->category}}</option>
                    @endforeach
                </select>
              </div>


            <div class="col-lg-7 my-2">
                    <label>Committee Designation  </label>
                    <input name="designation"  type="text" id="edit_designation" class="form-control" value=""  />
                    <p class="text-danger edit_err_designation"></p>
              </div>

              <div class="col-lg-5 my-2">
              <label for="lname">Batch/Session</label>
                 <select class="form-select" name="batch_id" id="edit_batch_id" aria-label="Default select example"  >
                       <option value="">Select One</option>
                 @foreach(batch_category() as $category) 
                         <option value="{{$category->id}}">{{$category->category}}</option>
                     @endforeach
                </select>
              </div>


             <div class="col-lg-12 my-2">
                <label> Address</label>
                <input name="village"  type="text" id="edit_village" class="form-control" value=""  />
                <p class="text-danger edit_err_email"></p>
           </div>

           <div class="col-lg-12 my-2">
                <label> Organization </label>
                <input name="organization"  type="text" id="edit_organization" class="form-control" value=""  />
                <p class="text-danger edit_err_email"></p>
           </div>


             <div class="col-lg-8 my-2">
                  <label> Phone   No<span style="color:red;"> * </span></label>
                  <input name="phone"  type="text" id="edit_phone" pattern="[0][1][3 4 5 6 7 8 9][0-9]{8}" class="form-control" value="" required />
                 <p class="text-danger edit_err_phone"></p>
             </div>

             <div class="col-lg-4 my-2">
              <label for="lname">Phone Status <span style="color:red;"> * </span></label>
              <select class="form-select" name="phone_status" id="edit_phone_status" aria-label="Default select example"  >
                     <option value="show">Web Show</option>
                     <option value="hidden">Web Hidden</option>
             </select>
            </div>


            <div class="col-lg-8 my-2">
                <label>E-mail<span style="color:red;"> * </span></label>
                <input name="email"  type="email" id="edit_email" class="form-control" value="" required />
                <p class="text-danger edit_err_email"></p>
           </div>

           <div class="col-lg-4 my-2">
              <label for="lname">E-mail Status</label>
              <select class="form-select" name="email_status" id="edit_email_status" aria-label="Default select example"  >
                     <option value="show">Web Show</option>
                     <option value="hidden">Web Hidden</option>
             </select>
            </div>


            <div class="row">
            <div class="col-lg-8 my-2">
              <label for="fname">Blood Group</label>
              <select class="form-select" name="blood" id="edit_blood" aria-label="Default select example" >
                     <option value="">Select One</option>
                     <option value="A+">A+</option>
                     <option value="A-">A-</option>
                     <option value="B+">B+</option>
                     <option value="B-">B-</option>
                     <option value="O+">O+</option>
                     <option value="O-">O-</option>
                     <option value="AB+">AB+</option>
                     <option value="AB-">AB-</option>
                   
             </select>
            </div>

            <div class="col-lg-4 my-2">
              <label for="lname">Blood  Status </label>
              <select class="form-select" name="blood_status" id="edit_blood_status" aria-label="Default select example"  >
                     <option value="show">Web Show</option>
                     <option value="hidden">Web Hidden</option>
             </select>
            </div>
         </div>

           <div class="col-lg-12 my-2">
                 <label for="roll"> Image (Max:300kb)</label>
                 <input type="file" name="image" id="image" class="form-control" placeholder="" >
            </div>
  </div>

            <div class="mt-2" id="avatar_image">

             </div>

         
          <div class="loader">
              <img src="{{ asset('images/abc.gif') }}" alt="" style="width: 50px;height:50px;">
          </div>

        <div class="mt-4">
            <button type="submit" id="edit_employee_btn" class="btn btn-success">Update </button>
       </div>  

      </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
         
        </div>
      </form>
    </div>
  </div>
</div>
{{-- edit employee modal end --}}





{{-- add new Student modal start --}}
<div class="modal fade" id="ViewModal" tabindex="-1" aria-labelledby="exampleModalLabel"
  data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">View  Member</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form  method="POST" id="add_employee_form" enctype="multipart/form-data">

        <div class="modal-body p-4 bg-light">
          <div class="row">

         


          <div class="mt-2" id="avatar"></div>

        
<div class="row">
          <div class="col-sm-4">
          <b>Name</b>
          </div>
          <div class="col-sm-8" id="view_name">
          </div>
       <hr>
  </div>

  <div class="row">
          <div class="col-sm-4">
          <b>Membership Number</b>
          </div>
          <div class="col-sm-8" id="view_member_card">
          </div>
       <hr>
  </div>

  <div class="row">
          <div class="col-sm-4">
          <b>Category</b>
          </div>
          <div class="col-sm-8" id="view_category">
          </div>
       <hr>
  </div>


  <div class="row">
          <div class="col-sm-4">
          <b>Phone Number</b>
          </div>
          <div class="col-sm-8" id="view_phone">
          </div>
       <hr>
  </div>


  <div class="row">
          <div class="col-sm-4">
          <b>Degree</b>
          </div>
          <div class="col-sm-8" id="view_degree_category">
          </div>
       <hr>
  </div>

  <div class="row">
          <div class="col-sm-4">
          <b>Passing Year</b>
          </div>
          <div class="col-sm-8" id="view_passing_year">
          </div>
       <hr>
  </div>


  <div class="row">
          <div class="col-sm-4">
          <b>Email</b>
          </div>
          <div class="col-sm-8" id="view_email">
          </div>
       <hr>
  </div>

  <div class="row">
          <div class="col-sm-4">
          <b>Gender</b>
          </div>
          <div class="col-sm-8" id="view_gender">
          </div>
       <hr>
  </div>

  <div class="row">
          <div class="col-sm-4">
          <b>Date of Birth</b>
          </div>
          <div class="col-sm-8" id="view_birth_date">
          </div>
       <hr>
  </div>

  <div class="row">
          <div class="col-sm-4">
          <b>Blood</b>
          </div>
          <div class="col-sm-8" id="view_blood">
          </div>
       <hr>
  </div>


     <div class="row">
          <div class="col-sm-4">
              <b>Country</b>
          </div>
             <div class="col-sm-8" id="view_country">
          </div>
       <hr>
    </div>


  <div class="row">
          <div class="col-sm-4">
          <b>City</b>
          </div>
          <div class="col-sm-8" id="view_city">
          </div>
       <hr>
  </div>

  <div class="row">
          <div class="col-sm-4">
          <b>Occupation</b>
          </div>
          <div class="col-sm-8" id="view_occupation">
          </div>
       <hr>
  </div>

  <div class="row">
          <div class="col-sm-4">
          <b> Organization</b>
          </div>
          <div class="col-sm-8" id="view_organization">
          </div>
       <hr>
  </div>

  <div class="row">
          <div class="col-sm-4">
          <b> Designation</b>
          </div>
          <div class="col-sm-8" id="view_designation">
          </div>
       <hr>
  </div>

  
      </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
       
        </div>
      </form>
    </div>
  </div>
</div>

{{-- add new employee modal end --}}



 @endsection             