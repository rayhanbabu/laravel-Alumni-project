<?php
namespace App\Helpers;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;
 
class AlumniJWTToken
{
    public static function CreateToken($id,$name,$email,$phone,$admin_name)
    {
          $key =env('JWT_KEY');
          $payload=[
             'iss'=>'rayhan-token',
             'iat'=>time(),
             'exp'=>time()+60*60*24*15,
             'id'=>$id,
             'email'=>$email,
             'name'=>$name,
             'phone'=>$phone,
             'admin_name'=>$admin_name
          ];
         return JWT::encode($payload,$key,'HS256');
    }

    public static function ReadToken($token)
    {
        try {
            if($token==null){
                return 'unauthorized';
            }
            else{
                $key =env('JWT_KEY');
                return JWT::decode($token,new Key($key,'HS256'));
            }
        }
        catch (Exception $e){
            return 'unauthorized';
        }
    }
}

?>