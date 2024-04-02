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
        <h3>{{$admin}}</h3>
        <h5>{{$admin}}</h5>
        <h5> Payment Summary : </h5>
</center>


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
  


  <tr>
	      <td align="left" colspan="4"> Total Invoice : </td>
        <td align="left" colspan="3"> Total Amount : TK</td>  
     </tr>
</table>


 

</body>
</html>


