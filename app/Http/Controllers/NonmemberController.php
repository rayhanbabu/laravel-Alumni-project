<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Cookie;
use App\Models\Nonmember;
use Illuminate\Http\Request;
use App\Models\App;
use App\Models\Admin;
use Illuminate\Support\Facades\validator;
use Illuminate\Support\Str;
use Exception;

use PDF;
use Illuminate\Support\Facades\Mail;

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
             'registration' => 'required',
           ]);

      if ($admin) {
         if ($validator->fails()) {
            return response()->json([
               'status' => 600,
               'message' => "Registration Number Already Exists",
            ]);
         } else {
            $app = App::where('admin_name', $request->username)->where('id', $request->input('category_id'))
               ->where('admin_category','Event')->first();
               if ($app) {

              $member_count=Nonmember::where('admin_name',$request->username)->where('payment_status',1)
                ->where('category_id',$request->input('category_id'))->get();
                
              
   
            if($member_count->count()< $app->seat_no) {

                  $amount=$app->amount+$admin->blood_size;
                  $total_amount = $amount + ($amount * $admin->getway_fee) / 100;
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
                  $model->amount = $amount;
                  $model->getway_fee = $admin->getway_fee;
                  $model->total_amount = $total_amount;
                  $model->web_link = $admin->other_link;

                  $model->department = $request->input('department');
                  $model->registration = $request->input('registration');
                  $model->resident = $request->input('resident');
                  $model->gender = $request->input('gender');
                  $model->registration_type = $request->input('registration_type');
                  $model->save();

                  return response()->json([
                    'status' => 200,
                    'tran_id' => $model->tran_id,
                    'message' => 'Invoice Create Successfull',
                 ]);

                }else{
                     return response()->json([
                         'status' => 600,
                         'message' => "Seat already Booked",
                         'message1' => 'আমরা আন্তরিক দু:খিত অডিটোরিয়াম সকল  সিট বুক হয়ে গেছে। অনুগ্রহ করে রেজিষ্ট্রেশন টাইপ ফ্রী দিয়ে
                          রেজিষ্ট্রেশন করুন। TSC তে আপনাদের জন্য ব্যাবস্থা করা হবে',
                     ]);
                }
       


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
       
        $data=Nonmember::where('tran_id',$tran_id)->orderBy('id','desc')->first();
  
    
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


        $invoice=Nonmember::leftjoin('apps','apps.id','=','nonmembers.category_id')
        ->leftjoin('admins','admins.admin_name','=','nonmembers.admin_name')
        ->where('nonmembers.admin_name',$model->admin_name)->where('nonmembers.id',$model->id)
        ->where('nonmembers.payment_status',1)->where('payment_type','Online')->select(
        'admins.nameen' ,'admins.address','admins.mobile','admins.email as admin_email'
        ,'apps.category','nonmembers.*')->orderBy('payment_date', 'asc')->first();
 
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




       public function non_paymentview(Request $request)
       {
            $admin_name = $request->header('admin_name'); 
            $data = APP::where('admin_name',$admin_name)->where('status', 1)
           ->where('admin_category','Event')->orderBy('id','desc')->get();
         return view('admin.non_paymentview', ['category' => $data]);
       }
     
       public function non_fetch(Request $request)
       {
           $admin_name = $request->header('admin_name'); 
           $admin = Admin::where('admin_name', $admin_name)->first();
           $data = Nonmember::leftjoin('apps','apps.id','=','nonmembers.category_id')
             ->where('nonmembers.admin_name',$admin->admin_name)
             ->select(
               'apps.category',
               'nonmembers.*'
             )->orderBy('nonmembers.id', 'desc')->paginate(10);
           return view('admin.non_paymentview_data', compact('data'));
       }
     
     
       function non_fetch_data(Request $request)
       {
         if ($request->ajax()) {
            $admin_name = $request->header('admin_name'); 
            $admin = Admin::where('admin_name', $admin_name)->first();
            $sort_by = $request->get('sortby');
            $sort_type = $request->get('sorttype');
            $search = $request->get('search');
            $search = str_replace(" ", "%", $search);
            $data = Nonmember::leftjoin('apps', 'apps.id', '=', 'nonmembers.category_id')
             ->where('nonmembers.admin_name', $admin->admin_name)
             ->where(function ($query) use ($search) {
               $query->orwhere('nonmembers.designation', 'like', '%' . $search . '%');
               $query->orwhere('nonmembers.name', 'like', '%' . $search . '%');
               $query->orwhere('nonmembers.serial', 'like', '%' . $search . '%');
               $query->orwhere('nonmembers.phone', 'like', '%' . $search . '%');
               $query->orwhere('nonmembers.email', 'like', '%' . $search . '%');
               $query->orwhere('nonmembers.id', 'like', '%' . $search . '%');
               $query->orwhere('apps.category', 'like', '%' . $search . '%');
               $query->orwhere('nonmembers.registration', 'like', '%' . $search . '%');
               $query->orwhere('nonmembers.registration_type', 'like', '%' . $search . '%');
             })->select('apps.category', 'nonmembers.*')
              ->orderBy($sort_by, $sort_type)->paginate(10);
            return view('admin.non_paymentview_data', compact('data'))->render();
           }
       }
     
     
      

       public function add_non_payment(Request $request)
       {

        $admin_name = $request->header('admin_name'); 
        $admin = Admin::where('admin_name', $admin_name)->first();
  
         $request->validate([
           'name' => 'required',
           'category_id' => 'required',
           'email' => 'required',
           'phone' => 'required',
           'address' => 'required',
           'designation' => 'required',
         ]);


         $app = App::where('admin_name', $admin->admin_name)->where('id', $request->input('category_id'))
         ->where('admin_category','Event')->first();
         if ($app) {
            $amount=$app->amount+$admin->blood_size;
            $total_amount = $amount + ($amount * $admin->getway_fee) / 100;
            $model = new Nonmember;
            $model->category_id = $request->input('category_id');
            $model->admin_name = $admin->admin_name;
            $model->name = $request->input('name');
            $model->phone = $request->input('phone');
            $model->email = $request->input('email');
            $model->address = $request->input('address');
            $model->passing_year = $request->input('passing_year');
            $model->designation = $request->input('designation');
            $model->tran_id = Str::random(10);
            $model->amount = $amount;
            $model->getway_fee = $admin->getway_fee;
            $model->total_amount = $total_amount;
            $model->web_link = $admin->other_link;
            $model->save();

            $modelupdate = Nonmember::find($model->id);
            $modelupdate->serial = $model->id;
            $modelupdate->update();

            return back()->with('success','Data Insert Successfully');

          }else{
              return back()->with('fail','Invalid category');
          }

         $model = Nonmember::find($request->input('id'));
         $model->serial = $request->input('serial');
         $model->update();
         return back()->with('success','data Update Successfully');
       }     



       public function non_payment_update(Request $request)
       {
          
          $id = $request->id;
          $payment_method = $request->payment_method;
          $invoice = Nonmember::where('id', $id)->first();
      
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
      
            $model = Nonmember::find($id);
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



