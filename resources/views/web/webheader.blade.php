<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>@yield('page_title') </title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Ammaderthikana, amader, thikana, welfare, Organization, Bd, Bangladesh" name="keywords">
    <meta content="Welcome For amderthikana.com" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{asset('webfront/lib/animate/animate.min.css')}}" rel="stylesheet">
    <link href="{{asset('webfront/lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">
    <link href="{{asset('webfront/lib/lightbox/css/lightbox.min.css')}}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{asset('webfront/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{asset('webfront/css/style.css')}}" rel="stylesheet">
	<link rel="stylesheet" href="{{asset('webfront/css/solaiman.css')}}" rel="stylesheet">


      <meta property="og:url"           content="{!!getFullURL()!!}"/>
      <meta property="og:type"          content="website"/>
      <meta property="og:title"         content="{!!$admin->nameen!!}" />
      <meta property="og:description"   content="{!!$admin->address!!}"/>
      <meta property="og:image"         content="{!!getURL().'/'.fbimage()!!}">

  <style>
   @media(min-width:992px) {
      .header_size{
        font-size:{!!$admin->header_size!!};
      }
    }

      @media(max-width:992px) {
        .header_size{
        font-size:{!!$admin->resheader_size!!};
        }
      }

    </style>


   </head>

<body>
   
 
     <a href="https://www.facebook.com/sharer/sharer.php?u={{getFullURL()}}"
      class="btn btn-sm btn-primary rounded-pill" target="_blank" id="shareBtn">Share </a>

       <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border position-relative text-primary" style="width: 6rem; height: 6rem;" role="status"></div>
        <i class="fa fa-laptop-code fa-2x text-primary position-absolute top-50 start-50 translate-middle"></i>
    </div>
    <!-- Spinner End -->


    <!-- Brand & Contact Start -->
    <div class="container-fluid py-4 px-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="row align-items-center top-bar bg-gray">
            <div class="col-lg-8 col-md-8 text-center text-lg-start">
                <a href="/">
                    <h6 class=" text-primary header_size" >{{$admin->name}}</h6>
                    <!-- <img src="img/logo.png" alt="Logo"> -->
                </a>
            </div>
            <div class="col-lg-4 col-md-4 bg-light">
                          <!-- Google Ads -->
                </div>
            </div>
        </div>
    </div>
    <!-- Brand & Contact End -->


    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-primary navbar-dark sticky-top py-lg-0 px-lg-5 wow fadeIn" data-wow-delay="0.1s">
        <a href="#" class="navbar-brand ms-3 d-lg-none">MENU</a>
        <button type="button" class="navbar-toggler me-3" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav me-auto p-3 p-lg-0">

                <a href="{{url('/')}}" class="nav-item nav-link @yield('home_select')">হোম</a>

                <a href="{{url('web/member/Advisor')}}" class="nav-item nav-link  @yield('Advisor')">উপদেষ্টামন্ডলী</a>

                <a href="{{url('web/member/Executive')}}" class="nav-item nav-link  @yield('Executive')">কার্যনির্বাহী কমিটি</a>

                <a href="{{url('web/magazine')}}" class="nav-item nav-link  @yield('magazine')">ম্যাগাজিন</a>

            
                 <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle @yield('Senior') @yield('General') @yield('expre')" data-bs-toggle="dropdown">অন্যান্য তথ্য</a>
                    <div class="dropdown-menu border-0 rounded-0 rounded-bottom m-0">
                         <a href="{{url('web/member/Senior')}}" class="dropdown-item @yield('Senior')">সিনিয়র সদস্য</a>
                         <a href="{{url('web/member/General')}}" class="dropdown-item @yield('General')">সাধারণ সদস্য</a>
                         <a href="{{url('web/expre')}}" class="dropdown-item @yield('expre')">সাবেক সভাপতি সেক্রেটারি বৃন্দ</a>
                    </div>
                 </div>

                 <a href="{{url('web/notice')}}" class="nav-item nav-link  @yield('notice')">নোটিশ</a>
 
                 <a href="{{url('web/history')}}" class="nav-item nav-link  @yield('history')">সংগঠনটির ইতিহাস</a>

                
             </div>
            <a href="{{url('/web/search')}}" class="btn btn-sm btn-light rounded-pill py-2 px-4  d-lg-block">সংগঠন পরিবর্তন </a>
        </div>
    </nav>
    <!-- Navbar End -->



      <div>
          @yield('content')
     </div>
    


    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-body footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-light mb-4">Address</h5>
                    <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>{{$admin->address}}</p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>{{$admin->mobile}}</p>
                    <p class="mb-2"><i class="fa fa-envelope me-3"></i>{{$admin->email}}</p>
                    <div class="d-flex pt-2">
                        <a class="btn btn-square btn-outline-secondary rounded-circle me-1" href="{{$admin->other_link}}"><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-square btn-outline-secondary rounded-circle me-1" href="{{$admin->fb_link}}"><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-square btn-outline-secondary rounded-circle me-1" href="{{$admin->youtube_link}}"><i class="fab fa-youtube"></i></a>
                        <a class="btn btn-square btn-outline-secondary rounded-circle me-0" href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-light mb-4">Quick Links</h5>
                    <a class="btn btn-link" href="#">About Us</a>
                    <a class="btn btn-link" href="#">Privacy Policy</a>
                    <a class="btn btn-link" href="#">Terms & Condition</a>
                    <a class="btn btn-link" href="#">Support</a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-light mb-4">Developed By</h5>
                    <div class="row g-2">
					    <div class="col-8">
                            <a href="#"></a>
                        </div>
                        <div class="col-4">
                             <a href="http://ancovabd.com/"><img class="img-fluid rounded" src="{{ asset('images/ancovabr.png')}}" alt="Image"></a>
                        </div>
                        
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-light mb-4">Newsletter</h5>
                    <p> Registration New Organization</p>
                    <div class="position-relative mx-auto" style="max-width: 400px;">
                        <a href="{{url('/web/reg')}}" class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">Register Now </a>
                        
                    </div>
                </div>
            </div>
        </div>
       
    </div>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-circle back-to-top"><i class="bi bi-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('webfront/lib/wow/wow.min.js')}}"></script>
    <script src="{{asset('webfront/lib/easing/easing.min.js')}}"></script>
    <script src="{{asset('webfront/lib/waypoints/waypoints.min.js')}}"></script>
    <script src="{{asset('webfront/lib/counterup/counterup.min.js')}}"></script>
    <script src="{{asset('webfront/lib/owlcarousel/owl.carousel.min.js')}}"></script>
    <script src="{{asset('webfront/lib/lightbox/js/lightbox.min.js')}}"></script>

    <!-- Template Javascript -->
    <script src="{{asset('webfront/js/main.js')}}"></script>
</body>

</html>