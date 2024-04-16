<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Pages;

class PageController extends Controller
{
    public function index(){
        $pages = Pages::all();
        $data = compact('pages');
        return view('admin.pages.list')->with($data);
    }

    public function create(){
        return view('admin.pages.create');
    }

    public function store(Request $request){
        $request->validate([
            'name'=>'required|unique:pages',
            'content'=>'required',
            'status'=>'required|in:1,0'
        ]);
        $page = new Pages;
        $page->name = $request->name;
        $page->slug = Str::slug($request->name);
        $page->content = $request->content;
        $page->status = $request->status;
        $page->save();
        return redirect()->route('admin.page.list')->with('success','Page Add Successfully');
    }

    public function edit($id){
        $pages = Pages::where('id',$id)->first();
        $data = compact('pages');
        return view('admin.pages.edit')->with($data);
    }

    public function update(Request $request){
        $request->validate([
            'name'=>'required',
            'content'=>'required',
            'status'=>'required|in:1,0'
        ]);
        $page = Pages::find($request->id);
        $page->name = $request->name;
        $page->slug = Str::slug($request->name);
        $page->content = $request->content;
        $page->status = $request->status;
        $page->save();
        return redirect()->route('admin.page.list')->with('success','Page Update Successfully');   
    }

    public function delete(Request $request){
        $pages = Pages::find($request->page_id);
        $pages->delete();
        return response()->json(['status'=>true,'message'=>'Page Delete Successfull']);
    }
}
