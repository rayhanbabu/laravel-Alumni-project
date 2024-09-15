<!DOCTYPE html>
<html>
<head>
<style>

 table, td, th{  
   border: 1px solid #acacac;
    *text-align: left;
 }

 table {
   border-collapse: collapse;
   *width: 100%;
 }

th, td {
  padding:1px;
  font-size:13px;
}
</style>
</head>
<body>

        <h3>{{$file}}</h3>
          <h5> 
           
            {{$admin_mobile}}<br>
            {{$admin_email}}
         </h5>   


           
        </h5>
     




       <h5>To<br>
             {{$name}}<br>
             {{$phone}} <br>
             {{$email}} <br>
             {{$address}}<br>
              @if($registration)
                  Registration : {{$registration}}<br>
              @endif
              @if($department)
                  Department : {{$department}}<br>
              @endif
            
            Invoice Id: {{$tran_id}}
         
        </h5>
           <center> 
               <h4> Payment Invoice Summary </h4>
           </center>
       
<table>

     <tr>
          <th align="left" width="50"> Serial</th>
          <th align="left" width="200"> Description</th>
          <th align="left" width="90"> Payment Method</th>
          <th align="left" width="90"> Payment Time</th>
	        <th align="left" width="80">Total Amount (Including Service Charge 4%) </th>
        
     </tr>

     <tr>
         <th align="left">1 </th>
         <th align="left"> {{$category}} </th>
         <th align="left">  {{$payment_method}}</th>
         <th align="left">  {{$payment_time}} </th>
         <th align="right"> {{$total_amount}}TK</th>
     </tr>

     <tr>
          <th align="left"> 2 </th>
          <th align="left">  </th>
          <th align="left">  </th>
          <th align="left">  </th>
          <th align="right">  </th>
     </tr>

     <tr>
          <th align="right" colspan="4">Total Received Amount </th>
          <th align="right"> {{$total_amount}}TK</th>
     </tr>
  
</table>


 

</body>
</html>


