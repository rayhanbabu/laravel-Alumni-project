@extends('web/webheader')
@section('page_title','Notice::'.$admin->nameen)
@section('notice','active')
@section('content')

    <!-- Project Start -->
  <div class="container-xxl py-5">
     <div class="container">
         <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width:600px;">
             <h5 class="section-title bg-white text-center text-primary px-3">নোটিশ</h5>
            </div>
                

          <div class="owl-carousel project-carousel wow fadeInUp" data-wow-delay="0.1s">
            @foreach($data as $row)
                 <div class="project-item border rounded h-100 p-4" data-dot="01">
                     <div class="position-relative mb-4"> 	
                        @if(empty($row->image))	
						  <h1><a href="#" class="btn  py-2 px-5 mt-3 text-info">বিস্তারিত দেখুন</a></h1><br>
                          @else
                          <h1><a href="{{ asset('uploads/admin/'.$row->image)}}" class="btn  py-2 px-5 mt-3 text-info">বিস্তারিত দেখুন</a></h1><br>
                          @endif
                     </div>
                     <h6><i class="far fa-calendar-alt text_primary me-2"></i> <?php echo date('d-M-Y',strtotime($row['created_at'])); ?></h6>
                    <span>{!!$row->text!!}</span>			         
                 </div>
			@endforeach	 
				 
				 
		
            </div>
        </div>
    </div>
    <!-- Project End -->

   
   
 
 
    

 @endsection