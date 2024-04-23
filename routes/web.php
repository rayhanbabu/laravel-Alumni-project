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
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\WithdrawController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\InvoiceMaintainController;
use App\Http\Controllers\NonmemberController;

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

    

     //Only Supper Admin Access 
     Route::middleware('AdminAccess')->group(function(){
            //maintain people add
           Route::get('maintain/maintainview',[MaintainController::class,'maintainview']);
           Route::post('/maintain/store',[MaintainController::class,'store']);
           Route::get('/maintain/fetchAll',[MaintainController::class,'fetchAll']);
           Route::get('/maintain/edit',[MaintainController::class,'edit']);
           Route::post('/maintain/update',[MaintainController::class,'update']);

          //Data defoult data view
          Route::get('maintain/dataview',[MaintainController::class,'dataview']);
          Route::post('maintain/dataedit',[MaintainController::class,'dataedit']);


          //SMS information
          Route::get('maintain/sms',[SmsController::class,'index']);
          Route::get('/maintain/sms/fetchall',[SmsController::class,'fetchAll']);
          Route::post('/maintain/sms/store',[SmsController::class,'store']);
          Route::get('/maintain/sms/edit',[SmsController::class,'edit']);
          Route::post('/maintain/sms/update',[SmsController::class,'update']);
          Route::delete('/maintain/sms/delete',[SmsController::class,'delete']);
          Route::post('/maintain/smspayment',[SmsController::class,'smspayment']);
          Route::get('/maintain/sms/{type}/{status}/{id}',[SmsController::class,'smsstatus']);
          Route::post('onlinesmspdf',[SmsController::class,'onlinesmspdf']);

         //Testinomial
         Route::get('/homepage/index', [HomepageController::class,'index']);
         Route::post('/homepage/store', [HomepageController::class,'store']);
         Route::get('/homepage/fetchall', [HomepageController::class,'fetchAll']);
         Route::delete('/homepage/delete', [HomepageController::class,'delete']);
         Route::get('/homepage/edit', [HomepageController::class,'edit']);
         Route::post('/homepage/update', [HomepageController::class,'update']);


     });

     //admin View Access
     Route::middleware('AdminViewAccess')->group(function(){
          Route::get('maintain/adminview',[MaintainController::class,'adminview']);
      });

     //admin Edit Access
     Route::middleware('AdminEditAccess')->group(function(){
         Route::post('maintain/admininsert',[MaintainController::class,'admininsert']);
         Route::post('maintain/adminedit',[MaintainController::class,'adminedit']);
         Route::get('maintain/admindelete/{id}',[MaintainController::class,'admindelete']);
         Route::get('/maintain/adminlist/{type}/{status}/{id}',[MaintainController::class,'adminstatus']);
         Route::post('/maintain/adminpdf',[MaintainController::class,'adminpdf']);
         Route::get('/maintain/adminexport',[MaintainController::class,'adminexportview']);
         Route::post('/maintain/adminexport',[MaintainController::class,'adminexport']);
         Route::get('/maintain/adminimport',[MaintainController::class,'adminimportview']);
         Route::post('/maintain/adminimport',[MaintainController::class,'adminimport']);
    });
   
     
       // Issue View Access
     Route::middleware('IssueViewAccess')->group(function(){
         //issue View
       Route::get('/maintain/issue/',[FeedbackController::class,'issue_index']);
       Route::get('/maintain/issue_fetch/',[FeedbackController::class,'issue_fetch']);
       Route::get('/maintain/issue/fetch_data/',[FeedbackController::class,'issue_fetch_data']);

        //Invoice View
       Route::get('/maintain/invoice/',[InvoiceMaintainController::class,'invoice_index']);
       Route::get('/maintain/invoice_fetch/',[InvoiceMaintainController::class,'maintain_invoice_fetch']);
       Route::get('/maintain/invoice/fetch_data',[InvoiceMaintainController::class,'maintain_invoice_fetch_data']);
       
     });

      // Issue Edit Access
    Route::middleware('IssueEditAccess')->group(function(){
          Route::post('/maintain/issue_update',[FeedbackController::class,'issue_update']); 
          Route::post('/maintain/invoice_update',[InvoiceMaintainController::class,'invoice_update']); 
    });


      // Payment  View Access
      Route::middleware('PaymentViewAccess')->group(function(){
          //Payment information
          Route::get('maintain/payment',[OnlinepaymentController::class,'paymentview']);
          //withdraw
          Route::post('/admin/withdraw',[WithdrawController::class,'store']);
          Route::get('/maintain/withdraw/',[MaintainController::class,'withdraw_index']);
          Route::get('/maintain/withdraw_fetch/',[MaintainController::class,'withdraw_fetch']);
          Route::get('/maintain/withdraw/fetch_data/',[MaintainController::class,'withdraw_fetch_data']);
      });
 
          // Payment  Edit Access
      Route::middleware('PaymentEditAccess')->group(function(){
          //withdraw
           Route::get('/maintain/withdraw/{operator}/{status}/{id}', [MaintainController::class,'withdraw_status']);
           Route::post('/maintain/withdraw_update',[MaintainController::class,'withdraw_update']); 

           //Payment information
           Route::post('/onlinepaymentstatus',[OnlinepaymentController::class,'onlinepaymentstatus']);
           Route::post('maintain/paymentedit',[OnlinepaymentController::class,'paymentedit']);
           Route::post('onlinepaymentpdf',[OnlinepaymentController::class,'onlinepaymentpdf']);
     
      });
 
        
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
    Route::get('/admin/app/{admin_category}',[AppController::class,'index']);
    Route::post('/admin/app',[AppController::class,'store']);
    Route::get('/admin/app_fetch/{admin_category}',[AppController::class,'fetch']);
    Route::get('/admin/app/fetch_data/{admin_category}',[AppController::class,'fetch_data']);
    Route::get('/admin/app_edit/{id}',[AppController::class,'edit']);
    Route::post('/admin/app_update/{id}',[AppController::class,'update']);
    Route::delete('/admin/app_delete/{id}',[AppController::class,'destroy']);


    //member
    Route::get('/admin/member/{category_id}', [AdminController::class, 'member']);
    Route::get('/admin/member_fetch/{category_id}', [AdminController::class, 'member_fetch']);
    Route::get('/admin/member_view/{id}', [AdminController::class, 'member_view']);
    Route::get('/admin/member/fetch_data/{category_id}', [AdminController::class, 'member_fetch_data']);
    Route::post('/admin/member_update', [AdminController::class, 'member_update']);
    Route::get('/admin/member/{operator}/{status}/{id}', [AdminController::class, 'memberstatus']);
    Route::get('/admin/member_delete/{id}', [AdminController::class, 'member_delete']);
    Route::post('/member/export',[AdminController::class,'member_export']); 

    Route::get('admin/dataview',[AdminController::class,'dataview']);
    Route::post('admin/dataedit',[AdminController::class,'dataedit']);


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


         //Payment View 
        Route::get('/admin/paymentview',[AdminController::class,'paymentview']);
        Route::get('/admin/payment_fetch',[AdminController::class,'fetch']);
        Route::get('/admin/payment/fetch_data',[AdminController::class,'fetch_data']);
        Route::post('/admin/payment_status',[AdminController::class,'payment_status']);
        Route::post('/admin/payment_delete',[AdminController::class,'payment_delete']);
       
        Route::post('/admin/admin_invoice_create',[AdminController::class,'admin_invoice_create']);

        //Non Payment View 
        Route::get('/admin/non_paymentview',[NonmemberController::class,'non_paymentview']);
        Route::get('/admin/non_payment_fetch',[NonmemberController::class,'non_fetch']);
        Route::get('/admin/non_payment/fetch_data',[NonmemberController::class,'non_fetch_data']);
        Route::post('/admin/non_payment_update',[NonmemberController::class,'non_payment_update']);
        Route::post('/admin/add_non_payment',[NonmemberController::class,'add_non_payment']);
        Route::get('/admin/non_payment_status/{id}',[NonmemberController::class,'non_payment_status']);
         
        //Form Customize
        Route::get('/form/customize', [FormController::class,'customize']);
        Route::post('/form/customize_update', [FormController::class,'customize_update']);
        Route::get('/form/data', [FormController::class,'form_data']);
        Route::post('/form/form_update', [FormController::class,'form_update']);
        Route::get('admin/form_delete/{id}', [FormController::class,'form_delete']);

         //Withdraw 
        Route::get('/admin/withdraw/',[WithdrawController::class,'index']);
        Route::get('/admin/withdraw_fetch/',[WithdrawController::class,'fetch']);
        Route::get('/admin/withdraw/fetch_data/',[WithdrawController::class,'fetch_data']);
        Route::delete('/admin/withdraw_delete/{id}',[WithdrawController::class,'destroy']);

         // Admin view 
         Route::get('/admin/issue/',[FeedbackController::class,'issue_index_admin']);
         Route::get('/admin/issue_fetch_admin/',[FeedbackController::class,'issue_fetch_admin']);
         Route::get('/admin/issue/fetch_data_admin/',[FeedbackController::class,'fetch_data_admin']);

         //Pdf Reports
         Route::post('/pdf/payment_category',[AdminController::class,'payment_category']);
         Route::post('/pdf/payment_report',[AdminController::class,'payment_report']);
         Route::post('/pdf/payment_report_date',[AdminController::class,'payment_report_date']);
         Route::post('/pdf/payment_category_report',[AdminController::class,'payment_category_report']);
         Route::post('/pdf/event_report',[AdminController::class,'event_report']);
      
         Route::get('/auto_invoice', [AdminController::class,'auto_invoice']);
         
   });


    //Amarpay Payment getway
    Route::get('epay/{username}/{tran_id}',[InvoiceController::class,'amarpay_epay'])->name('amarpay_epay');
 
    Route::get('amarpay_payment/{tran_id}',[InvoiceController::class,'amarpay_payment'])->name('amarpay_payment');
    //You need declear your success & fail route in "app\Middleware\VerifyCsrfToken.php"
    Route::post('amarpay_success',[InvoiceController::class,'amarpay_success'])->name('amarpay_success');
    Route::post('amarpay_fail',[InvoiceController::class,'amarpay_fail'])->name('amarpay_fail');
    Route::get('amarpay_cancel',[InvoiceController::class,'amarpay_cancel'])->name('amarpay_cancel');
    Route::get('payment',[InvoiceController::class,'payment'])->name('payment');

    Route::post('admin/amarpay_search',[InvoiceController::class,'amarpay_search']);

     //Mon Member aamarpay Getway
     Route::get('nonmember_epay/{username}/{tran_id}',[NonmemberController::class,'nonmember_amarpay_epay'])->name('nonmember_amarpay_epay');
     Route::get('nonmember_amarpay_payment/{tran_id}',[NonmemberController::class,'nonmember_amarpay_payment'])->name('nonmember_amarpay_payment');
     //You need declear your success & fail route in "app\Middleware\VerifyCsrfToken.php"
     Route::post('nonmember_amarpay_success',[NonmemberController::class,'nonmember_amarpay_success'])->name('nonmember_amarpay_success');
     Route::post('nonmember_amarpay_fail',[NonmemberController::class,'nonmember_amarpay_fail'])->name('nonmember_amarpay_fail');
     Route::get('nonmember_amarpay_cancel',[NonmemberController::class,'nonmember_amarpay_cancel'])->name('nonmember_amarpay_cancel');

    //registration
    Route::get('/', [HomepageController::class, 'homepage']);
    Route::get('/application', [MaintainController::class, 'reg']);
    Route::get('/policy', [HomepageController::class, 'policy']);
    Route::get('/term', [HomepageController::class, 'term']);
    Route::get('/refund', [HomepageController::class, 'refund']);
    Route::get('/cancel', [HomepageController::class, 'cancel']);
    Route::post('/web/insert', [MaintainController::class, 'webinsert']);
    Route::get('/email_verify/{email2}', [MaintainController::class, 'email_verify']);
   
    
      /* 
   Route::get('/testimonial', [TestimonialController::class,'testimonial']);
   Route::get('/langhome', [TestimonialController::class,'langhome']);

  Route::get('/view',[HomeController::class,'view']); 

  //Route::post('/import',[HomeController::class,'import']); 

  Route::get('/export',[HomeController::class,'export']); 

  Route::post('/generate-pdf', [PDFController::class, 'generatePDF']);
  Route::post('/generate-fpdf', [PDFController::class, 'generatefPDF']);

  //Route::get('/exportview',[HomeController::class,'exportview']); 
  Route::post('/exports',[HomeController::class,'exports']); 

  Route::get('/pdfview',[HomeController::class,'pdfview']); 

  Route::post('/pdfs',[HomeController::class,'pdfs']); 

*/






  
  
  

