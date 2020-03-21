<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;


use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{
  
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    public function showLoginForm(){
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $credential = [
            'email'=>$request->email,
            'password'=>$request->password,
        ];

        if(Auth::guard('admin')->attempt($credential, $request->member)){
            return redirect()->intended(route('dashboard'));
        }
        return redirect()->back()->withInput($request->only('email,remember'));
    }


    public function logout(Request $request){
        Auth::guard('admin')->logout();
        return redirect('admin/login');
    }


}
