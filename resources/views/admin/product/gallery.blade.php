@extends('admin.layout.app')
@section('content')
<!-- Content Header (Page header) -->
<style>
    #image{
        background-color:#ffff;
        border-radius: 10px;
        border: dashed 2px #919191;
        margin-bottom: 30px
    }
    .dz-message{
        font-size:30px
    }
    .card img{
        width: 100px;
        height: 150px;
    }
</style>
<section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Product Gallery</h1>
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
        <div class="card">
            <div class="card-body">								
                <form method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="image" class="dropzone dz-clickable">
                                <div class="dz-message needsclick">    
                                    <br>Drop files here or click to upload.<br><br>                                            
                                </div>
                            </div>
                            <div class="row" id="product_gallery">
                                @if ($gallery->isNotEmpty())
                                    @foreach ($gallery as $gallery_img)
                                    <div class="col-md-2" id="image-row{{$gallery_img->id}}">
                                        <div class="card">
                                            <img class="card-img-top" src="{{asset('public/admin/img/products/'.$gallery_img->image)}}" alt="Card image" style="width:100%">
                                            <div class="card-body text-center">
                                                <a href="javascript:void(0)" onclick="deleteImage({{$gallery_img->id}})" class="btn btn-danger">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                @endif
                            </div>
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
    Dropzone.autoDiscover = false;    
    $(function () {
       
        const dropzone = $("#image").dropzone({ 
            url:  "{{route('admin.product.gallery.add',$product_id)}}",
            maxFiles: 5,
            addRemoveLinks: true,
            paramName:'image',
            acceptedFiles: "image/jpeg,image/png,image/gif",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
            }, success: function(file, response){
               if(response.status==true){
                    var html = `<div class="col-md-2" id="image-row${response.image_id}">
                                    <div class="card">
                                        <img class="card-img-top" src="${response.image_path}" alt="Card image" style="width:100%">
                                        <div class="card-body text-center">
                                            <a href="javascript:void(0)" onclick="deleteImage(${response.image_id})" class="btn btn-danger">Delete</a>
                                        </div>
                                    </div>
                                </div>`;
                    $('#product_gallery').append(html);
               }
            },
            complete:function(file){
                this.removeFile(file);
            }
        });
    });
        function deleteImage(id){
            $.ajax({
                type: "post",
                url: "{{route('delete.gallery.image')}}",
                data: "id="+id+"&_token={{csrf_token()}}",
                success: function (response) {
                    $('#image-row'+id).remove();
                }
            });
        }
</script>
@endpush