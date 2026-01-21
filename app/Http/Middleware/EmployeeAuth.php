<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class EmployeeAuth
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
        $path=$request->path();
      

        if(( $path == "employee-login") && Session::get('emp_id')){
            return redirect('employee/home');
        }
        else if(($path != 'employee-login') && (!Session::get('emp_id'))){
            return redirect('/employee-login');
        }
       return $next($request);
    }
}
