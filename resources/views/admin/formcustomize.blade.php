@extends('admin/dashboardheader')
@section('page_title','Text')
@section('customize_select','active')
@section('content')

<div class="row mt-4 mb-3">
               <div class="col-3"> <h4 class="mt-0">Customize Form View</h4></div>
                    
                     </div> 
             </div>  
             
                     <div class="form-group  mx-2 my-2">
                           @if(Session::has('fail'))
                   <div  class="alert alert-danger"> {{Session::get('fail')}}</div>
                                @endif
                             </div>

                             <div class="form-group  mx-2 my-2">
                           @if(Session::has('success'))
                   <div  class="alert alert-success"> {{Session::get('success')}}</div>
                                @endif
                             </div>

             
             
 <div class="card-block table-border-style">                     
 <div class="table-responsive">
 <table class="table table-bordered" id="employee_data">
    <thead>
      <tr>
          <th width="10%" >Header </th>
          <th width="10%" >Footer </th>
          <th width="10%" >Registartion Status  </th>
          <th width="10%" >Name </th>
          <th width="10%" >Phone </th>
          <th width="15%" >Custom 1 </th>
		      <th width="15%" >Custom 2 </th>
	        <th width="15%" >Custom 3</th>
          <th width="15%" >Custom 4 </th>
	        <th width="15%" >Custom 5</th>
          <th width="15%" >Custom 6 </th>
		      <th width="15%" >Custom 7 </th>
	        <th width="15%" >Custom 8</th>
          <th width="15%" >Custom 9 </th>
	        <th width="15%" >Custom 10</th>
          <th width="5%" >Edit</th> 
      </tr>
  </thead>
  <tbody>

	@foreach($admin as $item)
	 <tr>
        <td>{{$item->header}}</td>
        <td>{{$item->footer}}</td>
        <td>{{$item->registration}}</td>
        <td>{{$item->formname}}</td>
        <td>{{$item->phone}}</td>
        <td>{{$item->custom1}}</td>
        <td>{{$item->custom2}}</td>
        <td>{{$item->custom3}}</td>
        <td>{{$item->custom4}}</td>
        <td>{{$item->custom5}}</td>
        <td>{{$item->custom6}}</td>
        <td>{{$item->custom7}}</td>
        <td>{{$item->custom8}}</td>
        <td>{{$item->custom9}}</td>
        <td>{{$item->custom10}}</td>
    <td>
      <button type="button" name="edit" id="{{$item->id}}" class="btn btn-success btn-sm edit" 
	  	 data-header="{{$item->header}}" data-footer="{{$item->footer}}"  data-registration="{{$item->registration}}" 
       data-formname="{{$item->formname}}" data-phone="{{$item->phone}}" data-custom1="{{$item->custom1}}"  
       data-custom2="{{$item->custom2}}"  data-custom3="{{$item->custom3}}"  data-custom4="{{$item->custom4}}" 
       data-custom5="{{$item->custom5}}"  data-custom6="{{$item->custom6}}"  data-custom7="{{$item->custom7}}"
       data-custom8="{{$item->custom8}}"  data-custom9="{{$item->custom9}}"  data-custom10="{{$item->custom10}}"  >Edit</button>
    </td>

      
	</tr>
    @endforeach	 
	</tbody>
  </table>
</div>
</div>


   <script>  
 $(document).ready(function(){  
      $('#employee_data').DataTable({
        "order": [[ 0, "desc" ]] ,
		"lengthMenu": [[20, 50, 100, -1], [20, 50, 100, "All"]]
      }
	  );  
 });  
 </script>  
	</div>
</div>


