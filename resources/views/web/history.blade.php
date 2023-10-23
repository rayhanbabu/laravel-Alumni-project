@extends('web/webheader')
@section('page_title','History::'.$admin->nameen)
@section('history','active')
@section('content')

    <!-- Project Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width:600px;">
                <h5 class="section-title bg-white text-center text-primary px-3"> সংগঠনটির ইতিহাস </h5>
            </div>
                
            @foreach($data as $row)
                    <p>{!!$row->dureg!!} </p>  

           @endforeach
				 

        </div>
    </div>
    <!-- Project End -->




 
 
    

 @endsection