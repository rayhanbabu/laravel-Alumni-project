
<!doctype html>
<html lang="en">
  <head>
  	<title>ANCOVA</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('dashboardfornt\css\login.css')}}">
   <link rel="icon" type="image/png" href="{{ asset('images/ancovabr.png') }}">

	</head>
	<script>
	    function showpass()
		{
		   var pass = document.getElementById('pass');
		   if(document.getElementById('check').checked)
		   {
		     pass.setAttribute('type','text');
		   }
		   else{
		     pass.setAttribute('type','password'); 
		   }
		}
	 </script>
	<body>
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-7 col-lg-5">
					<div class="login-wrap p-4 p-md-5">

		         <a target="_blank" href="http://ancovabd.com/"><img src="{{ asset('images/ancovabr.png') }}" alt="Denim Jeans" width="150" style="margin-top:-20px;"></a>
				<h5></h5>
		      	<h3 class="text-center mb-4"> Sign In</h3>
				  @lang('home.name')
				  <form method="post" action="{{url('maintain/login')}}"  class="myform"  enctype="multipart/form-data" >
                         {!! csrf_field() !!}
		      		<div class="form-group">
		      			<input type="text" class="form-control rounded-left" autocomplete="off"  name="maintain_name" placeholder="Username" required>
		      		</div>
	           
				 <div class="form-group ">
	              <input type="password" class="form-control rounded-left" id="pass"  name="maintain_password" placeholder="Password" required>
				     <small>  <input type="checkbox" id="check" onclick="showpass();"/>Show Password</small> 
	            </div>
				
				  @if(Session::has('success'))
                  <div  class="alert alert-success"> {{Session::get('success')}}</div>
                   @endif
 
                     @if(Session::has('fail'))
                 <div  class="alert alert-warning"> {{Session::get('fail')}}</div>
                  @endif
			
				
	            <div class="form-group">
	            
					<input type="submit"  class="form-control btn btn-primary rounded submit px-3" value="Submit">
	            </div>
				 
				
	            <div class="form-group d-md-flex">
	            	<div class="w-50">
	            		<label class="checkbox-wrap checkbox-primary">Remember Me
									  <input type="checkbox" checked>
									  <span class="checkmark"></span>
									</label>
								</div>
								<div class="w-50 text-md-right">
									<a href="{{url('maintain/forget')}}">Forgot Password</a>
								</div>
	            </div>
	          </form>
	        </div>
				</div>
			</div>
		</div>
	</section>


	</body>
</html>
