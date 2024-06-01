@extends('maintain/dashboardheader')
@section('page_title','Dashboard Import')
@section('import_select','active')
@section('content')

        <h4 class="mt-4">Export Data</h4>
              <ol class="breadcrumb mb-4">
                  <li class="breadcrumb-item active">Dashboard/password change</li>
              </ol>
     <div class="row">
         <p>  'batch_id'=> $row[0], 
              'member_card'=>$row[1],
              'serial'=>$row[2], 
              'admin_name'=>$row[3], 
              'category_id'=>$row[4], 
              'name'=> $row[5], 
              'phone'=> $row[6], 
              'email'=> $row[7], 
              'member_password'=> $row[8], 
              'village'=> $row[9], 
              'organization'=> $row[10],  </p>
         @if(session('status'))
         <h5 class="alert alert-success">{{ session('status')}} </h5>
                @endif
               <div class="col-sm-6">
               <form action="{{ url('maintain/adminimport') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="file" class="form-control">
                <br>
                <button class="btn btn-success">Import User Data</button>
            </form
       
       </div>
               <div class="col-sm-6">
            
                </div>		 
          </div> 
             </div>


@endsection