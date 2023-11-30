@extends('maintain/dashboardheader')
@section('page_title','Admin View')
@section('admin_select','active')
@section('content')

<div class="row mt-4 mb-3">
               <div class="col-3"> <h4 class="mt-0">Admin View</h4></div>
                     <div class="col-2">
                         <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                             <form action="{{url('maintain/adminpdf')}}" method="POST" enctype="multipart/form-data">
                                  {!! csrf_field() !!}
                                  <input type="hidden" name="invoice" class="form-control" value="invoice" required>
                                  <button type="submit" name="search" class="btn btn-primary">Admin pdf </button>
					                   </form>   
                         </div>
                     </div>

                     <div class="col-2">
                         <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                             <form action="{{url('generate-pdf')}}" method="POST" enctype="multipart/form-data">
                                  {!! csrf_field() !!}
                                  <input type="hidden" name="invoice" class="form-control" value="invoice" required>
                                  <button type="submit" name="search" class="btn btn-primary">Testing tpdf </button>
					                   </form>   
                         </div>
                     </div>

                     <div class="col-2">
                         <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                             <form action="{{url('generate-fpdf')}}" method="POST" enctype="multipart/form-data">
                                  {!! csrf_field() !!}
                                  <input type="hidden" name="invoice" class="form-control" value="invoice" required>
                                  <button type="submit" name="search" class="btn btn-primary">Testing fpdf </button>
					                   </form>   
                         </div>
                     </div>

                     <div class="col-3">
                         <div class="d-grid gap-2 d-md-flex ">
                         <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                           Add
                        </button>
                             
                         </div>
                     </div> 
             </div>  
             
   @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div>
  @endif

                     <div class="form-group  mx-2 my-2">
                           @if(Session::has('fail'))
                   <div  class="alert alert-danger"> {{Session::get('fail')}}</div>
                                @endif
                             </div>

                             <div class="form-group  mx-2 my-2">
                           @if(Session::has('success'))
                   <div  class="alert alert-success"> {{Session::get('success')}}</div>
                                @endif
                             </div>

             
             
 <div class="card-block table-border-style">                     
 <div class="table-responsive">
 <table class="table table-bordered" id="employee_data">
    <thead>
      <tr>
         <th width="10%" >Name bangla </th>
         <th width="10%" >Name English </th>
         <th width="10%" >Address </th>
         <th width="10%" >Created, Subscrible, Duration, Expired </th>
         <th width="15%" >version type, Payment</th>
         <th width="15%" >E-mail</th>
	   <th width="15%" >Mobile </th>
         <th width="15%" >Getway Fee </th>
	   <th width="15%" >Username</th>
         <th width="15%" >Password</th>
         <th width="5%" >Email verify</th>
         <th width="5%" >Status</th>
         <th width="5%" >Edit</th>
         <th width="5%" >Delete</th>
      </tr>
  </thead>
  <tbody>

	@foreach($admin as $item)
	 <tr>
        <td>{{$item->name}}</span></td>
        <td>{{$item->nameen}}</span></td>
        <td>{{$item->address}}</span></td>
        <td>{{$item->created_date}}, {{$item->subscribe}}, {{$item->payment_duration}}, {{$item->expired_date}} </td>
        <td>{{$item->version_type}}, {{$item->payment}}</td>
        <td>{{$item->email}}</td>
        <td>{{$item->mobile}}</td>
        <td>{{$item->getway_fee}}</td>
        <td>{{$item->admin_name}}</td>
        <td>{{$item->admin_password}}</td>
       
   <td>
     @if($item->email_verify == 1)         
        <a href="{{ url('maintain/adminlist/email_verify/deactive/'.$item->id) }}" class="btn btn-success btn-sm" >Active<a>     
        @else
        <a href="{{ url('maintain/adminlist/email_verify/active/'.$item->id) }}" class="btn btn-danger btn-sm" >Deactive<a>       
        @endif
   </td>

   <td>
   @if($item->status == 1)         
        <a href="{{ url('maintain/adminlist/status/deactive/'.$item->id) }}" class="btn btn-success btn-sm" >Active<a>     
        @else
        <a href="{{ url('maintain/adminlist/status/active/'.$item->id) }}" class="btn btn-danger btn-sm" >Deactive<a>       
        @endif
   </td>

    <td>
      <button type="button" name="edit" id="{{$item->id}}" class="btn btn-success btn-sm edit" 
	  	 data-name="{{$item->name}}" data-email="{{$item->email}}" data-admin_name="{{$item->admin_name}}"
       data-admin_password="{{$item->admin_password}}" data-role="{{$item->role}}" data-mobile="{{$item->mobile}}"
       data-nameen="{{$item->nameen}}" data-address="{{$item->address}}" data-payment="{{$item->payment}}"
       data-magazine_size="{{$item->magazine_size}}" data-member_size="{{$item->member_size}}"
       data-advisor_size="{{$item->advisor_size}}"  data-blood_size="{{$item->blood_size}}"
       data-header_size="{{$item->header_size}}"  data-fb_link="{{$item->fb_link}}"
       data-youtube_link="{{$item->youtube_link}}" data-other_link="{{$item->other_link}}"
       data-text1="{{$item->text1}}"  data-text2="{{$item->text2}}"  data-text3="{{$item->text3}}"
       data-text4="{{$item->text4}}" data-version_type="{{$item->version_type}}"
       data-resheader_size="{{$item->resheader_size}}"  data-executive_size="{{$item->executive_size}}"
       data-senior_size="{{$item->senior_size}}" data-general_size="{{$item->general_size}}" data-notice_size="{{$item->notice_size}}"
       data-welcome_size="{{$item->welcome_size}}"data-testimonial_size="{{$item->testimonial_size}}" 
       data-bank_name="{{$item->bank_name}}" data-bank_account="{{$item->bank_account}}" data-bank_route="{{$item->bank_route}}"
       data-slide_size="{{$item->slide_size}}" data-getway_fee="{{$item->getway_fee}}" >Edit</button>
    </td>

        <td><a  class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to milloff  this month?')"  href="{{ url('maintain/admindelete/'.$item->id)}}">Delete</a></td>

	</tr>
    @endforeach	 
	</tbody>
  </table>
