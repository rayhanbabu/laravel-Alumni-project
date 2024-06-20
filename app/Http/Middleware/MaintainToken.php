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

         // $TOKEN_LOGIN=$request->header('TOKEN_LOGIN');
         $alumni_maintain=$request->cookie('alumni_maintain');
         $result=MaintainJWTToken::ReadToken($alumni_maintain);
         if($result=="unauthorized"){
              return response()->json([
                  'status'=>500,
                  'errors'=> 'Unauthorized',
               ]); 
          }else{
              $request->headers->set('email',$result->email);
              $request->headers->set('maintain_id',$result->maintain_id);
              $request->headers->set('maintain_username',$result->maintain_username);
              $request->headers->set('role',$result->role);
              $request->headers->set('phone',$result->phone);
             return $next($request);
        }
    }
}
