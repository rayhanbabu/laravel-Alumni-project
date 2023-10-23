<!DOCTYPE html>
<html lang="en">
<head>
  <title>amderthikana.com</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <link rel="stylesheet" href="{{asset('webfront/css/solaiman.css')}}" rel="stylesheet">

  <style>
        #fixedmyBtn {
  position: fixed;
  bottom:60px;
  right: 15px;
  z-index: 99;
  font-size: 15px;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 10px;
  border-radius: 4px;
}


  </style>
</head>
<body>

    <a href="{{url('/web/contact')}}" class="btn btn-sm btn-primary rounded-pill" id="fixedmyBtn">Contact Us</a>

<div class="container mt-5">
     <h2 class="text-center mb-3">amderthikana.com এ আপনাকে স্বাগতম</h2>
        <h4 class="text-center">আপনার সংগঠনের নামে অনুসন্ধান করুন   অথবা 
                    <a href="{{url('/web/reg')}}"class="btn btn-primary end my-2" >ফ্রিতে রেজিস্ট্রেশন করুন<a>  
                  </h4>


       
          <div class="row ">
              <div class="col-md-3 "></div>
               <div class="col-md-5 my-3"> 
                 <input type="text" name="search" id="search" class="form-control" id="trolInput1" placeholder="অনুসন্ধান করুন">
               </div>
                 <div class="col-md-4 my-3">
                    
                  </div>
           </div>


         <div class="row " id="show_all_employees">

            
           </div>

 
 
  <script>  
   $(document).ready(function(){

    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} });
    
    $(document).on('keyup', '#search', function(){
        var search = $('#search').val();
        $.ajax({
        url:"/web/fetch_data?search="+search,
        success:function(response)
        {
          $("#show_all_employees").html(response);
        }
        });
        
      });



   });

 </script>
  
  
  

</body>
</html>