</div>
</div>


   <script>  
 $(document).ready(function(){  
      $('#employee_data').DataTable({
        "order": [[ 0, "desc" ]] ,
		"lengthMenu": [[20, 50, 100, -1], [20, 50, 100, "All"]]
      }
	  );  
 });  
 </script>  
	</div>
</div>


<script type="text/javascript">
           $(document).ready(function(){
                $(document).on('click','.edit',function(){
                   var id = $(this).attr("id");  
                   var name = $(this).data("name");
                   var nameen = $(this).data("nameen");
                   var address = $(this).data("address");
                   var payment = $(this).data("payment");
                   var email = $(this).data("email");
                   var mobile = $(this).data("mobile");
                   var role = $(this).data("role");
                   var admin_name = $(this).data("admin_name");
                   var admin_password = $(this).data("admin_password");
                   var magazine_size = $(this).data("magazine_size");
                   var header_size = $(this).data("header_size");
                   var resheader_size = $(this).data("resheader_size");
                   var member_size = $(this).data("member_size");
                   var blood_size = $(this).data("blood_size");
                   var advisor_size = $(this).data("advisor_size");
                   var fb_link = $(this).data("fb_link");
                   var youtube_link = $(this).data("youtube_link");
                   var other_link = $(this).data("other_link");
                   var text1 = $(this).data("text1");
                   var text2 = $(this).data("text2");
                   var text3 = $(this).data("text3");
                   var text4 = $(this).data("text4");
                   var version_type = $(this).data("version_type");
                   var executive_size = $(this).data("executive_size");
                   var senior_size = $(this).data("senior_size");
                   var general_size = $(this).data("general_size");
                   var notice_size = $(this).data("notice_size");
                   var welcome_size = $(this).data("welcome_size");
                   var testimonial_size = $(this).data("testimonial_size");
                   var slide_size = $(this).data("slide_size");
                   var getway_fee = $(this).data("getway_fee");
                   var bank_name = $(this).data("bank_name");
                   var bank_account = $(this).data("bank_account");
                   var bank_route = $(this).data("bank_route");
                     $('#edit_name').val(name);
                     $('#edit_nameen').val(nameen);
                     $('#edit_address').val(address);
                     $('#edit_id').val(id);
                     $('#edit_email').val(email);
                     $('#edit_mobile').val(mobile);
                     $('#edit_admin_name').val(admin_name);
                     $('#edit_admin_password').val(admin_password);
                     $('#edit_role').val(role);
                     $('#edit_address').val(address);
                     $('#edit_payment').val(payment);
                     $('#edit_magazine_size').val(magazine_size);
                     $('#edit_header_size').val(header_size);
                     $('#edit_resheader_size').val(resheader_size);
                     $('#edit_member_size').val(member_size);
                     $('#edit_advisor_size').val(advisor_size);
                     $('#edit_blood_size').val(blood_size);
                     $('#edit_fb_link').val(fb_link);
                     $('#edit_youtube_link').val(youtube_link);
                     $('#edit_other_link').val(other_link);
                     $('#edit_text1').val(text1);
                     $('#edit_text2').val(text2);
                     $('#edit_text3').val(text3);
                     $('#edit_text4').val(text4);
                     $('#edit_version_type').val(version_type);
                     $('#edit_executive_size').val(executive_size);
                     $('#edit_senior_size').val(senior_size);
                     $('#edit_general_size').val(general_size);
                     $('#edit_notice_size').val(notice_size);
                     $('#edit_welcome_size').val(welcome_size);
                     $('#edit_testimonial_size').val(testimonial_size);
                     $('#edit_slide_size').val(slide_size);
                     $('#edit_getway_fee').val(getway_fee);
                     $('#edit_bank_name').val(bank_name);
                     $('#edit_bank_account').val(bank_account);
                     $('#edit_bank_route').val(bank_route);
                     $('#updatemodal').modal('show');
                });

           });


