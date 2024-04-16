@extends('admin.layout.app')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Update SubCategory</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{route('admin.subcategory.list')}}" class="btn btn-primary">Back</a>
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
                <form action="{{route('admin.subcategory.update')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Category</label>
                                <select name="category" class="form-control @error('category') is-invalid @enderror" id="">
                                    <option value="" selected disabled> Select Category</option>
                                    @foreach ($category as $cat)
                                        <option {{($cat->id==$subcategory->category_id) ? 'selected' : ''}} value="{{$cat->id}}">{{$cat->name}}</option>
                                    @endforeach    
                                </select>	
                                @error('category')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name">Name</label>
                                <input type="hidden" name="id" value="{{$subcategory->id}}">
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Name" value="{{$subcategory->name}}">
                                @error('name')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror	
                            </div>
                        </div>	
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Slug</label>
                                <input type="text" readonly id="slug" name="slug" class="form-control" placeholder="Slug" value="{{$subcategory->slug}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="image">Status</label>
                                <select name="status" class="form-control @error('status') is-invalid @enderror" id="">
                                    <option value="" selected disabled> Select Status</option>
                                    <option value="1" {{($subcategory->status==1) ? 'selected' : ''}}>Active</option>
                                    <option value="0" {{($subcategory->status==0) ? 'selected' : ''}}>Inactive</option>    
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