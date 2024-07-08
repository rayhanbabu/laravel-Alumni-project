@extends('admin/dashboardheader')
@section('page_title','Admin Panel')
@section('notice_select','active')
@section('content')

<div class="row mt-4 mb-3">
               <div class="col-6"> <h4 class="mt-0"> {{$category}}</h4></div>
                     <div class="col-3">
                         <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            
                         </div>
                     </div>
                     <div class="col-3">
                         <div class="d-grid gap-2 d-md-flex ">
                         <a class="btn btn-primary" href="{{url('/admin/notice_create/'.$category)}}" role="button">Add</a>
              </div>
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


<div id="success_message"></div>
 <div class="row mb-2">
    <div class="col-md-9">

    </div>
    <div class="col-md-3">
     <div class="form-group">
      <input type="text" name="search" id="search" placeholder="Enter Search " class="form-control"  autocomplete="off"  />
     </div>
    </div>
   </div>


   <div class="card-block table-border-style">                     
 <div class="table-responsive">
 <div class="x_content">
 <table class="table table-bordered" id="employee_data">
 <thead>
       <tr>
         <th width="10%" class="sorting" data-sorting_type="asc" data-column_name="date" style="cursor: pointer">Date 
                <span id="date_icon" ><i class="fas fa-sort-amount-up-alt"></i></span> </th>
        <th width="20%" class="sorting" data-sorting_type="asc" data-column_name="category" style="cursor: pointer">Category
                  <span id="category_icon"><i class="fas fa-sort-amount-up-alt"></span></th>
         <th width="30%" class="sorting" data-sorting_type="asc" data-column_name="title" style="cursor: pointer">Title
            <span id="title_icon"><i class="fas fa-sort-amount-up-alt"></span></th>          
       
            <th  width="10%">Image</th>
		      <th  width="10%">View</th>
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

<script>  
$(document).ready(function(){ 

  $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} });

     $('#add').click(function(){  
           $('#submit').val("Submit");  
           $('#add_form')[0].reset();   			   
      }); 


         fetch();
         function fetch(){
            $.ajax({
             type:'GET',
             url:'/admin/notice_fetch/{{$category}}',
             datType:'json',
             success:function(response){
                    $('tbody').html('');
                   $('.x_content tbody').html(response);
              }
             });
          }
    

    function fetch_data(page, sort_type="", sort_by="", search=""){
        $.ajax({
        url:"/admin/notice/fetch_data/{{$category}}?page="+page+"&sortby="+sort_by+"&sorttype="+sort_type+"&search="+search,
        success:function(data)
        {
         $('tbody').html('');
            $('.x_content tbody').html(data);
         }
         });
       }
   
       
    $(document).on('keyup', '#search', function(){
        var search = $('#search').val();
        var column_name = $('#hidden_column_name').val();
        var sort_type = $('#hidden_sort_type').val();
        var page = $('#hidden_page').val();
        fetch_data(page, sort_type, column_name, search);
      });


      $(document).on('click', '.pagin_link a', function(event){
           event.preventDefault();
           var page = $(this).attr('href').split('page=')[1];
           var column_name = $('#hidden_column_name').val();
           var sort_type = $('#hidden_sort_type').val();
           var search = $('#search').val();
          fetch_data(page, sort_type, column_name, search);
        }); 


        $(document).on('click', '.sorting', function(){
          var column_name = $(this).data('column_name');
          var order_type = $(this).data('sorting_type');
          var reverse_order = '';
            if(order_type == 'asc')
             {
            $(this).data('sorting_type', 'desc');
            reverse_order = 'desc';
            $('#'+column_name+'_icon').html('<i class="fas fa-sort-amount-down"></i>');
             }
            else
            {
            $(this).data('sorting_type', 'asc');
            reverse_order = 'asc';
            $('#'+column_name+'_icon').html('<i class="fas fa-sort-amount-up-alt"></i>');
            }
           $('#hidden_column_name').val(column_name);
           $('#hidden_sort_type').val(reverse_order);
           var page = $('#hidden_page').val();
           var search = $('#search').val();
          fetch_data(page, reverse_order, column_name, search);
          });
}); 

</script>   
  




 @endsection             