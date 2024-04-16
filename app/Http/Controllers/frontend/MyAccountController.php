<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use App\Models\Products;
use App\Models\CustomerAddresses;
use App\Models\Orders;
use App\Models\OrderItems;
use App\Models\User;

class MyAccountController extends Controller
{
    public function account(){
        $account = User::find(Auth::user()->id);
        $title = 'my-account';
        $data = compact('title','account');
        return view('frontent.account')->with($data);
    }

    public function update_info(Request $request){
        $request->validate([
            'name'=>'required',
            'email'=>'required|email',
            'phone'=>'required|max:10|min:10',
        ]);     
        $exist_email = User::where('email',$request->email)->where('id','!=',Auth::user()->id)->first();
        $exist_phone = User::where('phone',$request->phone)->where('id','!=',Auth::user()->id)->first();
        if(!empty($exist_email)){
            return redirect()->route('front.account')->with('error','Email already Exist!');
        }
        if(!empty($exist_phone)){
            return redirect()->route('front.account')->with('error','Phone number already Exist!');
        }
        $user = User::find(Auth::user()->id);      
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->save();
        return redirect()->route('front.account')->with('success','Profile update successfully');

    }

    public function myAddress(){
        $customerAddress = CustomerAddresses::find(Auth::user()->id);
        $title = 'my-address';
        $data = compact('title','customerAddress');
        return view('frontent.address')->with($data);
    }

    public function updateAddress(Request $request){
        $request->validate([
            'first_name'=>'required',
            'last_name'=>'required',
            'email'=>'required|email',
            'address'=>'required',
            'city'=>'required',
            'state'=>'required',
            'zip'=>'required|numeric',
            'mobile'=>'required|numeric',
        ]);

        $user_id = Auth::user()->id;

        CustomerAddresses::UpdateOrCreate(
            ['user_id'=>$user_id],
            [
                'first_name'=>$request->first_name,
                'last_name'=>$request->last_name,
                'email'=>$request->email,
                'address'=>$request->address,
                'apartment'=>$request->apartment,
                'city'=>$request->city,
                'state'=>$request->state,
                'zip'=>$request->zip,
                'mobile'=>$request->mobile
            ]
        );            
        return redirect()->route('front.myaddress')->with('success','Address update successfully');

    }

    public function myOrders(){
        $userId = Auth::user()->id;
        $orders = Orders::where('user_id',$userId)->latest()->paginate(10);
        $title = 'my-order';
        $data = compact('orders','title');
        return view('frontent.my-orders')->with($data);
    }

    public function orderDetail($orderId){
        $orders = Orders::where('orderId',$orderId)->first();
        if(!empty($orders)){
            $order_id = $orders->id;
        }else{
            abort(404);
        }
        $title = 'my-order';
        $orderItems = DB::table('order_items')->join('products','order_items.product_id','=','products.id')->select('order_items.*','products.image','products.slug')->where('order_id',$order_id)->get();
        $data = compact('orders','orderItems','title');
        return view('frontent.order-detail')->with($data);
    }

    public function change_password(){
        $title='change-password';
        $data = compact('title');
        return view('frontent.change-password')->with($data);
    }

    public function change_password_process(Request $request){
        $request->validate([
            'old_password'=>'required',
            'new_password'=>'required|string|min:8',
            'confirm_password'=>'required|same:new_password'
        ]);

        if(Hash::check($request->old_password,Auth::user()->password)){
            $user = User::find(Auth::user()->id);
            $user->password = Hash::make($request->new_password);
            $user->save();
            return redirect()->route('front.changePassword')->with('success','Password has been changed');
        }else{
           return redirect()->route('front.changePassword')->with('error','Old Password Not Matched');
        }
    }
}
