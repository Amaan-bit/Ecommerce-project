<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Brands;
use App\Models\Products;
use App\Models\ProductGallery;
use DateTime;

class HomeController extends Controller
{
    public function index(){
        $category = Category::where('status',1)->get();
        $featured_products = Products::where('status',1)->where('is_featured',1)->latest()->get();
        $products = Products::where('status',1)->latest()->get();
        $data = compact('category','featured_products','products');
        return view('frontent.index')->with($data);
    }

    public function product($slug){
        $product = Products::where('slug',$slug)->first();
        $gallery = ProductGallery::where('product_id',$product->id)->get();
        $related_products = Products::where('category_id',$product->category_id)->where('subcategory_id',$product->subcategory_id)->where('status',1)->where('qty','>',0)->where('id','!=',$product->id)->get();
        $data = compact('product','related_products','gallery');
        return view('frontent.product')->with($data);
    }

    public function shop(Request $request,$categorySlug=null,$subcategorySlug=null,$brandSlug=null){
        $categorySelected = '';
        $subcategorySelected = '';
        $brandSelected = '';
        $products = Products::where('status',1);
        $brands = Brands::where('status',1)->orderBy('name','ASC')->latest()->get();

        if($categorySlug!=null){
            $category = Category::where('slug',$categorySlug)->first();
            $products = $products->where('category_id',$category->id);
            $categorySelected = $category->id;
        }

        if($subcategorySlug!=null){
            $subcategory = SubCategory::where('slug',$subcategorySlug)->first();
            $products = $products->where('subcategory_id',$subcategory->id);
            $subcategorySelected = $subcategory->id;
        }
        if($brandSlug!=null){
            $brand = Brands::where('slug',$brandSlug)->first();
            $products = $products->where('brand_id',$brand->id);
            $brandSelected = $brand->id;
        }
        $products = $products->latest()->paginate(10);
        $data = compact('products','brands','categorySelected','subcategorySelected');
        return view('frontent.shop')->with($data);
    }

    

}
