<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Helpers\AlumniJWTToken;
use Illuminate\Support\Facades\Cookie;

class AlumniTokenExist
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
              return $next($request);
          }else{
              return redirect('/admin/dashboard');
          }
    }
}
