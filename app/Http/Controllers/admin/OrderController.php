<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Brands;
use App\Models\Products;
use App\Models\ProductGallery;
use App\Models\CustomerAddresses;
use App\Models\Orders;
use App\Models\OrderItems;
use App\Models\Transaction;
use App\Mail\OrderStatusMail;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function index(){
        $orders = Orders::latest()->get();
        $data = compact('orders');
        return view('admin.orders.list')->with($data);
    }

    public function order_detail($orderId){
        $orders = Orders::where('orderId',$orderId)->first();
        if(!empty($orders)){
            $order_id = $orders->id;
        }else{
            abort(404);
        }
        $transaction = Transaction::where('orderId',$orderId)->first();
        $orderItems = DB::table('order_items')->join('products','order_items.product_id','=','products.id')->select('order_items.*','products.image','products.slug')->where('order_id',$order_id)->get();
        $data = compact('orders','orderItems','transaction');
        return view('admin.orders.detail')->with($data);
    }

    public function order_status(Request $request){
        $request->validate([
            'status'=>'required'
        ]);
        $order = Orders::find($request->id);
        $order->order_status = $request->status;
        $order->save();
        $data = [
            'name'=>$order->first_name.' '.$order->last_name,
            'orderId'=>$order->orderId,
            'status'=>$request->status,
        ];
        Mail::to($order->email)->send(new OrderStatusMail($data));
        
        return redirect()->route('admin.order.detail',$order->orderId)->with('success','Order status update successfully');
    }
}
