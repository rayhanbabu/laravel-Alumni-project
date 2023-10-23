@extends('admin/dashboardheader')
@section('page_title','Admin Panel')
@section($member.'_select','active')
@section('content')


   @if($member=='Executive' OR $member=='General' OR $member=='Advisor' Or $member=='Senior' Or $member=='Alumni')

     <div class="row mt-4 mb-3">
           <div class="col-6"> <h4 class="mt-0">{{$member}} Member View</h4></div>
                     <div class="col-3">
                          <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            
                          </div>
                     </div>
                     <div class="col-3">
                          <div class="d-grid gap-2 d-md-flex "> 
                         <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEmployeeModal"><i
                      class="bi-plus-circle me-2"></i>Add</button>      
                </div>
           </div> 
       </div> 


 <div class="table-responsive">
           <div class="card-body" id="show_all_employees">
                    
                    <h1 class="text-center text-secondary my-5">Loading...</h1>
                
              </div>
     </div>


 {{-- add new employee modal start --}}
<div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="exampleModalLabel"
  data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form  method="POST" id="add_employee_form" enctype="multipart/form-data">
        <div class="modal-body p-4 bg-light">
           <ul class="text-danger"  id="add_form_errlist"></ul>

           <input type="hidden" name="category" id="category" value={{$member}} class="form-control" placeholder="" >

           <div class="col-lg-12">
              <label for="fname">Serial<span style="color:red;"> * </span></label>
              <input type="number" name="serial" id="serial" class="form-control" placeholder="" required>
            </div>

          <div class="my-2">
                <label for="name">Name<span style="color:red;"> * </span></label>
                <input type="text" name="name" id="name" class="form-control" placeholder=""  required>
          </div>
          
          
           <div class="my-2">
               <label for="desig">Designation<span style="color:red;"> * </span></label>
                <input type="text" name="text1" id="text1" class="form-control" placeholder=""  required>
           </div>

           <div class="my-2">
               <label for="desig">WorkPlace/ Institution<span style="color:red;"> * </span></label>
                <input type="text" name="workplace" id="workplace" class="form-control" placeholder=""  required>
           </div>

          <div class="my-2">
            <label for="desig">Current Address </label>
            <input type="text" name="current_address" id="current_address" class="form-control" placeholder="">
          </div>
          
         
          <div class="my-2">
            <label for="desig">Permanent Address </label>
            <input type="text" name="permanent_address" id="permanent_address" class="form-control" placeholder="">
          </div>
          
           <div class="my-2">
            <label for="desig">Facebook Link  </label>
            <input type="text" name="fb_link" id="fb_link" class="form-control" placeholder="">
          </div>

          <div class="row">
            <div class="col-lg-6 my-2">
              <label for="fname">Blood Group</label>
              <select class="form-select" name="blood" id="blood" aria-label="Default select example" >
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

            <div class="col-lg-6 my-2">
              <label for="lname">Blood Group Status </label>
              <select class="form-select" name="blood_status" id="blood_status" aria-label="Default select example"  >
                     <option value="show">Web Show</option>
                     <option value="hidden">Web Hidden</option>
             </select>
            </div>

          
            <div class="col-lg-8 my-2">
              <label for="fname">Phone</label>
              <input name="phone" id="phone" type="text" pattern="[0][1][3 7 6 5 8 9][0-9]{8}" title="
				Please select Valid mobile number"  class="form-control"  />
            </div>

            <div class="col-lg-4 my-2">
              <label for="lname">Phone Status <span style="color:red;"> * </span></label>
              <select class="form-select" name="phone_status" id="phone_status" aria-label="Default select example"  >
                     <option value="show">Web Show</option>
                     <option value="hidden">Web Hidden</option>
             </select>
            </div>


            <div class="col-lg-8 my-2">
              <label for="fname">E-mail</label>
              <input name="email" id="email" type="text"  class="form-control"  />
            </div>

            <div class="col-lg-4 my-2">
              <label for="lname">E-mail Status</label>
              <select class="form-select" name="email_status" id="email_status" aria-label="Default select example"  >
                     <option value="show">Web Show</option>
                     <option value="hidden">Web Hidden</option>
             </select>
            </div>


          </div>

          
          <div class="my-2">
             <label for="avatar">Select Image(300*300)</label>
             <input type="file" name="image"  id="image" class="form-control" >
          </div>
  
          <div class="loader">
            <img src="{{ asset('images/abc.gif') }}" alt="" style="width: 50px;height:50px;">
          </div>

        <div class="mt-4">
          <button type="submit" id="add_btn" class="btn btn-primary">Add </button>
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


