<?php
use Illuminate\Support\Facades\DB;
use App\Models\Magazine;
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
      $count=DB::table($table)->where('admin_name',$admin_name)->where('category',$category)->count();
   return $count;
}



function baseimage($path){
    //$path = 'image/slide1.jpg';
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
      return  $logo = 'data:image/' . $type . ';base64,' . base64_encode($data);
   }


   function sms_send($phonearr,$text) {
    $url = "http://bulksmsbd.net/api/smsapi";
    $api_key = "C6P8TG4mnTDDGLHosLeZ";
    $senderid = 8809617613072;
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
  $api_key ="C6P8TG4mnTDDGLHosLeZ";
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


   function fbimage(){
   if(Cookie::has('cook_user')){
         $cook_user=Cookie::get('cook_user');
         $fbimage = Magazine::where('category','Slide')->where('admin_name',$cook_user)->first();
         if($fbimage){
             return 'uploads/admin/'.$fbimage->image;
         }else{
            return 'images/slide.jpg';
         }
        
    }

}
      
