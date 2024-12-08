<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use Yajra\DataTables\DataTables;
use App\Models\Nonmember;

class InvoiceMaintainController extends Controller
{
    
     
    public function invoice_index(Request $request)
    {
        if ($request->ajax()) {
            $data = Invoice::leftJoin('members', 'members.id', '=', 'invoices.member_id')
                ->leftJoin('apps', 'apps.id', '=', 'invoices.category_id')
                ->select(
                    'members.member_card',
                    'members.name',
                    'members.phone',
                    'apps.category',
                    'invoices.*'
                )
                ->latest()
                ->get();
    
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('edit', function ($row) {
                    $btn = '<button type="button"  
                        data-payment_method="' . $row->payment_method . '"  
                        data-payment_status="' . $row->payment_status . '"  
                        data-bank_tran="' . $row->bank_tran . '"  
                        data-invoice_id="' . $row->id . '"  
                        data-name="' . $row->name . '" 
                        class="edit btn btn-info btn-sm">Edit</button>';
                    return $btn;
                })
                ->addColumn('delete', function ($row) {
                    $btn = '<a href="#" 
                        onclick="return confirm(\'Are you sure you want to delete this item?\')" 
                        class="delete btn btn-danger btn-sm">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['edit', 'delete'])
                ->make(true);
        }
    
        return view('maintain.invoice');
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



public function non_invoice_index(Request $request)
{
    if ($request->ajax()) {
        $data = Nonmember::leftJoin('apps', 'apps.id', '=', 'nonmembers.category_id')
            ->select(
                'apps.category',
                'nonmembers.*'
            )
            ->latest()
            ->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('edit', function ($row) {
                $btn = '<button type="button"  
                    data-payment_method="' . $row->payment_method . '"  
                    data-payment_status="' . $row->payment_status . '"  
                    data-bank_tran="' . $row->bank_tran . '"  
                    data-invoice_id="' . $row->id . '"  
                    data-name="' . $row->name . '" 
                    class="edit btn btn-info btn-sm">Edit</button>';
                return $btn;
            })
            ->addColumn('delete', function ($row) {
                $btn = '<a href="#" 
                    onclick="return confirm(\'Are you sure you want to delete this item?\')" 
                    class="delete btn btn-danger btn-sm">Delete</a>';
                return $btn;
            })
            ->rawColumns(['edit', 'delete'])
            ->make(true);
    }

    return view('maintain.non_invoice');
}



public function non_invoice_update(Request $request)
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

$data=Nonmember::where('problem_status','No')->where('id',$request->input('id'))->first();
if($data){
   return redirect()->back()->with('fail','Invoice Already Paid');
}else{
$model = Nonmember::find($request->input('id'));
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
