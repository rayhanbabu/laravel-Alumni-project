@extends('admin/dashboardheader')
@section('page_title','Data View')
@section('dataview_select','active')
@section('content')

<div class="row mt-4 mb-3">
               <div class="col-3"> <h4 class="mt-0">Token Setup</h4></div> 
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
         <th width="10%" >Token 1</th>
         <th width="10%" >Token 2 </th>
         <th width="10%" >Token 3 </th>
         <th width="10%" >Token 4 </th>
         <th width="10%" >Token 5 </th>
         <th width="15%" >Token 6 </th>
         <th width="5%" >Edit</th>
        
      </tr>
  </thead>
  <tbody>

	@foreach($admin as $item)
	 <tr>
        <td>{{$item->token1}}</td>
        <td>{{$item->token2}}</td>
        <td>{{$item->token3}}</td>
        <td>{{$item->token4}}</td>
        <td>{{$item->token5}}</td>
        <td>{{$item->token6}}</td>
       

    <td>
      <button type="button" name="edit" id="{{$item->id}}" class="btn btn-success btn-sm edit" 
	    data-token1="{{$item->token1}}"  data-token2="{{$item->token2}}"  data-token3="{{$item->token3}}"
          data-token4="{{$item->token4}}" data-token5="{{$item->token5}}" data-token6="{{$item->token6}}"
           >Edit</button>
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
                 
                   var token1 = $(this).data("token1");
                   var token2 = $(this).data("token2");
                   var token3 = $(this).data("token3");
                   var token4 = $(this).data("token4");
                   var token5 = $(this).data("token5");
                   var token6 = $(this).data("token6");
                 
                 
                 
                   
                     $('#edit_id').val(id);
                     $('#edit_token1').val(token1);
                     $('#edit_token2').val(token2);
                     $('#edit_token3').val(token3);
                     $('#edit_token4').val(token4);
                     $('#edit_token5').val(token5);
                     $('#edit_token6').val(token6);
                    
                     $('#updatemodal').modal('show');
                });

           });


</script>






<!-- Modal Edit -->
<div class="modal fade" id="updatemodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Token Setup  Edit</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
      <form method="post" action="{{url('admin/dataedit')}}"  class="myform"  enctype="multipart/form-data" >
         {!! csrf_field() !!}

         <input type="hidden" id="edit_id" name="id" class="form-control">

         <div class="row px-3">

       

          <div class="form-group  col-sm-12  my-2">
               <label class=""><b>Token 1</b></label>
               <input type="text" id="edit_token1"  name="token1" class="form-control" >
          </div> 

          <div class="form-group  col-sm-12  my-2">
               <label class=""><b>Token 2</b></label>
               <input type="text" id="edit_token2"  name="token2" class="form-control" >
          </div>

          <div class="form-group  col-sm-12  my-2">
               <label class=""><b>Token 3</b></label>
               <input type="text" id="edit_token3"  name="token3" class="form-control" >
          </div>

          <div class="form-group  col-sm-12  my-2">
               <label class=""><b>Token 4</b></label>
               <input type="text" id="edit_token4"  name="token4" class="form-control" >
          </div>

          <div class="form-group  col-sm-12  my-2">
               <label class=""><b>Token 5</b></label>
               <input type="text" id="edit_token5"  name="token5" class="form-control" >
          </div>

          <div class="form-group  col-sm-12  my-2">
               <label class=""><b>Token 6</b></label>
               <input type="text" id="edit_token6"  name="token6" class="form-control" >
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