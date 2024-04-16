@extends('admin.layout.app')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Create User</h1>
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
                <form action="{{route('admin.user.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name">Name</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Name" value="{{old('name')}}">
                                @error('name')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror	
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{old('email')}}">
                                @error('email')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>	
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Phone</label>
                                <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="Phone" value="{{old('phone')}}">
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