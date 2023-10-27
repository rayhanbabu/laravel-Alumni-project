<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Helpers\ForgetJWTToken;
use Illuminate\Support\Facades\Cookie;


class ForgetToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        
        $TOKEN_FORGET=$request->header('TOKEN_FORGET');
       
        $result=ForgetJWTToken::ReadToken($TOKEN_FORGET);
        if($result=="unauthorized"){
            return response()->json([
                'status'=>500,
                'errors'=> 'Unauthorized',
             ]);    
        }
        else{
             $request->headers->set('email',$result->email);
             return $next($request);
        }
    }
}
