<?php

namespace App\Http\Middleware;
use Auth;
use Closure;

class UserAuthenticated
{
    public function handle($request, Closure $next)
    {
        if( Auth::check() )
        {
            // if user admin take him to his dashboard
            if ( Auth::user()->isAdmin() ) {
                 return redirect(route('admin_dashboard'));
            }

            // allow user to proceed with request
            else if ( Auth::user()->isUser() ) {
                if($request->user()->active==1)
                {
                    return $next($request);
                }else{
                    $url=url()->previous();
                    $previous=explode('/',$url);
                    $last=end($previous);
                    Auth::logout();
                    $request->session()->flush();
                    $request->session()->regenerate();
                    // dd($last=='register');
                    if(strcmp($last, 'register') == 0) {
                        return redirect(route('login'))->with('success', 'Account created,will be activated by the admin shortly!');
                    }else{
                        return redirect(route('login'))->with('error', 'Account Deactivated!');
                    }
                }
                 return $next($request);
            }
        }else{
            return redirect(route('login'));
        }

        //abort(404);  // for other user throw 404 error
    }
}
