@extends('frontent.layout.app')
@section('section')
<main>
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="#">My Account</a></li>
                    <li class="breadcrumb-item">Settings</li>
                </ol>
            </div>
        </div>
    </section>

    <section class=" section-11 ">
        <div class="container  mt-5">
            <div class="row">
                <div class="col-md-3">
                    @include('frontent.layout.account-panel')
                </div>
                <div class="col-md-9">
                    @if ($wishlists->isNotEmpty())
                    <div class="card">
                        <div class="card-header">
                            <h2 class="h5 mb-0 pt-2 pb-2">My Wishlist</h2>
                        </div>
                        <div class="card-body p-4">
                            @foreach ($wishlists as $wishlist)
                            <div class="d-sm-flex justify-content-between mt-lg-4 mb-4 pb-3 pb-sm-2 border-bottom">
                                <div class="d-block d-sm-flex align-items-start text-center text-sm-start"><a class="d-block flex-shrink-0 mx-auto me-sm-4" href="{{route('front.product',$wishlist->slug)}}" style="width: 100px;"><img src="{{asset('public/admin/img/products')}}/{{$wishlist->image}}" alt="{{$wishlist->title}}"></a>
                                    <div class="pt-2">
                                        <h3 class="product-title fs-base mb-2"><a href="{{route('front.product',$wishlist->slug)}}">{{$wishlist->title}}</a></h3>                                        
                                        <div class="fs-lg text-accent pt-2">${{number_format($wishlist->price)}}</div>
                                    </div>
                                </div>
                                <div class="pt-2 ps-sm-3 mx-auto mx-sm-0 text-center">
                                    <button class="btn btn-outline-danger btn-sm removeWishlist" data-id="{{$wishlist->wishlistId}}" type="button" ><i class="fas fa-trash-alt me-2"></i>Remove</button>
                                </div>
                            </div> 
                            @endforeach
                            <nav aria-label="Page navigation example">
                                {{ $wishlists->links() }}
                           </nav>
                        </div>
                    </div>
                    @else
                    <div class="card text-center shadow">
                        <div class="card-body">
                          <h4 class="card-title">No data found</h4>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
@push('script')
    <script>
        $(document).ready(function () {
            $('.removeWishlist').on('click',function(){
                var id = $(this).data('id');
                $.ajax({
                    type: "post",
                    url: "{{route('front.removeWishlist')}}",
                    data: "id="+id+"&_token={{csrf_token()}}",
                    success: function (response) {
                        if(response.status==true){
                            Swal.fire({
                            title: 'Removed',
                            text: response.message,
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Ok'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href="{{route('front.wishlist')}}";
                                }
                            });
                        }
                    }
                });
            });
        });
    </script>
@endpush