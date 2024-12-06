@extends('maintain/dashboardheader')
@section('page_title','Data View')
@section('dataview_select','active')
@section('content')

<div class="row mt-4 mb-3">
               <div class="col-3"> <h4 class="mt-0">Data View</h4></div>
                    
                     </div> 
             </div>  
             
  

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
        
       @if(maintain_access()->duclub=='Yes')
          <th width="10%" > Id </th>
          <th width="10%" > Onwer name </th>
          <th width="10%" > Registration Status </th>
          <th width="10%" > Deadline Status </th>
          <th width="10%" > Program Title  </th>
          <th width="10%" > Program Description </th>
          <th width="10%" > Program Year </th>
          <th width="10%" > Message </th>
       @else  
         <th width="10%" >Onwer name </th>
         <th width="10%" >Payment </th>
         <th width="10%" >Version Type </th>
         <th width="10%" >Subscribe </th>
         <th width="10%" >Payment Duration </th>
         <th width="15%" >Header Size </th>
		     <th width="15%" >Reponseive Header Size </th>
	       <th width="15%" >Magazine Size</th>
         <th width="15%" >Bllod Size</th>
         <th width="10%" >Member Size</th>
         <th width="10%" >advisor size</th>
         <th width="10%" >Fb Link</th>
         <th width="10%" >Youtube Link </th>
         <th width="10%" > Other/ForntEnd Link</th>
         <th width="10%" >Taxt1 </th>
         <th width="10%" >Taxt2 </th>
         <th width="10%" >Taxt3 </th>
         <th width="10%" >Taxt4 </th>
         <th width="10%" >Store Id </th>
         <th width="10%" >Store Password </th>
         <th width="10%" >currency </th>
         <th width="10%" >success_url </th>
         <th width="10%" >fail_url </th>
         <th width="10%" >cancel_url</th>
         <th width="10%" >ipn_url </th>
         <th width="10%" >init_url </th>
        @endif
         <th width="5%" >Edit</th>
        
      </tr>
  </thead>
  <tbody>

	@foreach($maintain as $item)
	 <tr>

       @if(maintain_access()->duclub=='Yes')
           <td>{{$item->id}}</td>
           <td>{{$item->name}} </td>
           <td>{{$item->registration_status}} </td>
           <td>{{$item->deadline_status}} </td>
           <td>{{$item->program_title}} </td>
           <td>{{$item->program_desc}} </td>
           <td>{{$item->program_year}}  </td>
           <td>{{$item->message}} </td>
      @else 
        <td>{{$item->name}}</span></td>
      
        <td>{{$item->payment}}</td>
        <td>{{$item->version_type}}</td>
        <td>{{$item->subscribe}}</td>
        <td>{{$item->payment_duration}}</td>
        <td>{{$item->header_size}}</td>
        <td>{{$item->resheader_size}}</td>
        <td>{{$item->magazine_size}}</td>
        <td>{{$item->blood_size}}</td>
        <td>{{$item->member_size}}</td>
        <td>{{$item->advisor_size}}</td>
        <td>{{$item->fb_link}}</td>
        <td>{{$item->youtube_link}}</td>
        <td>{{$item->other_link}}</td>
        <td>{{$item->text1}}</td>
        <td>{{$item->text2}}</td>
        <td>{{$item->text3}}</td>
        <td>{{$item->text4}}</td>

        <td>{{$item->store_id}}</td>
        <td>{{$item->store_password}}</td>
        <td>{{$item->currency}}</td>
        <td>{{$item->success_url}}</td>
        <td>{{$item->fail_url}}</td>
        <td>{{$item->cancel_url}}</td>
        <td>{{$item->ipn_url}}</td>
        <td>{{$item->init_url}}</td>
       
        @endif

    <td>
      <button type="button" name="edit" id="{{$item->id}}" class="btn btn-success btn-sm edit" 
	 data-payment="{{$item->payment}}"  data-payment_duration="{{$item->payment_duration}}" data-subscribe="{{$item->subscribe}}"
       data-magazine_size="{{$item->magazine_size}}" data-member_size="{{$item->member_size}}"
       data-advisor_size="{{$item->advisor_size}}"  data-blood_size="{{$item->blood_size}}"
       data-header_size="{{$item->header_size}}"  data-fb_link="{{$item->fb_link}}"
       data-youtube_link="{{$item->youtube_link}}" data-other_link="{{$item->other_link}}"
       data-text1="{{$item->text1}}"  data-text2="{{$item->text2}}"  data-text3="{{$item->text3}}"
       data-text4="{{$item->text4}}" data-version_type="{{$item->version_type}}"
       data-resheader_size="{{$item->resheader_size}}"  data-executive_size="{{$item->executive_size}}"
       data-senior_size="{{$item->senior_size}}" data-general_size="{{$item->general_size}}" data-notice_size="{{$item->notice_size}}"
       data-welcome_size="{{$item->welcome_size}}"data-testimonial_size="{{$item->testimonial_size}}"data-slide_size="{{$item->slide_size}}" 
       data-store_id="{{$item->store_id}}" data-store_password="{{$item->store_password}}" data-currency="{{$item->currency}}"
       data-success_url="{{$item->success_url}}" data-fail_url="{{$item->fail_url}}" data-cancel_url="{{$item->cancel_url}}" 
       data-ipn_url="{{$item->ipn_url}}" data-init_url="{{$item->init_url}}"

       data-program_title="{{$item->program_title}}" data-program_desc="{{$item->program_desc}}"
       data-program_year="{{$item->program_year}}" data-message="{{$item->message}}"
       data-deadline_status="{{$item->deadline_status}}" data-registration_status="{{$item->registration_status}}"  >Edit</button>
    </td>

      
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
                 
                   var payment = $(this).data("payment");
                   var payment_duration = $(this).data("payment_duration");
                   var subscribe = $(this).data("subscribe");
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

                   var store_id = $(this).data("store_id");
                  var store_password = $(this).data("store_password");
                  var currency = $(this).data("currency");
                  var success_url = $(this).data("success_url");
                  var fail_url = $(this).data("fail_url");
                  var cancel_url = $(this).data("cancel_url");
                  var init_url = $(this).data("init_url");
                  var ipn_url = $(this).data("ipn_url");

                  var registration_status = $(this).data("registration_status");
                  var deadline_status = $(this).data("deadline_status");
                  var program_title = $(this).data("program_title");
                  var program_desc = $(this).data("program_desc");
                  var program_year = $(this).data("program_year");
                  var message = $(this).data("message");
                 
                   
                     $('#edit_id').val(id);
                     $('#edit_payment').val(payment);
                     $('#edit_payment_duration').val(payment_duration);
                     $('#edit_subscribe').val(subscribe);
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

                     $('#edit_store_id').val(store_id);
                     $('#edit_store_password').val(store_password);
                     $('#edit_currency').val(currency);
                     $('#edit_success_url').val(success_url);
                     $('#edit_fail_url').val(fail_url);
                     $('#edit_cancel_url').val(cancel_url);
                     $('#edit_ipn_url').val(ipn_url);
                     $('#edit_init_url').val(init_url);

                     $('#registration_status').val(registration_status);
                     $('#deadline_status').val(deadline_status);
                     $('#program_title').val(program_title);
                     $('#program_desc').val(program_desc);
                     $('#program_year').val(program_year);
                     $('#message').val(message);


                     $('#updatemodal').modal('show');
                });

           });


