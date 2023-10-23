@extends('admin/dashboardheader')
@section('page_title','Admin Panel')
@section($member.'_select','active')
@section('content')

@if($member=='Welcome' OR $member=='Testimonial' OR $member=='Magazine' Or $member=='Slide' Or $member=='Gallery'Or $member=='Link')
    <div class="row mt-4 mb-3">
               <div class="col-6"> <h4 class="mt-0">{{$member}}  View</h4></div>
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
  <div class="modal-dialog modal-lg modal-dialog-centered">
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

            <div class="col-lg-12">
              <label for="fname">Title<span style="color:red;"> * </span></label>
              <input type="text" name="title" id="title" class="form-control" placeholder="" required>
            </div>

         @if($member=='Slide')


                 <input type="hidden" name="text1" id="title" value="text1" class="form-control" placeholder="">
                 <input type="hidden" name="text2" id="title" class="form-control" placeholder="">
                 <input type="hidden" name="name" id="name" class="form-control" placeholder="" >
                 <input type="hidden" name="workplace" id="workplace" class="form-control" placeholder="" >


                 <div class="my-2">
                 <label for="lname">Category<span style="color:red;"> * </span></label>
                 <select class="form-select" name="text4" id="text4" aria-label="Default select example"  required >
                      <option value="Slide">Slide</option>
                      <option value="Logu">Logu</option>
                      <option value="HeaderLogu">Header Logu</option>
                 </select>
            </div>  


          <div class="my-2">
                <label for="avatar">Select Image(max:1600*900)<span style="color:red;"> * </span></label>
                <input type="file" name="image"  id="image" class="form-control" required>
          </div>


          @elseif($member=='Gallery')
               
          <input type="hidden" name="text1" id="title" value="text1" class="form-control" placeholder="">
                 <input type="hidden" name="text2" id="title" class="form-control" placeholder="">
                 <input type="hidden" name="name" id="name" class="form-control" placeholder="" >
                 <input type="hidden" name="workplace" id="workplace" class="form-control" placeholder="" >


                

          <div class="my-2">
                <label for="avatar">Select Image(max:1600*900)<span style="color:red;"> * </span></label>
                <input type="file" name="image"  id="image" class="form-control" required>
          </div>
       @elseif($member=='Link') 
                    <input type="hidden" name="text1" id="title" value="text1" class="form-control" placeholder="">
                   <input type="hidden" name="text2" id="title" class="form-control" placeholder="">
                   <input type="hidden" name="name" id="name" class="form-control" placeholder="" >
                   <input type="hidden" name="workplace" id="workplace" class="form-control" placeholder="" >


                

          <div class="my-2">
                <label for="avatar">Select Image/Pdf (Max: 700KB)<span style="color:red;"> * </span></label>
                <input type="file" name="image"  id="image" class="form-control" required>
          </div>


        @else
          <div class="my-2">
            <label for="desig">Text 1<span style="color:red;"> * </span></label>
            <textarea name="text1" id="text1" col="10" rows="4"  class="form-control" ></textarea>
          </div>

          <div class="my-2">
            <label for="desig">Text 2  </label>
            <textarea name="text2" id="text2" col="10" rows="4"  class="form-control" ></textarea>
          </div>

        <div class="row">
          <div class="col-sm-6 my-2">
            <label for="name">Name<span style="color:red;"> * </span></label>
            <input type="text" name="name" id="name" class="form-control" placeholder=""  required>
          </div>

          <div class="col-sm-6 my-2">
            <label for="desig">WorkPlace/ Institution<span style="color:red;"> * </span></label>
            <input type="text" name="workplace" id="workplace" class="form-control" placeholder=""  required>
          </div>
        </div>

        <div class="my-2">
             <label for="avatar">Select Image(300*300)</label>
             <input type="file" name="image"  id="image" class="form-control" >
          </div>


     @endif
          
          
        

  
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
  <div class="modal-dialog modal-lg  modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form  method="POST" id="edit_employee_form" enctype="multipart/form-data">
        <input type="hidden" name="edit_id" id="edit_id">
        <div class="modal-body p-4 bg-light">
          <ul class="text-danger"  id="edit_form_errlist"></ul>
        
          <div class="my-2">
              <label for="fname">Serial<span style="color:red;"> * </span></label>
              <input type="text" name="serial" id="edit_serial" class="form-control" placeholder="" >
           </div>

           <div class="col-lg-12">
              <label for="fname">Title<span style="color:red;"> * </span></label>
              <input type="text" name="title" id="edit_title" class="form-control" placeholder="" required>
            </div>

           @if($member=='Slide')
                 <input type="hidden" name="text1" id="title" value="text1" class="form-control" placeholder="">
                 <input type="hidden" name="text2" id="title" class="form-control" placeholder="">
                 <input type="hidden" name="name" id="name" class="form-control" placeholder="" >
                 <input type="hidden" name="workplace" id="workplace" class="form-control" placeholder="" >


            <div class="my-2">
                 <label for="lname">Category<span style="color:red;"> * </span></label>
                 <select class="form-select" name="text4" id="edit_text4" aria-label="Default select example"  required >
                      <option value="Slide">Slide</option>
                      <option value="Logu">Logu</option>
                      <option value="HeaderLogu">Header Logu</option>
                 </select>
            </div>  


             <div class="my-2">
                 <label for="avatar">Select Image(max:1600*900)</label>
                 <input type="file" name="image"  id="edit_image" class="form-control" />
             </div>

             @elseif($member=='Gallery')
               
                       <input type="hidden" name="text1" id="title" value="text1" class="form-control" placeholder="">
                      <input type="hidden" name="text2" id="title" class="form-control" placeholder="">
                      <input type="hidden" name="name" id="name" class="form-control" placeholder="" >
                      <input type="hidden" name="workplace" id="workplace" class="form-control" placeholder="" >
     
     
                     
     
               <div class="my-2">
                     <label for="avatar">Select Image(max:1600*900)<span style="color:red;"> * </span></label>
                     <input type="file" name="image"  id="image" class="form-control" >
               </div>
            @elseif($member=='Link') 
                         <input type="hidden" name="text1" id="title" value="text1" class="form-control" placeholder="">
                        <input type="hidden" name="text2" id="title" class="form-control" placeholder="">
                        <input type="hidden" name="name" id="name" class="form-control" placeholder="" >
                        <input type="hidden" name="workplace" id="workplace" class="form-control" placeholder="" >
     
     
                     
     
               <div class="my-2">
                     <label for="avatar">Select Image/Pdf (Max: 700KB)<span style="color:red;"> * </span></label>
                     <input type="file" name="image"  id="image" class="form-control" >
               </div>
     



          @else    
            

          <div class="my-2">
            <label for="desig">Text 1<span style="color:red;"> * </span></label>
            <textarea name="text1" id="edit_text1" col="10" rows="4"  class="form-control" ></textarea>
          </div>

          <div class="my-2">
            <label for="desig">Text 2  </label>
            <textarea name="text2" id="edit_text2" col="10" rows="4"  class="form-control" ></textarea>
          </div>


          <div class="my-2">
            <label for="name">Name </label>
            <input type="text" name="name" id="edit_name" class="form-control" placeholder="" >
          </div>

          <div class="my-2">
            <label for="desig">WorkPlace/ Institution<span style="color:red;"> * </span></label>
            <input type="text" name="workplace" id="edit_workplace" class="form-control" placeholder=""  required>
          </div>

          <div class="my-2">
             <label for="avatar">Select Image</label>
             <input type="file" name="image"  id="edit_image" class="form-control" >
          </div>

          @endif

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
          url:'/magazine/store',
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
              Swal.fire("Warning",response.errors, "warning");
             }else if(response.status == 300){
              Swal.fire("Warning", response.message, "warning");
             }else if(response.status == 700){
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
          url:'/magazine/fetchall/{{$member}}',
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
          url:'/magazine/edit',
          data: {
            id: id,
          },
          success: function(response){
            $("#edit_serial").val(response.data.serial);
            $("#edit_name").val(response.data.name);
            $("#edit_workplace").val(response.data.workplace);
            $("#edit_title").val(response.data.title);
            $("#edit_text1").val(response.data.text1);
            $("#edit_text2").val(response.data.text2);
            $("#edit_text4").val(response.data.text4);
    
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
          url:'/magazine/update',
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
              url:'/magazine/delete',
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
<h1>Page Not Found</h1>
@endif



@endsection     