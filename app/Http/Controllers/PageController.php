<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class PageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function home(Request $request)
    {
        if (Auth::check()) {
            if($request->user()->role == 'admin'){
                return redirect(route('admin_dashboard'));
            }else if($request->user()->role == 'user'){
                return redirect(route('user_dashboard'));
            }else{
                return redirect(route('login'));
            }
        }
        return view('welcome');
    }

}
