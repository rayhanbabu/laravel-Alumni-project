<?php

namespace App\Http\Controllers;

 use Illuminate\Http\Request;
 use App\Models\Admin;
 use PDF;

 class PDFController extends Controller
 {
    public function generatePDF()
    {
            
             $pdf = PDF::loadView('pdf.my-file-pdf',[
                    'title' => 'PDF Title',
                    'author' => 'PDF Author',
                    'margin_left' => 20,
                    'margin_right' => 20,
                    'margin_top' => 60,
                    'margin_bottom' => 20,
                    'margin_header' => 15,
                    'margin_footer' => 10,
                    'showImageErrors' => true
                ]);
        
                return $pdf->stream('pdf-file.pdf');
            }

             public function generatefPDF()
               {
                 $admin=Admin::get();
                 return view('pdf.fpdf-file',['admin'=>$admin ]);
               }

    }
 
