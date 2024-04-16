<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\DB;
use App\Models\Products;  

class CartController extends Controller
{
    public function cart(){
        $cartContent = Cart::content();
        $data = compact('cartContent');
        return view('frontent.cart')->with($data);
    }

    public function addToCart(Request $request){
        $product = Products::find($request->id);
        if(Cart::count()>0){
            $cartContent = Cart::content();
            $productAlreadyExist = '';
            foreach($cartContent as $items){
                if($items->id == $product->id){
                    $productAlreadyExist = true;
                }
            }

            if($productAlreadyExist == false){
                Cart::add($product->id,$product->title,1,$product->price,['image'=>$product->image]);
                $status = true;
                $message = 'Product Added In Your Cart';
            }else{ 
                $status = false;
                $message = 'Product Already In Your Cart';
            }
        }else{
            Cart::add($product->id,$product->title,1,$product->price,['image'=>$product->image]);
            $status = true;
            $message = 'Product Added In Your Cart';
        }
        return response()->json(['status'=>$status,'message'=>$message]);
    }

    public function removeCart(Request $request){
        $rowId = $request->id;
        Cart::remove($rowId);
        return response()->json(['status'=>true,'message'=>'Product Removed From Your Cart']);
    }

    public function updateCart(Request $request){
        $rowId = $request->id;
        $qty = $request->qty;
        $item = Cart::get($rowId);
        $product = Products::find($item->id);
        if($qty<=$product->qty){
            Cart::update($rowId,$qty);
            $status = true;
            $message = 'Product Cart Updated';
        }else{
            $status = false;
            $message = 'Given quantity is not available in stock';
        }
        return response()->json(['status'=>$status,'message'=>$message]);
    }
}
