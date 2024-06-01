<?php
   use App\Models\Onlinepayment;
   use App\Models\Admin;
?>
<!DOCTYPE html>
<html lang="en">
    <head>

    <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="MD Rayhan Babu" />
        <title>ANCOVA Admin Panel</title>
        <link rel="icon" type="image/png" href="{{asset('images/ancovabr.png')}}">
      

        <link rel="stylesheet" href="{{asset('dashboardfornt/css/styles.css')}}">
        <link rel="stylesheet" href="{{asset('dashboardfornt/css/solaiman.css')}}">
        <link rel="stylesheet" href="{{asset('dashboardfornt/css/dataTables.bootstrap5.min.css')}}">
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
   
        <link rel='stylesheet'
         href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css' />



         <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"  />
          <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" ></script>
         
        <meta name="csrf-token" content="{{ csrf_token() }}">
        

      
      
   

        <script src="{{asset('dashboardfornt\js\jquery-3.5.1.js')}}"></script>
        <script src="{{asset('dashboardfornt\js\bootstrap.bundle.min.js')}}"></script>
        <script src="{{asset('dashboardfornt\js\jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('dashboardfornt\js\dataTables.bootstrap5.min.js')}}"></script>
        <script src="{{asset('dashboardfornt/js/sweetalert.min.js')}}"></script>
        <script src="{{asset('dashboardfornt/js/scripts.js')}}"></script>

        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
         <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
      

         <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"  />
          <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" ></script>
	    
    </head>


 
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-light bg-primary text-white">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3 text-white"  href="#"  >AMS</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-5 me-lg-0 text-white" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">
                @if(Session::has('admin'))   
                  {{Session::get('admin')->nameen}},   Username : {{Session::get('admin')->admin_name}}
                @endif                   
                </div>
            </form>
            <!-- Navbar-->


            <?php
 $admin=Admin::where('admin_name',Session::get('admin')->admin_name)->first(); 
     $paydata=Onlinepayment::where('admin_name',Session::get('admin')->admin_name)->orderBy('id','desc')->first(); 
   ?>
           

            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                      <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                         <li><a class="dropdown-item" href="{{ url('/companypay')}}">Payment</a></li>
                         <li><a class="dropdown-item" href="{{ url('admin/password')}}">Password Change</a></li>
                         <li><hr class="dropdown-divider" /></li>
                         <li><a class="dropdown-item" href="{{ url('admin/logout')}}">Logout</a></li>
                      </ul>
                </li>
            </ul>
        </nav>


