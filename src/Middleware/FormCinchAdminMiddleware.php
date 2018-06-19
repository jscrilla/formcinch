<?php

namespace Ngmedia\Formcinch\Middleware;

use Closure;

class FormCinchAdminMiddleware
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
	    if(!auth()->check()){
	    	abort(403, "You will need to login to access this page.");
	    }

	    if(count(config('formcinch.formcinch.simple_access_users'))){
		    return (!in_array(auth()->user()->id, config('formcinch.formcinch.simple_access_users'))) ? abort(403, "You do not have credentials for this page.") : $next($request);
	    }
        return $next($request);
    }
}
