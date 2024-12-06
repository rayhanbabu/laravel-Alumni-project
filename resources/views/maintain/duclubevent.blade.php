@extends('maintain/dashboardheader')
@section('page_title','Data View')
@section('duclub_event','active')
@section('content')

<div class="card mt-2 mb-2 shadow-sm">
     <div class="card-header">
       <div class="row ">
               <div class="col-4">  <h5 class="mt-0"> Du Club Event Infromation </h5>  </div>
                     <div class="col-4">
                       <form  action="{{url('duclubevnt/export')}}"  method="POST"  enctype="multipart/form-data" >
                            {!! csrf_field() !!}
                           <div class="d-grid gap-2 d-md-flex justify-content-md-end">   
                           <input type="number" name="year" id="year" placeholder="Enter Year " class="form-control form-control-sm"  autocomplete="off"  />
                           <button type="submit" name="search" class="btn btn-primary btn-sm"> Export  </button>
                     </form>             
                         </div>
                     </div>

                    
                     <div class="col-2">
                         <div class="d-grid gap-2 d-md-flex ">
                      
                         </div>
                     </div> 
         </div>
           
         @if(Session::has('fail'))
             <div  class="alert alert-danger"> {{Session::get('fail')}}</div>
         @endif
                        
        @if(Session::has('success'))
              <div  class="alert alert-success"> {{Session::get('success')}}</div>
            @endif


      </div>
  <div class="card-body">   

   <div class="row">
         <div class="col-md-12">
           <div class="table-responsive">
                <table class="table  table-bordered data-table">
                   <thead>
                     <tr>
                         <td> Id </td>
                         <td> Name </td>
                         <td> Phone </td>
                         <td> Year </td>
                         <td> Invite Person</td>
                         <td> Dept </td>
                         <td> Designation </td>
                        
                      </tr>
                   </thead>
                   <tbody>

                   </tbody>

                </table>
          </div>
       </div>
    </div>


  </div>
</div>




<script>
       $(function() {
   var table = $('.data-table').DataTable({
       processing: true,
       serverSide: true,
       ajax: {
           url: "{{ url('/duclub/event') }}",
           error: function(xhr, error, code) {
               console.log(xhr.responseText);
           }
       },
       columns: [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'phone', name: 'phone'},
            {data: 'year', name: 'year'},
            {data: 'invite', name: 'invite'},
            {data: 'dept', name: 'dept'},
            {data: 'designation', name: 'designation'},
          
       ]
   });
});

   </script>






   
   
     


@endsection