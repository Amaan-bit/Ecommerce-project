<?php
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Brands;
use App\Models\Products;
use App\Models\ProductGallery;

function get_category(){
    $category = Category::where('status',1)->where('show_on_home',1)->orderBy('name','ASC')->get();
    return $category;
}
function get_subcategory($category_id){
    $subcategory = SubCategory::where('status',1)->where('category_id',$category_id)->orderBy('name','ASC')->get();
    return $subcategory;
}
?>