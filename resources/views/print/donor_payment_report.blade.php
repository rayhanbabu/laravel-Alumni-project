<!DOCTYPE html>
<html>

<head>
  <script>
    function printContent(e1) {
       var restorepage = document.body.innerHTML;
       var printcontent = document.getElementById(e1).innerHTML;
       document.body.innerHTML = printcontent;
      window.print();
      document.body.innerHTML = restorepage;
    }
  </script>
  <title> </title>

  <style>
   
   @media print {
    @page {
      margin: 0;
    }

    body {
      margin: 1.6cm;
    }
  }

    table,
    td,
    th {
      border: 2px solid #acacac;

    }

    table {
      border-collapse: collapse;
    }

    th,
    td {
      padding: 2px;
      font-size: 14px;
    }

    .area {

      width: 700px;
    }

    .btn {
      border: none;
      color: white;
      padding: 14px 28px;
      font-size: 14px;
      cursor: pointer;
    }

    .success {
      background-color: #4CAF50;
    }

    /* Green */
    .success:hover {
      background-color: #46a049;
    }
  </style>

</head>

<body>
  <center>
    <br>
    <button class="btn success" onclick="printContent('div1')" >Print </button>
    <div id="div1">

      <div class="area">
     
       <h5>{{$admin->nameen}}<br>
            {{$admin->address}}<br>
            Payment Summary : {{$date1}} To {{$date2}}<br>Payment Type : {{$payment_type}}</h5>
        
           <h4> Total Payment[{{$date1}} To {{$date2}}] : {{ $donor_invoice->sum('amount')}}TK</h4>
         
</table>

 <br>

<b> Donor Member Payment History </b>
<table>

    <tr>
        <th align="left" width="40">Serial No</th>
        <th align="left" width="40">Invoice ID</th>
	      <th align="left" width="140">Name</th>
        <th align="left" width="50">Amount(TK)</th>
        <th align="left" width="70">Payment date</th>
        <th align="left" width="60">Payment Type</th>
    </tr>
  
  @foreach($donor_invoice as $row)
     <tr>
	      <td align="left" >{{ $row->id}}</td>
		    <td align="left" >{{$row->tran_id}}</td>
	      <td align="left">{{ $row->name }} </td> 
        <td align="right">{{ $row->amount }} </td> 
        <td align="right">{{ $row->payment_date }}</td> 
        <td align="right">{{ $row->payment_method }} </td> 
     </tr>
  @endforeach

  <tr>
	      <td align="left" colspan="4"> Total Invoice : {{$donor_invoice->count()}}</td>
        <td align="left" colspan="3"> Total Amount : {{$donor_invoice->sum('amount')}}TK</td>  
     </tr>
</table>






      </div>
    </div>
    <br>

  </center>



</body>

</html>