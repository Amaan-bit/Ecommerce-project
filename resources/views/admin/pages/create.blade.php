@extends('admin.layout.app')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Create Page</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{route('admin.page.list')}}" class="btn btn-primary">Back</a>
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
                <form action="{{route('admin.page.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="name">Name</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Name" id="name" value="{{old('name')}}">
                                @error('name')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror	
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label>Slug</label>
                                <input type="text" readonly id="slug" name="slug" value="{{old('slug')}}" class="form-control" placeholder="Slug" value="">
                            </div>
                        </div>	
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label>Status</label>
                                <select name="status" class="form-control @error('status') is-invalid @enderror" id="">
                                    <option value="" selected disabled> Select Status</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>    
                                </select>	
                                @error('status')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>	
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label>Content</label>
                                <textarea name="content" class="summernote" cols="30" rows="10"></textarea>
                                @error('content')
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
@push('script')
    <script>
        $(document).ready(function () {
            $('#name').on('keyup',function(){
                var name = $('#name').val();
                $.ajax({
                    type: "post",
                    url: "{{route('admin.getslug')}}",
                    data: "name="+name+"&_token={{csrf_token()}}",
                    success: function (response) {
                        $('#slug').val(response.slug);
                    }
                });
            });
        });
    </script>
@endpush