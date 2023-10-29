<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MaintainController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AppController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\TextController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\MagazineController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\OnlinepaymentController;
use App\Http\Controllers\SmsController;
use App\Http\Controllers\ExpreController;
use App\Http\Controllers\FormController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


   //Route::get('/', function () {
   //      return view('welcome');
  // });

  


   Route::get('locale/{locale}',function($locale){
       Session::put('locale',$locale);
       return redirect()->back();
   });

   Route::get('/web/12345', [OnlinepaymentController::class,'onlinepaymentupdate']);

   Route::middleware('MaintainAlready')->group(function(){
     Route::get('/maintain/login',[MaintainController::class,'loginview']);
     Route::post('maintain/login',[MaintainController::class,'login']);

   });

   Route::get('maintain/forget',[MaintainController::class,'forget']); 
   Route::post('maintain/forget',[MaintainController::class,'forgetemail']); 
   Route::post('maintain/forgetcode',[MaintainController::class,'forgetcode']); 
   Route::post('maintain/confirmpass',[MaintainController::class,'confirmpass']);

   
  


Route::middleware('MaintainIs')->group(function(){

   Route::get('/maintain/logout',[MaintainController::class,'logout']);
   Route::get('/maintain/dashboard',[MaintainController::class,'dashboard']);
   Route::get('/maintain/password',[MaintainController::class,'password']);
   Route::post('maintain/password',[MaintainController::class,'passwordedit']);

  
    //admin
   Route::get('maintain/adminview',[MaintainController::class,'adminview']);
   Route::post('maintain/admininsert',[MaintainController::class,'admininsert']);
   Route::post('maintain/adminedit',[MaintainController::class,'adminedit']);
   Route::get('maintain/admindelete/{id}',[MaintainController::class,'admindelete']);
   Route::get('/maintain/adminlist/{type}/{status}/{id}',[MaintainController::class,'adminstatus']);
   Route::post('/maintain/adminpdf',[MaintainController::class,'adminpdf']);
   Route::get('/maintain/adminexport',[MaintainController::class,'adminexportview']);
   Route::post('/maintain/adminexport',[MaintainController::class,'adminexport']);
   Route::get('/maintain/adminimport',[MaintainController::class,'adminimportview']);
   Route::post('/maintain/adminimport',[MaintainController::class,'adminimport']);

     //Data defoult data view
   
     Route::get('maintain/dataview',[MaintainController::class,'dataview']);
     Route::post('maintain/dataedit',[MaintainController::class,'dataedit']);

      //Payment information
      Route::get('maintain/payment',[OnlinepaymentController::class,'paymentview']);
      Route::post('/onlinepaymentstatus',[OnlinepaymentController::class,'onlinepaymentstatus']);
      Route::post('maintain/paymentedit',[OnlinepaymentController::class,'paymentedit']);
      Route::post('onlinepaymentpdf',[OnlinepaymentController::class,'onlinepaymentpdf']);

      //SMS information
      Route::get('maintain/sms',[SmsController::class,'index']);
      Route::get('/maintain/sms/fetchall',[SmsController::class,'fetchAll']);
      Route::post('/maintain/sms/store',[SmsController::class,'store']);
      Route::get('/maintain/sms/edit',[SmsController::class, 'edit']);
      Route::post('/maintain/sms/update',[SmsController::class, 'update']);
      Route::delete('/maintain/sms/delete',[SmsController::class, 'delete']);
      Route::post('/maintain/smspayment',[SmsController::class,'smspayment']);
      Route::get('/maintain/sms/{type}/{status}/{id}',[SmsController::class,'smsstatus']);
      Route::post('onlinesmspdf',[SmsController::class,'onlinesmspdf']);

});


Route::middleware('AdminAlready')->group(function(){

       Route::get('/admin/login',[AdminController::class,'loginview']);
       Route::post('admin/login',[AdminController::class,'login']);
});  

Route::get('admin/forget',[AdminController::class,'forget']); 
Route::post('admin/forget',[AdminController::class,'forgetemail']); 
Route::post('admin/forgetcode',[AdminController::class,'forgetcode']); 
Route::post('admin/confirmpass',[AdminController::class,'confirmpass']);

