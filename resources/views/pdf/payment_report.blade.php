<!DOCTYPE html>
<html>
<head>
<style>

table,td,th{  
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

  <center>
        <h3>{{$admin->nameen}}</h3>
        <h5>{{$admin->address}}</h5>
        <h5> Payment Summary : {{$date1}} To {{$date2}} <br>Payment Type : {{$payment_type}}</h5>
</center>

<h4> Total Payment {{$date1}} To {{$date2}} : {{ $invoice->sum('amount')}}</h4>
<h4> Member Payment History</h4>
<table>

    <tr>
        <th align="left" width="40">Membership</th>
        <th align="left" width="40">Invoice ID</th>
	      <th align="left" width="140">Name</th>
        <th align="left" width="80">Payment Category</th>
        <th align="left" width="50">Amount</th>
        <th align="left" width="70">Payment date</th>
        <th align="left" width="60">Payment Type</th>
    </tr>
  
  @foreach($invoice as $row)
     <tr>
	      <td align="left" >{{ $row->member_card}}</td>
		    <td align="left" >{{$row->tran_id}}</td>
	      <td align="left">{{ $row->name }} </td>
	      <td align="left">{{ $row->category }} </td>   
        <td align="right">{{ $row->amount }}TK </td> 
        <td align="right">{{ $row->payment_date }}</td> 
        <td align="right">{{ $row->payment_method }} </td> 
     </tr>
  @endforeach

  <tr>
	      <td align="left" colspan="4"> Total Invoice : {{$invoice->count()}}</td>
        <td align="left" colspan="3"> Total Amount : {{$invoice->sum('amount')}}TK</td>  
     </tr>
</table>


 <h4>Non Member Payment History</h4>
<table>

    <tr>
        <th align="left" width="40">Serial No</th>
        <th align="left" width="40">Invoice ID</th>
	      <th align="left" width="140">Name</th>
        <th align="left" width="80">Payment Category</th>
        <th align="left" width="50">Amount</th>
        <th align="left" width="70">Payment date</th>
        <th align="left" width="60">Payment Type</th>
    </tr>
  
  @foreach($non_invoice as $row)
     <tr>
	      <td align="left" >{{ $row->id}}</td>
		    <td align="left" >{{$row->tran_id}}</td>
	      <td align="left">{{ $row->name }} </td>
	      <td align="left">{{ $row->category }} </td>   
        <td align="right">{{ $row->amount }}TK </td> 
        <td align="right">{{ $row->payment_date }}</td> 
        <td align="right">{{ $row->payment_method }} </td> 
     </tr>
  @endforeach

  <tr>
	      <td align="left" colspan="4"> Total Invoice : {{$non_invoice->count()}}</td>
        <td align="left" colspan="3"> Total Amount : {{$non_invoice->sum('amount')}}TK</td>  
     </tr>
</table>

</body>
</html>


