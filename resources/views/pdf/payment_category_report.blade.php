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

  <center>
        <h3>{{$admin->nameen}}</h3>
       <h5>{{$admin->address}}</h5>
       <h5> Category : {{$category_name->category}} , Payment Type : {{$payment_type}}  </h5>
</center>


<h4> Member Payment History</h4>
<table>
    <tr>
        <th align="left" width="50">Member Ship</th>
        <th align="left" width="50">Invoice ID</th>
	      <th align="left" width="190">Name</th>
        <th align="left" width="60">Amount</th>
        <th align="left" width="80">Date</th>
        <th align="left" width="70">Payment method</th>
    </tr>
  
  @foreach($invoice as $row)
     <tr>
	      <td align="left" >{{ $row->member_card}}</td>
		    <td align="left" >{{$row->tran_id}}</td>
	      <td align="left">{{ $row->name }} </td>
        <td align="left">{{ $row->amount }}TK </td>
        <td align="left">{{ $row->payment_date }} </td>
	      <td align="right"> {{ $row->payment_method }}</td>   
     </tr>
  @endforeach

  <tr>
	      <td align="left" colspan="3"> Total Member : {{$invoice->count()}}</td>
        <td align="left" colspan="3"> Total Amount : {{$invoice->sum('amount')}}TK</td>  
     </tr>
</table>


<h4>Non Member Payment History</h4>
<table>
    <tr>
        <th align="left" width="50">Member Ship</th>
        <th align="left" width="50">Invoice ID</th>
	      <th align="left" width="190">Name</th>
        <th align="left" width="60">Amount</th>
        <th align="left" width="80">Date</th>
        <th align="left" width="70">Payment method</th>
    </tr>
  
  @foreach($non_invoice as $row)
     <tr>
	       <td align="left" > {{$row->id}}</td>
		     <td align="left" > {{$row->tran_id}}</td>
	       <td align="left"> {{ $row->name }} </td>
         <td align="left"> {{ $row->amount }}TK </td>
         <td align="left"> {{ $row->payment_date }} </td>
	       <td align="right"> {{ $row->payment_method }}</td>   
      </tr>
    @endforeach

     <tr>
	        <td align="left" colspan="3"> Total Member : {{$non_invoice->count()}}</td>
          <td align="left" colspan="3"> Total Amount : {{$non_invoice->sum('amount')}}TK</td>  
      </tr>
</table>


</body>
</html>


