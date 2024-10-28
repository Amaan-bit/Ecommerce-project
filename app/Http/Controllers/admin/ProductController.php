<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Brands;
use App\Models\Products;
use App\Models\ProductGallery;

class ProductController extends Controller
{
    public function index(){
        $products = Products::orderBy('id','DESC')->get();
        $data = compact('products');
        return view('admin.product.list')->with($data);
    }

    public function create(){
        $category = Category::where('status',1)->orderBy('name','ASC')->get();
        $brands = Brands::orderBy('name','ASC')->get();
        $data = compact('category','brands');
        return view('admin.product.create')->with($data);
    }

    public function store(Request $request){
        $request->validate([
            'title'=>'required',
            'slug'=>'required',
            'image'=>'required|image|mimes:png,jpg,jpeg,webp',
            'short_description'=>'required',
            'description'=>'required',
            'shipping_returns'=>'required',
            'sku'=>'required|unique:products',
            'qty'=>'required|numeric|min:1',
            'status'=>'required|in:1,0',
            'category'=>'required',
            'sub_category'=>'required',
            'brand'=>'required',
            'price'=>'required|numeric',
            'compare_price'=>'required|numeric',
            'is_featured'=>'required|in:1,0',
        ]);

        $products = new Products;
        $products->title = $request->title;
        $products->slug = Str::slug($request->title);
        $products->short_description = $request->short_description;
        $products->description = $request->description;
        $products->shipping_returns = $request->shipping_returns;
        $products->sku = $request->sku;
        $products->barcode = $request->barcode;
        $products->qty = $request->qty;
        $products->status = $request->status;
        $products->category_id = $request->category;
        $products->subcategory_id = $request->sub_category;
        $products->brand_id = $request->brand;
        $products->price = $request->price;
        $products->compare_price = $request->compare_price;
        $products->is_featured = $request->is_featured;
        if($request->hasfile('image')){
            $path = 'public/admin/img/products/'.$products->image;
            if(File::exists($path)){
                File::delete($path);
            }
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'.'.$extension;
            $file->move('public/admin/img/products/',$filename);
            $products->image = $filename;
        }
        $products->save();
        return redirect()->route('admin.product.list')->with('success','Product Add Successfully');
    }

    public function edit($id){
        $products = Products::find($id);
        $category = Category::where('status',1)->orderBy('name','ASC')->get();
        $sub_category = SubCategory::where('category_id',$products->category_id)->orderBy('name','ASC')->get();
        $brands = Brands::orderBy('name','ASC')->get();
        $data = compact('products','category','sub_category','brands');
        return view('admin.product.edit')->with($data);
    }

    public function update(Request $request){
        $request->validate([
            'title'=>'required',
            'slug'=>'required',
            'image'=>'image|mimes:png,jpg,jpeg,webp',
            'short_description'=>'required',
            'description'=>'required',
            'shipping_returns'=>'required',
            'sku'=>'required',
            'qty'=>'required|numeric|min:1',
            'status'=>'required|in:1,0',
            'category'=>'required',
            'sub_category'=>'required',
            'brand'=>'required',
            'price'=>'required|numeric',
            'compare_price'=>'required|numeric',
            'is_featured'=>'required|in:1,0',
        ]);

        $products = Products::find($request->id);
        $products->title = $request->title;
        $products->slug = Str::slug($request->title);
        $products->short_description = $request->short_description;
        $products->description = $request->description;
        $products->shipping_returns = $request->shipping_returns;
        $products->sku = $request->sku;
        $products->barcode = $request->barcode;
        $products->qty = $request->qty;
        $products->status = $request->status;
        $products->category_id = $request->category;
        $products->subcategory_id = $request->sub_category;
        $products->brand_id = $request->brand;
        $products->price = $request->price;
        $products->compare_price = $request->compare_price;
        $products->is_featured = $request->is_featured;
        if($request->hasfile('image')){
            $path = 'public/admin/img/products/'.$products->image;
            if(File::exists($path)){
                File::delete($path);
            }
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'.'.$extension;
            $file->move('public/admin/img/products/',$filename);
            $products->image = $filename;
        }
        $products->save();
        return redirect()->route('admin.product.list')->with('success','Product Update Successfully');
    }

    public function delete(Request $request){
        $products = Products::find($request->product_id);
        $path = 'public/admin/img/products/'.$products->image;
        if(File::exists($path)){
            File::delete($path);
        }
        $products->delete();
        return response()->json(['status'=>true,'message'=>'Product Delete Successfull']);
    }

    public function gallery($product_id){
        $gallery = ProductGallery::where('product_id',$product_id)->get();
        $data = compact('product_id','gallery');
        return view('admin.product.gallery')->with($data);
    }

    public function add_gallery(Request $request,$product_id){
        if($request->hasfile('image')){
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = rand(10000,99999).'_'.$file->getClientOriginalName();
            $file->move('public/admin/img/products/',$filename);
            $gallery = new ProductGallery;
            $gallery->product_id = $product_id;
            $gallery->image = $filename;
            $gallery->status = 1;
            $gallery->save();
            return response()->json(['status'=>true,'message'=>'Product image add successfull','image_id'=>$gallery->id,'image_path'=>asset('public/admin/img/products/'.$gallery->image)]);
        }
    }

    public function delete_gallery(Request $request){
        $gallery = ProductGallery::find($request->id);
        $path = 'public/admin/img/products/'.$gallery->image;
        if(File::exists($path)){
            File::delete($path);
        }
        $gallery->delete();
        return response()->json(['status'=>true,'message'=>'Gallery Image Delete Successfull']);
    }
}
