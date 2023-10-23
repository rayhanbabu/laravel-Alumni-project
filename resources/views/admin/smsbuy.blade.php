@extends('admin/dashboardheader')
@section('page_title','SMS Buy')
@section('smsbuy_select','active')
@section('content')
    
                       
<div class="row mt-3 mb-0 mx-2">
               <div class="col-4"> <h4 class="mt-0">Total SMS Buy : {{$activesms}} </h4> </div>
                          <div class="col-3">
                             
                         </div>


                         <div class="col-3">
                           
                         </div>


                
                       <div class="col-2">
                          <div class="d-grid gap-2 d-md-flex "> 
                              <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEmployeeModal"><i
                            class="bi-plus-circle me-2"></i>Add</button>  
                         </div>
                      </div> 
 </div>

   <br>
           

               <div class="card-block table-border-style">                     
   <div class="table-responsive">
     <table class="table table-bordered" id="employee_data">
    <thead>
             <tr>
                  
                   <th>Total SMS</th>
                   <th>Payment Amount</th>
                   <th>Payment Type</th>
                   <th>Payment Status</th>
                   <th>Verify Status </th>
                   <th>Requested time </th>
                   <th>Pay Now </th>
             </tr>
    </thead>
    <tbody> 
            @foreach($smsbuy as $row)
             <tr>
                  <td>{{$row->smsno}}</td>
                  <td>{{$row->payment}}</td>
                  <td>{{$row->payment_type}}</td>
                  <td>
                     @if($row->status==1)
                      <button type="button" name="view" data-status="1" id="" class="btn btn-success btn-sm view"> Paid </button>  
                      @else 
                      <button type="button" name="view" data-status="0" id="" class="btn btn-danger btn-sm view"> Not Paid</button>  
                     @endif
                  </td>
                  <td>
                     @if($row->verify_status==1)
                      <button type="button" name="view" data-status="1" id="" class="btn btn-success btn-sm view"> Verified </button>  
                      @else 
                      <button type="button" name="view" data-status="0" id="" class="btn btn-danger btn-sm view"> Waiting</button>  
                     @endif
                  </td>
                  <td>{{$row->created_at}}</td>

                  <td>
		         <a  class="btn btn-primary btn-sm" href="{{ url('#')}}">Pay Now</a> 
                 </td>
            </tr>   
            @endforeach
	
	</tbody>
   </table>

  <script>  
  $(document).ready(function(){  
      $('#employee_data').DataTable({
        "order": [[ 0, "asc" ]] ,
	   "lengthMenu": [[15, 50, 100, -1], [10, 50, 100, "All"]]
      }
	  );  
  });  
 </script>  
</div>
</div>      




{{-- add new Student modal start --}}
<div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="exampleModalLabel"
  data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog  ">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form  method="POST" action="{{url('school/smsbuy')}}" enctype="multipart/form-data">
           @csrf    
        <div class="modal-body p-4 bg-light">
          <div class="row">


          
                        <div class="col-lg-12 my-2">
                                 <select class="form-control" name ="payment" id="payment" required >
                                        <option   value="">Seclect One</option>			    
                                        <option   value="300">750sms(300TK)</option> 
                                        <option   value="500">1250sms(500TK)</option> 
                                        <option   value="1000">2500sms(1000TK)</option>          
			              </select>
                         </div>

     



          </div>

          <div class="loader">
            <img src="{{ asset('images/abc.gif') }}" alt="" style="width: 50px;height:50px;">
          </div>

        <div class="mt-4">
            <button type="submit" id="edit_employee_btn" class="btn btn-success">Update </button>
       </div>  

      </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
         
        </div>
      </form>
    </div>
  </div>
</div>

             
                       

@endsection