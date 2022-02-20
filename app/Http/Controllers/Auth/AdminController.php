<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admin');
    }
    protected function guard()
    {
        return Auth::guard('admin');
    }
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
         //validate the form
        $this->validate($request,[
            'email'=>'required|email',
            'password'=>'required|min:6'
        ]);

        //attempt to login
        if(Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password],$request->remember))
        {

            return redirect()->intended(route('admin.dashboard.home'));
        }
        Session::flash('errorAdmin',"Invalid Email or password");
        return redirect()->back()->withInput($request->only('email','remember'));
    }
    function logout(Request $request)
    {
        $sessionKey=$this->guard()->getName();
        $this->guard()->logout();
        $request->session()->forget($sessionKey);
        return Redirect::route('admin.login');
    }

}
