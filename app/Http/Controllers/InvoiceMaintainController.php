<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;

class InvoiceMaintainController extends Controller
{
    
    public function invoice_index(){
        return view('maintain.invoice');
    }



     public function maintain_invoice_fetch(){
           $data=Invoice::leftjoin('members','members.id','=','invoices.member_id')
               ->leftjoin('apps','apps.id','=','invoices.category_id')
               ->select('members.member_card','members.name','members.phone'
               ,'apps.category','invoices.*')->orderBy('invoices.id','desc')->paginate(10);
           return view('maintain.invoice_data',compact('data'));
      }



  function maintain_invoice_fetch_data(Request $request)
   {
    if($request->ajax())
    {
     $sort_by = $request->get('sortby');
     $sort_type = $request->get('sorttype'); 
       $search = $request->get('search');
       $search = str_replace(" ", "%", $search);

        $data=Invoice::leftjoin('members','members.id','=','invoices.member_id')
        ->leftjoin('apps','apps.id','=','invoices.category_id')
        ->where(function($query) use ($search) {
             $query->orwhere('tran_id', 'like', '%'.$search.'%');
             $query->orWhere('name', 'like', '%'.$search.'%');
             $query->orWhere('members.phone', 'like', '%'.$search.'%');
             $query->orWhere('member_card', 'like', '%'.$search.'%');
             $query->orWhere('problem_status', 'like', '%'.$search.'%');
             $query->orWhere('invoices.admin_name', 'like', '%'.$search.'%');
         })->select('members.member_card','members.name','members.phone'
           ,'apps.category','invoices.*')->orderBy($sort_by, $sort_type)->paginate(10);


      return view('maintain.invoice_data', compact('data'))->render();          
   }
}




public function invoice_update(Request $request)
{

   $validated = $request->validate([
        'payment_method'=>'required',
        'bank_tran'=>'required',
        'payment_status'=>'required',
    ]);

    $payment_date= date('Y-m-d');
    $payment_day= date('d');
    $payment_month= date('n');
    $payment_year= date('Y');

   $data=Invoice::where('problem_status','No')->where('id',$request->input('id'))->first();
   if($data){
       return redirect()->back()->with('fail','Invoice Already Paid');
   }else{
   $model = Invoice::find($request->input('id'));
   $model->payment_method=$request->input('payment_method');
   $model->bank_tran=$request->input('bank_tran');
   $model->payment_status=$request->input('payment_status');
   $model->payment_time=date('Y-m-d H:i:s');
   $model->payment_date=$payment_date; 
   $model->payment_year=$payment_year; 
   $model->payment_month=$payment_month;  
   $model->payment_day=$payment_day; 
   $model->problem_status='Yes'; 
   $model->problem_update_time=date('Y-m-d H:i:s'); 
   $model->problem_update_by=maintain_access()->maintain_name;
   $model->save();
   return redirect()->back()->with('success','Data Updated Successfuly');
   }

   
}

}
