<!DOCTYPE html>
<html>
<head>
<style>

table, td, th{  
      border:1px solid black;
		 	border-collapse:collapse;     
}

table {
  border-collapse: collapse;
  *width: 100%;
}

th, td {
  padding:3px;
  font-size:15px;
}
</style>
</head>
<body>



<center>
<h2>Ancova School Management Software </h2>
<h4>Invoice Summary</h4>

   <p> Invoice Month : <?php echo date('F-Y',strtotime($monthyear)); ?> , Status : @if($status==1) Paid @else Not Paid @endif</p>
  
</center>

<table>
   <tr>
        <th align="left" width="60">Adnim Name </th>
        <th align="left" width="180">School</th>
        <th align="left" width="65">Phone</th>
        <th align="left" width="65">Invoice date</th>
        <th align="left" width="70">Payment Date</th>
        <th align="left" width="50">Amount</th>
	      <th align="left" width="55">Payment Type</th>
   </tr>
  
   @foreach($invoice as $row)
    <tr>
         <td align="left" >{{$row->admin_name}}</td>
         <td align="left" >{{admininfo($row->admin_name,'nameen')}}</td>
         <td align="left" >{{admininfo($row->admin_name,'mobile')}}</td>
         <td align="left" >{{$row->created_date}}</td>
		   <td align="left" >{{$row->payment_date}}</td>
         <td align="left" >{{$row->payment}}</td>
         <td align="right"> {{$row->payment_type}}</td>
		    
 </tr>
  @endforeach

   <tr>
      <td colspan="4"> Total Amount</td>
      <td colspan="3">{{$invoice->sum('payment')}}TK</td>
   </tr>


 
  
  
</table>

</body>
</html>


