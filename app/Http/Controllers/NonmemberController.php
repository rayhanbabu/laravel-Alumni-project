<?php

namespace App\Http\Controllers;

use App\Models\Nonmember;
use Illuminate\Http\Request;
use App\Models\App;
use App\Models\Admin;
use Illuminate\Support\Facades\validator;
use Illuminate\Support\Str;
use Exception;
use Illuminate\Support\Facades\Session;

class NonmemberController extends Controller
{
   
    public function nonmember_invoice_create(Request $request)
    {

       $admin = Admin::where('admin_name', $request->username)->first();
       $validator = \Validator::make(
         $request->all(),
          [
             'name' => 'required',
             'category_id' => 'required',
             'email' => 'required',
             'phone' => 'required',
             'address' => 'required',
           ]);

      if ($admin) {
         if ($validator->fails()) {
            return response()->json([
               'status' => 700,
               'message' => $validator->messages(),
            ]);
         } else {
            $app = App::where('admin_name', $request->username)->where('id', $request->input('category_id'))
               ->where('admin_category','Event')->first();
               if ($app) {
                  $total_amount = $app->amount+$admin->blood_size + ($app->amount * $admin->getway_fee) / 100;
                  $model = new Nonmember;
                  $model->category_id = $request->input('category_id');
                  $model->admin_name = $request->username;
                  $model->name = $request->input('name');
                  $model->phone = $request->input('phone');
                  $model->email = $request->input('email');
                  $model->address = $request->input('address');
                  $model->passing_year = $request->input('passing_year');
                  $model->designation = $request->input('designation');
                  $model->tran_id = Str::random(10);
                  $model->amount = $app->amount+$admin->blood_size;
                  $model->getway_fee = $admin->getway_fee;
                  $model->total_amount = $total_amount;
                  $model->web_link = $admin->other_link;
                  $model->save();

                  return response()->json([
                    'status' => 200,
                    'tran_id' => $model->tran_id,
                    'message' => 'Invoice Create Successfull',
                 ]);

                }else{
                     return response()->json([
                         'status' => 600,
                         'message' => 'Undefind Category',
                     ]);

                }

          }
      }else{
          return response()->json([
             'status' => 600,
             'message' => 'Something Rong Or Undefind Username',
          ]);
      }

    }




    public function nonmember_amarpay_epay($username, $tran_id)
    {
  
     // try {
             $nonmember_invoice = Nonmember::where('admin_name', $username)->where('tran_id', $tran_id)->first();
        if ($nonmember_invoice) {
             $admin = Admin::where('admin_name', $username)->select('other_link','senior_size','nameen'
              ,'address','phone')->first();
            
              $category = App::where('id',$nonmember_invoice->category_id)->select('category')->first();
          if($admin->senior_size==1){
                 return view('web.nonmember_invoicePayment', ['nonmember_invoice' => $nonmember_invoice, 'admin' => $admin,'category'=>$category ]);
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



    public function nonmember_amarpay_payment( $tran_id)
    {
      //try {
       
        $data=Nonmember::where('tran_id',$tran_id)->first();
  
    
        $tran_id = $tran_id;  //unique transection id for every transection 
        $currency = "BDT"; //aamarPay support Two type of currency USD & BDT  
  
        $amount = $data->total_amount;   // 10 taka is the minimum amount for show card option in aamarPay payment gateway
  
  
           $url ='https://secure.aamarpay.com/jsonpost.php';
           $store_id ='amaderthikana';
           $signature_key ='e270a2a831529d4e89721ee48d3d8499';

        // $url ='https://sandbox.aamarpay.com';
        // $store_id ='aamarpaytest';
        // $signature_key ='dbb74894e82415a2f7ff0ec3a97e4183';
    
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
          "success_url": "' . route('nonmember_amarpay_success') . '",
          "fail_url": "' . route('nonmember_amarpay_fail') . '",
          "cancel_url": "' . route('nonmember_amarpay_cancel') . '",
          "amount": "' . $amount . '",
          "currency": "' . $currency . '",
          "signature_key": "' . $signature_key . '",
          "desc": "' . $data->category_id . '",
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
  
  


    public function nonmember_amarpay_success(Request $request)
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
  
      
        $model = Nonmember::find($success['opt_a']);
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
  
         return view('web.payment_success', ["web_link" => $success['opt_b']]);

      } catch (Exception $e) {
          return "Something Error. please try again"; }
    }


    public function nonmember_amarpay_fail(Request $request)
    {
      try {
           $fail = $request;
           return view('web.payment_fail', ["web_link" => $fail['opt_b']]);
       } catch (Exception $e) {
           return "Something Error. please try again";
       }
    }



    public function nonmember_amarpay_cancel()
     {
        return 'Payment Canceled. Please try again';
      }


      public function nonmember_invoice_view($username, $tran_id)
       {
          $data=Nonmember::where('admin_name', $username)->where('tran_id',$tran_id)->first();
            return response()->json([
             'status' => 200,
             'data' =>$data,
           ]); 
       }




       public function non_paymentview()
       {
         $data = APP::where('admin_name', Session::get('admin')->admin_name)->where('status', 1)->orderBy('id', 'desc')->get();
       
         return view('admin.non_paymentview', ['category' => $data]);
       }
     
       public function non_fetch()
       {
         if (Session::has('admin')) {
           $admin = Admin::where('admin_name', Session::get('admin')->admin_name)->first();
           $data = Nonmember::leftjoin('apps','apps.id','=','nonmembers.category_id')
             ->where('nonmembers.admin_name',$admin->admin_name)
             ->select(
               'apps.category',
               'nonmembers.*'
             )->orderBy('nonmembers.id', 'desc')->paginate(10);
           return view('admin.non_paymentview_data', compact('data'));
         }
       }
     
     
       function non_fetch_data(Request $request)
       {
         if ($request->ajax()) {
            $admin = Admin::where('admin_name', Session::get('admin')->admin_name)->first();
            $sort_by = $request->get('sortby');
            $sort_type = $request->get('sorttype');
            $search = $request->get('search');
            $search = str_replace(" ", "%", $search);
            $data = Nonmember::leftjoin('apps', 'apps.id', '=', 'nonmembers.category_id')
             ->where('nonmembers.admin_name', $admin->admin_name)
             ->where(function ($query) use ($search) {
               $query->orwhere('nonmembers.designation', 'like', '%' . $search . '%');
               $query->orwhere('nonmembers.name', 'like', '%' . $search . '%');
               $query->orwhere('nonmembers.phone', 'like', '%' . $search . '%');
               $query->orwhere('nonmembers.email', 'like', '%' . $search . '%');
               $query->orwhere('nonmembers.id', 'like', '%' . $search . '%');
               $query->orwhere('apps.category', 'like', '%' . $search . '%');
             })->select('apps.category', 'nonmembers.*')
              ->orderBy($sort_by, $sort_type)->paginate(10);
            return view('admin.non_paymentview_data', compact('data'))->render();
           }
       }
     
     



}


