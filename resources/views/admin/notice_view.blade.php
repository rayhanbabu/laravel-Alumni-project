@extends('admin/dashboardheader')
@section('page_title','Admin Panel')
@section('notice_select','active')
@section('content')

<div class="row mt-4 mb-3">
               <div class="col-6"> <h4 class="mt-0">News & Event  View</h4></div>
                     <div class="col-3">
                         <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            
                         </div>
                     </div>
                     <div class="col-3">
                         <div class="d-grid gap-2 d-md-flex ">
                         <a class="btn btn-primary" href="{{url('/admin/notice')}}" role="button">Back</a>  
              </div>
        </div> 
 </div> 

 <div class="container p-4 ">
    <div class="row justify-content-md-center">
        <div class="col-md-12">
            <div class="text-center">
              category: <b> {{$data->category}}</b>
              Date:<b> {{$data->date}}</b>
              Title:<b> {{$data->title}}</b>
           
            </div>
          
                      Description
                      <hr>
            <div>
                {!! $data->text !!}
            </div>
        </div>
    </div>
</div>




</div>



    <script>
      $('#summernote').summernote({
        placeholder: 'Description...',
        tabsize: 2,
        height: 100
      });
    </script>


  




 @endsection             