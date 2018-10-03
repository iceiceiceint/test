<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Http\Requests\User\RegisterRequest;
use Session;

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
    protected $redirectTo = '/home';

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
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [

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
        return User::create([
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
        ]); 
    }
    public function getRegister() {
        dd(1);
        return view('frontend.register');
    }

    public function postRegister(RegisterRequest $request) {

        $datas = $request->all();
//        dd($datas);
        $validator = $this->validator($datas);
        if($validator->fails()){
            return redirect('/')->withErrors($validator)->withInput();
        }else {
            if($this->create($datas)){
                Session::flash('success','Bạn đã đăng ký thành công , vui lòng đăng nhập');
                return redirect('/login'); 
            }else{
                Session:flash('error','Đăng ký thất bại');
                return redirect('/');
            }
        }
    }
}
