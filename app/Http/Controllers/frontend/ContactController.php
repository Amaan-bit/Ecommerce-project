<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function contact(){
        return view('frontent.contact-us');
    }

    public function contactData(Request $request){
        dd($request->all());
        $validate = Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required|email',
            'message'=>'required',
            'image'=>'required|image',
            'status'=>'required|in:1,0'
        ]);

        if($validate->passes()){

        }else{
            return response()->json(['status'=>201,'error'=>$validate->errors()]);
        }
    }
}