</script>



<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Admin Add</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
      <form method="post" action="{{url('maintain/admininsert')}}"  class="myform"  enctype="multipart/form-data" >
   {!! csrf_field() !!}

           <input type="hidden" name="version_type" value="free" class="form-control" required>
         <div class="form-group  my-2">
               <label class=""><b>Organization Name(Bangla)</b></label>
               <input type="text" name="name" class="form-control" required>
          </div> 

           <div class="form-group  my-2">
               <label class=""><b>Organization Name(English)</b></label>
               <input type="text" name="nameen" class="form-control" required>
           </div> 

           <div class="form-group  my-2">
               <label class=""><b>Address(English)</b></label>
               <input type="text" name="address" class="form-control" required>
           </div> 
			  
			  
           <div class="form-group  my-2">
               <label class=""><b>E-mail</b></label>
               <input type="text" name="email"  class="form-control" required>
           </div> 

          <div class="form-group  my-2">
               <label class=""><b>Mobile(880)</b></label>
                 <input name="mobile" id="mobile" type="text" pattern="[1][3 7 6 5 8 9][0-9]{8}" title="
				            Please select Valid mobile number"  class="form-control" required />
          </div> 

          <div class="form-group  my-2">
               <label class=""><b>Username</b></label>
               <input type="text" name="admin_name" class="form-control" required>
          </div> 

           <div class="form-group  my-2">
               <label class=""><b>Password</b></label>
               <input type="text" name="admin_password" class="form-control" required>
           </div>

         

          
        <div class="form-group  mb-4">
        <label class=""><b>Role</b></label>
          <select class="form-select" name="role" aria-label="Default select example">
                 <option selected>Select One</option>
                 <option value="Admin">Admin</option>
           </select>
       </div>   

         
    <input type="submit"   id="insert" value="Submit" class="btn btn-success" />
	  
              
   </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>



