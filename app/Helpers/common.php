<?php

use App\Helpers\MaintainJWTToken;
use App\Helpers\AlumniJWTToken;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use App\Models\Magazine;
use App\Models\Nonmember;
use App\Models\Invoice;
use App\Models\Admin;
use Illuminate\Support\Facades\Cookie;

function prx($arr){
   echo "<pre>";
   print_r($arr);
   die();
}


  function admininfo($admin_name,$find){
     $admin=DB::table('admins')->where('admin_name',$admin_name)->first();
     return $admin->$find;
  }

  function countinfo($table,$admin_name,$category){
      $count=DB::table($table)->where('admin_name',$admin_name)->where('member_verify',1)->where('category',$category)->count();
     return $count;
  }


  function SendEmail($email,$subject,$body,$otp,$name){
   $details = [
     'subject' => $subject,
     'otp_code' =>$otp,
     'body' => $body,
     'name' => $name,
   ];
  Mail::to($email)->send(new \App\Mail\LoginMail($details));
}

  
   function member_category(){
         $alumni_token=Cookie::get('alumni_token');
         $result=AlumniJWTToken::ReadToken($alumni_token);
         $category=DB::table('apps')->where('admin_name',$result->admin_name)->where('admin_category','Member')->get();
        return $category;
       
    }

      function batch_category(){
            $alumni_token=Cookie::get('alumni_token');
            $result=AlumniJWTToken::ReadToken($alumni_token);
            $category=DB::table('apps')->where('admin_name',$result->admin_name)->where('admin_category','Batch')->get();
            return $category;
       }


       function profession_category(){
            $alumni_token=Cookie::get('alumni_token');
            $result=AlumniJWTToken::ReadToken($alumni_token);
            $category=DB::table('apps')->where('admin_name',$result->admin_name)->where('admin_category','Profession')->get();
              return $category;
        }

        function session_category(){
         $alumni_token=Cookie::get('alumni_token');
         $result=AlumniJWTToken::ReadToken($alumni_token);
         $category=DB::table('apps')->where('admin_name',$result->admin_name)->where('admin_category','Session')->get();
           return $category;
     }

     function show_category($id){
         $alumni_token=Cookie::get('alumni_token');
         $result=AlumniJWTToken::ReadToken($alumni_token);
         $category=DB::table('apps')->where('id',$id)->where('admin_name',$result->admin_name)->first();
         return $category?$category->category:"";
     }

   function news_category(){
      $alumni_token=Cookie::get('alumni_token');
      $result=AlumniJWTToken::ReadToken($alumni_token);
      $category=DB::table('weeks')->where('admin_name',$result->admin_name)->where('category_name','Event')->orderBy('serial','asc')->get();
      return $category;
    }

        function alumni_info(){
          $alumni_info=Cookie::get('alumni_info');
          $result=unserialize($alumni_info);
          return $result;
       }

    
  



function baseimage($path){
    //$path = 'image/slide1.jpg';
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
      return  $logo = 'data:image/' . $type . ';base64,' . base64_encode($data);
   }


   function sms_send($phonearr,$text) {
    $url = "http://bulksmsbd.net/api/smsapi";
    $api_key = "Eu7TjIcUL3QhhK7qBmdN";
    $senderid = 8809617614712;
    $number = '88'.$phonearr;
    $message = $text;
 
    $data = [
        "api_key" => $api_key,
        "senderid" => $senderid,
        "number" => $number,
        "message" => $message,
    ];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}

function get_balance() {
  $url = "http://bulksmsbd.net/api/getBalanceApi";
  $api_key ="Eu7TjIcUL3QhhK7qBmdN";
  $data = [
      "api_key" => $api_key
  ];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  $response = curl_exec($ch);
  curl_close($ch);
  return $response;
}


  function getFullURL(){
    $protocol=((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS']!='off')|| $_SERVER['SERVER_PORT']==443)?"https://":"http://";
     $host=$_SERVER['HTTP_HOST'];
     $uri=$_SERVER['REQUEST_URI'];				  
     return $protocol.$host.$uri;
      
    }

    function getURL(){
        $protocol=((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS']!='off')|| $_SERVER['SERVER_PORT']==443)?"https://":"http://";
        $host=$_SERVER['HTTP_HOST'];
        $uri=$_SERVER['REQUEST_URI'];				  
        return $protocol.$host;
        
      }


   function maintain_access(){
      $alumni_maintain=Cookie::get('alumni_maintain');
      $result=MaintainJWTToken::ReadToken($alumni_maintain);
      $maintain=DB::table('maintains')->where('id',$result->maintain_id)->first();
      return $maintain;   
   }


      function event_atten_number($admin_name,$category_id){
          $data=Invoice::leftjoin('apps', 'apps.id', '=', 'invoices.category_id')
             ->leftjoin('members', 'members.id', '=', 'invoices.member_id')
          ->where('invoices.admin_name',$admin_name)->where('invoices.category_id',$category_id)
          ->where('payment_status',1)->select('apps.category', 'invoices.*','members.name'
          ,'members.phone','members.member_card','members.serial')->orderBy('members.serial','asc')->get();
          return $data;
       }

       function event_atten_payment_type($admin_name,$category_id,$payment_type){
         $data=Invoice::where('admin_name',$admin_name)->where('category_id',$category_id)->where('payment_status',1)
         ->where('payment_type',$payment_type)->get();
         return $data;
      } 

       function non_event_atten_number($admin_name,$category_id){
          $data=Nonmember::leftjoin('apps', 'apps.id', '=', 'nonmembers.category_id')->
          where('nonmembers.admin_name',$admin_name)->where('category_id',$category_id)
          ->where('payment_status',1)->select('apps.category', 'nonmembers.*')->orderBy('nonmembers.id','asc')->get();
          return $data;
       }

       function non_event_atten_payment_type($admin_name,$category_id,$payment_type){
          $data=Nonmember::where('admin_name',$admin_name)->where('category_id',$category_id)->where('payment_status',1)
          ->where('payment_type',$payment_type)->get();
          return $data;
       } 




      
