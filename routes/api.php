<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\MemberController;


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
       Route::get('/email_verify/{emailmd5}', [MemberController::class, 'email_verify']);
       Route::get('{username}/forget_password/{email}', [MemberController::class, 'forget_password']);
       Route::get('{username}/forget_code/{email}/{forget_code}', [MemberController::class, 'forget_code']);
       Route::post('{username}/confirm_password/{email}/{forget_code}', [MemberController::class, 'confirm_password']);

       Route::post('/{username}/member_login',[MemberController::class,'member_login']);

       Route::middleware('MaintainToken')->group(function(){
            Route::get('{username}/member_profile', [MemberController::class, 'member_profile']);
            Route::get('{username}/member_logout', [MemberController::class, 'member_logout']);
            Route::post('{username}/member_password_update', [MemberController::class, 'password_update']);

       });

        

       //public APi
       Route::get('/{username}', [TestimonialController::class,'apiusername']);
       Route::get('/{username}/home', [TestimonialController::class,'apihome']);
        // category= History, Notice, Upcoming, Past, Constitution, Contact, Others, Document 
       Route::get('/{username}/notice/{category}', [TestimonialController::class, 'apinotice']);

          // member=Executive , Life_Member, Member
       Route::get('/{username}/member/{member}', [TestimonialController::class, 'apimember']);
       Route::get('/{username}/viewmember/{id}', [TestimonialController::class,'apiviewmember']);

       //category =Gallery
       Route::get('/{username}/magazine/{category}', [TestimonialController::class, 'apimagazine']);


       Route::get('/{username}/expre', [TestimonialController::class, 'apiexpre']);
       
       
       