<script type="text/javascript">
           $(document).ready(function(){
                $(document).on('click','.edit',function(){
                   var id = $(this).attr("id");  
                 
                    var header = $(this).data("header");
                    var footer = $(this).data("footer");
                    var registration = $(this).data("registration");
                    var formname = $(this).data("formname");
                    var phone = $(this).data("phone");
                    var custom1 = $(this).data("custom1");
                    var custom2 = $(this).data("custom2");
                    var custom3 = $(this).data("custom3");
                    var custom4 = $(this).data("custom4");
                    var custom5 = $(this).data("custom5");
                    var custom6 = $(this).data("custom6");
                    var custom7 = $(this).data("custom7");
                    var custom8 = $(this).data("custom8");
                    var custom9 = $(this).data("custom9");
                    var custom10 = $(this).data("custom10");
                  
                  
                 
                   
                     $('#edit_id').val(id);
                     $('#edit_header').val(header);
                     $('#edit_footer').val(footer);
                     $('#edit_registration').val(registration);
                     $('#edit_formname').val(formname);
                     $('#edit_phone').val(phone);
                     $('#edit_custom1').val(custom1);
                     $('#edit_custom2').val(custom2);
                     $('#edit_custom3').val(custom3);
                     $('#edit_custom4').val(custom4);
                     $('#edit_custom5').val(custom5);
                     $('#edit_custom6').val(custom6);
                     $('#edit_custom7').val(custom7);
                     $('#edit_custom8').val(custom8);
                     $('#edit_custom9').val(custom9);
                     $('#edit_custom10').val(custom10);
                
                   
                   
                     $('#updatemodal').modal('show');
                });

           });


</script>






<!-- Modal Edit -->
<div class="modal fade" id="updatemodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Customize Form  Edit</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
      <form method="post" action="{{url('form/customize_update')}}"  class="myform"  enctype="multipart/form-data" >
         {!! csrf_field() !!}

           <input type="hidden" id="edit_id" name="edit_id" class="form-control">
           <input type="hidden" id="admin_name" name="admin_name" value="demoswa">
         <div class="row px-3">

          <div class="form-group  col-sm-12  my-2">
               <label class=""><b>Header</b></label>
               <input type="text" id="edit_header"  name="header" class="form-control" required>
          </div> 

          <div class="form-group  col-sm-12  my-2">
               <label class=""><b> Footer </b></label>
               <input type="text" id="edit_footer"  name="footer" class="form-control" >
          </div> 

          <div class="form-group  col-sm-6  my-2">
               <label class=""><b> Name </b></label>
               <input type="text" id="edit_formname"  name="formname" class="form-control" required >
          </div> 
    

       <div class="form-group col-sm-6  mb-4">
        <label class=""><b>Registration Status</b></label>
          <select class="form-select" id="edit_registration"  name="registration" aria-label="Default select example" required>
                  <option value="No">No</option>
                  <option value="Yes">Yes</option>
           </select>
       </div>   

       <div class="form-group col-sm-6  my-2">
               <label class=""><b>Phone</b></label>
               <input type="text" id="edit_phone"  name="phone" class="form-control" required >
        </div> 

         <div class="form-group col-sm-6  my-2">
               <label class=""><b>Customize 1</b></label>
               <input type="text" id="edit_custom1"  name="custom1" class="form-control" >
         </div> 

         <div class="form-group col-sm-6  my-2">
               <label class=""><b>Customize 2</b></label>
               <input type="text" id="edit_custom2"  name="custom2" class="form-control" >
         </div> 

         <div class="form-group col-sm-6  my-2">
               <label class=""><b>Customize 3</b></label>
               <input type="text" id="edit_custom3"  name="custom3" class="form-control" >
         </div> 

         <div class="form-group col-sm-6  my-2">
               <label class=""><b>Customize 4</b></label>
               <input type="text" id="edit_custom4"  name="custom4" class="form-control" >
         </div> 

         <div class="form-group col-sm-6  my-2">
               <label class=""><b>Customize 5</b></label>
               <input type="text" id="edit_custom5"  name="custom5" class="form-control" >
         </div> 

         <div class="form-group col-sm-6  my-2">
               <label class=""><b>Customize 6</b></label>
               <input type="text" id="edit_custom6"  name="custom6" class="form-control" >
         </div> 

         <div class="form-group col-sm-6  my-2">
               <label class=""><b>Customize 7</b></label>
               <input type="text" id="edit_custom7"  name="custom7" class="form-control" >
         </div> 

         <div class="form-group col-sm-6  my-2">
               <label class=""><b>Customize 8</b></label>
               <input type="text" id="edit_custom8"  name="custom8" class="form-control" >
         </div> 

         <div class="form-group col-sm-6  my-2">
               <label class=""><b>Customize 9</b></label>
               <input type="text" id="edit_custom9"  name="custom9" class="form-control" >
         </div> 

         <div class="form-group col-sm-6  my-2">
               <label class=""><b>Customize 10</b></label>
               <input type="text" id="edit_custom10"  name="custom10" class="form-control" >
         </div> 

         
    </div>
     <br>
      <input type="submit"   id="insert" value="Update" class="btn btn-success" />
	  
              
   </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>





   
   


@endsection     