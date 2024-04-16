<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin;

class AuthController extends Controller
{
    public function login(Request $request){
        $validate = Validator::make($request->all(), 
        [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(!$validate->fails()){
            if(Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])){
                $admin = Admin::where('email',$request->email)->first();
                $token    =  $admin->createToken('MyAuthApp')->plainTextToken;
                return response()->json(['status'=>200,'message'=>'Login successfully','token'=>$token]);
            }else{
                return response()->json(['status'=>201,'message'=>'Crediantial do not match']);
            }
            
        }else{
            return response()->json(['status' => 201,'message' => 'validation error','errors' => $validate->errors()]);
        }
    }

    public function user_detail(Request $request){
        $validate = Validator::make($request->all(), 
        [
            'user_id' => 'required'
        ]);

        if(auth('sanctum')->check()){
            $user = auth('sanctum')->user();
            if(!empty($user)){
                if(!$validate->fails()){
                    $admin = Admin::where('id',$request->user_id)->first();
                    return response()->json(['status'=>200,'message'=>'Data get successfully','data'=>$admin]);
                }else{
                    return response()->json(['status' => '201','message' => 'validation error','errors' => $validate->errors()]);
                }
                
            }else{
                return response()->json(['status' => 502, 'message' => "Token expaired !"]);
            }
        }else{
            return response()->json(['status' => 502, 'message' => "Credentials do not match" ]);
        }
        
    }
}
