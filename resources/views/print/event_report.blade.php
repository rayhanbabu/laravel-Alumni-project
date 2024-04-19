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
     
        <h5> {{$admin->nameen}}<br>
            {{$admin->address}}<br>
           Event Report Summary </h5>
        

        <b> Member List of current Event</b>
<table>

    <tr>
        <th align="left" width="40">Membership</th>
        <th align="left" width="40">Serial No</th>
	      <th align="left" width="140">Name</th>
        <th align="left" width="70">Event Type</th>
        <th align="left" width="60">Signature </th>
    </tr>
  
  @foreach($event_category as $item)

      @php
      $event_member=event_atten_number($item->admin_name,$item->id);
      @endphp
    
     @foreach($event_member as $row)
        <tr>
	          <td align="left" > {{$row->member_card}}</td>
            <td align="left" > {{$row->serial}}</td>
            <td align="left" > {{$row->name}}</td>
            <td align="left" >{{$row->category}} </td>
            <td align="left" > </td>
        </tr>  
        @endforeach
     
  @endforeach
</table>

 <br>


   
 <b> Non-Member List of current Event</b>
<table>

    <tr>
        <th align="left" width="40">Membership</th>
        <th align="left" width="40">Serial No</th>
	      <th align="left" width="140">Name</th>
        <th align="left" width="70">Event Type</th>
        <th align="left" width="60">Signature </th>
    </tr>
  
  @foreach($event_category as $item)

      @php
      $event_non_member=non_event_atten_number($item->admin_name,$item->id);
      @endphp
    
     @foreach($event_non_member as $row)
        <tr>
	          <td align="left" > </td>
            <td align="left" > {{$row->id}}</td>
            <td align="left" > {{$row->name}}</td>
            <td align="left" >{{$row->category}} </td>
            <td align="left" > </td>
        </tr>  
        @endforeach
     
  @endforeach
</table>







      </div>
    </div>
    <br>

  </center>



</body>

</html>