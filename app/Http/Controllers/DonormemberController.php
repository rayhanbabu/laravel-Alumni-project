<?php

namespace App\Http\Controllers;

use App\Models\Donormember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\validator;
use Exception;
use PDF;
use Illuminate\Support\Facades\Mail;
use App\Models\Admin;
use Illuminate\Support\Str;


class DonormemberController extends Controller
{
    
  
    public function donormember_invoice_create(Request $request)
    {

       $admin = Admin::where('admin_name', $request->username)->first();
       $validator = \Validator::make(
         $request->all(),
          [
             'name' =>'required',
             'email' =>'required',
              'phone' =>'required',
             'address' =>'required',
              'net_amount' =>'required|numeric|min:15',
           ]);

      if ($admin) {
         if ($validator->fails()) {
              return response()->json([
                 'status' => 700,
                 'message' => $validator->messages(),
              ]);
         } else if($admin->donor_gateway_status==0){
               return response()->json([
                 'status' => 600,
                 'message' => 'Donor Payment No Access',
               ]);
         } else{       
            
                  $gateway_fee=$admin->getway_fee;
                  $gateway_charge_add=$admin->gateway_charge_add;
                  $net_amount = $request->input('net_amount');

                  if($gateway_charge_add==1){
                    $total_amount = $net_amount + ($net_amount * $gateway_fee) / 100;
                    $gateway_charge=($net_amount * $gateway_fee) / 100;
                    $amount=$total_amount-$gateway_charge;
                  }else{
                    $total_amount = $net_amount;
                    $gateway_charge=($net_amount * $gateway_fee) / 100;
                    $amount=$total_amount-$gateway_charge;
                  }

                 
                  $model = new Donormember;
                  $model->admin_name = $request->username;
                  $model->name = $request->input('name');
                  $model->phone = $request->input('phone');
                  $model->email = $request->input('email');
                  $model->address = $request->input('address');
                  $model->passing_year = $request->input('passing_year');
                  $model->designation = $request->input('designation');
                  $model->tran_id = Str::random(12);
                  $model->net_amount = $net_amount;
                  $model->gateway_charge = $gateway_charge;
                  $model->gateway_charge_status = $gateway_charge_add;
                  $model->amount = $amount;
                  $model->getway_fee = $admin->getway_fee;
                  $model->total_amount = $total_amount;
                  $model->web_link = $admin->other_link;
                  $model->save();

                  return response()->json([
                      'status' => 200,
                      'tran_id' => $model->tran_id,
                      'message' => 'Invoice Create Successfull',
                  ]);

          }
        }else{
            return response()->json([
               'status' => 600,
               'message' => 'Something Rong Or Undefind Username',
            ]);
       }

    }


    public function donormember_invoice_view($username, $tran_id)
      {
          $data=Donormember::where('admin_name', $username)->where('tran_id',$tran_id)->first();
           return response()->json([
             'status' => 200,
             'data' =>$data,
           ]); 
       }



       public function donormember_amarpay_epay($username, $tran_id)
       {
     
        // try {
                $donormember_invoice = Donormember::where('admin_name', $username)->where('tran_id', $tran_id)->first();
           if ($donormember_invoice) {
                $admin = Admin::where('admin_name', $username)->select('other_link','senior_size','nameen'
                 ,'address','phone','donor_gateway_status')->first();
               
             if($admin->donor_gateway_status==1){
                    return view('web.donormember_invoicePayment', ['donormember_invoice' => $donormember_invoice, 'admin' => $admin ]);
                }else{
                    return "Online payment gateway No Access Available";
               }
     
           } else {
             return "Invalid URL";
           }
         // } catch (Exception $e) {
         //   return "Something Error. please try again";
         // }
     
       }



