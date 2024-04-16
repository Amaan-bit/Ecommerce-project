<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pages;

class PageController extends Controller
{

    public function pages($page_slug){
        $page = Pages::where('slug',$page_slug)->first();
        if(!empty($page)){
            $data = compact('page');
            return view('frontent.static-page')->with($data);
        }else{
            abort(404);
        }
        
    }
}
