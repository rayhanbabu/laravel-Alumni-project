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
      font-size: 16px;
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
     
          <h5>  {{$admin->nameen}}  <br>
                {{$admin->address}} <br>
                Category: @if($category=="batch_id") Batch @elseif($category=="profession_id") Profession @elseif($category=="session_id") Session @endif </h5>
          <b>  </b>
<table>
    <tr>
        <th align="left" width="240"> Name</th>
	      <th align="left" width="80"> Number</th>
      
    </tr>

         @foreach($data as $row)
           <tr>
	            <td align="left" > {{show_category($row->$category)}}</td>
              <td align="left" > {{$row->id}}</td>  
           </tr>  
         @endforeach
         <tr>
	          <td align="left" colspan="1"> Total Member :</td>
            <td align="left" colspan="1"> {{$data->sum('id')}} </td>  
        </tr>
  </table>

      </div>
    </div>
    <br>

  </center>



</body>

</html>