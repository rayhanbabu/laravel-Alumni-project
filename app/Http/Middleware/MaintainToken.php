<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Helpers\MaintainJWTToken;
use Illuminate\Support\Facades\Cookie;

class MaintainToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        
        $token=$request->header('token');
        if(!$token){
            $token=Cookie::get('token');
        }
        
        $result=MaintainJWTToken::ReadToken($token);
        if($result=="unauthorized"){
            return response()->json([
                'status'=>500,
                'errors'=> 'Unauthorized',
             ]); 
            
        }
        else{
             $request->headers->set('email',$result->email);
             $request->headers->set('member_id',$result->member_id);
             $request->headers->set('admin_name',$result->admin_name);
             return $next($request);
        }
    }
}
