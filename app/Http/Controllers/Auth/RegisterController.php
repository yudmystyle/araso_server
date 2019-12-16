<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/successregister';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255','unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        // echo('here');
        // die();
        return User::create([
            'name' => $data['name'],
            'password' => Hash::make($data['password']),
            'isonline'=> false
        ]);
    }

    public function register(Request $r)
    {
        $data=[
            'name'=>$r->name,
            'password'=>$r->password
        ];
        // $r->validate([
        //     'name' => ['required', 'string', 'max:255','unique:users'],
        //     'password' => ['required', 'string'],
        // ]);
        
        $validator = $this->validator($data);

        if ($validator->fails()){
            return response()->json($validator->messages(),200);
        }

        $this->create($data);
        return response()->json([
            'success'=> 1
        ]);
    }
}
