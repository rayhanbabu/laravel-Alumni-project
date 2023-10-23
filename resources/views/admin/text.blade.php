@extends('admin/dashboardheader')
@section('page_title','Text')
@section('text_select','active')
@section('content')

<div class="row mt-4 mb-3">
               <div class="col-6"> <h4 class="mt-0">Blood View</h4></div>
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
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form  method="POST" id="add_employee_form" enctype="multipart/form-data">
        <div class="modal-body p-4 bg-light">

           <ul class="text-danger"  id="add_form_errlist"></ul>
        
        <div class="my-2">
            <label for="name">Name<span style="color:red;"> * </span></label>
            <input type="text" name="name" id="name" class="form-control" placeholder=""  required>
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

          <div class="row">
            <div class="col-lg-12 my-2">
              <label for="fname">Blood Group<span style="color:red;"> * </span></label>
              <select class="form-select" name="blood" id="blood" aria-label="Default select example"  required>
                     <option value="Select One">Select One</option>
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

      

          
            <div class="col-lg-12 my-2">
              <label for="fname">Phone<span style="color:red;"> * </span></label>
              <input name="phone" id="phone" type="text" pattern="[0][1][3 7 6 5 8 9][0-9]{8}" title="
				Please select Valid mobile number"  class="form-control" required />
            </div>

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
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form  method="POST" id="edit_employee_form" enctype="multipart/form-data">
        <input type="hidden" name="edit_id" id="edit_id">
        <div class="modal-body p-4 bg-light">
        <div class="my-2">
            <label for="name">Name<span style="color:red;"> * </span></label>
            <input type="text" name="name" id="edit_name" class="form-control" placeholder=""  required>
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

          <div class="row">
            <div class="col-lg-12 my-2">
              <label for="fname">Blood Group<span style="color:red;"> * </span></label>
              <select class="form-select" name="blood" id="edit_blood" aria-label="Default select example"  required>
                     <option value="Select One">Select One</option>
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


         <div class="my-2">
            <label for="desig">Last Blood Donate date </label>
            <input type="date" name="blood_date" id="edit_blood_date" class="form-control" placeholder="">
        </div>

        <div class="my-2">
            <label for="desig">No of Blood Donate  </label>
            <input type="number" name="bloodno" id="edit_bloodno" class="form-control" placeholder="">
        </div>

      

          
            <div class="col-lg-12 my-2">
              <label for="fname">Phone<span style="color:red;"> * </span></label>
              <input name="phone" id="edit_phone" type="text" pattern="[0][1][3 7 6 5 8 9][0-9]{8}" title="
				Please select Valid mobile number"  class="form-control" required />
            </div>

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




<script>  
  $(document).ready(function(){ 

    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} });
 
       // add new employee ajax request
      
         let formData=new FormData($('#add_form')[0]);
        

       $("#add_employee_form").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);

       // if(jQuery.inArray(extension, ['png','jpeg','jpg']) == -1)
      //  {Swal.fire("Please select Image ", "", "warning"); }else{
    
        $.ajax({
          type:'POST',
          url:'/text/store',
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
             }else if(response.status == 200){
              Swal.fire("Warning","Image Size grather than 500KB", "warning");
             }else if(response.status == 600){
              Swal.fire("Warning",response.errors, "warning");
             }else if(response.status == 300){
              Swal.fire("Warning","Image Height*Width = 300*300 ", "warning");
             }else if(response.status == 700){
                 $.each(response.validate_err,function(key,err_values){      
                      $('#add_form_errlist').append('<li>'+err_values+'</li>');
                  });
             }
            $("#add_btn").prop('disabled', false);
            $('.loader').hide();
          }
        });

      // }
      });


      fetchAll();
      function fetchAll() {
        $.ajax({
          type:'GET',
          url:'/text/fetchall',
          success: function(response) {
            $("#show_all_employees").html(response);
            $("table").DataTable({
              order: [0, 'desc']
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
          url:'/text/edit',
          data: {
            id: id,
          },
          success: function(response){
            $("#edit_name").val(response.data.name);
            $("#edit_workplace").val(response.data.workplace);
            $("#edit_current_address").val(response.data.current_address);
            $("#edit_permanent_address").val(response.data.permanent_address);
            $("#edit_blood").val(response.data.blood);
            $("#edit_phone").val(response.data.phone);
            $("#edit_blood_status").val(response.data.blood_status);
            $("#edit_blood_date").val(response.data.blood_date);
            $("#edit_bloodno").val(response.data.bloodno);
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
          url:'/text/update',
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
            if (response.status == 400){
               Swal.fire("Updated", "Data Updated Successfully!", "success");
               fetchAll();
             }else if(response.status == 200){
              Swal.fire("Warning", "Image Size grather than 500KB", "warning");
             }
            $("#edit_employee_btn").text('Update');
            $("#edit_employee_form")[0].reset();
            $("#editEmployeeModal").modal('hide');
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
              url:'/text/delete',
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




@endsection     