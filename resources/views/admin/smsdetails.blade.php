@extends('admin/dashboardheader')
@section('page_title','Admin Dashboard')
@section('smsdetails_select','active')
@section('content')

<h4 class="mt-4"> SMS Detals </h4>
               <ol class="breadcrumb mb-4">

               </ol>
         

  <div class="card-block table-border-style">                     
     <div class="table-responsive">
       <table class="table table-bordered" id="employee_data">
       <thead>
             <tr>
                   <th>SMS type</th>
                   <th>No Of SMS</th>
                   <th>Others</th>
                   <th>Message</th>
                   <th>Cetagory</th>
                   <th>Date & time </th>
             </tr>
    </thead>
    <tbody> 
            @foreach($smsspend as $row)
             <tr>
                  <td>{{$row->sms_type}}</td>
                  <td>{{$row->sms_count}}</td>
                  <td>{{$row->others1}}</td>
                  <td>{{$row->text}}</td>
                  <td>{{$row->class}}</td>
                  <td>{{$row->created_at}}</td>
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
                          
                        
                       

@endsection