{{-- edit employee modal start --}}
<div class="modal fade" id="editEmployeeModal" tabindex="-1" aria-labelledby="exampleModalLabel"
  data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog  modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form  method="POST" id="edit_employee_form" enctype="multipart/form-data">
        <input type="hidden" name="edit_id" id="edit_id">
        <div class="modal-body p-4 bg-light">
          <ul class="text-danger"  id="edit_form_errlist"></ul>
          <div class="row">
            <div class="col-lg-6">
              <label for="fname">Serial<span style="color:red;"> * </span></label>
              <input type="number" name="serial" id="edit_serial" class="form-control" placeholder="" >
            </div>


            <div class="col-lg-6">
              <label for="lname">Category<span style="color:red;"> * </span></label>
              <select class="form-select" name="category" id="edit_category" aria-label="Default select example"  required >
                     <option value="Executive">Executive</option>
                     <option value="Advisor">Advisor</option>
                     <option value="Senior">Senior</option>
                     <option value="General">General</option>
                      <option value="Alumni">Alumni</option>
             </select>
            </div>
          </div>

          <div class="my-2">
            <label for="name">Name </label>
            <input type="text" name="name" id="edit_name" class="form-control" placeholder=""required >
          </div>
          
           <div class="my-2">
               <label for="desig">Designation<span style="color:red;"> * </span></label>
                <input type="text" name="text1" id="edit_text1" class="form-control" placeholder=""  required>
           </div>

          <div class="my-2">
            <label for="desig">WorkPlace/ Institution<span style="color:red;"> * </span></label>
            <input type="text" name="workplace" id="edit_workplace" class="form-control" placeholder=""  required>
          </div>

          <div class="my-2">
            <label for="desig">Current Address </label>
            <input type="text" name="current_address" id="edit_current_address" class="form-control" placeholder="">
          </div>

          <div class="my-2">
            <label for="desig">Permanent Address </label>
            <input type="text" name="permanent_address" id="edit_permanent_address" class="form-control" placeholder="">
          </div>
          
           <div class="my-2">
            <label for="desig">Facebook Link  </label>
            <input type="text" name="fb_link" id="edit_fb_link" class="form-control" placeholder="">
          </div>
          
            <div class="my-2">
            <label for="desig">Session </label>
            <input type="text" name="text2" id="edit_text2" class="form-control" placeholder="">
          </div>

          <div class="row">
            <div class="col-lg-6 my-2">
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

            <div class="col-lg-6 my-2">
              <label for="lname">Blood Group Status </label>
              <select class="form-select" name="blood_status" id="edit_blood_status" aria-label="Default select example"  >
                     <option value="show">Web Show</option>
                     <option value="hidden">Web Hidden</option>
             </select>
            </div>

          
            <div class="col-lg-8 my-2">
              <label for="fname">Phone</label>
              <input name="phone" id="edit_phone" type="text" pattern="[0][1][3 7 6 5 8 9][0-9]{8}" title="
				Please select Valid mobile number"  class="form-control"  />
            </div>

            <div class="col-lg-4 my-2">
              <label for="lname">Phone Status <span style="color:red;"> * </span></label>
              <select class="form-select" name="phone_status" id="edit_phone_status" aria-label="Default select example"  >
                     <option value="show">Web Show</option>
                     <option value="hidden">Web Hidden</option>
             </select>
            </div>


            <div class="col-lg-8 my-2">
              <label for="fname">E-mail</label>
              <input name="email" id="edit_email" type="text"  class="form-control"  />
            </div>

            <div class="col-lg-4 my-2">
              <label for="lname">E-mail Status</label>
              <select class="form-select" name="email_status" id="edit_email_status" aria-label="Default select example"  >
                     <option value="show">Web Show</option>
                     <option value="hidden">Web Hidden</option>
             </select>
            </div>


          </div>


               <div class="my-2">
             <label for="lname">Verify  Status</label>
                <select class="form-select" name="verify_status" id="edit_verify_status" aria-label="Default select example"  >
                     <option value="1">Verifed</option>
                     <option value="0">Pending</option>
               </select>
          </div>
          
             <div class="my-2">
            <label for="desig">Last Blood Donate date </label>
            <input type="date" name="blood_date" id="edit_blood_date" class="form-control" placeholder="">
        </div>

        <div class="my-2">
            <label for="desig">No of Blood Donate  </label>
            <input type="number" name="bloodno" id="edit_bloodno" class="form-control" placeholder="">
        </div>
          
          

          <div class="my-2">
             <label for="avatar">Select Image</label>
             <input type="file" name="image"  id="edit_image" class="form-control" >
          </div>

            <div class="mt-2" id="avatar">

            </div>
  
          <div class="loader">
            <img src="{{ asset('images/abc.gif') }}" alt="" style="width: 50px;height:50px;">
          </div>

        <div class="mt-4">
            <button type="submit" id="edit_btn" class="btn btn-success">Update </button>
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




