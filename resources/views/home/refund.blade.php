<!DOCTYPE html>
<html lang="en">
  <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
     <meta name="description" content="">
     <meta name="author" content="">
     <link rel="preconnect" href="https://fonts.gstatic.com">
     <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

     <title> Amader Thikana </title>

     <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="{{asset('homefront/vendor/bootstrap/css/bootstrap.min.css')}}">

     <!-- Additional CSS Files -->
        <link rel="stylesheet" href="{{asset('homefront/assets/css/fontawesome.css')}}">
        <link rel="stylesheet" href="{{asset('homefront/assets/css/templatemo-onix-digital.css')}}">
        <link rel="stylesheet" href="{{asset('homefront/assets/css/animated.css')}}">
        <link rel="stylesheet" href="{{asset('homefront/assets/css/owl.css')}}">
           <link rel="icon" type="image/png" href="{{ asset('homefront/assets/images/amaderthikana.png') }}">
  
      <!--

TemplateMo 565 Onix Digital

https://templatemo.com/tm-565-onix-digital

-->
  </head>

<body>

  <!-- ***** Preloader Start ***** -->
  <div id="js-preloader" class="js-preloader">
    <div class="preloader-inner">
      <span class="dot"></span>
      <div class="dots">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
  </div>
  <!-- ***** Preloader End ***** -->

  <!-- ***** Header Area Start ***** -->
  <header class="header-area header-sticky wow slideInDown" data-wow-duration="0.75s" data-wow-delay="0s">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <nav class="main-nav">
               <!-- ***** Logo Start ***** -->
            <a href="/" class="logo">
                 <img src="{{ asset('homefront/assets/images/amaderthikana.png') }}" >
            </a>
               <!-- *****    Logo End ***** -->
               <!-- ***** Menu Start ***** -->
             <ul class="nav">
                 <li class="scroll-to-section"><a href="#top" class="active">Home</a></li>
			        <li class="scroll-to-section"><a href="{{url('/application')}}">Application</a></li> 
                    <li class="scroll-to-section"><a href="{{url('/admin/login')}}"> Login</a></li> 
			        <li class="scroll-to-section"><a href="{{url('/admin/login')}}"> Login</a></li> 
                
             </ul>        
             <a class='menu-trigger'>
                   <span>Menu</span>
             </a>
            <!-- ***** Menu End ***** -->
          </nav>
        </div>
      </div>
    </div>
  </header>
  <!-- ***** Header Area End ***** -->




  <br> <br><br><br>

<div class="container">
    <div class="row p-3">
          @foreach($term as $item)
               {!!$item->text!!}

          @endforeach	 
              
          </div>
</div>


 
  
  

  <div class="footer-dec">
    <img src="{{asset('homefront/assets/images/libra.png') }}"  alt="">
  </div>

  <footer>
    <div class="container">
      <div class="row">
        <div class="col-lg-3">
          <div class="about footer-item">
            <div class="logo">
              <a href="#"><img src="{{asset('/uploads/admin/'.$FooterContact->image) }}" alt="ANCOVA"></a>
            </div>
            <a href="#">{!! $FooterContact->desig !!}</a>
            <ul>
              <li><a href="{{$FooterContact->link1}}"><i class="fa fa-facebook"></i></a></li>
              <li><a href="{{$FooterContact->link2}}"><i class="fa fa-twitter"></i></a></li>
              <li><a href="{{$FooterContact->link3}}"><i class="fa fa-youtube"></i></a></li>
              
            </ul>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="services footer-item">
            <h4> Necessary link</h4>
            <ul>
                 <li><a href="{{url('/policy')}}">Privacy Policy</a></li>
                <li><a href="{{$FooterLink1->link1}}">{{$FooterLink1->name}}</a></li>
                <li><a href="{{$FooterLink1->link2}}">{{$FooterLink1->desig}}</a></li>
                <li><a href="{{$FooterLink1->link3}}">{{$FooterLink1->text}}</a></li>
            </ul>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="community footer-item">
             <h4>Necessary link</h4>
            <ul>
               <li><a href="{{url('/term')}}">Terms and Conditions</a></li>
               <li><a href="{{url('/refund')}}">Return & Refund Policy</a></li>
               <li><a href="{{$FooterLink2->link1}}">{{$FooterLink2->name}}</a></li>
               <li><a href="{{$FooterLink2->link2}}">{{$FooterLink2->desig}}</a></li>
               <li><a href="{{$FooterLink2->link3}}">{{$FooterLink2->text}}</a></li>
            </ul>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="subscribe-newsletters footer-item">
            <h4>Subscribe Newsletters</h4>
            <p>Get our latest news and ideas to your inbox</p>
            <form action="#" method="get">
              <input type="text" name="email" id="email" pattern="[^ @]*@[^ @]*" placeholder="Your Email" required="">
              <button type="submit" id="form-submit" class="main-button "><i class="fa fa-paper-plane-o"></i></button>
            </form>
          </div>
        </div>
        <div class="col-lg-12">
          <div class="copyright">
            <p>Copyright © 2023 ANVOVA. All Rights Reserved. 
          </div>
        </div>
      </div>
    </div>
  </footer>

  <!-- Scripts -->
  <script src="{{asset('homefront/vendor/jquery/jquery.min.js')}}"></script>
  <script src="{{asset('homefront/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('homefront/assets/js/owl-carousel.js')}}"></script>
  <script src="{{asset('homefront/assets/js/animation.js')}}"></script>
  <script src="{{asset('homefront/assets/js/imagesloaded.js')}}"></script>
  <script src="{{asset('homefront/assets/js/custom.js')}}"></script>
  
  <script>
  // Acc
    $(document).on("click", ".naccs .menu div", function() {
      var numberIndex = $(this).index();

      if (!$(this).is("active")) {
          $(".naccs .menu div").removeClass("active");
          $(".naccs ul li").removeClass("active");

          $(this).addClass("active");
          $(".naccs ul").find("li:eq(" + numberIndex + ")").addClass("active");

          var listItemHeight = $(".naccs ul")
            .find("li:eq(" + numberIndex + ")")
            .innerHeight();
          $(".naccs ul").height(listItemHeight + "px");
        }
    });
  </script>



</body>
</html>