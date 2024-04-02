<?php

namespace App\Http\Controllers;

 use Illuminate\Http\Request;
 use App\Models\Admin;
 use PDF;
 use Illuminate\Support\Facades\Mail;
 use Illuminate\Support\Facades\Session;

 class PDFController extends Controller
 {
    public function generatePDF(Request $request)
    {

      $admin = Admin::where('admin_name', Session::get('admin')->admin_name)->select('id','name','nameen', 'address','email', 'mobile', 'admin_name',
      'header_size','resheader_size','getway_fee','other_link')->first();

           $data['email']='rayhanbabu458@gmail.com';
           $data['title']='Email testing Title';
           $data['body']='Email testing Body';

           $pdf = PDF::loadView('pdf.auto_payment_invoice',[
                    'title' => 'PDF Title',
                    'author' => 'PDF Author',
                    'margin_left' => 20,
                    'margin_right' => 20,
                    'margin_top' => 60,
                    'margin_bottom' => 20,
                    'margin_header' => 15,
                    'margin_footer' => 10,
                    'showImageErrors' => true,
                    'admin' => $admin,
              ]);
        
            return $pdf->stream('pdf-file.pdf');
          //  Mail::send('pdf.my-file-pdf',$data,function($message) use ($data,$pdf){
          //      $message->to($data['email'])
          //      ->subject($data['title'])
          //      ->attachData($pdf->output(),"test.pdf");       
          //  });

             dd("Email sent Successfully");

            }


             public function generatefPDF()
               {
                 $admin=Admin::get();
                 return view('pdf.fpdf-file',['admin'=>$admin ]);
               }

    }
 
