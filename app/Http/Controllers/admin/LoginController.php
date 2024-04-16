<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\Admin;

class LoginController extends Controller
{
    public function login(){
        return view('admin.login');
    }


    public function authenticate(Request $request){
        $request->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]); 

        if(Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])){
            return redirect()->route('admin.dashboard');
        }else{
            return redirect()->route('admin.login')->with('error','Cradiantials Do Not Match!');
        }
    }

    public function logout(){
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }

    
}
