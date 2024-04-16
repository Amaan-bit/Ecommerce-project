@extends('admin.layout.app')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Update User</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{route('admin.user.list')}}" class="btn btn-primary">Back</a>
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
                <form action="{{route('admin.user.update')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name">Name</label>
                                <input type="hidden" name="id" value="{{$users->id}}">
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Name" value="{{$users->name}}">
                                @error('name')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror	
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{$users->email}}">
                                @error('email')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>	
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Phone</label>
                                <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="Phone" value="{{$users->phone}}">
                                @error('phone')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Password</label>
                                <input type="text" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" value="{{old('password')}}">
                                @error('password')
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