<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;

class AdminController extends Controller
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
    public function index()
    {
        $users=User::where('role','user')->orderBy('id','desc')->paginate(5);

        return view('adminhome',['users'=>$users]);
    }

    public function handleuser(Request $request,$id)
    {
        $user=User::find($id);
        if($user->active==1){
           $user->active=0;
        }
        else{
           $user->active=1;
        }
        $user->save();
        return response()->json(['status' => 200, 'message' => 'User status updated! '], 200);
    }
        public function profile(Request $request)
    {
        $user=User::find($request->user()->id);

        return view('adminProfile',['user'=>$user]);
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
        $user->name=$request->name;
        $user->email=$request->email;
        $user->address=$request->address;
        $user->save();

        return redirect()->route('user_dashboard')->with('success', 'Profile updated successfully!');

        }
    public function adduser()
    {
        return view('adduser');
    }
    public function saveuser()
    {
        return view('adduser');
    }
}
