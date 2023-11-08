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

class InvoiceController extends Controller
{

  public function amarpay_epay($username, $tran_id)
  {
    try {
      $invoice = Invoice::where('admin_name', $username)->where('tran_id', $tran_id)->first();
      if ($invoice) {
        $admin = Admin::where('admin_name', $username)->select('other_link')->first();
        return view('web.amarpay_epay', ['tran_id' => $invoice->tran_id, 'web_link' => $admin->other_link]);
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
      $admin = Admin::where('admin_name', $invoice->admin_name)->select('other_link')->first();
      $tran_id = $tran_id;  //unique transection id for every transection 
      $currency = "BDT"; //aamarPay support Two type of currency USD & BDT  

      $amount = $invoice->total_amount;   //10 taka is the minimum amount for show card option in aamarPay payment gateway




      //For live Store Id & Signature Key please mail to support@aamarpay.com
      $store_id = "aamarpaytest";
      $signature_key = "dbb74894e82415a2f7ff0ec3a97e4183";
      $url = "https://​sandbox​.aamarpay.com/jsonpost.php"; // for Live Transection use "https://secure.aamarpay.com/jsonpost.php"


      $curl = curl_init();

      curl_setopt($curl, CURLOPT_URL, $url);

      // Set other cURL options as an array
      $options = array(
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
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
          "opt_c":"' . $admin->admin_name . '" ,
          "type": "json"
       }',
        // Replace $postData with your data array
        CURLOPT_HTTPHEADER => array(
          'Content-Type: application/json'
        ),
      );

      // Set the cURL options using curl_setopt_array
      curl_setopt_array($curl, $options);

      // Execute the cURL request
      $response = curl_exec($curl);

      // Handle the response and any errors
      if ($response === false) {
        // Handle cURL error
        echo 'cURL Error: ' . curl_error($curl);
      } else {

        $responseObj = json_decode($response);
        if (isset($responseObj->payment_url) && !empty($responseObj->payment_url)) {

          $paymentUrl = $responseObj->payment_url;
          // dd($paymentUrl);
          return redirect($paymentUrl);
        } else {
          echo $response;
        }
      }

      // Close the cURL session
      curl_close($curl);
    } catch (Exception $e) {
      return "Something Error. please try again";
    }
  }



  public function amarpay_success(Request $request)
  {
    try {
      $request_id = $request->mer_txnid;
      //verify the transection using Search Transection API 

      $url = "http://sandbox.aamarpay.com/api/v1/trxcheck/request.php?request_id=$request_id&store_id=aamarpaytest&signature_key=dbb74894e82415a2f7ff0ec3a97e4183&type=json";


      $curl = curl_init();
      curl_setopt($curl, CURLOPT_URL, $url);

      // Set other cURL options
      $options = array(
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTPHEADER => array(
          'Content-Type: application/json', // Add any headers required
        ),
      );

      // Set the cURL options using curl_setopt_array
      curl_setopt_array($curl, $options);

      // Execute the cURL request
      $response = curl_exec($curl);

      // Handle the response and any errors
      if ($response === false) {
        // Handle cURL error
        echo 'cURL Error: ' . curl_error($curl);
      } else {
        
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
        return view('web.payment_success', ["web_link" => $success['opt_b']]);

      }

      // Close the cURL session
      curl_close($curl);

      //database working part 
    } catch (Exception $e) {
      return "Something Error. please try again";
    }
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
      $store_id = "aamarpaytest";
      $signature_key = "dbb74894e82415a2f7ff0ec3a97e4183";

      $url = "http://sandbox.aamarpay.com/api/v1/trxcheck/request.php?request_id=$tran_id&store_id=$store_id&signature_key=$signature_key&type=json";

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
        return view('admin.invoice_search', ["data" => $data]);
      }
    } catch (Exception $e) {
      return "Something Error. please try again";
    }
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
        "success_url": "' . route('amarpay_success') . '",
        "fail_url": "' . route('amarpay_fail') . '",
        "cancel_url": "' . route('amarpay_cancel') . '",
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



}
