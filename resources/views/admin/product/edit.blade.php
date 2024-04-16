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
                <h1>Update Product</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{route('admin.product.list')}}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        <form action="{{route('admin.product.update')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-body">								
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="title">Title</label>
                                        <input type="text" name="title" id="name" class="form-control @error('title') is-invalid @enderror" value="{{$products->title}}" placeholder="Title">
                                        <input type="hidden" name="id" value="{{$products->id}}">
                                        @error('title')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror	
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Slug</label>
                                        <input type="text" readonly id="slug" name="slug" class="form-control" value="{{$products->slug}}" placeholder="Slug" value="">
                                    </div>
                                </div>
                            
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Product Image</label>
                                        <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" id="selectImage">
                                        @error('image')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <img id="preview" src="{{asset('public/admin/img/products')}}/{{$products->image}}" alt="your image" class="mt-3 img-thumbnail"/>
                                </div>
                                
                                
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="short_description">Short Description</label>
                                        <textarea name="short_description" id="short_description" cols="30" rows="10" class="summernote @error('short_description') is-invalid @enderror" placeholder="Short Description">{{$products->short_description}}</textarea>
                                        @error('short_description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>                                           
                            </div>
                        </div>	                                                                      
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">								
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="description">Description</label>
                                        <textarea name="description" id="description" cols="30" rows="10" class="summernote @error('description') is-invalid @enderror" placeholder="Description">{{$products->description}}</textarea>
                                        @error('description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>  
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="shipping_returns">Shipping And Returns</label>
                                        <textarea name="shipping_returns" id="shipping_returns" cols="30" rows="10" class="summernote @error('shipping_returns') is-invalid @enderror" placeholder="Shipping Returns">{{$products->shipping_returns}}</textarea>
                                        @error('shipping_returns')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>                                         
                            </div>
                        </div>	                                                                      
                    </div>
                    
                    
                </div>
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">	
                            <h2 class="h4 mb-3">Product status</h2>
                            <div class="mb-3">
                                <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                                    <option value="1" {{($products->status=='1'?'selected':'')}}>Active</option>
                                    <option value="0" {{($products->status=='0'?'selected':'')}}>Block</option>
                                </select>
                                @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div> 
                    <div class="card">
                        <div class="card-body">	
                            <h2 class="h4  mb-3">Product category</h2>
                            <div class="mb-3">
                                <label for="category">Category</label>
                                <select name="category" id="category" class="form-control @error('category') is-invalid @enderror">
                                    <option value="" selected disabled>Select Category</option>
                                    @foreach ($category as $cat)
                                    <option value="{{$cat->id}}" {{($cat->id)==$products->category_id ? 'selected' : ''}}>{{$cat->name}}</option>
                                    @endforeach
                                </select>
                                @error('category')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="sub_category">Sub category</label>
                                <select name="sub_category" id="sub_category" class="form-control @error('sub_category') is-invalid @enderror">
                                    <option value="" selected disabled>Select Sub Category</option>
                                    @foreach ($sub_category as $subcat)
                                    <option value="{{$subcat->id}}" {{($subcat->id)==$products->subcategory_id ? 'selected' : ''}}>{{$subcat->name}}</option>
                                    @endforeach
                                </select>
                                @error('sub_category')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div> 
                    <div class="card mb-3">
                        <div class="card-body">	
                            <h2 class="h4 mb-3">Product Brand</h2>
                            <div class="mb-3">
                                <select name="brand" id="brand" class="form-control @error('brand') is-invalid @enderror">
                                    <option value="" selected disabled>Select Brand</option>
                                    @foreach ($brands as $brand)
                                    <option value="{{$brand->id}}" {{($brand->id)==$products->brand_id ? 'selected' : ''}}>{{$brand->name}}</option>
                                    @endforeach
                                </select>
                                @error('brand')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div> 
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Pricing</h2>								
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="price">Price</label>
                                        <input type="text" name="price" id="price" class="form-control @error('price') is-invalid @enderror" value="{{$products->price}}" placeholder="Price">
                                        @error('price')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror	
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="compare_price">Compare at Price</label>
                                        <input type="text" name="compare_price" value="{{$products->compare_price}}" id="compare_price" class="form-control @error('compare_price') is-invalid @enderror" placeholder="Compare Price">
                                        @error('compare_price')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror<p class="text-muted mt-3">
                                            To show a reduced price, move the product’s original price into Compare at price. Enter a lower value into Price.
                                        </p>	
                                    </div>
                                </div>                                            
                            </div>
                        </div>	                                                                      
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Inventory</h2>								
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="sku">SKU (Stock Keeping Unit)</label>
                                        <input type="text" name="sku" id="sku" class="form-control @error('sku') is-invalid @enderror" value="{{$products->sku}}" placeholder="sku">	
                                        @error('sku')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="barcode">Barcode</label>
                                        <input type="text" name="barcode" id="barcode" class="form-control @error('barcode') is-invalid @enderror" value="{{$products->barcode}}" placeholder="Barcode">	
                                    </div>
                                </div>   
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="qty">Quanity</label>
                                        <input type="number" min="1" name="qty" id="qty" class="form-control @error('qty') is-invalid @enderror" value="{{$products->qty}}" placeholder="Qty">	
                                        @error('qty')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>                                         
                            </div>
                        </div>	                                                                      
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">	
                            <h2 class="h4 mb-3">Featured product</h2>
                            <div class="mb-3">
                                <select name="is_featured" id="is_featured" class="form-control @error('is_featured') is-invalid @enderror">
                                    <option value="0" {{($products->is_featured=='0') ? 'selected' : ''}}>No</option>
                                    <option value="1" {{($products->is_featured=='1') ? 'selected' : ''}}>Yes</option>                                                
                                </select>
                                @error('is_featured')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>                                 
                </div>
                <div class="col-md-12 pb-5 pt-3">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </div>
        </form>     
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->
@endsection
@push('script')
<script>
    Dropzone.autoDiscover = false;    
    $(function () {
        // Summernote
        $('.summernote').summernote({
            height: '300px'
        });
       
        // Drop Zone
        const dropzone = $("#image").dropzone({ 
            url:  "create-product.html",
            maxFiles: 5,
            addRemoveLinks: true,
            acceptedFiles: "image/jpeg,image/png,image/gif",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
            }, success: function(file, response){
                $("#image_id").val(response.id);
            }
        });

        // Get sub category behalf on category
        $('#category').on('change',function(){
            var category = $('#category').val();
            $.ajax({
                type: "post",
                url: "{{route('get.subcategory')}}",
                data: "category_id="+category+"&_token={{csrf_token()}}",
                success: function (response) {
                    $('#sub_category').html(response);
                }
            });
        });
    });
</script>
@endpush