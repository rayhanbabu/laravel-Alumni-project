@extends('admin/dashboardheader')
@section('page_title','Payment View')
@section('non_paymentview_select','active')
@section('content')
 
<div class="card mt-4 mb-3">
  <div class="card-header">
<div class="row ">
               <div class="col-4"> <h5 class="mt-0">Non Member Payment View</h5></div>
                     <div class="col-4">
                         <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                             <form action="{{url('pdf/payment_category')}}" method="POST" enctype="multipart/form-data">
                                  {!! csrf_field() !!}
                                     
                         </div>
                     </div>

                     <div class="col-1">
                         <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                           
                         
                         </div>
                     </div>

                     <div class="col-1">
                         <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                            
                     
					                   </form>   
                         </div>
                     </div>

                     <div class="col-2">
                         <div class="d-grid gap-2 d-md-flex ">
                         <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                           Add
                        </button>		 
                      
                         </div>
                     </div> 
             </div>


       @if ($errors->any())
          <div class="alert alert-danger">
             <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
           </div>
       @endif


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

  </div>
  <div class="card-body">                          

<div id="success_message"></div>
 <div class="row mb-2">
    <div class="col-md-9">

    </div>
    <div class="col-md-3">
     <div class="form-group">
      <input type="text" name="search" id="search" placeholder="Enter Search " class="form-control form-control-sm"  autocomplete="off"  />
     </div>
    </div>
   </div>


<div class="card-block table-border-style">                     
 <div class="table-responsive">
   <div class="x_content">
   <table class="table table-bordered" id="employee_data">
   <thead>
       <tr>
       <th  width="10%">Serial No </th>
       <th width="10%" class="sorting" data-sorting_type="asc" data-column_name="id" style="cursor: pointer" >Invoice ID
                <span id="id_icon" ><i class="fas fa-sort-amount-up-alt"></i></span> </th>

       <th  width="20%"> Payment Link </th>
       <th width="10%" class="sorting" data-sorting_type="asc" data-column_name="name" style="cursor: pointer">Name
                  <span id="name_icon"><i class="fas fa-sort-amount-up-alt"></span></th>
      <th  width="10%">Payment Category</th>
      <th  width="10%">Email , Passing Yaer</th>
      <th  width="10%">Payment</th>
		  <th  width="10%">Payment Status</th>
      <th  width="10%">Payment Type</th>
      <th  width="10%">Payment Info</th>
      <th  width="10%"> Registration No </th>
      <th  width="10%"> Registration Type </th>
		
      </tr>
    </thead>
    <tbody>
       
    </tbody>
  </table>
    <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
    <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="id" />
    <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="desc" />
 
     </div>
    </div>
  </div>
</div>

<script>  
$(document).ready(function(){ 

  $(".js-example-disabled-results").select2();

  $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} });

      
         $(document).on('click','.edit',function(){
                   var id = $(this).attr("id");  
                   var payment_method = $(this).data("payment_method");

                   $('#edit_id').val(id);
                   $('#edit_payment_method').val(payment_method);

                   $('#updatemodal').modal('show');
            });


         fetch();
         function fetch(){
            $.ajax({
             type:'GET',
             url:'/admin/non_payment_fetch',
             datType:'json',
             success:function(response){
                    $('tbody').html('');
                   $('.x_content tbody').html(response);
         
                }
            });
         }
    


        

    function fetch_data(page, sort_type="", sort_by="", search=""){
        $.ajax({
        url:"/admin/non_payment/fetch_data?page="+page+"&sortby="+sort_by+"&sorttype="+sort_type+"&search="+search,
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
           var search = $('#search').val();
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
           var search = $('#search').val();
          fetch_data(page, reverse_order, column_name, search);
          });




});  
</script>   



       <!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"> Add</h5>
           <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

       <div class="modal-body">
       <form method="post" action="{{url('admin/add_non_payment')}}"  class="myform"  enctype="multipart/form-data" >
          {!! csrf_field() !!}

         <div class="form-group  my-2">
               <label class=""><b>Name <span style="color:red;"> * </span></b></label>
               <input type="text" name="name" class="form-control" required>
          </div> 

  
           <div class="form-group  my-2">
               <label class=""><b>E-mail <span style="color:red;"> * </span></b></label>
               <input type="text" name="email"  class="form-control" required>
           </div> 

          <div class="form-group  my-2">
               <label class=""><b>Phone Number <span style="color:red;"> * </span></b></label>
                 <input name="phone" id="mobile" type="text" pattern="[0][1][3 7 6 5 8 9][0-9]{8}" title="
				            Please select Valid mobile number"  class="form-control" required />
          </div> 

          <div class="form-group  my-2">
               <label class=""><b>Current Address <span style="color:red;"> * </span></b></label>
               <input type="text" name="address" class="form-control" required>
           </div> 

           <div class="form-group  my-2">
               <label class=""><b>Designation<span style="color:red;"> * </span></b></label>
               <input type="text" name="designation" class="form-control" required>
           </div> 

           <div class="form-group  my-2">
               <label class=""><b>Passing Year</b></label>
               <input type="text" name="passing_year" class="form-control" >
           </div> 

        <div class="form-group  mb-4">
        <label class=""><b>Select Category </b></label>
          <select class="form-select" name="category_id" aria-label="Default select example" >
                 <option selected>Select One</option>
                 @foreach($category as $category)
                    <option value="{{$category->id}}">{{$category->amount}}TK-{{$category->category}}</option>
                    @endforeach
           </select>
       </div>   

         
    <input type="submit"   id="insert" value="Submit" class="btn btn-success" />
	  
              
   </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>




<!-- Modal Edit -->
<div class="modal fade" id="updatemodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Information Edit</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <form method="post" action="{{url('admin/non_payment_update')}}"  class="myform"  enctype="multipart/form-data" >
            {!! csrf_field() !!}

            <input type="hidden" id="edit_id" name="id" class="form-control">
 
              <div class="row px-3">

              <div class="form-group col-sm-12  my-2"> 
                  <label class=""> <b>Payment Ref/Payment Receipt </b></label>
                  <input type="text" name="payment_method" id="edit_payment_method" class="form-control" required>
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