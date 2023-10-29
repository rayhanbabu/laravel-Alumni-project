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
       <h5> Category : {{$category_name->category}} {{$monthyear}} </h5>
</center>

<table>

    <tr>
        <th align="left" width="90">Member card</th>
        <th align="left" width="90">Invoice ID</th>
	      <th align="left" width="190">Name</th>
        <th align="left" width="70">Signature</th>
    </tr>
  
  @foreach($invoice as $row)
     <tr>
	      <td align="left" >{{ $row->member_card}}</td>
		    <td align="left" >{{$row->id}}</td>
	      <td align="left">{{ $row->name }} </td>
	      <td align="right">{{ $row->Signature }} </td>   
     </tr>
  @endforeach

  <tr>
	      <td align="left" colspan="2"> Total Member : {{$invoice->count()}}</td>
        <td align="left" colspan="2"> Total Amount : {{$invoice->sum('amount')}}TK</td>  
     </tr>
</table>

</body>
</html>


