<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use App\Models\Products;
use App\Models\Wishlist;

class WishlistController extends Controller
{
    public function wishlist(){
        $title = 'my-wishlist';
        $user_id = Auth::user()->id;
        $wishlists = DB::table('wishlist')->join('products','wishlist.product_id','=','products.id')->where('wishlist.user_id',$user_id)->select('products.*','wishlist.id as wishlistId')->latest()->paginate(8);
        $data = compact('title','wishlists');
        return view('frontent.wishlist')->with($data);
    }

    public function addWishlist(Request $request){
        if(Auth::guard('web')->check()){
            $user_id = Auth::user()->id;
            $wishlist = Wishlist::where(['user_id'=>$user_id,'product_id'=>$request->id])->first();
            if(empty($wishlist)){
                $wishlist = new Wishlist;
                $wishlist->user_id = $user_id;
                $wishlist->product_id = $request->id;
                $wishlist->save();
                $status = true;
                $message = 'Product Added In Wishlist';
            }else{
                $status = false;
                $message = 'Product Already In Your Wishlist';
            }
            return response()->json(['status'=>$status,'message'=>$message]);
        }else{
            return redirect()->route('front.login');
        }
    }

    public function removeWishlist(Request $request){
        $wishlist = Wishlist::find($request->id);
        $wishlist->delete();
        $status = true;
        $message = 'Product Removed From Wishlist';
        return response()->json(['status'=>$status,'message'=>$message]);
    }
}
