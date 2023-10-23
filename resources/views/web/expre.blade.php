@extends('web/webheader')
@section('page_title','Ex President::'.$admin->nameen)
@section('expre','active')
@section('content')

<div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <h5 class="section-title bg-white text-center text-primary px-3">সভাপতিবৃন্দ </h5>
            </div>
            <div class="row g-4">
	  
     <div class="table-responsive" data-wow-delay="0.1s">      
	  <table class="table table-bordered table-hover " >
        <thead>
             <tr>
                    <th width="40%">নাম</th>
				   <th width="25%">  হতে  </th>
                    <th width="25%">  পযর্ন্ত     </th>		  
            </tr>
       </thead>
     <tbody>
     @foreach($data1 as $row)
	  <tr>	
		<td>{!!$row->name!!} </td>
		<td> <?php echo date('d-M-Y',strtotime($row['date1'])); ?></td>
		<td> <?php echo date('d-M-Y',strtotime($row['date2'])); ?></td>			 
	</tr>
    @endforeach
    </tbody>
  </table>
  </div>
  
    </div>
	</div>
	 </div>



     <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <h5 class="section-title bg-white text-center text-primary px-3">সাধারণ সম্পাদক বৃন্দ</h5>
            </div>
            <div class="row g-4">
	  
     <div class="table-responsive" data-wow-delay="0.1s">      
	  <table class="table table-bordered table-hover " >
        <thead>
             <tr>
                    <th width="40%">নাম</th>
				   <th width="25%">  হতে  </th>
                    <th width="25%">  পযর্ন্ত     </th>		  
            </tr>
       </thead>
     <tbody>
     @foreach($data2 as $row)
	  <tr>	
		<td>{!!$row->name!!} </td>
		<td> <?php echo date('d-M-Y',strtotime($row['date1'])); ?></td>
		<td> <?php echo date('d-M-Y',strtotime($row['date2'])); ?></td>			 
	</tr>
    @endforeach
    </tbody>
  </table>
  </div>
  
    </div>
	</div>
	 </div>



 
 
    

 @endsection