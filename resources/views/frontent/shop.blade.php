@extends('frontent.layout.app')
@section('section')
<main>
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{route('front.home')}}">Home</a></li>
                    <li class="breadcrumb-item active">Shop</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="section-6 pt-5">
        <div class="container">
            <div class="row">            
                <div class="col-md-3 sidebar">
                    <div class="sub-title">
                        <h2>Categories</h3>
                    </div>
                    
                    <div class="card">
                        <div class="card-body">
                            <div class="accordion accordion-flush" id="accordionExample">
                                @if (get_category()->isNotEmpty())
                                    @foreach (get_category() as $cat)
                                        @if (get_subcategory($cat->id)->isNotEmpty())
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingOne">
                                                    <button class="accordion-button {{($categorySelected==$cat->id)?'text-primary':'collapsed'}}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$cat->id}}" aria-expanded="false" aria-controls="collapseOne">
                                                        {{$cat->name}}
                                                    </button>
                                                </h2>
                                                <div id="collapse{{$cat->id}}" class="accordion-collapse collapse {{($categorySelected==$cat->id)?'show':''}}" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
                                                    <div class="accordion-body">
                                                        <div class="navbar-nav">
                                                            @foreach (get_subcategory($cat->id) as $subcat)
                                                            <a href="{{route('front.shop',[$cat->slug,$subcat->slug])}}" class="nav-item nav-link {{($subcategorySelected==$subcat->id)?'text-primary':''}}">{{$subcat->name}}</a>
                                                            @endforeach 
                                                        </div>
                                                    </div>
                                                </div> 
                                            </div> 
                                        @else
                                            <a href="{{route('front.shop',[$cat->slug])}}" class="nav-item nav-link {{($categorySelected==$cat->id)?'text-primary':''}}"> {{$cat->name}}</a>
                                        @endif 
                                    @endforeach 
					            @endif                
                                                    
                            </div>
                        </div>
                    </div>

                    <div class="sub-title mt-5">
                        <h2>Brand</h3>
                    </div>
                    
                    <div class="card">
                        <div class="card-body">
                            @if ($brands->isNotEmpty())
                                @foreach ($brands as $brand)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input brand" type="radio" name="brand" value="{{$brand->slug}}" id="brand">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            {{$brand->name}}
                                        </label>
                                    </div>  
                                @endforeach
                            @endif
                                             
                        </div>
                    </div>

                    {{-- <div class="sub-title mt-5">
                        <h2>Price</h3>
                    </div> --}}
                    
                    {{-- <div class="card">
                        <div class="card-body">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    $0-$100
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                <label class="form-check-label" for="flexCheckChecked">
                                    $100-$200
                                </label>
                            </div>                 
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                <label class="form-check-label" for="flexCheckChecked">
                                    $200-$500
                                </label>
                            </div> 
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                <label class="form-check-label" for="flexCheckChecked">
                                    $500+
                                </label>
                            </div>                 
                        </div>
                    </div> --}}
                </div>
                <div class="col-md-9">
                    <div class="row pb-3">
                        <div class="col-12 pb-1">
                            <div class="d-flex align-items-center justify-content-end mb-4">
                                <div class="ml-2">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-bs-toggle="dropdown">Sorting</button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="#">Latest</a>
                                            <a class="dropdown-item" href="#">Price High</a>
                                            <a class="dropdown-item" href="#">Price Low</a>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>
                        </div>
                        @if ($products->isNotEmpty())
                            @foreach ($products as $product)
                                <div class="col-md-4">
                                    <div class="card product-card">
                                        <div class="product-image position-relative">
                                            <a href="{{route('front.product',$product->slug)}}" class="product-img"><img class="card-img-top" src="{{asset('public/admin/img/products')}}/{{$product->image}}" alt=""></a>
                                            <a class="whishlist" href="222"><i class="far fa-heart"></i></a>                            
        
                                            <div class="product-action">
                                                @if ($product->qty > 0)
                                                <a class="btn btn-dark addToCart" data-id="{{$product->id}}" href="javascript:void(0)">
                                                    <i class="fa fa-shopping-cart"></i> Add To Cart
                                                </a> 
                                                @else
                                                <a class="btn btn-danger">
                                                    <i class="fa fa-shopping-cart"></i> Out of stock
                                                </a>
                                                @endif                            
                                            </div>
                                        </div>                        
                                        <div class="card-body text-center mt-3">
                                            <a class="h6 link" href="{{route('front.product',$product->slug)}}">{{$product->title}}</a>
                                            <div class="price mt-2">
                                                <span class="h5"><strong>${{$product->price}}</strong></span>
                                                <span class="h6 text-underline"><del>${{$product->compare_price}}</del></span>
                                            </div>
                                        </div>                        
                                    </div>                                               
                                </div>
                            @endforeach
                        @else
                        <div class="card text-center shadow">
                            <div class="card-body">
                              <h4 class="card-title">No Product Found</h4>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-12 pt-5">
                    <nav aria-label="Page navigation example">
                         {{ $products->links() }}
                    </nav>
                </div>
            </div>
        </div>
    </section>    
</main>
@endsection
@push('script')
    <script>
        $(document).ready(function () {
            // $('.brand').on('click',function(){
            //     var slug = $(this).val();
            //     var url = '{{url()->current()}}/';
            //     window.location.href=url+slug;
            // })
        });
    </script>
@endpush