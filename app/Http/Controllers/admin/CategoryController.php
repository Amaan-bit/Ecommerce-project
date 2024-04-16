<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image as ResizeImage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(){
        $category = Category::latest()->get();
        $data = compact('category');
        return view('admin.category.list')->with($data);
    }

    public function create(){
        return view('admin.category.create');
    }

    public function store(Request $request){
        $request->validate([
            'name'=>'required|unique:category',
            'image'=>'required|image|mimes:png,jpg,jpeg,webp',
            'show_on_home'=>'required|in:1,0',
            'status'=>'required|in:1,0'
        ]);
        $category = new Category;
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->show_on_home = $request->show_on_home;
        $category->status = $request->status;
        if($request->hasfile('image')){
            $path = 'public/admin/img/category/'.$category->emp_image;
            if(File::exists($path)){
                File::delete($path);
            }
            $destination = 'public/admin/img/category/';
            $name = time() . '.' . $request->image->extension();
            ResizeImage::make($request->file('image'))
            ->resize(100, 130)
            ->save($destination . $name);
            $category->image = $name;
        }
        $category->save();
        return redirect()->route('admin.category.list')->with('success','Category Add Successfully');
    }

    public function edit($id){
        $category = Category::where('id',$id)->first();
        $data = compact('category');
        return view('admin.category.edit')->with($data);
    }

    public function update(Request $request){
        $request->validate([
            'name'=>'required',
            'image'=>'image|mimes:png,jpg,jpeg,webp',
            'show_on_home'=>'required|in:1,0',
            'status'=>'required|in:1,0'
        ]);
        $category = Category::find($request->id);
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->show_on_home = $request->show_on_home;
        $category->status = $request->status;
        if($request->hasfile('image')){
            $path = 'public/admin/img/category/'.$category->image;
            if(File::exists($path)){
                File::delete($path);
            }
            $destination = 'public/admin/img/category/';
            $name = time() . '.' . $request->image->extension();
            ResizeImage::make($request->file('image'))
            ->resize(100, 130)
            ->save($destination . $name);
            $category->image = $name;
        }
        $category->save();
        return redirect()->route('admin.category.list')->with('success','Category Update Successfully');   
    }

    public function delete(Request $request){
        $category = Category::find($request->cat_id);
        $path = 'public/admin/img/category/'.$category->image;
        if(File::exists($path)){
            File::delete($path);
        }
        $category->delete();
        return response()->json(['status'=>true,'message'=>'Category Delete Successfull']);
    }
}
