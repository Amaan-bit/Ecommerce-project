<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Brands;

class BrandsController extends Controller
{
    public function index(){
        $brands = Brands::latest()->get();
        $data = compact('brands');
        return view('admin.brands.list')->with($data);
    }

    public function create(){
        return view('admin.brands.create');
    }

    public function store(Request $request){
        $request->validate([
            'name'=>'required|unique:brands',
            'status'=>'required|in:1,0'
        ]);
        $brands = new Brands;
        $brands->name = $request->name;
        $brands->slug = Str::slug($request->name);
        $brands->status = $request->status;
        $brands->save();
        return redirect()->route('admin.brands.list')->with('success','Brands Add Successfully');
    }

    public function edit($id){
        $brands = Brands::where('id',$id)->first();
        $data = compact('brands');
        return view('admin.brands.edit')->with($data);
    }

    public function update(Request $request){
        $request->validate([
            'name'=>'required',
            'status'=>'required|in:1,0'
        ]);
        $brands = Brands::find($request->id);
        $brands->name = $request->name;
        $brands->slug = Str::slug($request->name);
        $brands->status = $request->status;
        $brands->save();
        return redirect()->route('admin.brands.list')->with('success','Brands Update Successfully');   
    }

    public function delete(Request $request){
        $brands = Brands::find($request->brand_id);
        $brands->delete();
        return response()->json(['status'=>true,'message'=>'Brands Delete Successfull']);
    }
}
