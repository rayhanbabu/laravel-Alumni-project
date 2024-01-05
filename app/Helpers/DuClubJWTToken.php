<?php
namespace App\Helpers;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;
 

class DuClubJWTToken
{
    public static function CreateToken($duclub_id,$member_id,$member_card,$name,$phone,$email)
    {
        //60*3= 3 minite
        $key =env('JWT_KEY');
        $payload=[
            'iss'=>'rayhan-token',
            'iat'=>time(),
            'exp'=>time()+60*60*24*365,
            'email'=>$email,
            'phone'=>$phone,
            'member_id'=>$member_id,
            'member_card'=>$member_card,
            'name'=>$name,
            'duclub_id'=>$duclub_id,
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