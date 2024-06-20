<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminEditAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(maintain_access()->role=='Admin' || maintain_access()->admin_edit=='Yes'){ 
             return $next($request);
         }else{
             return  response('UnAthorized') ;
         } 
    }
}
