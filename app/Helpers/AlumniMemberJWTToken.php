<?php
namespace App\Helpers;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;
 

class AlumniMemberJWTToken
{
    public static function CreateToken($maintainEmail,$maintainID,$admin_name)
    {
        //60*3= 3 minite
        $key="qomNRPiHjkS173qIm3BgIvNLQvnUpsmPfdAVbYtyuuYYYHKKMember";
        $payload=[
            'iss'=>'rayhan-token',
            'iat'=>time(),
            'exp'=>time()+60*60*48,
            'email'=>$maintainEmail,
            'member_id'=>$maintainID,
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
                $key="qomNRPiHjkS173qIm3BgIvNLQvnUpsmPfdAVbYtyuuYYYHKKMember";
                 return JWT::decode($token,new Key($key,'HS256'));
             }
        } catch (Exception $e){
            return 'unauthorized';
        }
    }

  }

?>