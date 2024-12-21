$(document).ready(function(){ 

    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} });
  
        $('.js-example-basic-multiple').select2();
         $(".js-example-disabled-results").select2();
  
       $('#add').click(function(){  
             $('#submit').val("Submit");  
             $('#add_form')[0].reset();   			   
        }); 
  
  
           fetch();

          // var committeeunit_id=$('#committeeunit_id').val();
           function fetch(){
              $.ajax({
               type:'GET',
               url:'/committee/year_fetch/'+committeeunit_id,
               datType:'json',
               success:function(response){
                      $('tbody').html('');
                      $('.x_content tbody').html(response);
                  }
              });
           }
      
  
  
             $(document).on('click', '.delete_id', function(e){ 
              e.preventDefault(); 
              var delete_id = $(this).val(); 
              if(confirm("Are you sure you want to delete this?"))
                   {
                     $.ajax({
                     type:'DELETE',
                     url:'/committee/year_delete/'+delete_id,
                     success:function(response){    
                         //console.log(response); 
                         $('#success_message').html("");
                         $('#success_message').addClass('alert alert-success');
                         $('#success_message').text(response.message)
                         $('#deleteexampleModal').modal('hide');
                         fetch();
                        }
                     }); 
                  
                   }
                   else
                    {
                    return false; 
                    }
              });
  
  
  
  
  
          $(document).on('submit', '#edit_form', function(e){ 
          e.preventDefault(); 
          var edit_id=$('#edit_id').val();
  
          let editData=new FormData($('#edit_form')[0]);
          $.ajax({
               type:'POST',
               url:'/committee/year_update/'+edit_id,
               data:editData,
               contentType: false,
               processData:false,
               beforeSend : function()
                 {
                 $('.loader').show();
                 $("#edit_btn").prop('disabled', true)
  
                 },
               success:function(response){
                     // console.log(response);
                     if(response.status == 400){
                      $('.edit_err_phone').text(response.validate_err.phone);
                      $('.edit_err_dureg').text(response.validate_err.dureg);
                         //  $('#edit_form_errlist').html("");
                         //  $('#edit_form_errlist').removeClass('d-none');
                         //  $.each(response.errors,function(key,err_values){ 
                         //  $('#edit_form_errlist').append('<li>'+err_values+'</li>');
                         //  });
                    }else{
                      $('#edit_form_errlist').html("");
                      $('#edit_form_errlist').addClass('d-none');
                      $('#success_message').html("");
                      $('#success_message').addClass('alert alert-success');
                      $('#success_message').text(response.message)
                      $('#EditModal').modal('hide');
                      $('.err_phone').text('');
                      $('.err_dureg').text('');
                      fetch();
                    }
                    $("#edit_btn").prop('disabled', false)
                    $('.loader').hide();
               }
            });
         });
  
  
  
  
             $(document).on('click', '.edit_id', function(e){ 
              e.preventDefault(); 
              var edit_id = $(this).val(); 
              //alert(edit_id)
              $('#EditModal').modal('show');
              $.ajax({
               type:'GET',
               url:'/committee/year_edit/'+edit_id,
               success:function(response){
               
                  if(response.status == 404){
                    $('#success_message').html("");
                    $('#success_message').addClass('alert alert-danger');
                    $('#success_message').text(response.message);
                  }else{
                    $('#edit_year_status').val(response.edit_value.year_status);
                    $('#edit_year_name').val(response.edit_value.year_name);
                    $('#edit_id').val(edit_id);
                  }
               }
               });
             });
  
    
  
  
       $(document).on('submit', '#add_form', function(e){ 
            e.preventDefault();
          
            let formData=new FormData($('#add_form')[0]);
         
            $.ajax({
               type:'POST',
               url:'/committee/year_insert',
               data:formData,
               contentType: false,
               processData:false,
               beforeSend : function()
                 {
                 $('.loader').show();
                 $("#add_btn").prop('disabled', true)
                 },
               success:function(response){
                //console.log(response);
               if(response.status == 400){
                     $('.err_phone').text(response.validate_err.phone);
                     $('.err_dureg').text(response.validate_err.dureg);
                   }else if(response.status == 500){
                    Swal.fire("Du reg  already exist ", "Please try again", "warning");
                   }else{
                      //console.log(response.message);
                      $('#add_form_errlist').html("");
                      $('#add_form_errlist').addClass('d-none');
                      $('#success_message').html("");
                      $('#success_message').addClass('alert alert-success');
                      $('#success_message').text(response.message)
                      $('#AddModal').modal('hide');
                      $("#add_form")[0].reset();
                      $('.err_phone').text('');
                      $('.err_dureg').text('');
                      fetch();
                   }  
                   $('.loader').hide();
                   $("#add_btn").prop('disabled', false)
               }
  
              });
          });  
  
  
  
          function fetch_data(page, sort_type = "", sort_by = "", search = "") {
            $.ajax({
                url: "/committee/year/fetch_data/" + committeeunit_id + "?page=" + page + "&sortby=" + sort_by + "&sorttype=" + sort_type + "&search=" + search,
                success: function(data) {
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
             var search = $('#serach').val();
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
             var search = $('#serach').val();
            fetch_data(page, reverse_order, column_name, search);
            });
  });  