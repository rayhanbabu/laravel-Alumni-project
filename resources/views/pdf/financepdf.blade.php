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
  font-size:17px;
}
</style>
</head>
<body>

  <center>
        <h2>{{$admin->nameen}}</h2>
       <h4>{{$admin->address}}</h4>
       <h4>Finance Type : {{$cetagory}} </h4>
</center>
<br>
<table>

    <tr>
        <th align="left" width="90">Date</th>
	      <th align="left" width="100">Name</th>
        <th align="left" width="180">Description</th>
        <th align="left" width="70">Amount</th>
    </tr>
  
  @foreach($data as $row)
     <tr>
	      <td align="left" >{{ $row->date}}</td>
		    <td align="left" >{{$row->name}}</td>
	      <td align="left">{{ $row->des }} </td>
	      <td align="right">{{ $row->amount }} </td>   
     </tr>
  @endforeach

 
</table>

</body>
</html>


