@extends('admin.layout.app')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Products</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{route('admin.product.create')}}" class="btn btn-primary">New Product</a>
            </div>
        </div>
        @include('admin.message')
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        <div class="card">
            <div class="card-body table-responsive">								
                <table class="table table-hover text-nowrap" id="myTable">
                    <thead>
                        <tr>
                            <th width="60">Sr.</th>
                            <th width="80"></th>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>SKU</th>
                            <th width="100">Status</th>
                            <th width="100">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($products as $product)
                        <tr id="product{{$product->id}}">
                            <td>{{$loop->iteration}}</td>
                            <td><img src="{{asset('public/admin/img/products')}}/{{$product->image}}" class="img-thumbnail" width="50"></td>
                            <td><a href="{{route('admin.product.edit',$product->id)}}">{{$product->title}}</a></td>
                            <td>${{$product->price}}</td>
                            <td class="{{($product->qty==0)?'text-danger':''}}">{{$product->qty}} left in Stock</td>
                            <td>{{$product->sku}}</td>											
                            <td>
                                @if ($product->status==1)
                                    <svg class="text-success-500 h-6 w-6 text-success" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                @else
                                    <svg class="text-danger h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                @endif
                            </td>
                            <td>
                                <a href="{{route('admin.product.edit',$product->id)}}" class="mr-2">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                <a href="javascript:void(0)" data-id="{{$product->id}}" class="delete text-danger mr-2">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
                                <a href="{{route('admin.product.gallery',$product->id)}}" class="text-warning">
                                    <i class="fa-solid fa-images"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>										
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
            $('.delete').on('click',function(){
                var id = $(this).data('id');
                Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "post",
                        url: "{{route('admin.product.delete')}}",
                        data: "product_id="+id+"&_token={{csrf_token()}}",
                        success: function (response) {
                            if(response.status==true){
                                $('#product'+id).remove();
                                Swal.fire(
                                'Deleted!',
                                response.message,
                                'success'
                                )
                            }
                        }
                    });
                }
                });
            });
        });
    </script>
@endpush