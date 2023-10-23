@extends('maintain/dashboardheader')
@section('page_title','Dashboard Export')
@section('export_select','active')
@section('content')

                        <h4 class="mt-4">Export Data</h4>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard/password change</li>
                        </ol>

                        
                <div class="row">
                     <div class="col-sm-6">
                       <div class="card bg-light">
                       <form action="{{ url('maintain/adminexport') }}" method="post" enctype="multipart/form-data">
                          {!! csrf_field() !!}
                             
                           <div class="form-group  mx-3 my-3">
                                 <label class=""><b>Status</b></label>
                                  <input type="number" name="status" class="form-control">
                           </div> 

                      
                           <div class="form-group  mx-3 my-3">
                           @if(Session::has('fail'))
                   <div  class="alert alert-danger"> {{Session::get('fail')}}</div>
                                @endif
                             </div>

                             <div class="form-group  mx-3 my-3">
                           @if(Session::has('success'))
                   <div  class="alert alert-success"> {{Session::get('success')}}</div>
                                @endif
                             </div>


                           <div class="form-group  mx-3 my-3">
                                    <input type="submit" value="Submit" class="btn btn-primary waves-effect waves-light">
                             </div> 

                     </form>
                   </div>
                </div>
             </div>


@endsection