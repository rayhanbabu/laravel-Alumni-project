<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Helpers\ForgetJWTToken;
use Illuminate\Support\Facades\Cookie;

class ForgetTokenExist
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $TOKEN_FORGET=$request->header('TOKEN_FORGET');
        if(!$TOKEN_FORGET){
            $TOKEN_FORGET=Cookie::get('TOKEN_FORGET');
        }
        $result=ForgetJWTToken::ReadToken($TOKEN_FORGET);
        if($result=="unauthorized"){
            return $next($request);
        }else{
            return response()->json([
                'status'=>500,
                'errors'=> 'Unauthorized',
             ]); 
        }
    }
}
