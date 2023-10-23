@extends('web/webheader')
@section('page_title','Home::'.$admin->nameen)
@section('home_select','active')
@section('content')


<!-- Carousel Start -->
<div class="container-fluid p-0 mb-5 wow fadeIn" data-wow-delay="0.1s">
<div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
@if($slide1)
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="{{ asset('uploads/admin/'.$slide1->image)}}" class="d-block w-100" alt="...">
      <div class="carousel-caption ">
        <p style="font-size:25px;">{{$slide1->title}}</p>
      </div>
    </div>
    @else

    @endif

    @foreach($slide as $row)
    <div class="carousel-item">
      <img src="{{ asset('uploads/admin/'.$row->image)}}" class="d-block w-100" alt="...">
      <div class="carousel-caption ">
        <p style="font-size:25px;">{{$row->title}}</p>
      </div>
    </div>
    @endforeach
   
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>
    </div>
    <!-- Carousel End -->


    <!-- Facts Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="fact-item bg-light rounded text-center h-100 p-5">
                        <i class="fa fa-certificate fa-4x text-primary mb-4"></i>
                        <h5 class="mb-3">কার্যনির্বাহী কমিটি</h5>
                        <h1 class="display-5 mb-0" data-toggle="counter-up">{{countinfo('testimonials',$admin->admin_name,'Executive')}}</h1>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="fact-item bg-light rounded text-center h-100 p-5">
                        <i class="fa fa-users fa-4x text-primary mb-4"></i>
                        <h5 class="mb-3">উপদেষ্টা মন্ডলী</h5>
                        <h1 class="display-5 mb-0" data-toggle="counter-up">{{countinfo('testimonials',$admin->admin_name,'Advisor')}}</h1>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="fact-item bg-light rounded text-center h-100 p-5">
                        <i class="fa fa-check fa-4x text-primary mb-4"></i>
                        <h5 class="mb-3">সিনিয়র সদস্য</h5>
                        <h1 class="display-5 mb-0" data-toggle="counter-up">{{countinfo('testimonials',$admin->admin_name,'Senior')}}</h1>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="fact-item bg-light rounded text-center h-100 p-5">
                        <i class="fa fa-users-cog fa-4x text-primary mb-4"></i>
                        <h5 class="mb-3">সাধারণ সদস্য</h5>
                        <h1 class="display-5 mb-0" data-toggle="counter-up">{{countinfo('testimonials',$admin->admin_name,'General')}}</h1>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Facts End -->


    <!-- About Start -->
    <div class="container-xxl py-5">
        <div class="container">
      
        @foreach($welcome as $row)
            <div class="row g-5 my-2">
                <div class="col-lg-3 wow fadeInUp" data-wow-delay="0.1s">
                  @if(empty($row->image))
                    <img class="flex-shrink-0 rounded-circle border p-1" src="{{asset('images/default.png')}}" alt="">
                 @else
                    <img class="flex-shrink-0 rounded-circle border p-1" src="{{ asset('uploads/admin/'.$row->image)}}" alt="">
                  @endif          
                </div>
                <div class="col-lg-9 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="h-100">
                         <h5 class=""><span class="text-primary"> {{$row->title}} </span></h5>
                            <p>{!!$row->text1!!}</p>
                            <p>{!!$row->text2!!}</p>
						  
                         <div class="d-flex align-items-center mb-4 pb-2">
                              <div class="ps-4">
                                 <h6>{!!$row->name!!}</h6>
                                 <small>{!!$row->workplace!!}</small>
                             </div>
                        </div>
                       
                    </div>
                </div>
            </div>
		@endforeach	
			
			
        </div>
    </div>
    <!-- About End -->


 
 
    <!-- Testimonial Start -->
    <div class="container-xxl py-5">
        <div class="container"> 
              <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                    <h5 class="section-title bg-white text-center text-primary px-3">উপদেষ্টা মন্ডলীর বাণী</h5>
              </div>

            <div class="owl-carousel testimonial-carousel wow fadeInUp" data-wow-delay="0.1s">
               
             @foreach($test as $row)
                <div class="testimonial-item bg-light rounded p-4">
                    <div class="d-flex align-items-center mb-4">   
                   @if(empty($row->image))
                     <img class="flex-shrink-0 rounded-circle border p-1" src="{{ asset('images/default.png')}}" alt="">
                    @else
                      <img class="flex-shrink-0 rounded-circle border p-1" src="{{ asset('uploads/admin/'.$row->image)}}" alt="">
                    @endif     
                        <div class="ms-4">
                            <h5 class="mb-1">{!!$row->name!!} </h5>
                            <span>{!!$row->workplace!!}</span>
                        </div>
                    </div>
                    <p class="mb-0"> {!!$row->text1!!} {!!$row->text2!!}</p>
                  </div>
              @endforeach
                

            </div>  
        </div>
    </div>
    <!-- Testimonial End -->

 @endsection