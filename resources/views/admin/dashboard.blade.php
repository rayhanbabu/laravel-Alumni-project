@extends('admin/dashboardheader')
@section('page_title','Admin Dashboard')
@section('admin_select','active')
@section('content')

<div class="row mt-4 mb-3">
    <div class="col-sm-2 p-2">
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <form action="{{url('admin/amarpay_search')}}" method="POST" enctype="multipart/form-data">
                {!! csrf_field() !!}
                <input type="hidden" name="panel" class="form-control" value="admin" />
                <input type="text" name="tran_id" id="tran_id" class="form-control" placeholder="Search Invoice Id">
        </div>
    </div>

    <div class="col-sm-1 p-2">
        <div class="d-grid gap-2 d-md-flex justify-content-md-start">
            <button type="submit" name="search" class="btn btn-primary"> Submit </button>
            </form>
        </div>
    </div>

    <div class="col-sm-2 p-2">
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <form action="{{url('member/export')}}" method="POST" enctype="multipart/form-data">
                {!! csrf_field() !!}
                <select class="form-select" name="category_id" id="category_id" aria-label="Default select example" required>
                    @foreach(member_category() as $category)
                    <option value="{{$category->id}}">{{$category->category}}</option>
                    @endforeach
                </select>
        </div>
    </div>

    <div class="col-sm-1  p-2">
        <div class="d-grid gap-2 d-md-flex ">
            <button type="submit" name="search" class="btn btn-primary"> Export  </button>
            </form>
        </div>
    </div>

     <div class="col-sm-2 p-2">
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <form action="{{url('pdf/member_info')}}" method="POST" enctype="multipart/form-data">
                {!! csrf_field() !!}
                <select class="form-select" name="batch_id" id="batch_id" aria-label="Default select example" >
                    <option value="">Select Batch/Session</option>
                @foreach(batch_category() as $category)
                    <option value="{{$category->id}}">{{$category->category}}</option>
                    @endforeach
                </select>
         </div>
     </div>

    <div class="col-sm-2 p-2">
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                 {!! csrf_field() !!}
                 <select class="form-select" name="profession_id" id="profession_id" aria-label="Default select example" >
                     <option value="">Select Profession </option>
                  @foreach(profession_category() as $category)
                     <option value="{{$category->id}}">{{$category->category}}</option>
                    @endforeach
                </select>
        </div>
    </div>


    <div class="col-sm-1 p-2">
        <div class="d-grid gap-2 d-md-flex justify-content-md-start">
            <button type="submit" name="search" class="btn btn-primary"> Search </button>
            </form>
        </div>
    </div>


</div>

<div class="row">

    <div class="col-xl-3 col-sm-6 col-12 p-2">
        <div class="card shadow">
            <div class="card-content">
                <div class="card-body">
                    <div class="media d-flex">
                        <div class="media-body text-left">
                            <h3 class="success">{{$total_payment}}TK</h3>
                            </h3>
                            <span>Online Amount Colection </span>
                        </div>
                        <div class="align-self-center">
                            <i class="icon-cup success font-large-2 float-right"></i>
                        </div>
                    </div>
                    <div class="progress mt-1 mb-0" style="height: 7px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="col-xl-3 col-sm-6 col-12 p-2">
        <div class="card shadow">
            <div class="card-content">
                <div class="card-body">
                    <div class="media d-flex">
                        <div class="media-body text-left">
                            <h3 class="success"> {{$total_payment-$withdraw}}TK </h3>
                            </h3>
                            <span>Available Online Amount</span>
                        </div>
                        <div class="align-self-center">
                            <i class="icon-cup success font-large-2 float-right"></i>
                        </div>
                    </div>
                    <div class="progress mt-1 mb-0" style="height: 7px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="col-xl-3 col-sm-6 col-12 p-2">
        <div class="card shadow">
            <div class="card-content">
                <div class="card-body">
                    <div class="media d-flex">
                        <div class="media-body text-left">
                            <h3 class="success">{{$withdraw}}TK</h3>
                            </h3>
                            <span>Online Withdraw </span>
                        </div>
                        <div class="align-self-center">
                            <i class="icon-cup success font-large-2 float-right"></i>
                        </div>
                    </div>
                    <div class="progress mt-1 mb-0" style="height: 7px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="col-xl-3 col-sm-6 col-12 p-2">
        <div class="card shadow">
            <div class="card-content">
                <div class="card-body">
                    <div class="media d-flex">
                        <div class="media-body text-left">
                            <h3 class="success">00</h3>
                            </h3>
                            <span> No Infromation </span>
                        </div>
                        <div class="align-self-center">
                            <i class="icon-cup success font-large-2 float-right"></i>
                        </div>
                    </div>
                    <div class="progress mt-1 mb-0" style="height: 7px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<h4> Report Summary </h4>

