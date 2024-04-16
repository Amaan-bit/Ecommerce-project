<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Products;
use App\Models\CustomerAddresses;
use App\Models\Orders;
use App\Models\TempOrders;
use App\Models\Transaction;
use App\Models\OrderItems;
use App\Mail\OrderMail;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    public function checkout(){
        if(Cart::count()==0){
            return redirect()->route('front.cart');
        }
        if(Auth::guard('web')->check()){
            $items = Cart::content();
            $customerAddress = CustomerAddresses::find(Auth::user()->id);
            $data = compact('items','customerAddress');
            session()->forget('url.intended');
            return view('frontent.checkout')->with($data);
        }else{
            if(!session()->has('url.intended')){
                session(['url.intended'=>url()->current()]);
            }         
            return redirect()->route('front.login');
        } 
    }

    public function checkoutProcess(Request $request){
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

        if($request->payment_method=='cod'){
            $shipping = 0;
            $discount = 0;
            $subtotal = Cart::subtotal(2,'.','');
            $grand_total = $shipping+$subtotal;
            $orderId = date('ymd').'-'.time();
            $order = new Orders;
            $order->user_id = $user_id;
            $order->orderId = $orderId;
            $order->subtotal = $subtotal;
            $order->shipping = $shipping;
            $order->grand_total = $grand_total;
            $order->payment_method = $request->payment_method;
            $order->payment_status = 'not paid';
            $order->order_status = 'pending';
            $order->first_name = $request->first_name;
            $order->last_name = $request->last_name;
            $order->email = $request->email;
            $order->mobile = $request->mobile;
            $order->address = $request->address;
            $order->apartment = $request->apartment;
            $order->city = $request->city;
            $order->state = $request->state;
            $order->zip = $request->zip;
            $order->notes = $request->order_notes;
            $order->save();

            foreach(Cart::content() as $items){
                $orderItem = new OrderItems;
                $orderItem->order_id = $order->id;
                $orderItem->product_id = $items->id;
                $orderItem->name = $items->name;
                $orderItem->qty = $items->qty;
                $orderItem->price = $items->price;
                $orderItem->total = $items->price*$items->qty;
                $orderItem->save();

                $product = Products::find($items->id);
                $product->qty = $product->qty-$items->qty;
                $product->save();
            }
            Cart::destroy();
           
            $orders = Orders::where('id',$order->id)->first();
            $orderItems = OrderItems::where('order_id',$order->id)->get();
            $data = [
                'orders'=>$orders,
                'order_items'=>$orderItems
            ];
            Mail::to($request->email)->send(
                new OrderMail($data)
            );
            return redirect()->route('front.thanx')->with('success','Your order placed Successfully');
        }elseif($request->payment_method=='paypal'){
            $shipping = 0;
            $discount = 0;
            $subtotal = Cart::subtotal(2,'.','');
            $grand_total = $shipping+$subtotal;
            $orderId = date('ymd').'-'.time();
            $order = new TempOrders;
            $order->user_id = $user_id;
            $order->orderId = $orderId;
            $order->subtotal = $subtotal;
            $order->shipping = $shipping;
            $order->grand_total = $grand_total;
            $order->payment_method = $request->payment_method;
            $order->payment_status = 'not paid';
            $order->order_status = 'pending';
            $order->first_name = $request->first_name;
            $order->last_name = $request->last_name;
            $order->email = $request->email;
            $order->mobile = $request->mobile;
            $order->address = $request->address;
            $order->apartment = $request->apartment;
            $order->city = $request->city;
            $order->state = $request->state;
            $order->zip = $request->zip;
            $order->notes = $request->order_notes;
            $order->save();

            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $paypalToken = $provider->getAccessToken();

            $response = $provider->createOrder([
                "intent" => "CAPTURE",
                "application_context" => [
                    "return_url" => route('front.paypal.success'),
                    "cancel_url" => route('front.paypal.cancel')
                ],
                "purchase_units" => [
                    [
                        "amount" => [
                            "currency_code" => "USD",
                            "value" =>$grand_total
                        ],
                        "custom_id"=>$orderId,
                    ]
                ]
            ]);
            // dd($response);

            if(isset($response['id']) && $response['id']!=null) {
                foreach($response['links'] as $link) {
                    if($link['rel'] === 'approve') {
                        return redirect()->away($link['href']);
                    }
                }
            } else {
                return redirect()->route('front.paypal.cancel');
            }
        }


    }
    public function success(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request->token);

        if(isset($response['status']) && $response['status'] == 'COMPLETED') {
            $transaction_id = $response['purchase_units'][0]['payments']['captures'][0]['id'];
            $order_id = $response['purchase_units'][0]['payments']['captures'][0]['custom_id'];
            $amount = $response['purchase_units'][0]['payments']['captures'][0]['amount']['value'];
            $status = $response['status'];

            $tempOrder = TempOrders::where('orderId',$order_id)->first();
            $order = new Orders;
            $order->user_id = $tempOrder->user_id;
            $order->orderId = $order_id;
            $order->subtotal = $tempOrder->subtotal;
            $order->shipping = $tempOrder->shipping;
            $order->grand_total = $tempOrder->grand_total;
            $order->payment_method = 'paypal';
            $order->payment_status = 'paid';
            $order->order_status = 'pending';
            $order->first_name = $tempOrder->first_name;
            $order->last_name = $tempOrder->last_name;
            $order->email = $tempOrder->email;
            $order->mobile = $tempOrder->mobile;
            $order->address = $tempOrder->address;
            $order->apartment = $tempOrder->apartment;
            $order->city = $tempOrder->city;
            $order->state = $tempOrder->state;
            $order->zip = $tempOrder->zip;
            $order->notes = $tempOrder->order_notes;
            $order->save();

            foreach(Cart::content() as $items){
                $orderItem = new OrderItems;
                $orderItem->order_id = $order->id;
                $orderItem->product_id = $items->id;
                $orderItem->name = $items->name;
                $orderItem->qty = $items->qty;
                $orderItem->price = $items->price;
                $orderItem->total = $items->price*$items->qty;
                $orderItem->save();

                $product = Products::find($items->id);
                $product->qty = $product->qty-$items->qty;
                $product->save();
            }
            Cart::destroy();

            $transaction = new Transaction;
            $transaction->user_id = $order->user_id;
            $transaction->orderId = $order_id;
            $transaction->amount = $amount;
            $transaction->txn_id = $transaction_id;
            $transaction->txn_status = $status;
            $transaction->status = 1;
            $transaction->save();

            $orders = Orders::where('orderId',$order_id)->first();
            $orderItems = OrderItems::where('order_id',$order->id)->get();
            $data = [
                'orders'=>$orders,
                'order_items'=>$orderItems
            ];
            Mail::to($orders->email)->send(
                new OrderMail($data)
            );
            return redirect()->route('front.thanx')->with('success','Your order placed Successfully');

        } else {
            return redirect()->route('front.paypal.cancel');
        }
    }

    public function cancel()
    {
        return "Payment is cancelled!";
    }

    public function thankYou(){
        return view('frontent.thanx');
    }
}
