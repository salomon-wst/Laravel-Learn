<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class AdminAuthenticated
{
    public function handle($request, Closure $next)
    {
        if( Auth::check() )
        {
            // if user is not admin take him to his dashboard
            if ( Auth::user()->isUser() ) {
                return redirect(route('user_dashboard'));
            }

            // allow admin to proceed with request
            else if ( Auth::user()->isAdmin() ) {
                return $next($request);
            }
        }else{
            return redirect(route('login'));
        }

        //abort(404);  // for other user throw 404 error
    }
}
