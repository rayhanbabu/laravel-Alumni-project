@extends('admin/dashboardheader')
@section('page_title','Payment View')
@section('paymentview_select','active')
@section('content')
 

  <div class="card mt-4 mb-3">
         <div class="card-header">
    <div class="row">
               <div class="col-2">  <h5 class="mt-0">Member Payment </h5>  </div>
                     <div class="col-4">
                         <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                             <form action="{{url('pdf/payment_category')}}" method="POST" enctype="multipart/form-data">
                                  {!! csrf_field() !!}
                                  <select class="form-control" name="category" required>
                                    <option value="">Select Payment Category </option>
                                    @foreach($category as $row)
                                  <option value="{{$row->id}}">{{$row->category}}</option>
                                 @endforeach	
                               </select> 			                     
                         </div>
                     </div>

                     <div class="col-2">
                         <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                           
                         <input type="month" name="month" id="month" class="form-control" placeholder="" >          
                         </div>
                     </div>

                     <div class="col-2">
                         <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                            
                         <button type="submit" name="search" class="btn btn-primary"> Pdf View </button> 
					                   </form>   
                         </div>
                     </div>

                     <div class="col-2">
                         <div class="d-grid gap-2 d-md-flex ">
                       						 
                         <button type="button" class="bazar_entry btn btn-success btn-sm"> Add Payment</button>
                         </div>
                     </div> 
             </div>



  <div class="bazar-entry-show" style="background-color:aliceblue; padding:10px;">

   <h4> Event Enrollment </h4>
   <form method="post" id="add_form" enctype="multipart/form-data">
    <div class="row">
      <div class="col-sm-4">
        <label>Member Card </label><br>
        <select name="member_id" id="member_id" class="js-example-disabled-results" style="width:350px;" required>
          <option value="">Select Member Card Or Name Or Phone Or Id</option>
              @foreach($member as $row)
                  <option value="{{ $row->id}}">{{ $row->member_card}}-{{ $row->name}}-{{ $row->phone}}-{{ $row->id}}</option>
              @endforeach
        </select>
      </div>


      <div class="col-sm-4">
        <label>Event Category</label><br>
        <select name="category_id" id="category_id" class="js-example-disabled-results" style="width:350px;" required>
          <option value="">Select Event Category</option>
              @foreach($category as $row)
                 <option value="{{ $row->id}}">{{ $row->category}}({{ $row->amount}}TK)</option>
              @endforeach
          
        </select>
      </div>

      <div class="col-sm-2">
        <br>
        <div class="loader">
          <img src="{{ asset('images/abc.gif') }}" alt="" style="width: 50px;height:50px;">
        </div>
      </div>

      <div class="col-sm-2">
        <br>
        <input type="submit" value="Submit" id="submit" class=" btn btn-success btn-sm" />
      </div>
    </div>

      <ul class="alert alert-warning d-none" id="add_form_errlist"></ul>
     </form>
      <br>

   </div>
</div>


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
       <th width="10%" class="sorting" data-sorting_type="asc" data-column_name="id" style="cursor: pointer" >Invoice ID
                <span id="id_icon" ><i class="fas fa-sort-amount-up-alt"></i></span> </th>

       <th  width="20%"> Payment Link </th>
       <th width="10%" class="sorting" data-sorting_type="asc" data-column_name="member_card" style="cursor: pointer">Membership & Uid
                  <span id="member_card_icon"><i class="fas fa-sort-amount-up-alt"></span></th>
      <th  width="20%">Name</th>
      <th  width="10%">Payment Category</th>
      <th  width="10%">Payment</th>
		  <th  width="10%">Payment Status</th>
      <th  width="10%">Payment Type</th>
      <th  width="10%">Payment Info</th>
		  <th  width="10%">Delete</th>
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




<script>  
$(document).ready(function(){ 

  $(".js-example-disabled-results").select2();

  $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} });

    
         fetch();
         function fetch(){
            $.ajax({
             type:'GET',
             url:'/admin/payment_fetch',
             datType:'json',
             success:function(response){
                    $('tbody').html('');
                   $('.x_content tbody').html(response);
         
                }
            });
         }
    


          
                // delete employee ajax request
        $(document).on('click', '.status_id', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        

        (async () => {
        const { value: payment_method } = await Swal.fire({
               input:'text',
               inputLabel:'Payment Ref/ Payment Receipt',
               inputPlaceholder:'Payment Ref/ Payment Receipt'
             })
       if (payment_method) {
           $.ajax({
                url:'/admin/payment_status',
                method: 'post',
                data: {
                  id: id,
                  payment_method: payment_method,
                },
               success: function(response) {
                //console.log(response);
                 if(response.status==200){
                  Swal.fire("",response.message, "success");
                  fetch();
                 }else if(response.status==300){
                  Swal.fire("",response.message, "warning");  
                 }else if(response.status==400){
                  Swal.fire("",response.message, "warning");  
                 }

                }
              });

            }
        })();


        
      });


      $(document).on('click', '.delete_id', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
         
        (async () => {

   const { value: email } = await Swal.fire({
               input: 'email',
               inputLabel: 'Admin email address',
               inputPlaceholder: 'Enter  email address'
             })
       if (email) {
           $.ajax({
                url:'/admin/payment_delete',
                method: 'post',
                data: {
                  id: id,
                  email: email,
                },
               success: function(response) {
                console.log(response);
                 if(response.status==200){
                  Swal.fire("",response.message, "success");
                  fetch();
                 }else if(response.status==300){
                  Swal.fire("",response.message, "warning");  
                 }else if(response.status==400){
                  Swal.fire("",response.message, "warning");  
                 }

                }
              });

            }
        })();


      });


        
     

      $(document).on('submit', '#add_form', function(e) {
      e.preventDefault();

      let formData = new FormData($('#add_form')[0]);

      $.ajax({
        type: 'POST',
        url: '/admin/admin_invoice_create',
        data: formData,
        contentType: false,
        processData: false,
        beforeSend: function() {
          $('.loader').show();
        },
        success: function(response) {
          //console.log(response);
          if (response.status == 700) {
            $('#add_form_errlist').html("");
            $('#add_form_errlist').removeClass('d-none');
            $.each(response.message, function(key, err_values) {
              $('#add_form_errlist').append('<li>' + err_values + '</li>');
            });

          } else if(response.status==400){
                  Swal.fire("",response.message, "warning");      
          }else {
            //console.log(response.message);
            $('#add_form_errlist').html("");
            $('#add_form_errlist').addClass('d-none');
            $('#success_message').html("");
            $('#success_message').addClass('alert alert-success alert-sm');
            $('#success_message').text(response.message)
            $('#add_form')[0].reset();
            $('.bazar-entry-show').hide();
            fetch();
          }
          $('.loader').hide();

        }
      });

    });




    function fetch_data(page, sort_type="", sort_by="", search=""){
        $.ajax({
        url:"/admin/payment/fetch_data?page="+page+"&sortby="+sort_by+"&sorttype="+sort_type+"&search="+search,
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


          $(document).on('click', '.bazar_entry', function(e) {
      e.preventDefault();
            console.log('Rayhan babu');
      $('.bazar-entry-show').show();

    });
       
    


});  
</script>   




 @endsection             