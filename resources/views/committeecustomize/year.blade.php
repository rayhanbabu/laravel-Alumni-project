@extends('admin/dashboardheader')
@section('page_title','Appication')
@section('app_select','active')
@section('content')



<div class="row mt-2 mb-0 mx-1 shadow p-1">
    
       <div class="col-sm-6 my-2">
           <form  method="get" enctype="multipart/form-data">   
             <label> Select Unit </label>
              <select name="committeeunit_id" id="committeeunit_id" class="js-example-disabled-results" style="width:300px;" aria-label="Default select example" required>
                     <option value=""> Select Committee Unit</option>
                      @foreach($committeeunit as $row)  
                          @if($row->id==($committeeunit_id?$committeeunit_id->id:0))
                                <option  value="{{$row->id}}" selected> 
                               {{$row->unit_name}}</option>
                           @else
                             <option value="{{$row->id}}">{{$row->unit_name}}</option>
                           @endif
                      @endforeach
              </select>


      </div>
    

        <div class="col-sm-2 mt-2">
              <button type="submit" name="search" class="btn btn-primary btn-sm">Search</button>
         </div>
      </form>
    </div>


  @if($committeeunit_id!="")    
  <div class="card">
  <div class="card-header">

  <div class="row">
          <div class="col-6"> <h4 class="mt-0">Year List of {{$committeeunit_id?$committeeunit_id->unit_name:"" }} </h4></div>
                     <div class="col-3">
                          <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            
                          </div>
                      </div>
                      <div class="col-3">
                         <div class="d-grid gap-2 d-md-flex ">
                          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AddModal">
                           Add
                         </button>         
                </div>
          </div> 
    </div> 

    </div>
    <div class="card-body">

<div id="success_message"></div>
 <div class="row mb-2">
    <div class="col-md-9">

    </div>
    <div class="col-md-3">
     <div class="form-group">
      <input type="text" name="search" id="search" placeholder="Enter Search " class="form-control form-control-sm"  autocomplete="off"  />
     </div>
    </div>
   </div>


   <div class="card-block table-border-style">                     
 <div class="table-responsive">
 <div class="x_content">
 <table class="table table-bordered" id="employee_data">
 <thead>
       <tr>
              <th  width="10%"> Id </th>
              <th width="15%" class="sorting" data-sorting_type="asc" data-column_name="year_name" style="cursor: pointer" > Committee year 
              <span id="year_name_icon" ><i class="fas fa-sort-amount-up-alt"></i></span> </th>
              <th  width="10%"> Status </th>
		          <th  width="10%"></th>
		          <th  width="10%"></th>
      </tr>
    </thead>
    <tbody>
       
    </tbody>
  </table>
    <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
    <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="id" />
    <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc" />
 
   </div>
  </div>
</div>


</div>
</div>


   <!-- Modal Add -->
   <div class="modal fade" id="AddModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
     <div class="modal-dialog">
       <div class="modal-content">
         <div class="modal-header">
           <h5 class="modal-title" id="staticBackdropLabel"> Add</h5>
           <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

   <form method="post" id="add_form" enctype="multipart/form-data" >
      <div class="modal-body">
            <ul class="alert alert-warning d-none"  id="add_form_errlist"></ul>

     <div class="form-group  my-2">
            <h4>   {{$committeeunit_id?$committeeunit_id->unit_name:"" }} </h4>
	      	<label><b>Committeee Year</b></label>
	        <input name="year_name" id="year_name" type="text"   class="form-control"  required/>
          <p class="text-danger err_year_name"></p>
     </div>


       <div class="form-group  my-2">
         <label for="lname"> Committee Status </label>
                <select class="form-select" name="year_status" id="year_status" aria-label="Default select example"  >
                      <option value="1">Runing Committee</option>
                      <option value="0">Previous Committee </option>
                </select>
       </div>     
     

          <input type="hidden" name="committeeunit_id" id="committeeunit_id" value="{{$committeeunit_id->id}}" >
    
    
      <div class="loader">
                  <img src="{{ asset('images/abc.gif') }}" alt="" style="width: 50px;height:50px;">
			 </div><br>
	 
    
     <button type="submit"  id="add_btn"   class=" btn btn-success">Submit</button>

   </div>
   </form> 


      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>   

 <!-- Modal Add  End-->



  <!-- Modal Edit -->
  <div class="modal fade" id="EditModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Edit</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

<form method="post" id="edit_form" enctype="multipart/form-data" >
   <div class="modal-body">
 

      <input type="hidden" name="edit_id"  id="edit_id" >

                                
      <div class="form-group  my-2">
            <h4>   {{$committeeunit_id?$committeeunit_id->unit_name:"" }} </h4>
	      	<label><b>Committeee Year</b></label>
	        <input name="year_name" id="edit_year_name" type="text"   class="form-control"  required/>
          <p class="text-danger err_year_name"></p>
     </div>


       <div class="form-group  my-2">
         <label for="lname"> Committee Status </label>
                <select class="form-select" name="year_status" id="edit_year_status" aria-label="Default select example"  >
                      <option value="1">Runing Committee</option>
                      <option value="0">Previous Committee </option>
                </select>
       </div>     
     
   
	  


    <div class="loader">
            <img src="{{ asset('images/abc.gif') }}" alt="" style="width: 50px;height:50px;">
        </div><br>
 
<input type="submit" id="edit_btn"  value="Update" class="btn btn-success" />


   </div>
   </form> 


      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>   

 <!-- Modal Edit End-->


<script>
    var committeeunit_id = @json($committeeunit_id->id);
</script>

<script src="{{ asset('js/year.js') }}"></script>

@endif

<script type="text/javascript">
      
        $('.js-example-basic-multiple').select2();
        $(".js-example-disabled-results").select2();
</script>


 @endsection             