<!DOCTYPE html>
<html>
<head>
<style>

body {
	font-family: 'kalpurush', Georgia;
     }

table, td, th{  
      border:1px solid black;
		 	border-collapse:collapse;
   }

   

  table {
    border-collapse: collapse;
    *width: 100%;
  }

th, td {
  padding:4px;
  font-size:17px;
}
 .topheader{
   text-align:right;
   font-size:20px;
   padding:1px;
 }

 .midheader{
   font-size:19px;
   padding:10px;
 }

 .rayhan {
       position: absolute;
       left:50px;
       top:250px;
       z-index: -1;
       opacity: .1;
     }	 
     
</style>
</head>
<body>
    
    
  <div class="rayhan">
<img src="{{ public_path('/uploads/admin/'.$logu->image) }}" style=" width:600px; height:600px; "/>
</div>



          <br>
        <p class="topheader"> 
            {{$admin->nameen}}   <br>
            {{$admin->address}}  <br>
            {{$admin->mobile}}  <br>
            {{$admin->email}}  <br>
            {{$admin->text2}}  
        </p>

        <p class="midheader">
           Invoice Id :<b> {{ $data->id }} </b> <br>
           Donor/Sponsor :<b> {{ $data->name }} </b> <br>
           Phone/E-mail : <b> {{ $data->phone }}  </b> <br>
         
         
        </p>
     
         <h2 align="center"> Payment Order Summary </h2>
     

    <table align="center">
      <tr hight="30" >
          <th align="left" width="100">Invoice Date</th>
          <th align="left" width="190">Description</th>
           <th align="left" width="100">Payment Method</th>
	         <th align="right" width="60">Amount</th>
     </tr>
   
  
      <tr height="30">
           <td> {{$data->date}} </td>
           <td> {{$data->des}} </td>
            <td> {{$data->email}} </td>
           <td align="right"> {{$data->amount}}TK</td>
       </tr>


      <tr  height="30">
          <td> </td>
          <td> Total Amount </td>
            <td> </td>
          <td align="right">{{$data->amount}}TK</td>
      </tr>
     
  
</table>
   <br>
   
   <br>
     <p>{!!$admin->text1!!}</p>
      <br>
      Best Regards,
       <br> <br>   <br><br>

 <div style="display:block; width:100%;">
      <div style="width:50%; float: left; display: inline-block; text-align:center; font-size:16px;">President/General Secretary<br>{{$admin->nameen}} </div>
      <div style="width:50%; float: left; display: inline-block; text-align:center; font-size:16px;">Treasurer<br>{{$admin->nameen}}</div>
 </div>



</body>
</html>


