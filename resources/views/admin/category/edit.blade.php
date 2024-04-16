@extends('admin.layout.app')
@section('content')
<!-- Content Header (Page header) -->
<style>
    .img-thumbnail{
        width: 200px;
    }
</style>
<section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Update Category</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{route('admin.category.list')}}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">								
                <form action="{{route('admin.category.update')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Name</label>
                                <input type="hidden" name="id" value="{{$category->id}}">
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Name" value="{{$category->name}}">
                                @error('name')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror	
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Slug</label>
                                <input type="text" readonly id="slug" name="slug" class="form-control" placeholder="Slug" value="{{$category->slug}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Image</label>
                                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" placeholder="Image" id="selectImage">	
                                @error('image')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>	
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Show On Home</label>
                                <select name="show_on_home" class="form-control @error('show_on_home') is-invalid @enderror" id="">
                                    <option value="" selected disabled> Select Status</option>
                                    <option value="1" {{($category->show_on_home==1) ? 'selected' : ''}}>Yes</option>
                                    <option value="0" {{($category->show_on_home==0) ? 'selected' : ''}}>No</option>    
                                </select>	
                                @error('show_on_home')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <img id="preview" src="{{asset('public/admin/img/category/'.$category->image)}}" alt="your image" class="mt-3 img-thumbnail"/>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Status</label>
                                <select name="status" class="form-control @error('status') is-invalid @enderror" id="">
                                    <option value="" selected disabled> Select Status</option>
                                    <option value="1" {{($category->status==1) ? 'selected' : ''}}>Active</option>
                                    <option value="0" {{($category->status==0) ? 'selected' : ''}}>Inactive</option>    
                                </select>	
                                @error('status')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>	
                        
                        <div class=" col-md-12 pt-3">
                            <button type="submit" class="btn btn-primary mr-3">Submit</button>
                            <button type="reset" class="btn btn-default">Cancel</button>
                        </div>							
                    </div>
                </form>
            </div>							
        </div>
        
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->
@endsection