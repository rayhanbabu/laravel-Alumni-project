<!doctype html>
<html lang="en">
  <head>
  	<title>ANCOVA</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('dashboardfornt\css\login.css')}}">
   <link rel="icon" type="image/png" href="{{ asset('homefront/assets/images/amaderthikana.png') }}">
   <script src="{{asset('dashboardfornt\js\jquery-3.5.1.js')}}"></script>
   <meta name="csrf-token" content="{{ csrf_token() }}">
   <script src="{{asset('dashboardfornt/js/sweetalert.min.js')}}"></script>
   <link rel="stylesheet" href="{{asset('dashboardfornt/css/styles.css')}}">

   <style>
        #fixedmyBtn {
            position: fixed;
            bottom:60px;
            right: 15px;
            z-index: 99;
            font-size: 15px;
            border: none;
            outline: none;
            cursor: pointer;
            padding: 10px;
            border-radius: 4px;
        }


  </style>

	</head>

	<body>
	<section class="ftco-section">
		<div class="container">
		  <div class="row justify-content-center">
				<div class="col-md-7 col-lg-6">
					<div class="login-wrap p-4 p-md-5">
                   
		
		<h3 class="text-center mb-4"> Application Form</h3>
			<form method="post" id="add_employee_form" class="myform"  enctype="multipart/form-data" >
                 

		        <div class="col-lg-12 my-3">
                     <label for="name">Organization name(Bangla) <span style="color:red;"> * </span></label>
                     <input type="text" name="name" id="name" class="form-control" placeholder="" >
					 <p class="text-danger err_name"></p>
                </div>

               <div class="col-lg-12 my-3">
                   <label for="name">Organization name(English) <span style="color:red;"> * </span></label>
                   <input type="text" name="nameen" id="nameen" class="form-control" placeholder="" >
				   <p class="text-danger err_nameen"></p>
               </div>

               <div class="col-lg-12 my-3">
                   <label for="name">Address <span style="color:red;"> * </span></label>
                   <input type="text" name="address" id="address" class="form-control" placeholder="" >
				   <p class="text-danger err_address"></p>
               </div>


			    <div class="col-lg-12 my-3">
                    <label for="name">Phone Number<span style="color:red;"> * </span></label>
					<input name="mobile" id="mobile" type="text" pattern="[0][1][3 7 6 5 8 9][0-9]{8}" title="
				     Please select Valid mobile number"  class="form-control"  />
                        <p class="text-danger err_mobile"></p>
                </div>

			  <div class="col-lg-12 my-3">
                   <label for="roll">UserName<span style="color:red;"> * </span></label>
                   <input type="text"  name="username" id="username" class="form-control" placeholder="" >
				   <p class="text-danger err_username"></p>
              </div>


			  <div class="col-lg-12 my-2">
                  <label for="roll">E-mail<span style="color:red;"> * </span></label>
                  <input type="text"  name="email" id="email" class="form-control" placeholder="" >
				  <p class="text-danger err_email"></p>
              </div>


			  <div class="col-lg-12 my-3">
                  <label for="name">Password<span style="color:red;"> * </span></label>
                  <input type="password" name="password" id="password" class="form-control" placeholder="" >
				  <p class="text-danger err_password"></p>
              </div>


			   <div class="col-lg-12 my-3">
                  <label for="name">Re-Type Password<span style="color:red;"> * </span></label>
                   <input type="password" name="password1" id="password1" class="form-control" placeholder="" >
				   <p class="text-danger password_match"></p>
              </div>

				
				   @if(Session::has('success'))
                      <div  class="alert alert-success"> {{Session::get('success')}}</div>
                   @endif
 
                     @if(Session::has('fail'))
                      <div  class="alert alert-warning"> {{Session::get('fail')}}</div>
                  @endif


        <div class="loader">
            <img src="{{ asset('images/abc.gif') }}" alt="" style="width: 50px;height:50px;">
       </div>

			
				
	            <div class="col-lg-12 my-2 mt-4">
				  
					<input type="submit" id="add_btn"  class="form-control btn btn-primary rounded submit px-3" value="Submit">
	            </div>
				 
				

				<div class="col-lg-12 my-2 d-md-flex">
						<div class="w-100 text-md-left">
							   
						     	
					   </div>
	            </div>
				
	          </form>
	        </div>
				</div>
			</div>
		</div>
	</section>

	<script>  
  $(document).ready(function(){ 
       $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} });

	   let formData=new FormData($('#add_form')[0]);
  
  $("#add_employee_form").submit(function(e) {
   e.preventDefault();
  
   const fd = new FormData(this);


   $.ajax({
	 type:'POST',
	 url:'/web/insert',
	 data: fd,
	 cache: false,
	 contentType: false,
	 processData: false,
	 dataType: 'json',
	 beforeSend : function()
		  {
		  $('.loader').show();
		  $("#add_btn").prop('disabled', true)
		  },
	 success: function(response){
		$('.loader').hide();
		$("#add_btn").prop('disabled', false);
	   if(response.status == 100){
	 	  Swal.fire("Successfull",response.message, "success");
		    $("#add_employee_form")[0].reset();
			$(".text-danger").text('');
		 }else if(response.status == 200){
		    Swal.fire("Warning",response.message,"warning");
		 }else if(response.status == 300){
			$('.password_match').text(response.password_match);
		 }else if(response.status == 400){
			$('.err_name').text(response.validate_err.name);
			$('.err_nameen').text(response.validate_err.nameen);
			$('.err_address').text(response.validate_err.address);
			$('.err_email').text(response.validate_err.email);
			$('.err_username').text(response.validate_err.username);
			$('.err_mobile').text(response.validate_err.mobile);
			$('.err_password').text(response.validate_err.password);
		 }
	  
	 }
   });

 });


  
    });

   </script>


	</body>
</html>