<!-- Modal Edit -->
<div class="modal fade" id="updatemodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Admin Edit</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
      <form method="post" action="{{url('maintain/adminedit')}}"  class="myform"  enctype="multipart/form-data" >
         {!! csrf_field() !!}

         <input type="hidden" id="edit_id" name="id" class="form-control">

         <div class="row px-3">

         <div class="form-group col-sm-6  my-2">
               <label class=""><b>Organization Name(Bangla)</b></label>
               <input type="text" name="name" id="edit_name" class="form-control" required>
          </div> 

           <div class="form-group col-sm-6  my-2">
               <label class=""><b>Organization Name(English)</b></label>
               <input type="text" name="nameen" id="edit_nameen" class="form-control" required>
           </div> 

           <div class="form-group col-sm-6   my-2">
               <label class=""><b>Address(English)</b></label>
               <input type="text" name="address" id="edit_address" class="form-control" required>
           </div> 
			  
			  
         <div class="form-group  col-sm-6 my-2">
               <label class=""><b>E-mail</b></label>
               <input type="text" id="edit_email"  name="email" class="form-control" required>
          </div> 

        <div class="form-group col-sm-6  my-2">
               <label class=""><b>Mobile(880)</b></label>
               <input type="text" id="edit_mobile"  name="mobile" class="form-control" required>
        </div> 

          <div class="form-group  col-sm-6  my-2">
               <label class=""><b>Username</b></label>
               <input type="text" id="edit_admin_name"  name="admin_name" class="form-control" required>
          </div> 

          <div class="form-group  col-sm-6  my-2">
               <label class=""><b>Yearly Payment</b></label>
               <input type="text" id="edit_payment"  name="payment" class="form-control" required>
          </div> 

          <div class="form-group  col-sm-6 my-2">
               <label class=""><b>Password</b></label>
               <input type="text" id="edit_admin_password"  name="admin_password" class="form-control" required>
          </div>

          <div class="form-group  col-sm-6 my-2">
               <label class=""><b>Getway fee</b></label>
               <input type="text" id="edit_getway_fee"  name="getway_fee" class="form-control" required>
          </div>

          
        <div class="form-group col-sm-6  mb-4">
        <label class=""><b>Role</b></label>
          <select class="form-select" id="edit_role"  name="role" aria-label="Default select example">
                 <option selected>Select One</option>
                 <option value="Admin">Admin</option>
           </select>
       </div>   

       <div class="form-group col-sm-6  mb-4">
        <label class=""><b>Version Type</b></label>
          <select class="form-select" id="edit_version_type"  name="version_type" aria-label="Default select example" required>
                  <option selected>Select One</option>
                  <option value="free">free</option>
                  <option value="paid">paid</option>
           </select>
       </div>   

       <div class="form-group col-sm-6  my-2">
               <label class=""><b>Magazine/Gallery Size</b></label>
               <input type="text" id="edit_magazine_size"  name="magazine_size" class="form-control" required>
        </div> 

         <div class="form-group col-sm-6  my-2">
               <label class=""><b>Member Size</b></label>
               <input type="text" id="edit_member_size"  name="member_size" class="form-control" required>
         </div> 


         <div class="form-group col-sm-6  my-2">
               <label class=""><b>Executive Size</b></label>
               <input type="text" id="edit_executive_size"  name="executive_size" class="form-control" required>
         </div> 

         <div class="form-group col-sm-6  my-2">
               <label class=""><b>Online Payment Access</b></label>
               <select class="form-select" name="senior_size" id="edit_senior_size"  aria-label="Default select example">
                   <option value="1">Yes</option>
                   <option value="0">No</option>
               </select>
         </div> 

          <div class="form-group col-sm-6  my-2">
               <label class=""><b>Offline Payment Access</b></label>
                  <select class="form-select" name="general_size" id="general_size"  aria-label="Default select example">
                      <option value="1">Yes</option>
                      <option value="0">No</option>
                 </select>
          </div> 

         <div class="form-group col-sm-6  my-2">
               <label class=""><b>Notice Size</b></label>
               <input type="text" id="edit_notice_size"  name="notice_size" class="form-control" required>
         </div> 

         <div class="form-group col-sm-6  my-2">
               <label class=""><b>Welcome Size</b></label>
               <input type="text" id="edit_welcome_size"  name="welcome_size" class="form-control" required>
         </div> 

         <div class="form-group col-sm-6  my-2">
               <label class=""><b>Testimonial Size</b></label>
               <input type="text" id="edit_testimonial_size"  name="testimonial_size" class="form-control" required>
         </div> 

         <div class="form-group col-sm-6  my-2">
               <label class=""><b>Slide Size</b></label>
               <input type="text" id="edit_slide_size"  name="slide_size" class="form-control" required>
         </div> 
        

        

         <div class="form-group col-sm-6  my-2">
               <label class=""><b>Advisor Size</b></label>
               <input type="text" id="edit_advisor_size"  name="advisor_size" class="form-control" required>
         </div> 

         <div class="form-group col-sm-6  my-2">
               <label class=""><b>Blood Size</b></label>
               <input type="text" id="edit_blood_size"  name="blood_size" class="form-control" required>
         </div> 

         <div class="form-group col-sm-6  my-2">
               <label class=""><b>Header Size</b></label>
               <input type="text" id="edit_header_size"  name="header_size" class="form-control" required>
         </div> 

         <div class="form-group col-sm-6  my-2">
               <label class=""><b>Response Header Size</b></label>
               <input type="text" id="edit_resheader_size"  name="resheader_size" class="form-control" required>
         </div> 

         <div class="form-group col-sm-6  my-2">
               <label class=""><b>Fb link </b></label>
               <input type="text" id="edit_fb_link"  name="fb_link" class="form-control" >
         </div> 

         <div class="form-group col-sm-6  my-2">
               <label class=""><b>Youtube link </b></label>
               <input type="text" id="edit_youtube_link"  name="youtube_link" class="form-control" >
         </div> 

         <div class="form-group col-sm-6  my-2">
               <label class=""><b>other/Forntend link .com/ </b></label>
               <input type="text" id="edit_other_link"  name="other_link" class="form-control" >
         </div> 

         <div class="form-group col-sm-6  my-2">
               <label class=""><b>Text1   </b></label>
               <input type="text" id="edit_text1"  name="text1" class="form-control" >
         </div> 

         <div class="form-group col-sm-6  my-2">
               <label class=""><b>Text2   </b></label>
               <input type="text" id="edit_text2"  name="text2" class="form-control" >
         </div> 

         <div class="form-group col-sm-6  my-2">
               <label class=""><b>Text3  </b></label>
               <input type="text" id="edit_text3"  name="text3" class="form-control" >
         </div> 

         <div class="form-group col-sm-6  my-2">
               <label class=""><b>Menu Bar Hidden(0,1)  </b></label>
               <input type="text" id="edit_text4"  name="text4" class="form-control" >
         </div> 

         <div class="form-group col-sm-6  my-2">
               <label class=""><b>Bank name   </b></label>
               <input type="text" id="edit_bank_name"  name="bank_name" class="form-control" >
         </div> 

         <div class="form-group col-sm-6  my-2">
               <label class=""><b> Bank Account   </b></label>
               <input type="text" id="edit_bank_account"  name="bank_account" class="form-control" >
         </div> 

         <div class="form-group col-sm-6  my-2">
               <label class=""><b>Bank Route  </b></label>
               <input type="text" id="edit_bank_route"  name="bank_route" class="form-control" >
         </div> 

    </div>

     <br>
      <input type="submit"   id="insert" value="Update" class="btn btn-success" />
	  
              
   </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>





   
   
     


@endsection