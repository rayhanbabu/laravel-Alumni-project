@extends('admin/dashboardheader')
@section('page_title','SMS View')
@section('smsview_select','active')
@section('content')

<h4 class="mt-4">SMS Send , Available SMS({{$admin->available_sms}})</h4>
<ol class="breadcrumb mb-4">

</ol>


<div class="container mt-3">

   <div class="form-group  mx-2 my-2">
      @if(Session::has('success'))
      <div class="alert alert-success"> {{Session::get('success')}}</div>
      @endif
      @if(Session::has('danger'))
      <div class="alert alert-danger"> {{Session::get('danger')}}</div>
      @endif
   </div>


   <!-- Nav tabs -->
   <ul class="nav nav-tabs" role="tablist">
      <li class="nav-item">
         <a class="nav-link active" data-bs-toggle="tab" href="#single">Single</a>
      </li>

      <li class="nav-item">
         <a class="nav-link" data-bs-toggle="tab" href="#members">Members </a>
      </li>


   </ul>


   <!-- Tab panes -->
   <div class="tab-content">
      <div id="single" class="container tab-pane active"><br>
         <h3>Single</h3>

         <div class="row">
            <div class="col-sm-6">
               <div class="card bg-light">
                  <form action="{{ url('school/smsinsert') }}" method="post" enctype="multipart/form-data">
                     {!! csrf_field() !!}
                     <input type="hidden" name="sms_type" id="sms_type" value="single">

                     <div class="form-group  mx-3 my-3">
                        <label class=""><b>Phone Number(+88)<span style="color:red;"> * </span></b></label>
                        <input type="mumber" name="phone" pattern="[0][1][3 4 7 6 5 8 9][0-9]{8}" title="
				                           Please select Valid mobile number" class="form-control" required>
                     </div>

                     <div class="form-group  mx-3 my-3">
                        <label class=""><b>Message<span style="color:red;"> * </span></b></label>
                        <textarea name="text" id="text" col="15" rows="3" maxlength="150" class="form-control" required></textarea>
                     </div>

                     <div class="form-group  mx-3 my-3">
                        <input type="submit" value="Send massage" class="btn btn-primary waves-effect waves-light">
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>


      <div id="members" class="container tab-pane fade"><br>
         <h3>Members </h3>
         <div class="row">
            <div class="col-sm-6">
               <div class="card bg-light">
                  <form action="{{ url('school/smsinsert') }}" method="post" enctype="multipart/form-data">
                     {!! csrf_field() !!}
                     <input type="hidden" name="sms_type" id="sms_type" value="members">

                     <div class="form-group  mx-3 my-3">
                        <label class=""><b>Member Type<span style="color:red;"> * </span></b></label>
                        <select class="form-select" name="category" id="category" aria-label="Default select example" required>
                           <option value="">Select</option>
                           @foreach(member_category() as $row)
                           <option value="{{$row->id}}">{{$row->category}}</option>
                           @endforeach
                        </select>
                     </div>

                     <div class="form-group  mx-3 my-3">
                        <label class=""><b>Message <span style="color:red;"> * </span></b></label>
                        <textarea name="text" id="text" col="15" rows="3" maxlength="150" class="form-control" required></textarea>
                     </div>

                     <div class="form-group  mx-3 my-3">

                        <div class="row">
                           <div class="col-sm-3"> From Serial</div>
                           <div class="col-sm-3">
                              <input type="number" name="fromserial" class="form-control">
                           </div>

                           <div class="col-sm-3"> To Serial </div>
                           <div class="col-sm-3">
                              <input type="number" name="toserial" class="form-control">
                           </div>
                        </div>
                     </div>


                     <div class="form-check mx-3 my-3">
                        <input class="form-check-input" type="checkbox" value="membership" name="membership" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            Include Membership Number
                        </label>


                        <div class="form-group  mx-3 my-3">
                           <input type="submit" value="Send massage" class="btn btn-primary waves-effect waves-light">
                        </div>
                  </form>
               </div>
            </div>
         </div>
      </div>



   </div>
</div>



@endsection