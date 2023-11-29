
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Amaderthikana</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<style>

</style>

<body>

<div class="container mt-4">
<div class="row">
  <div class="col-sm-6 p-3 shadow"> 
             <p class="text-end"><a class="btn btn-primary" href="{{url($web_link.'dashbord')}}" role="button">Back</a>  </p>     
    <div class="card">
         <div class="card-body">
   
         <h3>Pay Now</h3>
         <p class="text-center">
         <div>
         <input type="checkbox" id="myCheck" onclick="myFunction()">
                  <label for="required">I Agree  <a href="https://amaderthikana.com/policy">Privacy Policy</a> & 
                    <a href="https://amaderthikana.com/term"> Terms and Conditions</a>  </label>
          </div><br>
          <div id="text" style="display:none" >
               <a href="{{url('amarpay_payment/'.$tran_id)}}" role="button"> 
                   <img src="{{ asset('images/amarpay.png') }}" alt="" >  
               </a>
          </div>
        
       </p>
    
       </div>
      </div>

    </div>
    </div>
 </div>


 <script>
function myFunction() {
  var checkBox = document.getElementById("myCheck");
  var text = document.getElementById("text");
  if (checkBox.checked == true){
    text.style.display = "block";
  } else {
     text.style.display = "none";
  }
}
</script>
  
  

</body>
</html>