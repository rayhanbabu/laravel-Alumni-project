<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\validator;
use App\Models\Admin;
use DB;
use Hash;
use Mail;
use Session;
use Illuminate\Support\Str;





class FormController extends Controller
{
  
    public function registration(Request $request){

        $validator=\Validator::make($request->all(),[  
             'name' => 'required',
             'phone' => 'required',
           ],
           [
             'phone.required'=>'Phone Number is required',
             'name.required'=>'Name is required',
           ]);
         
        if($validator->fails()){
              return response()->json([
                'status'=>400,
                'validate_err'=>$validator->messages(),
              ]);
         }else{
               $model= new Form;
               $model->admin_name=$request->input('admin_name');
               $model->name=$request->input('name');
               $model->phone=$request->input('phone');
               $model->email=$request->input('email')?$request->input('email'):"";
               $model->custom1=$request->input('custom1')?$request->input('custom1'):"";
               $model->custom2=$request->input('custom2')?$request->input('custom2'):"";
               $model->custom3=$request->input('custom3')?$request->input('custom3'):"";
               $model->custom4=$request->input('custom4')?$request->input('custom4'):"";
               $model->custom5=$request->input('custom5')?$request->input('custom5'):"";
               $model->custom6=$request->input('custom6')?$request->input('custom6'):"";
               $model->custom7=$request->input('custom7')?$request->input('custom7'):"";
               $model->custom8=$request->input('custom8')?$request->input('custom8'):"";
               $model->custom9=$request->input('custom9')?$request->input('custom9'):"";
               $model->custom10=$request->input('custom10')?$request->input('custom10'):"";
               $model->save();
            return response()->json([
                  'status'=>200,  
                  'message'=>'Registration Successfull',
              ]);
         }

    }


    public function customize(Request $request){
         if(Session::has('admin')){
              $admin= Admin::where('admin_name',Session::get('admin')->admin_name)->get();
          }

        return view('admin.formcustomize',['admin'=>$admin]);
      }

      public function customize_update(Request $request){

            $admin_name=$request->input('admin_name');
       
            $admin=Admin::where('admin_name',$admin_name)->first();
        
             if($admin){
                $model=Admin::find($request->input('edit_id'));
                $model->formname=$request->input('formname');
                $model->phone=$request->input('phone');
                $model->header=$request->input('header');
                $model->footer=$request->input('footer');
                $model->registration=$request->input('registration');
                $model->custom1=$request->input('custom1')?$request->input('custom1'):"";
                $model->custom2=$request->input('custom2')?$request->input('custom2'):"";
                $model->custom3=$request->input('custom3')?$request->input('custom3'):"";
                $model->custom4=$request->input('custom4')?$request->input('custom4'):"";
                $model->custom5=$request->input('custom5')?$request->input('custom5'):"";
                $model->custom6=$request->input('custom6')?$request->input('custom6'):"";
                $model->custom7=$request->input('custom7')?$request->input('custom7'):"";
                $model->custom8=$request->input('custom8')?$request->input('custom8'):"";
                $model->custom9=$request->input('custom9')?$request->input('custom9'):"";
                $model->custom10=$request->input('custom10')?$request->input('custom10'):"";
                $model->update();
                return back()->with('success','data Update'); 
                      
              }else{
                   return back()->with('success','Something rong'); 
             }
      }


      public function form_data(Request $request){
         if(Session::has('admin')){
                $data= Form::where('admin_name',Session::get('admin')->admin_name)->get();
          }
         return view('admin.formdata',['data'=>$data]);
     }
     
     
        public function form_update(Request $request){

        
            $model=Form::find($request->input('edit_id'));
            $model->name=$request->input('name');
            $model->phone=$request->input('phone');
            $model->custom1=$request->input('custom1')?$request->input('custom1'):"";
            $model->custom2=$request->input('custom2')?$request->input('custom2'):"";
            $model->custom3=$request->input('custom3')?$request->input('custom3'):"";
            $model->custom4=$request->input('custom4')?$request->input('custom4'):"";
            $model->custom5=$request->input('custom5')?$request->input('custom5'):"";
            $model->custom6=$request->input('custom6')?$request->input('custom6'):"";
            $model->custom7=$request->input('custom7')?$request->input('custom7'):"";
            $model->custom8=$request->input('custom8')?$request->input('custom8'):"";
            $model->custom9=$request->input('custom9')?$request->input('custom9'):"";
            $model->custom10=$request->input('custom10')?$request->input('custom10'):"";
            $model->verify_status=$request->input('verify_status');
            $model->comment=$request->input('comment');
            $model->update();
            return back()->with('success','data Update'); 
                  
         
  }


  public function form_delete($id){
    $notice=Form::find($id);
    $notice->delete();
    return back()->with('success','data Deleted'); 
}




public function payment(){

  $tran_id = "test".rand(1111111,9999999);//unique transection id for every transection 

  $currency= "BDT"; //aamarPay support Two type of currency USD & BDT  

  $amount = "10";   //10 taka is the minimum amount for show card option in aamarPay payment gateway
  
  //For live Store Id & Signature Key please mail to support@aamarpay.com
  $store_id = "aamarpaytest"; 

  $signature_key = "dbb74894e82415a2f7ff0ec3a97e4183"; 

  $url = "https://​sandbox​.aamarpay.com/jsonpost.php"; // for Live Transection use "https://secure.aamarpay.com/jsonpost.php"

  $curl = curl_init();

  curl_setopt_array($curl, array(
  CURLOPT_URL => $url,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
      "store_id": "'.$store_id.'",
      "tran_id": "'.$tran_id.'",
      "success_url": "'.route('success').'",
      "fail_url": "'.route('fail').'",
      "cancel_url": "'.route('cancel').'",
      "amount": "'.$amount.'",
      "currency": "'.$currency.'",
      "signature_key": "'.$signature_key.'",
      "desc": "Merchant Registration Payment",
      "cus_name": "Name",
      "cus_email": "payer@merchantcusomter.com",
      "cus_add1": "House B-158 Road 22",
      "cus_add2": "Mohakhali DOHS",
      "cus_city": "Dhaka",
      "cus_state": "Dhaka",
      "cus_postcode": "1206",
      "cus_country": "Bangladesh",
      "cus_phone": "+8801704",
      "type": "json"
  }',
  CURLOPT_HTTPHEADER => array(
      'Content-Type: application/json'
  ),
  ));

  $response = curl_exec($curl);

  curl_close($curl);
  // dd($response);
  
  $responseObj = json_decode($response);

  if(isset($responseObj->payment_url) && !empty($responseObj->payment_url)) {

      $paymentUrl = $responseObj->payment_url;
      // dd($paymentUrl);
      return redirect()->away($paymentUrl);

  }else{
      echo $response;
  }



}

public function success(Request $request){

  $request_id= $request->mer_txnid;

  //verify the transection using Search Transection API 

  $url = "http://sandbox.aamarpay.com/api/v1/trxcheck/request.php?request_id=$request_id&store_id=aamarpaytest&signature_key=dbb74894e82415a2f7ff0ec3a97e4183&type=json";
  
  //For Live Transection Use "http://secure.aamarpay.com/api/v1/trxcheck/request.php"
  
  $curl = curl_init();

  curl_setopt_array($curl, array(
  CURLOPT_URL => $url,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  ));

  $response = curl_exec($curl);

  curl_close($curl);
  echo $response;

}

public function fail(Request $request){
  return $request;
}

public function cancel(){
  return 'Canceled';
}



   
}
