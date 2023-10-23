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
<h2>Admin List of ANCOVA</h2>
<h4>University Of Dhaka</h4>
<h4>Invoice {{$title}} </h4>
</center>

<table>
  <tr>
    <th align="left" width="70">name</th>
	<th align="left" width="60">Mobile</th>
    <th align="left" width="160">email</th>
    <th align="left" width="80">username</th>
    <th align="right" width="100">role </th>
	
  </tr>
  
  @foreach($admin as $row)
    <tr>
	    <td align="left" >{{ $row->name}}</td>
		<td align="left" >{{ $row->mobile}}</td>
	    <td align="right">{{ $row->email }} </td>
	    <td align="right">{{ $row->admin_name }} </td>
        <td align="right">{{ $row->role}}</td>
 </tr>
  @endforeach

  <tr>
    <td colspan="3">Total Invoice: </td>
    <td colspan="2"  align="right">Payment:TK</td>
  </tr>
  
  
</table>

</body>
</html>