<div class="row">

    <div class="col-xl-3 col-sm-6 col-12 p-2">
        <div class="card bg-light shadow">
            <div class="mx-3 my-2">
                <b class="text-center">Range Wise Payment Report </b>
            </div>
            <form action="{{ url('pdf/payment_report') }}" method="post" enctype="multipart/form-data">
                {!! csrf_field() !!}
                <div class="justify-content-end p-3">
                    <label> Payment Type</label>
                    <select class="form-control form-control-sm" name="payment_type" id="payment_type" aria-label="Default select example" required>
                        <option value="">Select Type </option>
                        <option value="Offline">Offline</option>
                        <option value="Online">Online</option>
                    </select>
                </div>

                <div class="form-group  mx-3 my-1">
                    <label> From date </label>
                    <input type="date" name="date1" class="form-control form-control-sm" value="" required />
                </div>

                <div class="form-group  mx-3 my-3">
                    <label> To date </label>
                    <input type="date" name="date2" class="form-control form-control-sm" value="" required />
                </div>

                <div class="form-group  mx-3 my-3">
                    <input type="submit" value="Submit" class="btn btn-primary waves-effect waves-light btn-sm">
                </div>
            </form>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6 col-12 p-2">
        <div class="card bg-light shadow">
            <div class="mx-3 my-2">
                <b class="text-center">Date Wise Payment Report </b>
            </div>
            <form action="{{ url('pdf/payment_report_date') }}" method="post" enctype="multipart/form-data">
                {!! csrf_field() !!}
                <div class="justify-content-end p-3">
                    <label> Payment Type</label>
                    <select class="form-control form-control-sm" name="payment_type" id="payment_type" aria-label="Default select example" required>
                        <option value="">Select Type </option>
                        <option value="Offline">Offline</option>
                        <option value="Online">Online</option>
                    </select>
                </div>

                <div class="form-group  mx-3 my-1">
                    <label> date </label>
                    <input type="date" name="date" class="form-control form-control-sm" value="" required />
                </div>

                <div class="form-group  mx-3 my-3">
                    <input type="submit" value="Submit" class="btn btn-primary waves-effect waves-light btn-sm">
                </div>
            </form>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6 col-12 p-2">
        <div class="card bg-light shadow">
            <div class="mx-3 my-2">
                <b class="text-center">Category Wise Payment Report </b>
            </div>
            <form action="{{ url('pdf/payment_category_report') }}" method="post" enctype="multipart/form-data">
                {!! csrf_field() !!}
                <div class="justify-content-end p-3">
                    <label> Payment Type</label>
                    <select class="form-control form-control-sm" name="payment_type" id="payment_type" aria-label="Default select example" required>
                        <option value="">Select Type </option>
                        <option value="Offline">Offline</option>
                        <option value="Online">Online</option>
                    </select>
                </div>

                <div class="justify-content-end p-3">
                    <label> Select category</label>
                          <select class="form-control" name="category" required>
                                    <option value="">Select  One </option>
                                    @foreach($all_category as $row)
                                  <option value="{{$row->id}}">{{$row->category}}</option>
                                 @endforeach	
                         </select> 
                </div>



                <div class="form-group  mx-3 my-3">
                    <input type="submit" value="Submit" class="btn btn-primary waves-effect waves-light btn-sm">
                </div>
            </form>
        </div>
    </div>



    <div class="col-xl-3 col-sm-6 col-12 p-2">
        <div class="card bg-light shadow">
            <div class="mx-3 my-2">
                <b class="text-center">Member & Non Member Event List  </b>
            </div>
            <form action="{{ url('pdf/event_report') }}" method="post" enctype="multipart/form-data">
                {!! csrf_field() !!}
                <div class="justify-content-end p-3">
                   
                </div>

                <div class="justify-content-end p-3">
                   
                </div>



                <div class="form-group  mx-3 my-3">
                    <input type="submit" value="Submit" class="btn btn-primary waves-effect waves-light btn-sm">
                </div>
            </form>
        </div>
    </div>




</div>



