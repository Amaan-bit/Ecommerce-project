<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\SubCategory;

class SubCategoryController extends Controller
{
    public function index(){
        $subcategory = DB::table('sub_category as sub_cat')
                            ->join('category as cat','sub_cat.category_id','=','cat.id')
                            ->select('sub_cat.*','cat.name as category_name')
                            ->latest('sub_cat.id')
                            ->get();
        $data = compact('subcategory');
        return view('admin.sub-category.list')->with($data);
    }

    public function create(){
        $category = Category::where('status',1)->get();
        $data = compact('category');
        return view('admin.sub-category.create')->with($data);
    }

    public function store(Request $request){
        $request->validate([
            'name'=>'required|unique:sub_category',
            'category'=>'required',
            'status'=>'required|in:1,0'
        ]);
        $subcategory = new SubCategory;
        $subcategory->name = $request->name;
        $subcategory->slug = Str::slug($request->name);
        $subcategory->category_id = $request->category;
        $subcategory->status = $request->status;
        $subcategory->save();
        return redirect()->route('admin.subcategory.list')->with('success','SubCategory Add Successfully');
    }

    public function edit($id){
        $category = Category::where('status',1)->get();
        $subcategory = SubCategory::where('id',$id)->first();
        $data = compact('subcategory','category');
        return view('admin.sub-category.edit')->with($data);
    }

    public function update(Request $request){
        $request->validate([
            'name'=>'required',
            'category'=>'required',
            'status'=>'required|in:1,0'
        ]);
        $subcategory = SubCategory::find($request->id);
        $subcategory->name = $request->name;
        $subcategory->slug = Str::slug($request->name);
        $subcategory->category_id = $request->category;
        $subcategory->status = $request->status;
        $subcategory->save();
        return redirect()->route('admin.subcategory.list')->with('success','SubCategory Update Successfully');   
    }

    public function delete(Request $request){
        $subcategory = SubCategory::find($request->subcat_id);
        $subcategory->delete();
        return response()->json(['status'=>true,'message'=>'SubCategory Delete Successfull']);
    }
}