Route::middleware('AdminIs')->group(function(){  

    Route::get('/admin/logout',[AdminController::class,'logout']);
    Route::get('/admin/dashboard',[adminController::class,'dashboard']);
    Route::get('/admin/password',[AdminController::class,'password']);
    Route::post('admin/password',[AdminController::class,'passwordedit']);


    //Application 
    Route::get('/admin/app',[AppController::class,'index']);
    Route::post('/admin/app',[AppController::class,'store']);
    Route::get('/admin/app_fetch',[AppController::class,'fetch']);
    Route::get('/admin/app/fetch_data',[AppController::class,'fetch_data']);
    Route::get('/admin/app_edit/{id}',[AppController::class,'edit']);
    Route::post('/admin/app_update/{id}',[AppController::class,'update']);
    Route::delete('/admin/app_delete/{id}',[AppController::class,'destroy']);


    //member
    Route::get('/admin/member/{category}', [AdminController::class, 'member']);
    Route::get('/admin/member_fetch/{category}', [AdminController::class, 'member_fetch']);
    Route::get('/admin/member_view/{id}', [AdminController::class, 'member_view']);
    Route::get('/admin/member/fetch_data/{category}', [AdminController::class, 'member_fetch_data']);
    Route::post('/admin/member_update', [AdminController::class, 'member_update']);
    Route::get('/admin/member/{operator}/{status}/{id}', [AdminController::class, 'memberstatus']);
    Route::get('/admin/member_delete/{id}', [AdminController::class, 'member_delete']);


      //Notice
       Route::get('/admin/notice',[NoticeController::class,'index']);
       Route::get('/admin/notice_fetch',[NoticeController::class,'fetch']);
       Route::get('/admin/notice/fetch_data',[NoticeController::class,'fetch_data']); 

       Route::get('/admin/notice_create',[NoticeController::class,'notice_create']);
       Route::post('/admin/notice_insert',[NoticeController::class,'store']); 
       Route::get('/admin/notice_view/{id}',[NoticeController::class,'view']);
       Route::get('/admin/notice_edit/{id}',[NoticeController::class,'edit']);
       Route::post('/admin/notice_update/{id}',[NoticeController::class,'update']);
       Route::get('/admin/notice_delete/{id}',[NoticeController::class,'destroy']);

       //Testinomial
       Route::get('/testimonial/index/{member}', [TestimonialController::class,'index']);
       Route::post('/testimonial/store', [TestimonialController::class,'store']);
       Route::get('/testimonial/fetchall/{member}', [TestimonialController::class,'fetchAll']);
       Route::delete('/testimonial/delete', [TestimonialController::class,'delete']);
       Route::get('/testimonial/edit', [TestimonialController::class, 'edit']);
       Route::post('/testimonial/update', [TestimonialController::class, 'update']);

         //Magazine //Notice //Slide //Welcome Message
        Route::get('/magazine/index/{member}', [MagazineController::class,'index']);
        Route::post('/magazine/store', [MagazineController::class,'store']);
        Route::get('/magazine/fetchall/{member}',[MagazineController::class,'fetchAll']);
        Route::delete('/magazine/delete', [MagazineController::class,'delete']);
        Route::get('/magazine/edit', [MagazineController::class,'edit']);
        Route::post('/magazine/update', [MagazineController::class,'update']);


       //Text
      Route::get('/text/index', [TextController::class,'index']);
      Route::post('/text/store', [TextController::class,'store']);
      Route::get('/text/fetchall', [TextController::class,'fetchAll']);
      Route::delete('/text/delete', [TextController::class,'delete']);
      Route::get('/text/edit', [TextController::class, 'edit']);
      Route::post('/text/update', [TextController::class, 'update']);

      Route::get('/bloodsearch', [TextController::class,'bloodsearch']);
      Route::post('/bloodsearchview', [TextController::class,'bloodsearchview']);


         //Finance
         Route::get('/finance/index/{member}', [FinanceController::class,'index']);
         Route::post('/finance/store', [FinanceController::class,'store']);
         Route::get('/finance/fetchall/{member}', [FinanceController::class,'fetchAll']);
         Route::delete('/finance/delete', [FinanceController::class,'delete']);
         Route::get('/finance/edit', [FinanceController::class, 'edit']);
         Route::post('/finance/update', [FinanceController::class, 'update']);

         Route::post('/financepdf', [FinanceController::class,'financepdf']);
             Route::get('/invoiceprint/{id}',[FinanceController::class,'invoiceprint']);


           //Online Payment
           Route::get('/companypay', [OnlinepaymentController::class,'companypay']); 
           Route::get('/paymentprint/{id}', [OnlinepaymentController::class,'paymentprint']); 


            //SMS Send
            Route::get('/smsview', [SmsController::class,'smsview']); 
            Route::get('/smsbuy', [SmsController::class,'smsbuy']); 
            Route::get('/smsdetails', [SmsController::class,'smsdetails']); 
            Route::post('school/smsinsert', [SmsController::class,'smsinsert']); 
            Route::post('school/smstext_update', [SmsController::class,'smstext_update']); 
            Route::post('school/smsbuy', [SmsController::class,'smsbuyinsert']); 


      //Expreseodent
        Route::get('/expre/index', [ExpreController::class,'index']);
        Route::post('/expre/store', [ExpreController::class,'store']);
        Route::get('/expre/fetchall', [ExpreController::class,'fetchAll']);
        Route::delete('/expre/delete', [ExpreController::class,'delete']);
        Route::get('/expre/edit', [ExpreController::class, 'edit']);
        Route::post('/expre/update', [ExpreController::class, 'update']);


         //Application 
        Route::get('/admin/paymentview',[AdminController::class,'paymentview']);
        Route::get('/admin/payment_fetch',[AdminController::class,'fetch']);
        Route::get('/admin/payment/fetch_data',[AdminController::class,'fetch_data']);
        Route::post('/admin/payment_status',[AdminController::class,'payment_status']);
        Route::post('/admin/payment_delete',[AdminController::class,'payment_delete']);
        Route::post('/admin/payment_category',[AdminController::class,'payment_category']);
        
        
         //Form Customize
        Route::get('/form/customize', [FormController::class,'customize']);
        Route::post('/form/customize_update', [FormController::class,'customize_update']);
        Route::get('/form/data', [FormController::class,'form_data']);
         Route::post('/form/form_update', [FormController::class,'form_update']);
        Route::get('admin/form_delete/{id}', [FormController::class,'form_delete']);


   });

    //registration
   Route::get('/', [MaintainController::class, 'reg']);
   Route::post('/web/insert', [MaintainController::class, 'webinsert']);
   Route::get('/email_verify/{email2}', [MaintainController::class, 'email_verify']);
   
    //Organozation Search
   Route::get('/web/contact', [TestimonialController::class, 'webcontact']);
   Route::get('/web/search', [TestimonialController::class, 'websearch']);
   Route::get('/web/fetch_data',[TestimonialController::class,'fetch_data']);
   //Route::get('/{admin_name}', [TestimonialController::class, 'admin_name']);


    //webpage
    Route::get('/rewr', [TestimonialController::class, 'webhome']);
    Route::get('/web/member/{member}', [TestimonialController::class, 'webmember']);
    Route::get('/web/viewmember/{id}', [TestimonialController::class, 'viewmember']);
    Route::get('/web/magazine', [TestimonialController::class, 'webmagazine']);
    Route::get('/web/notice', [TestimonialController::class, 'webnotice']);
    Route::get('/web/expre', [TestimonialController::class, 'webexpre']);
    Route::get('/web/history', [TestimonialController::class, 'webhistory']);



    

   Route::get('/testimonial', [TestimonialController::class, 'testimonial']);
   Route::get('/langhome', [TestimonialController::class, 'langhome']);

  Route::get('/view',[HomeController::class,'view']); 

  //Route::post('/import',[HomeController::class,'import']); 

  Route::get('/export',[HomeController::class,'export']); 

  Route::post('/generate-pdf', [PDFController::class, 'generatePDF']);
  Route::post('/generate-fpdf', [PDFController::class, 'generatefPDF']);

  //Route::get('/exportview',[HomeController::class,'exportview']); 
  Route::post('/exports',[HomeController::class,'exports']); 

  Route::get('/pdfview',[HomeController::class,'pdfview']); 

  Route::post('/pdfs',[HomeController::class,'pdfs']); 




/*
   //payment
   Route::get('payment',[FormController::class,'payment'])->name('payment');
   //You need declear your success & fail route in "app\Middleware\VerifyCsrfToken.php"
   Route::post('success',[FormController::class,'success'])->name('success');
   Route::post('fail',[FormController::class,'fail'])->name('fail');
   Route::get('cancel',[FormController::class,'cancel'])->name('cancel');
*/

  
  
  

