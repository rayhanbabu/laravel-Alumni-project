@extends('maintain/dashboardheader')
@section('content')

<div class="row mt-4 mb-3">
               <div class="col-6"> <h4 class="mt-0">Testimonial/FAQ/Protfolio/Home/Service/Team View</h4></div>
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
          <div class="row">
            <div class="col-lg">
              <label for="fname">Serial<span style="color:red;"> * </span></label>
              <input type="text" name="serial" id="serial" class="form-control" placeholder="" required>
            </div>

            <div class="col-lg">
               <label for="lname">Category <span style="color:red;"> * </span></label>
                   <select class="form-select" name="babu" id="babu" aria-label="Default select example"  required >
                         <option value="HeaderImage">HeaderImage</option>
                         <option value="HeaderText">HeaderText</option>  
                         <option value="Client">Client</option>  
                         <option value="FooterContact">FooterContact</option>  
                         <option value="FooterLink1">FooterLink1</option> 
                         <option value="FooterLink2">FooterLink2</option> 
                         <option value="Term">Term</option> 
                         <option value="Policy">Policy</option> 
                         <option value="Refund">Refund</option> 
                         <option value="Cancel">Cancel</option>
                         <option value="DUCLUB">DUCLUB</option>
                         <option value="TermDu">TermDu</option> 
                         <option value="PolicyDu">PolicyDu</option> 
                   </select>
              </div>
          </div>

          <div class="my-2">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="" >
          </div>

          <div class="my-2">
            <label for="desig">designation/Title<span style="color:red;"> * </span></label>
            <input type="text" name="desig" id="desig" class="form-control" placeholder="" required>
          </div>

          <div class="my-2">
            <label for="desig">Link 1</label>
            <input type="text" name="link1" id="link1" class="form-control" placeholder="">
          </div>

          <div class="my-2">
            <label for="desig">Link 2</label>
            <input type="text" name="link2" id="link2" class="form-control" placeholder="">
          </div>

          <div class="my-2">
            <label for="desig">Link 3</label>
            <input type="text" name="link3" id="link3" class="form-control" placeholder="">
          </div>

          <div class="my-2">
            <label for="post">Description</label>
            <textarea name="text" id="text" col="15" rows="5"  class="form-control" ></textarea>
          </div>


          <div class="my-2">
             <label for="avatar">Select Image</label>
             <input type="file" name="image"  id="image" class="form-control" >
          </div>
  
          <div class="loader">
            <img src="{{ asset('images/abc.gif') }}" alt="" style="width: 50px;height:50px;">
          </div>

        <div class="mt-4">
          <button type="submit" id="add_employee_btn" class="btn btn-primary">Add </button>
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
          <div class="row">
            <div class="col-lg">
              <label for="fname">Serial<span style="color:red;"> * </span></label>
              <input type="text" name="serial" id="edit_serial" class="form-control" placeholder="" required>
            </div>

            <div class="col-lg">
              <label for="lname">Category<span style="color:red;"> * </span></label>
                    <select class="form-select" name="babu" id="edit_babu" aria-label="Default select example"  required >
                          <option value="HeaderImage">HeaderImage</option>
                          <option value="HeaderText">HeaderText</option>
                          <option value="Client">Client</option>  
                          <option value="FooterContact">FooterContact</option>  
                          <option value="FooterLink1">FooterLink1</option> 
                          <option value="FooterLink2">FooterLink2</option> 
                          <option value="Term">Term</option> 
                          <option value="Policy">Policy</option> 
                          <option value="Refund">Refund</option> 
                          <option value="Cancel">Cancel</option>
                          <option value="DUCLUB">DUCLUB</option>
                          <option value="TermDu">TermDu</option> 
                          <option value="PolicyDu">PolicyDu</option> 
                    </select>
            </div>
          </div>

          <div class="my-2">
            <label for="name">Name </label>
            <input type="text" name="name" id="edit_name" class="form-control" placeholder="" >
          </div>

          <div class="my-2">
            <label for="desig">designation/Title<span style="color:red;"> * </span></label>
            <input type="text" name="desig" id="edit_desig" class="form-control" placeholder="" required>
          </div>

          <div class="my-2">
            <label for="desig">Link 1</label>
            <input type="text" name="link1" id="edit_link1" class="form-control" placeholder="">
          </div>

          <div class="my-2">
            <label for="desig">Link 2</label>
            <input type="text" name="link2" id="edit_link2" class="form-control" placeholder="">
          </div>

          <div class="my-2">
            <label for="desig">Link 3</label>
            <input type="text" name="link3" id="edit_link3" class="form-control" placeholder="">
          </div>

          <div class="my-2">
            <label for="post">Description</label>
            <textarea name="text" id="edit_text" col="15" rows="5"  class="form-control"  ></textarea>
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
        var extension = $('#image').val().split('.').pop().toLowerCase();
        const fd = new FormData(this);

       // if(jQuery.inArray(extension, ['png','jpeg','jpg']) == -1)
       // {Swal.fire("Please select Image ", "", "warning"); }else{
    
        $.ajax({
          type:'POST',
          url:'/homepage/store',
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
            if(response.status == 400){
               Swal.fire("Added", "Data Added Successfully!", "success");
               $("#add_employee_btn").text('Add');
               $("#add_employee_form")[0].reset();
               $("#addEmployeeModal").modal('hide');
               fetchAll();
             }else if(response.status == 200){
              Swal.fire("Warning", "Image Size grather than 500KB", "warning");
             }else if(response.status == 600){
              Swal.fire("Warning", "Serial number already exist", "warning");
             }else if(response.status == 300){
              Swal.fire("Warning", "Image Height*Width = 300*300 ", "warning");
             }
            $('.loader').hide();
          }
        });

      // }
      });


      fetchAll();
      function fetchAll() {
        $.ajax({
          type:'GET',
          url:'/homepage/fetchall',
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
          url:'/homepage/edit',
          data: {
            id: id,
          },
          success: function(response){
            $("#edit_serial").val(response.data.serial);
            $("#edit_babu").val(response.data.babu);
            $("#edit_name").val(response.data.name);
            $("#edit_desig").val(response.data.desig);
            $("#edit_text").val(response.data.text);
            $("#edit_link1").val(response.data.link1);
            $("#edit_link2").val(response.data.link2);
            $("#edit_link3").val(response.data.link3);
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
          url:'/homepage/update',
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
              url:'/homepage/delete',
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