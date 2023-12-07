<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use App\Models\Maintain;
use App\Models\Admin;
use App\Models\Member;
use Exception;
use App\Models\App;


class InvoiceController extends Controller
{

  public function amarpay_epay($username, $tran_id)
  {

    try {
           $invoice = Invoice::where('admin_name', $username)->where('tran_id', $tran_id)
            ->select('tran_id','member_id','payment_status','created_at','category_id','total_amount')->first();
      if ($invoice) {
           $admin = Admin::where('admin_name', $username)->select('other_link','senior_size','nameen'
            ,'address','phone')->first();
            $member = Member::where('id', $invoice->member_id)->select('name','email','phone')->first();
            $category = App::where('id', $invoice->category_id)->select('category')->first();
        if($admin->senior_size==1){
               return view('web.invoicePayment', ['invoice' => $invoice, 'admin' => $admin,'member' => $member,'category'=>$category ]);
           }else{
               return "Online payment getway No Access Available";
          }

      } else {
        return "Invalid Url";
      }
    } catch (Exception $e) {
      return "Something Error. please try again";
    }

  }


  public function amarpay_payment($tran_id)
  {
    try {
      $invoice = Invoice::where('tran_id', $tran_id)->first();
      $member = Member::where('id', $invoice->member_id)->first();
      $admin = Admin::where('admin_name', $invoice->admin_name)->select('other_link','senior_size')->first();

   
     

      $tran_id = $tran_id;  //unique transection id for every transection 
      $currency = "BDT"; //aamarPay support Two type of currency USD & BDT  

      $amount = $invoice->total_amount;   // 10 taka is the minimum amount for show card option in aamarPay payment gateway

      //For live Store Id & Signature Key please mail to support@aamarpay.com
      //$store_id = "aamarpaytest";
      // $signature_key = "dbb74894e82415a2f7ff0ec3a97e4183";
      //$url = "https://​sandbox​.aamarpay.com/jsonpost.php"; // for Live Transection use "https://secure.aamarpay.com/jsonpost.php"

        $url =env('MERCHANT_URL');
        $store_id =env('STORE_ID');
        $signature_key =env('SIG_KEY');
  

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
        CURLOPT_POSTFIELDS => '{
        "store_id": "' . $store_id . '",
        "tran_id": "' . $tran_id . '",
        "success_url": "' . route('amarpay_success') . '",
        "fail_url": "' . route('amarpay_fail') . '",
        "cancel_url": "' . route('amarpay_cancel') . '",
        "amount": "' . $amount . '",
        "currency": "' . $currency . '",
        "signature_key": "' . $signature_key . '",
        "desc": "' . $invoice->category_id . '",
        "cus_name": "' . $member->name . '",
        "cus_email": "' . $member->email . '",
        "cus_add1": "' . $member->id . '",
        "cus_add2": "Mohakhali DOHS",
        "cus_city": "' . $member->city . '",
        "cus_state": "' . $member->city . '",
        "cus_postcode": "1206",
        "cus_country": "' . $member->country . '",
        "cus_phone": "' . $member->phone . '",
        "opt_a":"' . $invoice->id . '" ,
        "opt_b":"' . $admin->other_link . '" ,
        "opt_c":"' . $invoice->admin_name . '" ,
        "type": "json"
    }',
        CURLOPT_HTTPHEADER => array(
          'Content-Type: application/json'
        ),
      ));

      $response = curl_exec($curl);

      curl_close($curl);
      //dd($response);
    

      $responseObj = json_decode($response);

      if (isset($responseObj->payment_url) && !empty($responseObj->payment_url)) {

        $paymentUrl = $responseObj->payment_url;
        // dd($paymentUrl);
        return redirect($paymentUrl);
      } else {
        echo $response;
      }

    
    } catch (Exception $e) {
      return "Something Error. please try again";
    }
  }



  public function amarpay_success(Request $request)
  {
    try {
      $request_id = $request->mer_txnid;
      //verify the transection using Search Transection API 
      $success_url =env('SUCCESS_URL');
      $store_id =env('STORE_ID');
      $signature_key =env('SIG_KEY');

      $url = $success_url."?request_id=$request_id&store_id=$store_id&signature_key=$signature_key&type=json";

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
      // echo  $response;

      //database working part 
      $success = json_decode($response, true);
      //echo $success['status_code'];
      $payment_date = date('Y-m-d', strtotime($success['date_processed']));
      $payment_day = date('d', strtotime($success['date_processed']));
      $payment_month = date('n', strtotime($success['date_processed']));
      $payment_year = date('Y', strtotime($success['date_processed']));

    
      $model = Invoice::find($success['opt_a']);
      $model->payment_status = 1;
      $model->payment_type = 'Online';
      $model->payment_time = $success['date_processed'];
      $model->payment_method = $success['payment_type'];
      $model->payment_date = $payment_date;
      $model->payment_year = $payment_year;
      $model->payment_month = $payment_month;
      $model->payment_day = $payment_day;
      $model->update();

      $admin = Admin::where('admin_name', $success['opt_c'])->first();
      $online_cur_amount=$admin->online_cur_amount;
      $total_amount=$online_cur_amount+$model->amount;
      DB::update("update admins set online_cur_amount ='$total_amount' where admin_name = '$admin->admin_name'");

  
      return view('web.payment_success', ["web_link" => $success['opt_b']]);
    } catch (Exception $e) {
     return "Something Error. please try again"; }
  }


  public function amarpay_fail(Request $request)
  {
    try {
      $fail = $request;
      return view('web.payment_fail', ["web_link" => $fail['opt_b']]);
    } catch (Exception $e) {
      return "Something Error. please try again";
    }
  }

  public function amarpay_cancel()
  {
    return 'Payment Canceled. Please try again';
  }



  public function amarpay_search(Request $request)
  {
    try {
      $tran_id = $request->tran_id;
    
      $success_url =env('SUCCESS_URL');
      $store_id =env('STORE_ID');
      $signature_key =env('SIG_KEY');

      $url = $success_url."?request_id=$tran_id&store_id=$store_id&signature_key=$signature_key&type=json";
 
       //return $url;
     // die();
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
   
      $data = json_decode($response, true);
    if ($data === null) {
        echo "JSON decoding failed.";
    } else {
      return view('admin.invoice_search', ["data" =>$data]);
     }
     
    } catch (Exception $e) {
      return "Something Error. please try again";
    }
  }
}
