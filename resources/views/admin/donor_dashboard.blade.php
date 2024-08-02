@extends('admin/dashboardheader')
@section('page_title','Admin Dashboard')
@section('donor_admin_select','active')
@section('content')


<div class="row p-2">
           <h3>Donor Dashboard</h3>
    <div class="col-xl-3 col-sm-6 col-12 p-2">
        <div class="card shadow">
            <div class="card-content">
                <div class="card-body">
                    <div class="media d-flex">
                        <div class="media-body text-left">
                            <h3 class="success">{{$donormember}}TK</h3>
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
                            <h3 class="success"> {{$donormember-$donorwithdraw}}TK </h3>
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
                            <h3 class="success">{{$donorwithdraw}}TK</h3>
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
            <form action="{{ url('pdf/donor_payment_report') }}" method="post" enctype="multipart/form-data">
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

   

</div>



@endsection