<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\DuclubController;
use App\Models\Testimonial;
use App\Http\Controllers\NonmemberController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

  Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
       return $request->user();
  });

    
         //member api
       Route::post('/{username}/application_memebr',[MemberController::class,'application_memebr']);
       Route::get('/{username}/email_verify/{emailmd5}',[MemberController::class,'email_verify']);

       Route::get('{username}/forget_password/{email}', [MemberController::class, 'forget_password']);


          Route::middleware('ForgetToken')->group(function(){
              Route::get('{username}/forget_code/{forget_code}', [MemberController::class, 'forget_code']);
              Route::post('{username}/confirm_password/{forget_code}', [MemberController::class, 'confirm_password']);
          });

       Route::post('/{username}/member_login',[MemberController::class,'member_login']);

       Route::middleware('MaintainToken')->group(function(){
            Route::get('{username}/member_profile', [MemberController::class, 'member_profile']);
            Route::post('{username}/member_update', [MemberController::class, 'member_update']);
            Route::get('{username}/member_logout', [MemberController::class,'member_logout']);
            Route::get('{username}/category', [MemberController::class,'category_show']);
            Route::post('{username}/member_password_update', [MemberController::class,'password_update']);
            Route::post('{username}/invoice_create', [MemberController::class,'invoice_create']);
            Route::get('{username}/invoice_view', [MemberController::class,'invoice_view']);
            Route::get('{username}/invoice_delete/{id}', [MemberController::class,'invoice_delete']);
            Route::get('{username}/invoice_pdf/{id}', [MemberController::class,'invoice_pdf']); 
            Route::post('{username}/payment_create', [InvoiceController::class,'payment_create']);
            Route::post('{username}/issue_create', [MemberController::class,'issue_create']);
            Route::get('{username}/issue_view', [MemberController::class,'issue_view']);       
       });

       Route::get('payment_success', [InvoiceController::class,'payment_success']);
       Route::get('payment_fail', [InvoiceController::class,'payment_fail']);
       Route::post('payment_ipn', [InvoiceController::class,'payment_ipn']);

      
        //public APi
        Route::get('/{username}', [TestimonialController::class,'apiusername']);
        Route::get('/{username}/home', [TestimonialController::class,'apihome']);
        //category= History, Notice, Upcoming, Past, Constitution, Contact, Others, Document 
        Route::get('/{username}/notice/{category}', [TestimonialController::class, 'apinotice']);

       // member=Executive , Life_Member, Member
       Route::get('/{username}/member/{member}', [TestimonialController::class, 'apimember']);
       Route::get('/{username}/viewmember/{id}', [TestimonialController::class,'apiviewmember']);
       Route::get('/{username}/membersearch', [TestimonialController::class,'apimembersearch']);
       Route::get('/{username}/member_category', [TestimonialController::class,'apimembercategory']);

       //HomePage Booking 
       Route::get('/{username}/membercard/{membercard}',[MemberController::class,'apimembercard']);
       Route::get('/{username}/booking_category/',[MemberController::class,'apibooking_category']);
       Route::post('/{username}/home_invoice_create/',[MemberController::class,'apihome_invoice_create']);
       Route::get('/{username}/home_invoice_view/{member_id}',[MemberController::class,'apihome_invoice_view']);
       Route::get('/{username}/home_invoice_delete/{id}',[MemberController::class,'apihome_invoice_delete']);

       //Homepage Non Member Booking
       Route::post('{username}/nonmember_invoice_create', [NonmemberController::class,'nonmember_invoice_create']);
       Route::get('{username}/nonmember_invoice_view/{tran_id}', [NonmemberController::class,'nonmember_invoice_view']);
      
       // Geolocation
       Route::get('/{username}/divisions', [TestimonialController::class, 'apidivisions']);
       Route::get('/{username}/districts/{division_id}', [TestimonialController::class, 'apidistricts']);
       Route::get('/{username}/upazilas/{district_id}', [TestimonialController::class, 'apiupazilas']);
       Route::get('/{username}/unions/{upazilla_id}', [TestimonialController::class, 'apiunions']);
       
       //category =Gallery
       Route::get('/{username}/magazine/{category}', [TestimonialController::class, 'apimagazine']);
       Route::get('/{username}/expre', [TestimonialController::class, 'apiexpre']);

       //Payment Getway


       //Du Club routes
       Route::get('/duclub/api/homepage', [TestimonialController::class,'apidu_homepage']);
       Route::get('/duclub/api/product_view', [DuclubController::class,'product_view']);
       Route::get('/duclub/api/login/{phone}', [DuclubController::class,'duclub_login']);
       Route::get('/duclub/api/VerifyLogin/{phone}/{otp}',[DuclubController::class, 'duclub_VerifyLogin']);

  Route::middleware('DuClubToken')->group(function(){ 
       Route::get('/duclub/api/member_ledger', [DuclubController::class,'member_ledger']);
       Route::get('/duclub/api/product_add', [DuclubController::class,'product_add']);
       Route::get('/duclub/api/pending_product_view', [DuclubController::class,'pending_product_view']);
       Route::get('/duclub/api/product_delete/{saleID}', [DuclubController::class,'product_delete']);
  }); 
        
      
       
       