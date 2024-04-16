<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use Session;
use App\Models\User;
use App\Models\Otp;
use App\Mail\OtpMail;

class AuthController extends Controller
{
    public function login(){
        return view('frontent.login');
    }

    public function authentication(Request $request){
        $request->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);

        if(Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password])){
            if(session()->has('url.intended')){
                return redirect(session()->get('url.intended'));
            } 
            return redirect()->route('front.home');
        }else{
            return redirect()->route('front.login')->with('error','Cradiantials Do Not Match!');
        }
    }

    public function logout(){
        Auth::guard('web')->logout();
        session()->forget('url.intended');
        return redirect()->route('front.login');
    }

    public function register(){
        return view('frontent.register');
    }

    public function registration(Request $request){
        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'phone'=>'required|min:10|max:10|unique:users',
            'password'=>'required',
            'confirm_password'=>'required|same:password'
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect()->route('front.login')->with('success','You have register successfully');
    }

    public function forget_password(){
        return view('frontent.forget-password');
    }

    public function email_verify(Request $request){
        $request->validate([
            'email'=>'required|email'
        ]);
        $user = User::where('email', $request->email)->first();
        if(!empty($user)){
            $otp = rand(1000, 9999);
            Otp::updateOrCreate(
                ['user_id' => $user->id],
                ['otp' => $otp]
            );
            Session::put('user_id', $user->id);
            $data = [
                'name'=>$user->name,
                'otp'=>$otp
            ];
            Mail::to($request->email)->send(
                new OtpMail($data)
            );
            return redirect()->route('front.otp')->with('success','Otp successfully send on your email');
        }else{
            return redirect()->route('front.forget')->with('error','Email does not exist');
        }
    }

    public function otp(){
        return view('frontent.otp');
    }

    public function otp_verify(Request $request){
        $otp = $request->otp;
        $otp_table = Otp::where('user_id',$request->user_id)->where('otp',$otp)->first();
        if(!empty($otp_table)){
            $updated_at = date('H:i:s',strtotime($otp_table->updated_at));
            $start_time = strtotime($updated_at);
            $current_time = strtotime(date('H:i:s'));
            $minute_difference = $current_time - $start_time;
            if($minute_difference <= 180) {
                return response()->json(['status'=>true,'message'=>'Otp verify successfull']);
            }else{
                return response()->json(['status'=>false,'message'=>'Otp Expired']);
            }
        }else{
            return response()->json(['status'=>false,'message'=>'Invalid otp']);
        }
    }

    public function resend_otp($user_id){
        $user = User::where('id', $user_id)->first();
        if(!empty($user)){
            $otp = rand(1000, 9999);
            Otp::updateOrCreate(
                ['user_id' => $user->id],
                ['otp' => $otp]
            );
            Session::put('user_id', $user->id);
            $data = [
                'name'=>$user->name,
                'otp'=>$otp
            ];
            Mail::to($user->email)->send(
                new OtpMail($data)
            );
            return redirect()->route('front.otp')->with('success','Otp successfully send on your email');
        }else{
            return redirect()->route('front.forget')->with('error','Something Went Wrong');
        }
    }

    public function new_password(){
        if(session()->has('user_id')){
            return view('frontent.new-password');
        }else{
            return redirect()->route('front.forget');
        }
        
    }

    public function new_password_process(Request $request){
        $request->validate([
            'new_password'=>'required|string|min:8',
            'confirm_password'=>'required|same:new_password'
        ]);

        $user = User::find($request->user_id);
        if(!empty($user)){
            $user->password = Hash::make($request->new_password);
            $user->save();
            Session::forget('user_id');
            return redirect()->route('front.login')->with('success','Password change successfully');
        }else{
            return redirect()->route('front.new.password')->with('error','Something went wrong');
        }
        
    }

    public function redirectToGoogle(){
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $google = Socialite::driver('google')->user();
            $user = User::where('email',$google->email)->first();
            if(!empty($user)){
                $user->google_id = $google->id;
                $user->save();
                Auth::login($user);
                if(session()->has('url.intended')){
                    return redirect(session()->get('url.intended'));
                } 
                return redirect()->route('front.home');
            }else{
                $new_user = new User;
                $new_user->name = $google->name;
                $new_user->email = $google->email;
                $new_user->google_id = $google->id;
                $new_user->password = Hash::make($google->email);
                $new_user->save();
                Auth::login($new_user);
                if(session()->has('url.intended')){
                    return redirect(session()->get('url.intended'));
                } 
                return redirect()->route('front.home');
            }
      
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    public function redirectToFacebook(){
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        try {
      
            $user = Socialite::driver('facebook')->user();
            dd($user);
      
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
