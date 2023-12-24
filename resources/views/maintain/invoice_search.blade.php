@extends('maintain/dashboardheader')
@section('page_title','Invoice Search')
@section('invoice_search_select','active')
@section('content')
    
                       
          <div class="row mt-3 mb-0 mx-2"> 
               <div class="col-4"> <h4 class="mt-0"> Invoice Reports </h4> </div>
                          <div class="col-3">
                             
                         </div>

                         <div class="col-3">   
                         </div>
                
                       <div class="col-2">
                          <div class="d-grid gap-2 d-md-flex "> 
                            
                         </div>
                      </div> 
          </div>

     <br>
           

               <div class="card-block table-border-style">                     
   <div class="table-responsive">
     <table class="table table-bordered table-hover" id="employee_data">
    <thead>
             <tr>
                  
                   <th>Variable Name</th>
                   <th>Value</th>
             </tr>
    </thead>
    <tbody> 
            @foreach($data as $key => $value)
             <tr>
                  <td>{{$key}}</td>
                  <td>{{$value}}</td> 
            </tr>   
            @endforeach
	
 	</tbody>
     </table>

</div>
</div>      



            
                       

@endsection