<h4> Event Infromation Member</h4>
<div class="row">
    @php
    $total_sum_offline=0;
    $total_sum=0;
    @endphp
    @foreach($event_category as $item)
    <div class="col-xl-3 col-sm-6 col-12 p-2">
        <div class="card shadow">
            <div class="card-content">
                <div class="card-body">
                    <div class="media d-flex">
                        <div class="media-body text-left">

                            @php
                            $total=event_atten_number($item->admin_name,$item->id)->count();
                            $total_sum+=$total;

                            $total_offline=event_atten_payment_type($item->admin_name,$item->id,'Offline')->count();
                            $total_sum_offline+=$total_offline;
                            @endphp
                            <h3 class="success"> {{ event_atten_number($item->admin_name,$item->id)->count() }} </h3>
                            </h3>
                            <div class="d-grid gap-2 d-md-flex">
                                <p class="text-start text-info ">Online: {{event_atten_payment_type($item->admin_name,$item->id,'Online')->count() }} </p>
                                <p class="text-end text-success">Offline: {{event_atten_payment_type($item->admin_name,$item->id,'Offline')->count() }}</p>
                            </div>
                            <span> {{ $item->category }} ({{ $item->amount }}TK ) </span>
                        </div>
                        <div class="align-self-center">
                            <i class="icon-cup success font-large-2 float-right"></i>
                        </div>
                    </div>
                    <div class="progress mt-1 mb-0" style="height: 7px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach






    <div class="col-xl-3 col-sm-6 col-12 p-2">
        <div class="card shadow">
            <div class="card-content">
                <div class="card-body">
                    <div class="media d-flex">
                        <div class="media-body text-left">
                            <h3 class="success"> {{$total_sum}}</h3>
                            <div class="d-grid gap-2 d-md-flex">
                                <p class="text-start text-info ">Online: {{$total_sum-$total_sum_offline}} </p>
                                <p class="text-end text-success">Offline: {{$total_sum_offline}}</p>
                            </div>
                            </h3>
                            <span> Total Member Present </span>
                        </div>
                        <div class="align-self-center">
                            <i class="icon-cup success font-large-2 float-right"></i>
                        </div>
                    </div>
                    <div class="progress mt-1 mb-0" style="height: 7px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>




<h4> Event Infromation Non-Member</h4>
<div class="row">
    @php
    $non_total_sum_offline=0;
    $non_total_sum=0;
    @endphp
    @foreach($event_category as $item)
    <div class="col-xl-3 col-sm-6 col-12 p-2">
        <div class="card shadow">
            <div class="card-content">
                <div class="card-body">
                    <div class="media d-flex">
                        <div class="media-body text-left">

                            @php
                            $total=non_event_atten_number($item->admin_name,$item->id)->count();
                            $non_total_sum+=$total;

                            $non_total_offline=non_event_atten_payment_type($item->admin_name,$item->id,'Offline')->count();
                            $non_total_sum_offline+=$non_total_offline;
                            @endphp
                            <h3 class="success"> {{ non_event_atten_number($item->admin_name,$item->id)->count() }} </h3>
                            </h3>
                            <div class="d-grid gap-2 d-md-flex">
                                <p class="text-start text-info ">Online: {{non_event_atten_payment_type($item->admin_name,$item->id,'Online')->count() }} </p>
                                <p class="text-end text-success">Offline: {{non_event_atten_payment_type($item->admin_name,$item->id,'Offline')->count() }}</p>
                            </div>
                            <span> {{ $item->category }} ({{ $item->amount }}TK ) </span>
                        </div>
                        <div class="align-self-center">
                            <i class="icon-cup success font-large-2 float-right"></i>
                        </div>
                    </div>
                    <div class="progress mt-1 mb-0" style="height: 7px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach






    <div class="col-xl-3 col-sm-6 col-12 p-2">
        <div class="card shadow">
            <div class="card-content">
                <div class="card-body">
                    <div class="media d-flex">
                        <div class="media-body text-left">
                            <h3 class="success"> {{$non_total_sum}}</h3>
                            <div class="d-grid gap-2 d-md-flex">
                                <p class="text-start text-info ">Online: {{$non_total_sum-$non_total_sum_offline}} </p>
                                <p class="text-end text-success">Offline: {{$non_total_sum_offline}}</p>
                            </div>
                            </h3>
                            <span> Total Member Present </span>
                        </div>
                        <div class="align-self-center">
                            <i class="icon-cup success font-large-2 float-right"></i>
                        </div>
                    </div>
                    <div class="progress mt-1 mb-0" style="height: 7px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>





@endsection