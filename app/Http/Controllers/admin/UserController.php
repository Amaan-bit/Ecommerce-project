<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Mail\UserRegisterMail;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function index(){
        $users = User::latest()->get();
        $data = compact('users');
        return view('admin.users.list')->with($data);
    }

    public function create(){
        return view('admin.users.create');
    }

    public function store(Request $request){
        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'phone'=>'required|numeric|unique:users',
            'password'=>'required|min:8'
        ]);
        $users = new User;
        $users->name = $request->name;
        $users->email = $request->email;
        $users->phone = $request->phone;
        $users->password = Hash::make($request->password);
        $users->save();
        $data = [
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>$request->password,
        ];
        Mail::to($request->email)->send(
            new UserRegisterMail($data)
        );
        return redirect()->route('admin.user.list')->with('success','User Add Successfully');
    }

    public function edit($id){
        $users = User::where('id',$id)->first();
        $data = compact('users');
        return view('admin.users.edit')->with($data);
    }

    public function update(Request $request){
        $request->validate([
            'name'=>'required',
            'email'=>'required|email',
            'phone'=>'required|numeric',
        ]);
        $users = User::find($request->id);
        $users->name = $request->name;
        $users->email = $request->email;
        $users->phone = $request->phone;
        if($request->password!=''){
            $users->password = Hash::make($request->password);
        }
        $users->save();
        return redirect()->route('admin.user.list')->with('success','User Update Successfully');  
    }

    public function delete(Request $request){
        $users = User::find($request->user_id);
        $users->delete();
        return response()->json(['status'=>true,'message'=>'User Delete Successfull']);
    }

    public function export() 
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }
}
