@extends('admin/dashboardheader')
@section('page_title','Admin Dashboard')
@section('admin_select','active')
@section('content')

<div class="row mt-4 mb-3">
               <div class="col-sm-3"> <h5 class="mt-0">Dashboard </h5></div>
                    

                 <div class="col-sm-2 p-2">
                     <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                         <form action="{{url('admin/amarpay_search')}}" method="POST" enctype="multipart/form-data">
                            {!! csrf_field() !!}            
                         <input type="text" name="tran_id" id="tran_id" class="form-control" placeholder="Search Invoice Id" >          
                         </div>
                     </div>

                     <div class="col-sm-2 p-2">
                         <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                           <button type="submit" name="search" class="btn btn-primary"> Submit </button> 
					          </form>   
                         </div>
                     </div>

                     <div class="col-sm-3 p-2">
                         <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                          <form action="{{url('member/export')}}" method="POST" enctype="multipart/form-data">
                                  {!! csrf_field() !!}  
                        <select class="form-select" name="category_id" id="category_id" aria-label="Default select example"  required >
                                @foreach(member_category() as $category) 
                             <option value="{{$category->id}}">{{$category->category}}</option>
                               @endforeach
                      </select>
                         
                         </div>
                      </div>

                      <div class="col-sm-2">
                         <div class="d-grid gap-2 d-md-flex ">
                              <button type="submit" name="search" class="btn btn-primary"> Export CSV </button> 
					                   </form>  			 
                             
                         </div>
                     </div> 
             </div>

  

                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">Online  Amount Colection {{$admin->online_cur_amount+$admin->online_withdraw}}TK </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-danger text-white mb-4">
                                    <div class="card-body">Available  Online Amount {{$admin->online_cur_amount}}TK </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-success text-white mb-4">
                                    <div class="card-body">Online Withdraw  {{$admin->online_withdraw}}TK </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-danger text-white mb-4">
                                    <div class="card-body">No Infromation</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
							
						

                         
                                <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">No Infromation</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                  </div>
                               </div>
                     

                        <div class="col-xl-3 col-md-6">
                                <div class="card bg-danger text-white mb-4">
                                    <div class="card-body">No Information</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                        </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-success text-white mb-4">
                                    <div class="card-body">No Information</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-danger text-white mb-4">
                                    <div class="card-body"> No Information</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>


                       </div>	


                        
                       

@endsection