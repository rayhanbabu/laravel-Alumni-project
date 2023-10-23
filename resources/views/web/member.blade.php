@extends('web/webheader')
@section('page_title',$member.'::'.$admin->nameen)
@section($member,'active')
@section('content')

<style>
	  .team-social2{
          width: 100%;
          height: 100%;
          top: 65px;
          left: 0;
          display: flex;
          align-items: center;
          justify-content: center;
          background: #FFFFFF;
          transition: .5s;
		  padding:10px;
	       }
		   
		   .rounded-circle{
		      margin:5px;  
		   }
	</style>


@if($member=='Executive' OR $member=='General' OR $member=='Advisor' Or $member=='Senior')
    <!-- Team Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <h5 class="section-title bg-white text-center text-primary px-3"> @if($member=='Advisor')
                                                                                  উপদেষ্টামন্ডলী 
                                                                                @elseif($member=='Executive')
                                                                                    কার্যনির্বাহী কমিটি
                                                                                @elseif($member=='Senior')
                                                                                      সিনিয়র সদস্য
                                                                                @elseif($member=='General')
                                                                                     সাধারণ সদস্য
                                                                                 @endif
                                                                </h5>
            </div>
            <div class="row g-4">


            @foreach($data as $row)
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="team-item text-center p-4">
                    @if(empty($row->image))
                        <img class="img-fluid border rounded-circle w-75 p-2 mb-4" src="{{asset('images/default.png')}}" alt="">
                    @else 
                        <img class="img-fluid border rounded-circle w-75 p-2 mb-4" src="{{ asset('uploads/admin/'.$row->image)}}" alt="">
                    @endif
                        
                        
                           
                                <h6>{{$row->name}}</h6>
                                <span>{{$row->text1}}</span>
                         
                            <div class="team-social2">
                                @if(empty($row->fb_link))
                                   <a class="btn btn-square btn-primary rounded-circle" href="#"><i class="fab fa-facebook-f"></i></a>
                                @else
                                   <a target="_blank" class="btn btn-square btn-primary rounded-circle" href="{{$row->fb_link}}"><i class="fab fa-facebook-f"></i></a>
                                @endif
                                <a class="btn btn-square btn-primary rounded-circle viewmember" id="{{$row->id}}" href="#"><i class="far fa-eye"></i></a>
                                <a class="btn btn-square btn-primary rounded-circle" href="#"><i class="fab fa-instagram"></i></a>
                            </div>
                       
                    </div>
                </div>
           @endforeach
               

            </div>
        </div>
    </div>


    {{-- add new employee modal start --}}
<div class="modal fade" id="viewEmployeeModal" tabindex="-1" aria-labelledby="exampleModalLabel"
   aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><span id="edit_category"></span> Member</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form  method="POST" id="add_employee_form" enctype="multipart/form-data">
          <div class="modal-body p-4 bg-light">
         
             <div class="mt-2" id="avatar">

                 </div>
          <table class="table table-bordered table-hover">
    <tbody>
      <tr>
          <td width="30%">নাম</td>
            <td width="70%"> <span id="edit_name"></span></td>
      </tr>

       <tr>
           <td> কর্মস্থল / শিক্ষা প্রতিষ্ঠান  </td>
           <td width="70%"> <span id="edit_workplace"></span></td>
      </tr>

      <tr>
        <td> বর্তমান ঠিকানা </td>
        <td width="70%"> <span id="edit_current_address"></span></td>
      </tr>

      <tr>
        <td> স্থায়ী  ঠিকানা </td>
        <td width="70%"> <span id="edit_permanent_address"></span></td>
      </tr>
	
      <tr>
           <td> ব্লাড গ্রুপ   </td>
           <td width="70%"> <span id="edit_blood"></span></td>
      </tr>
	  
	  <tr>
           <td> ফোন নাম্বার   </td>
           <td width="70%"> <span id="edit_phone"></span></td>
      </tr>
	  
	  <tr>
        <td> ই-মেইল </td>
        <td width="70%"> <span id="edit_email"></span></td>
      </tr>
	  
	
	  
    </tbody>
  </table>
                  


          </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
       
        </div>
      </form>
    </div>
  </div>
</div>

{{-- add new employee modal end --}}
 
@else
    <h1>Page not Found</h1>
   @endif

 @endsection