<div id="layoutSidenav">
  <div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
     <div class="sb-sidenav-menu">
       <div class="nav">
                           					   
       <a class="nav-link @yield('admin_select') " href="{{url('admin/dashboard')}}">
          <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
             Dashboard
       </a>
		
     @if($admin->text4==1)
     
 <a class="nav-link @yield('Executive_select')  @yield('Advisor_select') @yield('Senior_select') @yield('General_select')
  collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
    <div class="sb-nav-link-icon "><i class="fas fa-columns"></i></div>
           Member Entry
     <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
  </a>
   <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
      <nav class="sb-sidenav-menu-nested nav">
           <a class="nav-link @yield('Executive_select')" href="{{url('/testimonial/index/Executive')}}">Executive Member</a>
           <a class="nav-link @yield('Advisor_select')" href="{{url('/testimonial/index/Advisor')}}">Advisor Member</a>
           <a class="nav-link @yield('Senior_select')" href="{{url('/testimonial/index/Senior')}}">Senior Member</a>
           <a class="nav-link @yield('General_select')" href="{{url('/testimonial/index/General')}}">General Member</a>
           <a class="nav-link @yield('General_select')" href="{{url('/testimonial/index/Alumni')}}">Alumni Member</a>
      </nav>
 </div>
 
 
    <a class="nav-link  @yield('customize_select') @yield('data_select')
    collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayoutsform" aria-expanded="false" aria-controls="collapseLayouts">
      <div class="sb-nav-link-icon "><i class="fas fa-columns"></i></div>
            Form
       <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
    </a>
     <div class="collapse" id="collapseLayoutsform" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
       <nav class="sb-sidenav-menu-nested nav">
            <a class="nav-link @yield('customize_select')" href="{{url('/form/customize')}}">Form Customize</a>
            <a class="nav-link @yield('data_select')" href="{{url('/form/data')}}">Form Data </a> 
      </nav>
   </div>

   <a class="nav-link @yield('Magazine_select')" href="{{url('/magazine/index/Magazine')}}">
        <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
           Magazine 
     </a>

     <a class="nav-link @yield('Testimonial_select')" href="{{url('/magazine/index/Testimonial')}}">
        <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
           Testimonial
     </a>


     <a class="nav-link  @yield('Earning_select') @yield('Spending_select')
    collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts1" aria-expanded="false" aria-controls="collapseLayouts">
      <div class="sb-nav-link-icon "><i class="fas fa-columns"></i></div>
           Finance
       <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
    </a>
     <div class="collapse" id="collapseLayouts1" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
       <nav class="sb-sidenav-menu-nested nav">
          <a class="nav-link @yield('Earning_select')" href="{{url('/finance/index/Earning')}}">Earning</a>
          <a class="nav-link @yield('Spending_select')" href="{{url('/finance/index/Spending')}}">Spending </a> 
      </nav>
   </div>


  

   @else


   @endif

   <a class="nav-link @yield('Life_Member_select')  @yield('Member_select')  @yield('Executive_select')
  collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
    <div class="sb-nav-link-icon "><i class="fas fa-columns"></i></div>
           Member
     <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
  </a>
   <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
      <nav class="sb-sidenav-menu-nested nav">
               @foreach(member_category() as $row)                   
                 <a class="nav-link @yield('Executive_select')" href="{{url('/admin/member/'.$row->id)}}">{{$row->category}} </a>                  
               @endforeach
      </nav>
     
 </div>

		




   <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseattansms" aria-expanded="false" aria-controls="collapseLayouts">
     <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
        SMS info
     <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
     </a>
       <div class="collapse" id="collapseattansms" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
         <nav class="sb-sidenav-menu-nested nav">
            <a class="nav-link" href="{{url('/smsview')}}">SMS Send</a>
            <a class="nav-link" href="{{url('smsbuy')}}"> SMS Buy</a>
            <a class="nav-link" href="{{url('smsdetails')}}"> SMS Details</a>
        </nav>
    </div>
	
		
      
     <a class="nav-link @yield('notice_select')" href="{{url('admin/notice')}}">
        <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
           News & Event 
     </a>




  

     <a class="nav-link " href="{{url('admin/app/Member')}}">
         <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
             Member Category
     </a>

     <a class="nav-link " href="{{url('admin/app/Event')}}">
         <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
             Event Create
     </a>

     <a class="nav-link @yield('paymentview_select')" href="{{url('admin/paymentview')}}">
         <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
             Payment View
     </a>

     <a class="nav-link @yield('non_paymentview_select')" href="{{url('admin/non_paymentview')}}">
         <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
           Non  Member Payment View
     </a>

     <a class="nav-link @yield('dataview_select')" href="{{url('admin/dataview')}}">
         <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
           Registartion & Token  Setup
     </a>

     <a class="nav-link @yield('withdraw_select')" href="{{url('admin/withdraw')}}">
        <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
          Withdraw 
     </a>

     <a class="nav-link @yield('issue_select') " href="{{url('admin/issue')}}">
          <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
              Payment Issue
         </a>


     <a class="nav-link @yield('bloodsearch_select')" href="{{url('/bloodsearch')}}">
       <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
           Blood Search
   </a>

     <a class="nav-link @yield('Welcome_select')" href="{{url('/magazine/index/Welcome')}}">
        <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
           Welcome 
     </a>

      <a class="nav-link @yield('Link_select')" href="{{url('/magazine/index/Link')}}">
          <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
              Image/Pdf Link  
      </a>


  

     <a class="nav-link @yield('Gallery_select')" href="{{url('/magazine/index/Gallery')}}">
        <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
           Gallery 
     </a>


    
   

     <a class="nav-link @yield('Slide_select')" href="{{url('/magazine/index/Slide')}}">
        <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
           Slider
     </a>

     <a class="nav-link @yield('expre_select')" href="{{url('/expre/index')}}">
        <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
            Former president, Secretary & Donor
     </a>

    
       <a class="nav-link @yield('committee_select')" href="{{url('admin/committee/Committee')}}">
          <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
              Former Committee
        </a>



   <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseattansetting" aria-expanded="false" aria-controls="collapseLayouts">
     <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
       Setting
     <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
     </a>
       <div class="collapse" id="collapseattansetting" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
         <nav class="sb-sidenav-menu-nested nav">
            <a class="nav-link" href="{{url('admin/app/Batch')}}">Batch</a>
            <a class="nav-link" href="{{url('admin/app/Profession')}}"> Profession</a>
            <a class="nav-link" href="{{url('admin/app/Committee')}}"> Committee</a>
        </nav>
    </div>


  </div>
 </div>
                   
<div class="sb-sidenav-footer">
     <div class="small">Developed By:</div>
          ANCOVA
      </div>
   </nav>
</div>


<div id="layoutSidenav_content">
<main>

<div class="container-fluid px-3">

      <div>
        @if($admin->version_type=='free')
                 @yield('content')
                 @yield('contentpay')
        @else
             @if($paydata->status=='1')
                  @yield('content')
                  @yield('contentpay')
             @else
                 @yield('contentpay')
             @endif     
       
        @endif
       

     </div>


</div>    

    </main>
               
            </div>
        </div> 

       
       

        
        
    
    
    </body>
</html>