   public function donormember_amarpay_payment($tran_id)
    {
      //try {
       
        $data=Donormember::where('tran_id',$tran_id)->first();
        $tran_id = $tran_id;  //unique transection id for every transection 
        $currency = "BDT"; //aamarPay support Two type of currency USD & BDT  
  
        $amount = $data->total_amount;   // 10 taka is the minimum amount for show card option in aamarPay payment gateway
  
          //  $url ='https://secure.aamarpay.com/jsonpost.php';
          //  $store_id ='amaderthikana';
          //  $signature_key ='e270a2a831529d4e89721ee48d3d8499';

        $url ='https://sandbox.aamarpay.com';
        $store_id ="aamarpaytest";
        $signature_key ='dbb74894e82415a2f7ff0ec3a97e4183';   


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
          "success_url": "' . route('donormember_amarpay_success') . '",
          "fail_url": "' . route('donormember_amarpay_fail') . '",
          "cancel_url": "' . route('donormember_amarpay_cancel') . '",
          "amount": "' . $amount . '",
          "currency": "' . $currency . '",
          "signature_key": "' . $signature_key . '",
          "desc": "Donation",
          "cus_name": "' . $data->name . '",
          "cus_email": "' . $data->email . '",
          "cus_add1": "' . $data->address . '",
          "cus_add2": "DU",
          "cus_city": "' . $data->passing_year . '",
          "cus_state": "' . $data->passing_year . '",
          "cus_postcode": "1206",
          "cus_country": "Bangladesh",
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
   

    public function donormember_amarpay_success(Request $request)
    {
      try {
        $request_id = $request->mer_txnid;
         
        $success_url ='https://secure.aamarpay.com/api/v1/trxcheck/request.php';
        $store_id ='amaderthikana';
        $signature_key ='e270a2a831529d4e89721ee48d3d8499';

        // $success_url ='https://sandbox.aamarpay.com/api/v1/trxcheck/request.php';
        // $store_id ='aamarpaytest';
        // $signature_key ='dbb74894e82415a2f7ff0ec3a97e4183';

          

  
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
  
      
        $model = Donormember::find($success['opt_a']);
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


        $invoice=Donormember::leftjoin('admins','admins.admin_name','=','donormembers.admin_name')
        ->where('donormembers.admin_name',$model->admin_name)->where('donormembers.id',$model->id)
        ->where('donormembers.payment_status',1)->where('payment_type','Online')->select(
        'admins.nameen' ,'admins.address','admins.mobile','admins.email as admin_email'
        ,'donormembers.*')->orderBy('payment_date','asc')->first();
 
       $data['title']=$invoice->nameen;
       $data['file']=$invoice->nameen;
       $data['address']=$invoice->address;
       $data['admin_mobile']=$invoice->mobile;
       $data['admin_email']=$invoice->admin_email;

       $data['email']=$invoice->email;
       $data['phone']=$invoice->phone;
       $data['name']=$invoice->name;
       $data['tran_id']=$invoice->tran_id;
       $data['category']="Donation";
       $data['payment_method']=$invoice->payment_method;
       $data['payment_time']=$invoice->payment_time;
       $data['total_amount']=$invoice->total_amount;

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


    public function donormember_amarpay_fail(Request $request)
    {
      try {
           $fail = $request;
           return view('web.payment_fail', ["web_link" => $fail['opt_b']]);
       } catch (Exception $e) {
           return "Something Error. please try again";
       }
    }



    public function donormember_amarpay_cancel()
     {
        return 'Payment Canceled. Please try again';
      }






       public function donor_paymentview(Request $request)
       {
           return view('admin.donor_paymentview');
       }
     
       public function donor_fetch(Request $request)
       {
             $admin_name = $request->header('admin_name'); 
             $data = Donormember::where('admin_name',$admin_name)
             ->select('donormembers.*')->orderBy('id', 'desc')->paginate(10);
             return view('admin.donor_paymentview_data', compact('data'));
        }
     
     
       function donor_fetch_data(Request $request)
       {
         if ($request->ajax()) {
            $admin_name = $request->header('admin_name'); 
            $admin = Admin::where('admin_name', $admin_name)->first();
            $sort_by = $request->get('sortby');
            $sort_type = $request->get('sorttype');
            $search = $request->get('search');
            $search = str_replace(" ", "%", $search);
            $data = Donormember::where('donormembers.admin_name', $admin->admin_name)
             ->where(function ($query) use ($search) {
               $query->orwhere('designation', 'like', '%' . $search . '%');
               $query->orwhere('name', 'like', '%' . $search . '%');
               $query->orwhere('phone', 'like', '%' . $search . '%');
               $query->orwhere('email', 'like', '%' . $search . '%');
               $query->orwhere('id', 'like', '%' . $search . '%');
             })->select('donormembers.*')
              ->orderBy($sort_by, $sort_type)->paginate(10);
            return view('admin.donor_paymentview_data', compact('data'))->render();
           }
       }
     

       public function add_donor_payment(Request $request)
       {
          $admin_name = $request->header('admin_name'); 
          $admin = Admin::where('admin_name', $admin_name)->first();
  
          $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'designation' => 'required',
            'net_amount' =>'required|numeric|min:20',
          ]);

         $gateway_fee=$admin->getway_fee;
         $gateway_charge_add=$admin->gateway_charge_add;
         $net_amount = $request->input('net_amount');

         if($gateway_charge_add==1){
           $total_amount = $net_amount + ($net_amount * $gateway_fee) / 100;
           $gateway_charge=($net_amount * $gateway_fee) / 100;
           $amount=$total_amount-$gateway_charge;
         }else{
           $total_amount = $net_amount;
           $gateway_charge=($net_amount * $gateway_fee) / 100;
           $amount=$total_amount-$gateway_charge;
         }

            $model = new Donormember;
            $model->admin_name = $admin->admin_name;
            $model->name = $request->input('name');
            $model->phone = $request->input('phone');
            $model->email = $request->input('email');
            $model->address = $request->input('address');
            $model->passing_year = $request->input('passing_year');
            $model->designation = $request->input('designation');
            $model->tran_id = Str::random(12);
            $model->net_amount = $net_amount;
            $model->gateway_charge = $gateway_charge;
            $model->gateway_charge_status = $gateway_charge_add;
            $model->amount = $amount;
            $model->getway_fee = $admin->getway_fee;
            $model->total_amount = $total_amount;
            $model->web_link = $admin->other_link;
            $model->save();

         return back()->with('success','data Inerted Successfully');

       }  
       
       

       public function donor_payment_update(Request $request)
       {
          
          $id = $request->id;
          $payment_method = $request->payment_method;
          $invoice = Donormember::where('id', $id)->first();
      
          if ($invoice->payment_type == "Online") {
            return back()->with('fail','Online Payment Exist.Can Not Change Payment Status');
          } else {
            if ($invoice->payment_status == 0) {
              $status = 1;
              $payment_time = date('Y-m-d H:i:s');
              $payment_type = 'Offline';
            } else {
              $status = 0;
              $payment_time = date('2010-10-10 10:10:10');
              $payment_type = 'Offline';
            }
            $payment_date = date('Y-m-d');
            $payment_day = date('d');
            $payment_month = date('n');
            $payment_year = date('Y');
      
            $model = Donormember::find($id);
            $model->payment_status = $status;
            $model->payment_type = $payment_type;
            $model->payment_time = $payment_time;
            $model->payment_method = $payment_method;
            $model->payment_date = $payment_date;
            $model->payment_year = $payment_year;
            $model->payment_month = $payment_month;
            $model->payment_day = $payment_day;
            $model->update();
      
            return back()->with('success','Payment Status updated');
          }
        }





      




}
