<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Helpers\AlumniJWTToken;
use Illuminate\Support\Facades\Cookie;

class AlumniToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
         $alumni_token=Cookie::get('alumni_token');
         $result=AlumniJWTToken::ReadToken($alumni_token);
         if($result=="unauthorized"){
                return redirect('/admin/login');
          }else{ 
                $request->headers->set('email',$result->email);
                $request->headers->set('phone',$result->phone);
                $request->headers->set('name',$result->name);
                $request->headers->set('id',$result->id);
                $request->headers->set('admin_name',$result->admin_name);
                return $next($request);
           }
    }
}
