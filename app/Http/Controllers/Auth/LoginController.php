<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use App\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    // use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/successlogin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest')->except('logout');
    }



    public function login(Request $request)
    {
        $user = User::where('name',$request->name)->first();

        if ($user == NULL){
            return response()->json([
                'success'=> 0,
                'message'=>'Name not found'
            ]);            
        }

        if ($user->isonline){
            return response()->json([
                'success'=> 0,
                'message'=>'User already online on other device'
            ]);
        }

        if (Auth::attempt(['name' => $request->name,'password'=>$request->password]))
        {
            $user = auth()->user();
            $user->isonline = true;
            $user->save();
            return response()->json([
                'success'=> 1
            ]);
        }else{
            return response()->json([
                'success'=> 0,
                'message'=> 'Wrong name/password'
            ]);
        }
    }


}
