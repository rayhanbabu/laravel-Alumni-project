<?php

namespace App\Http\Controllers;

use App\Models\Duclub;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Helpers\DuClubJWTToken;

class DuclubController extends Controller
{

    public function product_view(request $request)
    {
      try {    
      $dayName=$request->dayName;
       $response = Http::get('https://dhakauniversityclub.com/api/getProductByDay?dayName='.$dayName.'');
       if ($response->successful()) {
           $data = $response->json();
            return response()->json([
               'status' =>'success',
               'data' => $data,
            ],200);
          }
       } catch (Exception $e) {
           return response()->json([
              'status' => 501,
              'message' => 'Somting Error',
           ],501);
      }
    }


   
    public function duclub_login(Request $request, $phone)
    {
      try {  
        $otp=rand(1000,9999);
        $response = Http::get('https://dhakauniversityclub.com/api/getMember?mobile='.$phone);
        if ($response->successful()) {
        $data = $response->json();
        if($data['status']=='success'){
              $member= Duclub::updateOrCreate(['phone' => $phone],['phone'=>$phone ,'otp'=>$otp
              ,'member_id'=>$data['data']['id'] ,'member_card'=>$data['data']['member_code']
              ,'name'=>$data['data']['name'] ,'designation'=>$data['data']['designation']
              ,'dept'=>$data['data']['dept'] ,'email'=>$data['data']['email']
            ]); 
             
                //     $subject='DU Club OTP';  
                //     $title='Dear ';
                //     $body='Your OTP is';
                //     $link='';
                //     $name='ANCOVA';  
                //     $details = [
                //      'subject' => $subject,
                //      'title' => $title,
                //      'otp_code' => $otp,
                //      'link' => $link,
                //      'body' => $body,
                //      'name' => $name,

                //PLEASE ENTER YOUR MOBILE PHONE NUMBER
                //We've sent a 4-digit one time PIN in your phone
                //please enter 4 digit one time pin
                //Your DU Club One-Time PIN is 32432
                //     ];
                //  Mail::to($data['data']['email'])->send(new \App\Mail\ForgetMail($details));

             $url = 'https://www.24bulksmsbd.com/api/smsSendApi';
             $msg="Your DU Club One-Time PIN is ".$otp;
                $data = array(
                  'customer_id' => 182,
                  'api_key' => 1.7298318410087E+26,
                  'message' =>$msg,	
                  'mobile_no' => $phone
                );
                
                $curl = curl_init($url);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);     
                $output = curl_exec($curl);
                curl_close($curl);
                $output;

                  return response()->json([
                        'status' => 'success',
                        'message' => "We've sent a 4-digit One-Time PIN in your phone ",
                   ],200);       
            }else{
                return response()->json([
                    'status' => 'fail',
                    'message' => "Phone number not registered ",
                ],400);      
            }
                
        }else{
            return response()->json([
                'status' =>  'fail',
                'message' => "Internal Server Error",
             ],501);
        }
        
       } catch (Exception $e) {
           return response()->json([
              'status' => 501,
              'message' => 'Something error',
           ],501);
      }

    }



    public function duclub_VerifyLogin(Request $request ,$phone,$otp)
    {
            $duclub= Duclub::where('phone',$phone)->where('otp',$otp)->first();
            if($duclub){
                 Duclub::updateOrCreate(['phone' => $phone],['phone'=>$phone,'otp'=>'0']);
                 $duclub_token = DuClubJWTToken::CreateToken($duclub->id,$duclub->member_id,$duclub->member_card
                 ,$duclub->name,$duclub->phone,$duclub->email);
                 return response()->json([
                       'status' => "success",
                       'name' => $duclub->name,
                       'card' => $duclub->member_card,
                       'duclub_token' => $duclub_token,
                  ],200);
             }else{
                  return response()->json([
                    'status' =>'fail',
                    'data' => "Invalid OTP Code",
                  ],421);
            }
    }


      
    public function member_ledger(request $request)
    {
      try {    
           $from=$request->from;
           $to=$request->to; 
           $member_id=$request->header('member_id');

      $response = Http::get('https://www.dhakauniversityclub.com/api/memberLedger?memberID='.$member_id.'&from='.$from.'&to='.$to.'');
        if ($response->successful()) {
        $data = $response->json();
        return response()->json([
             'status' =>'success',
             'data' => $data,
         ],200);

        }
  
       } catch (Exception $e) {
           return response()->json([
              'status' => 501,
              'message' => 'Somting Error',
           ],501);
      }
    }



    public function product_add(request $request)
    {
    //  try {    
      $productID=$request->productID;
      $qty=$request->qty;
      $price=$request->price;
      $priority=$request->priority;
      $member_id=$request->header('member_id');
      $date= date('Y-m-d');

     
      $data = [
          'customer' => $member_id,
          'warehouseID' => '4',
          'saleDate' => $date,
          'invoiceDate' => $date,
          'subTotal' => '6.00',
          'vat' => '0',
          'vatPertan' => '0',
          'discountType' => '0',
          'discountPercent' => '',
          'discount' => '0',
          'totalAmount' => '6.00',
          'r1' => '3',
          'extra_sms' => '0',
          'submitBtn' => '',
          'priority' => $priority,
          'qty' => $qty,
          'productID' => $productID,
          'price' => $price,
      ];
    
    //   die();
      
      $response = Http::asForm()->post('https://www.dhakauniversityclub.com/api/salesStore', $data);
     
      if ($response->successful()) {
           $data = $response->json();
           if($data['status']=='success'){
             return response()->json([
                   'status' => 'success',
                   'message' => 'Order Place Successfull',
               ], 200);
            }
       }
      //  } catch (Exception $e) {
      //      return response()->json([
      //         'status' => 501,
      //         'message' => 'Someting Error',
      //      ],501);
      // }
    }



    public function pending_product_view(request $request)
    {
      try {    
           $member_id=$request->header('member_id');
           $to= date('Y-m-d');
           $next=-1;
           $from=date('Y-m-d',strtotime("+".$next." month"));
      $response = Http::get('https://www.dhakauniversityclub.com/api/salesQueues?memberID='.$member_id.'&from='.$from.'&to='.$to.'');
        if ($response->successful()) {
        $data = $response->json();
       if( $data['status']=='success'){
           return response()->json([
              'status' =>'success',
              'data' =>$data['data'],
          ],200);

        }else{
          return response()->json([
            'status' =>'success',
            'data' =>[],
        ],200);
        }

        }
  
       } catch (Exception $e) {
           return response()->json([
              'status' => 501,
              'message' => 'Somting Error',
           ],501);
      }
    }


    public function product_delete(request $request,$saleID)
    {
      try {    
       $member_id=$request->header('member_id');
       $response = Http::get('https://www.dhakauniversityclub.com/api/destroy?memberID='.$member_id.'&salesID='.$saleID.'');
        if ($response->successful()) {
        $data = $response->json();
        if( $data['status']=='success'){
          return response()->json([
             'status' =>'success',
             'message' => 'Order deleted successfully',
         ],200);

       }else{
         return response()->json([
           'status' =>'fail',
           'message' =>"Data Not Found",
       ],400);
       }

        }
  
       } catch (Exception $e) {
           return response()->json([
              'status' => 501,
              'message' => 'Somting Error',
           ],501);
      }
    }








}
