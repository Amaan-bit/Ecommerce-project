<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Brands;

class AjaxController extends Controller
{   
    public function Getslug(Request $request){
        $slug = Str::slug($request->name);
        return response()->json(['status'=>true,'slug'=>$slug]);
    }

    public function GetSubCategory(Request $request){
        $subcategory = SubCategory::where('category_id',$request->category_id)->where('status',1)->get();
        $data = '<option value="" selected disabled>Select Sub Category</option>';
        foreach($subcategory as $subcat){
            $data .= '<option value="'.$subcat->id.'">'.$subcat->name.'</option>';
        }
        echo $data;
    }
}
