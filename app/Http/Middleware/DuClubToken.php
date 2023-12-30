<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Helpers\DuClubJWTToken;
use Illuminate\Support\Facades\Cookie;


class DuClubToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        
        $duclub_token=$request->header('duclub_token');
        //  if(!$TOKEN_LOGIN){
        //     $TOKEN_LOGIN=$request->cookie('TOKEN_LOGIN');
        // }
        
        $result=DuClubJWTToken::ReadToken($duclub_token);
        if($result=="unauthorized"){
            return response()->json([
                'status'=>500,
                'errors'=> 'Unauthorized',
             ]); 
            
        }
        else{
             $request->headers->set('email',$result->email);
             $request->headers->set('member_id',$result->member_id);
             $request->headers->set('member_card',$result->member_card);
             $request->headers->set('phone',$result->phone);
             $request->headers->set('email',$result->email);
             $request->headers->set('duclub_id',$result->duclub_id);
             return $next($request);
        }
    }
}
