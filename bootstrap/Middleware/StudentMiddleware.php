<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Session;

class StudentMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

       session_start();
        $role_id = Session::get('role_id');

        if ($role_id == 2) {
            return $next($request);
        }elseif($role_id != ""){
            return redirect()->route('student_dashboard');
        } else {
            return redirect('login');
        }
    }
}
