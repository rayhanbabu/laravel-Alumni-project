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
            Member Information: {{$batch_category?$batch_category->category:""}} {{$profession_category?$profession_category->category:""}}</h5>
        

        <b>  </b>
<table>
    <tr>
        <th align="left" width="40"> Membership</th>
	      <th align="left" width="220"> Name</th>
        <th align="left" width="120"> Phone</th>
        <th align="left" width="90"> Email </th>
        <th align="left" width="90"> Organization </th>
        <th align="left" width="90"> Address </th>
    </tr>

     @foreach($data as $row)
        <tr>
	          <td align="left" > {{$row->member_card}}</td>
            <td align="left" > {{$row->name}}</td>
            <td align="left" > {{$row->phone}}</td>
            <td align="left" > {{$row->email}}</td>
            <td align="left" > {{$row->organization}}</td>
            <td align="left" > {{$row->village}}</td>
        </tr>  
        @endforeach
        <tr>
	         <td align="left" colspan="4"> Total Member : {{$data->count()}}</td>
           <td align="left" colspan="2"></td>  
     </tr>
</table>

      </div>
    </div>
    <br>

  </center>



</body>

</html>