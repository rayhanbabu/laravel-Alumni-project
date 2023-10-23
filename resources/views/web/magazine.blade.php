@extends('web/webheader')
@section('page_title','Magazine::'.$admin->nameen)
@section('magazine','active')
@section('content')

    <!-- About Start -->
    <div class="container-xxl py-5">
        <div class="container">

        <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width:600px;">
                <h5 class="section-title bg-white text-center text-primary px-3">ম্যাগাজিন</h5>
            </div>

        @foreach($data as $row)
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
                         <h4 class=""><span class="text-primary"> {{$row->title}} </span></h4>
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

      <div class="d-felx justify-content-center">

         {{ $data->links() }}

        </div>
			
			
        </div>
    </div>
    <!-- About End -->


 
 
    

 @endsection