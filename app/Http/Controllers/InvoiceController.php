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
use PDF;
use Illuminate\Support\Facades\Mail;


class InvoiceController extends Controller
{

  public function amarpay_epay($username, $tran_id)
  {

   // try {
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
    // } catch (Exception $e) {
    //   return "Something Error. please try again";
    // }

  }


  public function amarpay_payment($tran_id)
  {
    //try {
     
      $data=Invoice::leftjoin('members','members.id','=','invoices.member_id')
        ->where('invoices.tran_id',$tran_id)
        ->select('members.member_card','members.name','members.phone','members.email'
       ,'members.city','members.country','invoices.*')->first();

  
      $tran_id = $tran_id;  //unique transection id for every transection 
      $currency = "BDT"; //aamarPay support Two type of currency USD & BDT  

      $amount = $data->total_amount;   // 10 taka is the minimum amount for show card option in aamarPay payment gateway


         $url ='https://secure.aamarpay.com/jsonpost.php';
         $store_id ='amaderthikana';
         $signature_key ='e270a2a831529d4e89721ee48d3d8499';
  
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
        "desc": "' . $data->category_id . '",
        "cus_name": "' . $data->name . '",
        "cus_email": "' . $data->email . '",
        "cus_add1": "' . $data->member_card . '",
        "cus_add2": "DU",
        "cus_city": "' . $data->city . '",
        "cus_state": "' . $data->city . '",
        "cus_postcode": "1206",
        "cus_country": "' . $data->country . '",
        "cus_phone": "' . $data->phone . '",
        "opt_a":"' . $data->id . '" ,
        "opt_b":"' . $data->web_link . '" ,
        "opt_c":"' . $data->admin_name . '" ,
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

    
    // } catch (Exception $e) {
    //   return "Something Error. please try again";
    // }
  }



  public function amarpay_success(Request $request)
  {
    try {
      $request_id = $request->mer_txnid;
       

      $success_url ='https://secure.aamarpay.com/api/v1/trxcheck/request.php';
      $store_id ='amaderthikana';
      $signature_key ='e270a2a831529d4e89721ee48d3d8499';

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
      $model->bank_tran = $success['bank_trxid'];
      $model->problem_status = 'No';
      $model->update();

      $invoice=Invoice::leftjoin('members','members.id','=','invoices.member_id')
      ->leftjoin('apps','apps.id','=','invoices.category_id')
      ->leftjoin('admins','admins.admin_name','=','invoices.admin_name')
      ->where('invoices.admin_name',$model->admin_name)->where('invoices.id',$model->id)
      ->where('invoices.payment_status',1)->where('payment_type','Online')->select('members.member_card','members.name','members.email'
      ,'admins.nameen' ,'admins.address','admins.mobile','admins.email as admin_email'
      ,'members.phone','apps.category','invoices.*')->orderBy('payment_date', 'asc')->first();
 
       $data['title']=$invoice->nameen;
       $data['file']=$invoice->nameen;
       $data['address']=$invoice->address;
       $data['admin_mobile']=$invoice->mobile;
       $data['admin_email']=$invoice->admin_email;

       $data['email']=$invoice->email;
       $data['phone']=$invoice->phone;
       $data['name']=$invoice->name;
       $data['tran_id']=$invoice->tran_id;
       $data['category']=$invoice->category;
       $data['payment_method']=$invoice->payment_method;
       $data['payment_time']=$invoice->payment_time;
       $data['total_amount']=$invoice->total_amount;

       $data['registration']=$invoice->registration;
       $data['department']=$invoice->department;

       $pdf = PDF::loadView('pdf.auto_invoice',$data);
        Mail::send('pdf.auto_invoice',$data,function($message) use ($data,$pdf){
           $message->to($data['email'])
            ->subject($data['title'])
            ->attachData($pdf->output(),$data['file'].".pdf");       
       });
     
     
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
      $panel = $request->panel;
    
      // $success_url =env('SUCCESS_URL');
      // $store_id =env('STORE_ID');
      // $signature_key =env('SIG_KEY');

      $success_url ='https://secure.aamarpay.com/api/v1/trxcheck/request.php';
      $store_id ='amaderthikana';
      $signature_key ='e270a2a831529d4e89721ee48d3d8499';

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
      if($panel=='admin'){
         return view('admin.invoice_search', ["data" =>$data]);
      }else{
        return view('maintain.invoice_search', ["data" =>$data]);
      }
      
     }
     
    } catch (Exception $e) {
      return "Something Error. please try again";
    }
  }
}
