@extends('admin/dashboardheader')
@section('page_title','Blood Search')
@section('bloodsearch_select','active')
@section('content')




 <div class="panel panel-primary"> 
	   
	 <div class="panel-body">
    <div class="form-group">
      <div class="row mt-4 mb-3">
       <div class="col-6"> 
         <label> <h4>&nbsp;রক্ত অনুসন্ধান করুন </h4></label>
        <select class="form-control" name="blood1" id="blood1">
                             <option  value="">Select One </option>
                              <option   value="A-">A-</option>
							  <option   value="A+">A+</option>
							  <option   value="B-">B-</option>
							  <option   value="B+">B+</option>
							  <option   value="AB-">AB-</option>
							  <option   value="AB+">AB+</option>
							  <option   value="O-">O-</option>
							  <option   value="O+">O+</option>
        </select>
      </div> 
      <div class="col-6"> 
         <label> <h4>&nbsp;</h4></label><br>
        <button type="button" name="search" id="search" class="btn btn-success">Submit</button>
      </div>

  </div>
   
   
  
	</div>
</div>





 <div class="table-responsive">
           <div class="card-body" id="show_all_employees">
                    
                   
                
              </div>
     </div>


 




<script>  
  $(document).ready(function(){ 

    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} });
 
    $('#search').click(function(){
     var blood1= $('#blood1').val();
      if(blood1 != '')
     {
       $.ajax({
          type:'POST',
          url:'/bloodsearchview',
          data:{blood1:blood1},
          success:function(response){
            $("#show_all_employees").html(response);
            $("table").DataTable({
              order: [0, 'desc']
            });
          }
        });
     }else{
       Swal.fire("Blood Type is Required!", "!", "warning");
    }
    });


      fetchAll();
      function fetchsearch() {
        $.ajax({
          type:'GET',
          url:'/text/fetchall',
          success: function(response) {
             console.log(response);
            $("#show_all_employees").html(response);
            $("table").DataTable({
              order: [0, 'desc']
            });
          }
        });
      }



      





});

</script>




@endsection     