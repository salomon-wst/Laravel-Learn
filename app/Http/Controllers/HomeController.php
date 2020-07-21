<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $user=User::find($request->user()->id);
        return view('home',['user'=>$user]);
    }
    public function updateProfile(Request $request){
        $validator = Validator::make($request->all(), [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'address' => ['required', 'string', 'min:10', 'max:450'],
        'image'=>['nullable','mimes:jpeg,jpg,png,gif']
        ]);
        if ($validator->fails()) {
        return back()->with('error',$validator->errors())->withInput();
        }
        // dd($request->all());
        $user=User::find($request->user()->id);
        $destinationPath = public_path() .'/uploads/profile';
        $extension = $request->image->getClientOriginalExtension();
        $filename = uniqid() . '.' . $extension;
        $request->image->move($destinationPath, $filename);
        $user->image=$filename;
        $user->save();

        return redirect()->route('user_dashboard')->with('success', 'Profile updated successfully!');

    }
}
