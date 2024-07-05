@extends('admin/dashboardheader')
@section('page_title','Admin Panel')
@section('notice_select','active')
@section('content')

<div class="row mt-4 mb-3">
               <div class="col-6"> <h4 class="mt-0">News & Event Create</h4></div>
                     <div class="col-3">
                         <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            
                         </div>
                     </div>
                     <div class="col-3">
                         <div class="d-grid gap-2 d-md-flex ">
                         <a class="btn btn-primary" href="{{url('/admin/notice/'.$category)}}" role="button">Back</a>  
              </div>
        </div> 
 </div> 

 <div class="form-group  mx-2 my-2">
                           @if(Session::has('fail'))
                   <div  class="alert alert-danger"> {{Session::get('fail')}}</div>
                                @endif
                             </div>

                             <div class="form-group  mx-2 my-2">
                           @if(Session::has('success'))
                   <div  class="alert alert-success"> {{Session::get('success')}}</div>
                                @endif
                             </div>

 @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div>
  @endif

 <div class="container shadow p-4">
      <form method="POST" action="{{url('admin/notice_insert')}}" enctype="multipart/form-data">
        @csrf
  
      <div class="row">
          <div class="col-sm-4 my-2">
            <label for="name">Date<span style="color:red;"> * </span></label>
            <input type="date" name="date" id="date" class="form-control" placeholder=""  required>
          </div>

          <input type="hidden" name="category"  id="category" value="{{$category}}">

          <div class="col-sm-4 my-2">
             <label for="lname">Serial</label>
             <input type="number" name="serial" id="serial" value="0" class="form-control" placeholder="" >
          </div>

          <div class="col-sm-4 my-2">
              <label for="image">Image Optional (Max Size:400KB)</label>
              <input type="file" name="image"  class="form-control" >
          </div>



          <div class="col-sm-12 my-2">
            <label for="name">Titile<span style="color:red;"> * </span></label>
            <input type="text" name="title" id="titile" class="form-control" placeholder=""  required>
          </div>

        </div>


    <div class="mb-3">
          <label for="exampleFormControlTextarea1" class="form-label"> Description</label>
          <textarea name="text" id="summernote" cols="30" rows="10"></textarea>
    </div> 

 <button type="submit" class="btn btn-primary">Submit</button>

</form>
</div>
    <script>
      $('#summernote').summernote({
        placeholder: 'Description...',
        tabsize: 2,
        height: 100
      });
    </script>


  




 @endsection             