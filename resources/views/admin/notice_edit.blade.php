@extends('admin/dashboardheader')
@section('page_title','Admin Panel')
@section('notice_select','active')
@section('content')

<div class="row mt-4 mb-3">
               <div class="col-6"> <h4 class="mt-0">News & Event Edit</h4></div>
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
      <form method="POST" action="{{url('admin/notice_update/'.$data->id)}}" enctype="multipart/form-data">
        @csrf
  
      <div class="row">
          <div class="col-sm-4 my-2">
              <label for="name"> Date <span style="color:red;"> * </span> </label>
             <input type="date" name="date" id="name"  value="{{$data->date}}"class="form-control" placeholder=""  required>
          </div>

        <div class="col-sm-4 my-2">
             <label for="lname">Category<span style="color:red;"> * </span></label>
                 <select class="form-select" name="category" id="category" aria-label="Default select example"  required >
                      <option value="{{$data->category}}" selected>{{$data->category}}</option>
                      <option value="Notice">Notice</option>
                      <option value="Meeting">Meeting</option>
                      <option value="Upcoming">Upcoming</option>
                      <option value="Past">Past</option>
                      <option value="Constitution">Constitution</option>
                      <option value="History">History</option>
                      <option value="Others">Others</option>
                      <option value="Contact">Contact</option>
                      <option value="Document">Document</option>
                      <option value="Dashboard">Dashboard</option>
                      <option value="Membership">Membership</option>
                 </select>
          </div>

          <div class="col-sm-4 my-2">
              <label for="name">Image Optional (Max Size:400KB)</label>
             <input type="file" name="image" id="image"  value=""class="form-control" placeholder=""  >
          </div>


          <div class="col-sm-12 my-2">
            <label for="name">Titile<span style="color:red;"> * </span></label>
            <input type="text" name="title" id="titile" value="{{$data->title}}" class="form-control" placeholder=""  required>
          </div>

        </div>


    <div class="mb-3">
          <label for="exampleFormControlTextarea1" class="form-label"> Description</label>
          <textarea name="text" id="summernote"  cols="30" rows="10"> {{ $data->text }}</textarea>
    </div> 

 <button type="submit" class="btn btn-primary">Update</button>

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