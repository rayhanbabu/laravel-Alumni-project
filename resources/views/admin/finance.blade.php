@extends('admin/dashboardheader')
@section('page_title','Text')
@section($member.'_select','active')
@section('content')

@if($member=='Earning' OR $member=='Spending')

<div class="row mt-4 mb-3">
               <div class="col-3"> <h4 class="mt-0">{{$member}} View</h4></div>
                     <div class="col-2">
                         <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                             <form action="{{url('financepdf')}}" method="POST" enctype="multipart/form-data">
                                  {!! csrf_field() !!}
                                  <select class="form-control" name="cetagory" required>
                                    <option value="">Select Type </option>
                                    <option value="Earning">Earning</option>
                                    <option value="Spending">Spending</option>
                               </select> 
					                     
                         </div>
                     </div>

                     <div class="col-2">
                         <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                           
                         <input type="month" name="month" id="month" class="form-control" placeholder=""  required>          
                         </div>
                     </div>

                     <div class="col-2">
                         <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                            
                         <button type="submit" name="search" class="btn btn-primary"> Pdf View </button> 
					                   </form>   
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

           <input type="hidden" name="cetagory" id="cetagory"  value="{{$member}}">
        
        <div class="my-2">
            <label for="name">Date<span style="color:red;"> * </span></label>
            <input type="date" name="date" id="date" class="form-control" placeholder="" required>
          </div>

          @if($member=='Spending')
             <input type="hidden" name="name" id="name" class="form-control" value=""  placeholder="" >
             <input type="hidden" name="phone" id="phone" class="form-control" value=""  placeholder="" >
             <input type="hidden" name="email" id="email" class="form-control" value=""  placeholder="" >
          @else

          <div class="my-2">
             <label for="desig">Donor/Sponsor name<span style="color:red;"> * </span></label>
             <input type="text" name="name" id="name" class="form-control" placeholder=""  required>
         </div>

         <div class="my-2">
             <label for="desig">Phone/E-mail </label>
             <input type="text" name="phone" id="phone" class="form-control" placeholder=""  >
         </div>

         <div class="my-2">
             <label for="desig">Payment Method </label>
             <input type="text" name="email" id="email" class="form-control" placeholder=""  >
         </div>

          @endif

        <div class="form-group  my-2">
           <label>Description of Donation/Spending<span style="color:red;"> * </span></label>
            <textarea name="des" id="des" col="10" rows="3"  class="form-control" required></textarea>
        </div>

         

          <div class="my-2">
            <label for="desig">Amount<span style="color:red;"> * </span> </label>
            <input type="number" name="amount" id="amount" class="form-control" placeholder="" required>
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
            <label for="name">Date<span style="color:red;"> * </span></label>
            <input type="date" name="date" id="edit_date" class="form-control" placeholder=""  required>
          </div>

          @if($member=='Spending')
             <input type="hidden" name="name" id="edit_name" class="form-control" placeholder=""  >
             <input type="hidden" name="phone" id="edit_phone" class="form-control" value=""  placeholder="" >
             <input type="hidden" name="email" id="edit_email" class="form-control" value=""  placeholder="" >
          @else
          <div class="my-2">
             <label for="desig">Donor name<span style="color:red;"> * </span></label>
             <input type="text" name="name" id="edit_name" class="form-control" placeholder=""  required>
          </div>
          
          <div class="my-2">
             <label for="desig">Phone/E-mail </label>
             <input type="text" name="phone" id="edit_phone" class="form-control" placeholder=""  >
          </div>
 
          <div class="my-2">
             <label for="desig">Payment Method  </label>
             <input type="text" name="email" id="edit_email" class="form-control" placeholder=""  >
          </div>


          @endif

        <div class="form-group  my-2">
           <label>Description of Donation/Spending<span style="color:red;"> * </span></label>
            <textarea name="des" id="edit_des" col="10" rows="3"  class="form-control" required></textarea>
        </div>


          <div class="my-2">
            <label for="desig">Amount<span style="color:red;"> * </span> </label>
            <input type="number" name="amount" id="edit_amount" class="form-control" placeholder="" required>
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
          url:'/finance/store',
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
          url:'/finance/fetchall/{{$member}}',
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
          url:'/finance/edit',
          data: {
            id: id,
          },
          success: function(response){
             console.log(response);
            $("#edit_name").val(response.data.name);
            $("#edit_des").val(response.data.des);
            $("#edit_amount").val(response.data.amount);
            $("#edit_date").val(response.data.date);
            $("#edit_phone").val(response.data.phone);
            $("#edit_email").val(response.data.email);
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
          url:'/finance/update',
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
              url:'/finance/delete',
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