<script>  
  $(document).ready(function(){ 

    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} });
 
       // add new employee ajax request
      
         let formData=new FormData($('#add_form')[0]);
        

       $("#add_employee_form").submit(function(e) {
        e.preventDefault();
        var extension = $('#image').val().split('.').pop().toLowerCase();
        const fd = new FormData(this);

       // if(jQuery.inArray(extension, ['png','jpeg','jpg']) == -1)
      //  {Swal.fire("Please select Image ", "", "warning"); }else{
    
        $.ajax({
          type:'POST',
          url:'/testimonial/store',
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          beforeSend : function()
               {
               $('.loader').show();
               $("#add_btn").prop('disabled', true);
               },
          success: function(response){
            if(response.status == 400){
               Swal.fire("Added", "Data Added Successfully!", "success");
               $("#add_employee_btn").text('Add');
               $("#add_employee_form")[0].reset();
               $("#addEmployeeModal").modal('hide');
               $('#add_form_errlist').text('');
             
               fetchAll();
             }else if(response.status == 600){
              Swal.fire("Warning", "Serial number already exist", "warning");
             }else if(response.status == 300){
              Swal.fire("Warning", "Image Height*Width = 300*300 ", "warning");
             }else if(response.status == 500){
              Swal.fire("Warning",response.errors, "warning");
             }
             else if(response.status == 700){
                 //console.log(response.validate_err.serial);
                 $.each(response.validate_err,function(key,err_values){
                           //  console.log(err_values);
                    $('#add_form_errlist').append('<li>'+err_values+'</li>');
                 });
            
             }
            $('.loader').hide();
            $("#add_btn").prop('disabled', false);
          }
        });

      // }
      });


      fetchAll();
      function fetchAll() {
        $.ajax({
          type:'GET',
          url:'/testimonial/fetchall/{{$member}}',
          success: function(response) {
            $("#show_all_employees").html(response);
            $("table").DataTable({
              order: [1, 'desc']
            });
          }
        });
      }



        // edit employee ajax request
        $(document).on('click', '.editIcon', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        $.ajax({
          type:'GET',
          url:'/testimonial/edit',
          data: {
            id: id,
          },
          success: function(response){
            $("#edit_serial").val(response.data.serial);
            $("#edit_name").val(response.data.name);
            $("#edit_workplace").val(response.data.workplace);
            $("#edit_current_address").val(response.data.current_address);
            $("#edit_permanent_address").val(response.data.permanent_address);
            $("#edit_blood").val(response.data.blood);
            $("#edit_phone").val(response.data.phone);
            $("#edit_email").val(response.data.email);
            $("#edit_text1").val(response.data.text1);
            $("#edit_category").val(response.data.category);
            $("#edit_blood_status").val(response.data.blood_status);
            $("#edit_phone_status").val(response.data.phone_status);
            $("#edit_email_status").val(response.data.email_status);
            $("#edit_fb_link").val(response.data.fb_link);
            $("#edit_verify_status").val(response.data.verify_status);
            $("#edit_text2").val(response.data.text2);
            $("#edit_blood_date").val(response.data.blood_date);
            $("#edit_bloodno").val(response.data.bloodno);
           
            $("#avatar").html(
              `<img src="/uploads/admin/${response.data.image}" width="100" class="img-fluid img-thumbnail">`);
            $("#edit_id").val(response.data.id);
          }
        });
      });


       // update employee ajax request
       $("#edit_employee_form").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $.ajax({
          type:'POST',
          url:'/testimonial/update',
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          beforeSend : function()
               {
               $('.loader').show();
               $("#edit_btn").prop('disabled', true);
               },
          success: function(response){
            if (response.status == 400){
                  $("#edit_employee_form")[0].reset();
                  $("#editEmployeeModal").modal('hide');
                 Swal.fire("Updated", "Data Updated Successfully!", "success");
                 $('#edit_form_errlist').text('');
               fetchAll();
              }else if(response.status == 200){
               Swal.fire("Warning", response.message, "warning");
              }else if(response.status == 700){
                 //console.log(response.validate_err.serial);
                 $.each(response.validate_err,function(key,err_values){
                           //  console.log(err_values);
                    $('#edit_form_errlist').append('<li>'+err_values+'</li>');
                 });
            
             }
           $("#edit_btn").prop('disabled', false);
            $('.loader').hide();

          }
         
        });
      });



        // delete employee ajax request
        $(document).on('click', '.deleteIcon', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url:'/testimonial/delete',
              method: 'delete',
              data: {
                id: id,
              },
              success: function(response) {
                console.log(response);
                Swal.fire("Deleted", "Data Deleted Successfully!", "success");
                fetchAll();
              }
            });
          }
        })
      });







});

</script>
     
  @else
    <h1>Page not Found</h1>
   @endif

@endsection     