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
  padding:3px;
  font-size:14px;
}
</style>
</head>
<body>

  <center>
        <h3>{{$admin->nameen}}</h3>
        <h5>{{$admin->address}}</h5>
        <h5> Payment Summary : {{$date1}} To {{$date2}} <br>Payment Type : {{$payment_type}}</h5>
</center>

<table>

    <tr>
        <th align="left" width="50">Member card</th>
        <th align="left" width="50">Invoice ID</th>
	      <th align="left" width="170">Name</th>
        <th align="left" width="80">Payment Category</th>
        <th align="left" width="70">Amount</th>
        <th align="left" width="70">Payment Type</th>
    </tr>
  
  @foreach($invoice as $row)
     <tr>
	      <td align="left" >{{ $row->member_card}}</td>
		    <td align="left" >{{$row->tran_id}}</td>
	      <td align="left">{{ $row->name }} </td>
	      <td align="left">{{ $row->category }} </td>   
        <td align="right">{{ $row->amount }}TK </td> 
        <td align="right">{{ $row->payment_method }} </td> 
     </tr>
  @endforeach

  <tr>
	      <td align="left" colspan="3"> Total Invoice : {{$invoice->count()}}</td>
        <td align="left" colspan="3"> Total Amount : {{$invoice->sum('amount')}}TK</td>  
     </tr>
</table>

</body>
</html>


