<!DOCTYPE html>
<html lang="en">
    <head>
 
    <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>@yield('page_title')</title>
        <link rel="icon" type="image/png" href="{{asset('images/ancovabr.png')}}">

      
        <link rel="stylesheet" href="{{asset('dashboardfornt/css/styles.css')}}">
        <link rel="stylesheet" href="{{asset('dashboardfornt/css/solaiman.css')}}">
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
        <link rel="icon" type="image/png" href="{{asset('images/ancovabr.png')}}">
        <script src="{{asset('dashboardfornt/js/sweetalert.min.js')}}"></script>


        <link rel="stylesheet" href="{{asset('dashboardfornt/css/dataTables.bootstrap5.min.css')}}">
        <script src="{{asset('dashboardfornt\js\jquery-3.5.1.js')}}"></script>
        <script src="{{asset('dashboardfornt\js\jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('dashboardfornt\js\dataTables.bootstrap5.min.js')}}"></script>
       
        <meta name="csrf-token" content="{{ csrf_token() }}">

      
	    
    </head>
 
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-light bg-primary text-white">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3 text-white"  href="index.html"  >ANCOVA Software</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-5 me-lg-0 text-white" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                 <div class="input-group">
                     @lang('home.name') ,   @lang('home.dept') ,   @lang('home.university')                   
                 </div>
            </form>
            <!-- Navbar-->
           
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Language</a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="{{ url('locale/bn')}}">Bangla</a></li>
                        <li><a class="dropdown-item" href="{{ url('locale/en')}}">English</a></li>
                    </ul>
                </li>
            </ul>

            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#!">Settings</a></li>
                        <li><a class="dropdown-item" href="{{ url('maintain/password')}}">Password Change</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="{{ url('maintain/logout')}}">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>


<div id="layoutSidenav">
  <div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
     <div class="sb-sidenav-menu">
       <div class="nav">
                           					   
     <a class="nav-link  @yield('dashboard_select') " href="{{url('maintain/dashboard')}}">
        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
          Dashboard
     </a>
												
 <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
         Layouts
     <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
  </a>
   <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
     <nav class="sb-sidenav-menu-nested nav">
        <a class="nav-link" href="layout-static.html">Static Navigation</a>
        <a class="nav-link" href="layout-sidenav-light.html">Light Sidenav</a>
   </nav>
 </div>
	
 
							
 <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsestudent" aria-expanded="false" aria-controls="collapseLayouts">
   <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
      Default Page
     <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
    </a>
     <div class="collapse" id="collapsestudent" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
      <nav class="sb-sidenav-menu-nested nav">
       <a class="nav-link" href="{{url('maintain/notice')}}"> Notice</a>
       <a class="nav-link" href="layout-sidenav-light.html">Light Sidenav</a>
       <a class="nav-link" href="layout-sidenav-light.html">Light Sidenav</a>
     </nav>
  </div>
							
															
	
  

<a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
 <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
      Pages
 <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
   </a>
   <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
   <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
   <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
             Authentication
     <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
   </a>
       <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
         <nav class="sb-sidenav-menu-nested nav">
              <a class="nav-link" href="login.html">Login</a>
              <a class="nav-link" href="register.html">Register</a>
              <a class="nav-link" href="password.html">Forgot Password</a>
         </nav>
     </div>
 <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
             Error
  <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
    </a>
  <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
      <nav class="sb-sidenav-menu-nested nav">
        <a class="nav-link" href="401.html">401 Page</a>
        <a class="nav-link" href="404.html">404 Page</a>
        <a class="nav-link" href="500.html">500 Page</a>
      </nav>
   </div>
  </nav>
 </div>

 <a class="nav-link @yield('dataview_select') " href="{{url('maintain/dataview')}}">
     <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
   Data View
</a>
							
							
 <a class="nav-link @yield('admin_select') " href="{{url('maintain/adminview')}}">
     <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
   Admin View
</a>

  

<a class="nav-link @yield('payment_select') " href="{{url('maintain/payment')}}">
     <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
   Payment View
</a>

<a class="nav-link" href="{{url('maintain/sms')}}">
      <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
            Sms View
    </a>
	

<a class="nav-link @yield('export_select') " href="{{url('maintain/adminexport')}}">
  <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
  Admin Export
</a>
				
<a class="nav-link @yield('import_select') " href="{{url('maintain/adminimport')}}">
  <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
  Admin Import
</a>


  </div>
 </div>
                   
 
 
<div class="sb-sidenav-footer">
     <div class="small">Logged in as:</div>
          ANCOVA
      </div>
   </nav>
</div>


<div id="layoutSidenav_content">
<main>

<div class="container-fluid px-3">
      <div>
     @yield('content')
     </div>
</div>    

    </main>
               
            </div>
        </div> 

       
        <script src="{{asset('dashboardfornt\js\bootstrap.bundle.min.js')}}"></script>
        <script src="{{asset('dashboardfornt/js/scripts.js')}}"></script>

        
        
    
    
    </body>
</html>
