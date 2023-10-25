<?php
namespace App\Helpers;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;
 

class MaintainJWTToken
{
    public static function CreateToken($maintainEmail,$maintainID,$admin_name):string
    {
        $key =env('JWT_KEY');
        $payload=[
            'iss'=>'rayhan-token',
            'iat'=>time(),
            'exp'=>time()+60*60,
            'email'=>$maintainEmail,
            'member_id'=>$maintainID,
            'admin_name'=>$admin_name
        ];
        return JWT::encode($payload,$key,'HS256');
    }

    public static function ReadToken($token): string|object
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