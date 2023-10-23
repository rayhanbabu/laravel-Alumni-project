<!doctype html>
<html lang="en">
  <head>
  	<title>ANCOVA</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('dashboardfornt\css\login.css')}}">
    <script src="{{asset('dashboardfornt/js/sweetalert.min.js')}}"></script>
   <link rel="icon" type="image/png" href="{{ asset('images/ancovabr.png') }}">
   <script src="{{asset('dashboardfornt/js/jquery-3.5.1.js')}}"></script>
   
   <meta name="csrf-token" content="{{ csrf_token() }}">

   <style>
 .codeform{
     display:none;
 }	
 .confirmpass{
   display:none;
 }

 .loader{
    display:none;
 }
</style>

	</head>
	<body>

<div class="emailform">
	 <section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-7 col-lg-5">
				   <div class="login-wrap p-4 p-md-5">
		
                   <form method="post"  id="email_form"  class="myform"  enctype="multipart/form-data" >
                         {!! csrf_field() !!}
		      		<div class="form-group">
                      <label>Enter Your E-mail</label>
		      			<input type="email" class="form-control rounded-left" autocomplete="off" id="email"  name="email" placeholder="Enter E-mail " >
		      		</div>

                      <div class="loader">
                  <img src="{{ asset('images/abc.gif') }}" alt="" style="width: 50px;height:50px;">
			         </div><br>
	           
	            <div class="form-group">
                  
					<input type="submit"  class="form-control btn btn-primary rounded submit px-3" value="Submit">
	            </div>
	          </form>
	        </div>
				</div>
			</div>
		</div>
	</section>
</div>  



<div class="codeform">
	 <section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-7 col-lg-5">
				   <div class="login-wrap p-4 p-md-5">
		
                   <form  method="post" id="code_form" enctype="multipart/form-data">
                       
		      		<div class="form-group">
                <input type="hidden" name="email_id"  id="email_id" >
          <input type="text"  class="form-control rounded-left" name="forget_code" id="forget_code" autocomplete="off" placeholder="Enter code within 7 minutes" >
		      		</div>

                      <div class="loader">
                  <img src="{{ asset('images/abc.gif') }}" alt="" style="width: 50px;height:50px;">
			         </div><br>
	           
	            <div class="form-group">
                  
					<input type="submit"  class="form-control btn btn-primary rounded submit px-3" value="Submit">
	            </div>
	          </form>
	        </div>
				</div>
			</div>
		</div>
	</section>
</div>  



<div class="confirmpass">
	 <section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-7 col-lg-5">
				   <div class="login-wrap p-4 p-md-5">
		
                   <form  method="post"  id="confirm_pass" enctype="multipart/form-data">
                       
		      		<div class="form-group">
                <input type="hidden" name="email_id_pass"  id="email_id_pass" >	
                <label>New Password</label>  
          <input type="text" name="npass" id="npass" autocomplete="off" class="form-control rounded-left" requied>
		      		</div>

                      <div class="form-group">
                <label>Confirm Password</label>  
          <input type="text" name="cpass" id="cpass" autocomplete="off" class="form-control rounded-left" requied>
		      		</div>


                      <div class="loader">
                  <img src="{{ asset('images/abc.gif') }}" alt="" style="width: 50px;height:50px;">
			         </div><br>
	           
	            <div class="form-group">
                  
					<input type="submit"  class="form-control btn btn-primary rounded submit px-3" value="Submit">
	            </div>
	          </form>
	        </div>
				</div>
			</div>
		</div>
	</section>
</div>  






	</body>
</html>




<script>  
$(document).ready(function(){ 
	$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} });



    $(document).on('submit', '#email_form', function(e){
        e.preventDefault();
        var email=$('#email').val();
        let emailData=new FormData($('#email_form')[0]);

  if(email== "")  
     {  
      Swal.fire("E-mail Field  is Required !", "", "warning");
     }else{
        $.ajax({
             type:'POST',
             url:'/admin/forget',
             data:emailData,
             contentType: false,
             processData:false,
             beforeSend : function()
              {
               $('.loader').show();
              },
             success:function(response){ 
               // console.log(response);
                if(response.status == 500){
                $('#email_id').val(email);
                $('.emailform').hide();
                $('.codeform').show();
                }else{
                  Swal.fire("Invalid Email ", "Please try again", "warning");
                }
                $('.loader').hide();
              }

         });
        }
      });


      $(document).on('submit', '#code_form', function(e){
        e.preventDefault();
        var email_id=$('#email_id').val();
        var forget_code=$('#forget_code').val();
        let codeData=new FormData($('#code_form')[0]);
        if(forget_code== "")  
        {  
          Swal.fire("Forget code Field  is Required !", "", "warning");
     }else{
        $.ajax({
             type:'POST',
             url:'/admin/forgetcode',
             data:codeData,
             contentType: false,
             processData:false,
             beforeSend : function()
              {
               $('.loader').show();
              },
             success:function(response){ 
               // console.log(response);
                if(response.status == 500){
                $('#email_id_pass').val(email_id);
                $('.confirmpass').show();
                $('.emailform').hide();
                $('.codeform').hide();
                }else{
                  Swal.fire("Invalid Code ", "Please try again", "warning");
                }  
                
                $('.loader').hide();
              }

         });
        }
      });




      $(document).on('submit', '#confirm_pass', function(e){
        e.preventDefault();
        var email_id=$('#email_id').val();
        var npass=$('#npass').val();
        var cpass=$('#cpass').val();
        let passData=new FormData($('#confirm_pass')[0]);
        if(npass== "")  
        {  
          Swal.fire("New password Field  is Required !", "", "warning");
     }else if(cpass== ""){
      Swal.fire("Confirm password Field  is Required !", "", "warning");
     }else{
        $.ajax({
             type:'POST',
             url:'/admin/confirmpass',
             data:passData,
             contentType: false,
             processData:false,
             beforeSend : function()
              {
               $('.loader').show();
              },
             success:function(response){ 
               // console.log(response);
                if(response.status == 500){
                $('.confirmpass').hide();
                $('.emailform').hide();
                $('.codeform').hide();
             
                Swal.fire("Password Change Successfull", "", "warning");
                location.href='/admin/login';
                }else{
                  Swal.fire("New Password & Confirm Password not Match ", "Please try again", "warning");
                }  
                
                $('.loader').hide();
              }

         });
        }
      });






    });
</script>