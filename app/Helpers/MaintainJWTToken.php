<?php
namespace App\Helpers;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;
 

class MaintainJWTToken
{
    public static function CreateToken($maintainUsername,$maintainEmail,$maintainID,$role,$phone)
    {
        //60*3= 3 minite
        $key =env('JWT_KEY');
        $payload=[
             'iss'=>'rayhan-token',
             'iat'=>time(),
             'exp'=>time()+60*60*24*6,
             'maintain_username'=>$maintainUsername,
             'email'=>$maintainEmail,
             'maintain_id'=>$maintainID,
             'role'=>$role,
             'phone'=>$phone,
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