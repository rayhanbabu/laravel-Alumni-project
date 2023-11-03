<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\validator;
use Illuminate\Support\Facades\Http;
use App\Models\Maintain;
use App\Models\Member;
use Exception;

class InvoiceController extends Controller
{

    public function payment_create(request $request,$username){
        try{
        $member_id=$request->header('member_id');
        $ssl=Maintain::first();
        $validator=\Validator::make($request->all(),[    
           'invoice_id'  =>'required',
        ]
       );    

        if($validator->fails()){
           return response()->json([
               'status'=>700,
               'message'=>$validator->messages(),
          ]);
        }

         $invoice=Invoice::where('id',$request->invoice_id)->where('member_id',$member_id)->first();
         if($invoice){
         if($invoice->payment_status==1){
                 return response()->json([
                      'status'=>300,
                      'message'=>"Payment Already Paid",
                 ]); 
          }else{
               $member=Member::find($member_id);
               $response = Http::asForm()->post($ssl->init_url,[
                "store_id"=>$ssl->store_id, 
                "store_passwd"=>$ssl->store_password,
                "total_amount"=>$invoice->total_amount, 
                "currency"=>$ssl->currency, 
                "tran_id"=>$invoice->tran_id, 
                "success_url"=>"$ssl->success_url?tran_id=$invoice->tran_id",
                "fail_url"=>"$ssl->fail_url?tran_id=$invoice->tran_id",
                "cancel_url"=>"$ssl->cancel_url?tran_id=$invoice->tran_id",
                "ipn_url"=>$ssl->ipn_url,
                "cus_name"=>$member->name, 
                "cus_email"=>$member->email, 
                "cus_addl"=>$member->country,
                "cus_add2"=>$member->city, 
                "cus_city"=>$member->city,
                "cus_state"=>$member->city,
                "cus_postcode"=>"1200",
                "cus_country"=>$member->city,
                "cus_phone"=>$member->phone,
                "cus_fax"=>$member->phone,
                "shipping_method"=>"YES",
                "ship_name"=>$member->name,
                "ship_addl"=>$member->city, 
                "ship_add2"=>$member->city, 
                "ship_city"=>$member->city,
                "ship_state"=>$member->city, 
                "ship_country"=>$member->country, 
                "ship_postcode"=>"1200e",
                "product_name"=>"Apple Shop Product", 
                "product_category"=>"Apple Shop Category",
                "product_profile"=>"Apple Shop Profile",
                "product_amount"=>$invoice->total_amount, 
                 ]); 
                   return $response->json('desc'); 
             
             
          }

        }else{
            return response()->json([
              'status'=>300,
              'message'=>"Invoice Not Found",
           ]);
        }

        } catch (Exception $e){ 
            return response()->json([
                'status'=>400,
                'message'=>"Something went wrong",
             ]);
          }

             
    }


    static function payment_fail($tran_id)
     {
       Invoice::where(['tran_id'=>$tran_id,''])->update(['payment_status'=>'Fail']);
       return 1;
    } 

static function payment_success($tran_id)
  {
      Invoice::where(['tran_id'=>$tran_id])->update(['payment_status'=>1]);
       return 1; 
   } 

 static function payment_cancel($tran_id){
      Invoice::where(['tran_id'=>$tran_id])->update(['payment_status'=>'Cancel']);
       return 1;
  }


static function payment_ipn($tran_id)
  { 
      Invoice::where(['tran_id'=>$tran_id])->update(['payment_status'=>'Ipn Problem']);
      return 1; 
  } 

   
}
