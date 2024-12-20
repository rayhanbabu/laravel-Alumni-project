<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Cookie;
use App\Helpers\MaintainJWTToken;

class MaintainTokenExist
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
     {
        $alumni_maintain=$request->cookie('alumni_maintain');
        $result=MaintainJWTToken::ReadToken($alumni_maintain);
         if($result=="unauthorized"){
             return $next($request);
         }else{
             return redirect('/maintain/dashboard');
          }
      }
}
