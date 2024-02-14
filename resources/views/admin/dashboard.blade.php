@extends('admin/dashboardheader')
@section('page_title','Admin Dashboard')
@section('admin_select','active')
@section('content')

<div class="row mt-4 mb-3">
    <div class="col-sm-3">
        <h5 class="mt-0">Dashboard </h5>
    </div>


    <div class="col-sm-2 p-2">
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <form action="{{url('admin/amarpay_search')}}" method="POST" enctype="multipart/form-data">
                {!! csrf_field() !!}
                <input type="hidden" name="panel" class="form-control" value="admin" />
                <input type="text" name="tran_id" id="tran_id" class="form-control" placeholder="Search Invoice Id">
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
                <select class="form-select" name="category_id" id="category_id" aria-label="Default select example" required>
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

       <div class="col-xl-3 col-sm-6 col-12 p-2">
        <div class="card shadow">
            <div class="card-content">
                <div class="card-body">
                    <div class="media d-flex">
                        <div class="media-body text-left">
                            <h3 class="success">{{$admin->online_cur_amount+$admin->online_withdraw}}TK</h3>
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
                            <h3 class="success"> {{$admin->online_cur_amount}}TK </h3>
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
                            <h3 class="success">{{$admin->online_withdraw}}TK</h3>
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
         <br>
       <h4> Event Infromation</h4>

  <div class="row">
       @php
          $y=0;
          $x=0;
       @endphp
      @foreach($event_category as $item)
         <div class="col-xl-3 col-sm-6 col-12 p-2">
          <div class="card shadow">
            <div class="card-content">
                <div class="card-body">
                    <div class="media d-flex">
                        <div class="media-body text-left">

                        @php
                         $y=event_atten_number($item->admin_name,$item->id)->count();
                         $x+=$y;
                        @endphp
                            <h3 class="success"> {{ event_atten_number($item->admin_name,$item->id)->count() }} </h3>
                            </h3>
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
                            <h3 class="success"> {{$x}}</h3>
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