</script>






<!-- Modal Edit -->
<div class="modal fade" id="updatemodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Data View Edit</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
      <form method="post" action="{{url('maintain/dataedit')}}"  class="myform"  enctype="multipart/form-data" >
         {!! csrf_field() !!}

         <input type="hidden" id="edit_id" name="id" class="form-control">

         <div class="row px-3">

         @if(maintain_access()->duclub=='Yes')

          <div class="form-group col-sm-4  mb-4">
             <label class=""><b> Registation Status</b></label>
              <select class="form-select" id="registration_status"  name="registration_status" aria-label="Default select example" required>
                   <option selected>Select One</option>
                   <option value="0">No</option>
                   <option value="1">Yes</option>
              </select>
           </div>  
           
           
           <div class="form-group col-sm-4  mb-4">
             <label class=""><b> Deadline Status</b></label>
              <select class="form-select" id="deadline_status"  name="deadline_status" aria-label="Default select example" required>
                   <option selected>Select One</option>
                   <option value="0">No</option>
                   <option value="1">Yes</option>
              </select>
           </div>   

           <div class="form-group  col-sm-4  my-2">
               <label class=""><b>Program Year </b></label>
               <input type="number" id="program_year"  name="program_year" class="form-control" required>
          </div> 
         
           <div class="form-group  col-sm-12  my-2">
               <label class=""><b>Program Title </b></label>
               <input type="text" id="program_title"  name="program_title" class="form-control" required>
          </div> 

          <div class="form-group  col-sm-12  my-2">
               <label class=""><b>Program Description </b></label>
               <input type="text" id="program_desc"  name="program_desc" class="form-control" required>
          </div> 

         

          <div class="form-group  col-sm-12  my-2">
               <label class=""><b> Message </b></label>
               <input type="text" id="message"  name="message" class="form-control" required>
          </div> 

         @else

          <div class="form-group  col-sm-6  my-2">
               <label class=""><b>Yearly Payment</b></label>
               <input type="text" id="edit_payment"  name="payment" class="form-control" required>
          </div> 

          <div class="form-group  col-sm-6  my-2">
               <label class=""><b> Payment Duration </b></label>
               <input type="text" id="edit_payment_duration"  name="payment_duration" class="form-control" required>
          </div> 

          <div class="form-group  col-sm-6  my-2">
               <label class=""><b> Subscribe </b></label>
               <input type="text" id="edit_subscribe"  name="subscribe" class="form-control" required>
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
               <label class=""><b>Magazine Size</b></label>
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
               <label class=""><b>Senior Size</b></label>
               <input type="text" id="edit_senior_size"  name="senior_size" class="form-control" required>
         </div> 

         <div class="form-group col-sm-6  my-2">
               <label class=""><b>General Size</b></label>
               <input type="text" id="edit_general_size"  name="general_size" class="form-control" required>
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
               <label class=""><b> Other/ForntEnd Link </b></label>
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
               <label class=""><b>Text4   </b></label>
               <input type="text" id="edit_text4"  name="text4" class="form-control" >
         </div> 

         <div class="form-group col-sm-6  my-2">
               <label class=""><b>Store_id   </b></label>
               <input type="text" id="edit_store_id"  name="store_id" class="form-control" >
         </div> 


         <div class="form-group col-sm-6  my-2">
               <label class=""><b>store_passwd  </b></label>
               <input type="text" id="edit_store_password"  name="store_password" class="form-control" >
         </div>
         
         <div class="form-group col-sm-6  my-2">
               <label class=""><b>currency  </b></label>
               <input type="text" id="edit_currency"  name="currency" class="form-control" >
         </div> 

         <div class="form-group col-sm-6  my-2">
               <label class=""><b>success_url  </b></label>
               <input type="text" id="edit_success_url"  name="success_url" class="form-control" >
         </div> 

         <div class="form-group col-sm-6  my-2">
               <label class=""><b>fail_url  </b></label>
               <input type="text" id="edit_fail_url"  name="fail_url" class="form-control" >
         </div> 

         <div class="form-group col-sm-6  my-2">
               <label class=""><b>cancel_url  </b></label>
               <input type="text" id="edit_cancel_url"  name="cancel_url" class="form-control" >
         </div> 

         <div class="form-group col-sm-6  my-2">
               <label class=""><b>ipn_url  </b></label>
               <input type="text" id="edit_ipn_url"  name="ipn_url" class="form-control" >
         </div> 

         <div class="form-group col-sm-6  my-2">
               <label class=""><b>init_url  </b></label>
               <input type="text" id="edit_init_url"  name="init_url" class="form-control" >
         </div> 


         
         @endif



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