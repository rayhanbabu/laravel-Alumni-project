@extends('maintain/dashboardheader')
@section('content')

                        <h4 class="mt-4">Password Chnage</h4>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard/password change</li>
                        </ol>

                        
                <div class="row">
                     <div class="col-sm-6">
                       <div class="card bg-light">
                       <form action="{{ url('maintain/password') }}" method="post" enctype="multipart/form-data">
                          {!! csrf_field() !!}
                             
                           <div class="form-group  mx-3 my-3">
                                 <label class=""><b>E-mail</b></label>
                                  <input type="text" name="email" class="form-control">
                           </div> 

                           <div class="form-group  mx-3 my-3">
                                 <label class=""><b>New Password</b></label>
                                  <input type="password" name="n_pass" class="form-control">
                           </div> 

                           <div class="form-group  mx-3 my-3">
                                 <label class=""><b>Confirm Password</b></label>
                                  <input type="password" name="c_pass" class="form-control">
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