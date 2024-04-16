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
                    <div class="card">
                        <div class="card-header">
                            <h2 class="h5 mb-0 pt-2 pb-2">My Orders</h2>
                        </div>

                        <div class="card-body pb-0">
                            <!-- Info -->
                            <div class="card card-sm">
                                <div class="card-body bg-light mb-3">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <!-- Heading -->
                                            <h6 class="heading-xxxs text-muted">Order No:</h6>
                                            <!-- Text -->
                                            <p class="mb-lg-0 fs-sm fw-bold">
                                            #{{$orders->orderId}}
                                            </p>
                                        </div>
                                        <div>
                                            <!-- Heading -->
                                            <h6 class="heading-xxxs text-muted">Order date:</h6>
                                            <!-- Text -->
                                            <p class="mb-lg-0 fs-sm fw-bold">
                                                <time datetime="2019-10-01">
                                                    {{Carbon\Carbon::parse($orders->created_at)->format('d M , Y')}}
                                                </time>
                                            </p>
                                        </div>
                                        <div>
                                            <!-- Heading -->
                                            <h6 class="heading-xxxs text-muted">Status:</h6>
                                            <!-- Text -->
                                            <p class="mb-0 fs-sm fw-bold">
                                                {{$orders->order_status}}
                                            </p>
                                        </div>
                                        <div>
                                            <!-- Heading -->
                                            <h6 class="heading-xxxs text-muted">{{ucfirst($orders->order_status)}} Date:</h6>
                                            <!-- Text -->
                                            <p class="mb-0 fs-sm fw-bold">
                                                {{Carbon\Carbon::parse($orders->updated_at)->format('d M , Y')}}
                                            </p>
                                        </div>
                                        <div>
                                            <!-- Heading -->
                                            <h6 class="heading-xxxs text-muted">Order Amount:</h6>
                                            <!-- Text -->
                                            <p class="mb-0 fs-sm fw-bold">
                                            ${{number_format($orders->grand_total,2)}}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer p-3">

                            <!-- Heading -->
                            <h6 class="mb-7 h5 mt-4">Order Items ({{$orderItems->count()}})</h6>

                            <!-- Divider -->
                            <hr class="my-3">

                            <!-- List group -->
                            
                            <ul>
                                @foreach ($orderItems as $orderItem)
                                <li class="list-group-item">
                                    <div class="row align-items-center">
                                        <div class="col-4 col-md-3 col-xl-2">
                                            <!-- Image -->
                                            <a href="{{route('front.product',$orderItem->slug)}}"><img src="{{asset('public/admin/img/products')}}/{{$orderItem->image}}" alt="..." class="img-fluid"></a>
                                        </div>
                                        <div class="col">
                                            <!-- Title -->
                                            <p class="mb-4 fs-sm fw-bold">
                                                <a class="text-body" href="{{route('front.product',$orderItem->slug)}}">{{$orderItem->name}} x {{$orderItem->qty}}</a> <br>
                                                <span class="text-muted">${{number_format($orderItem->price,2)}}</span>
                                            </p>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>                      
                    </div>
                    
                    <div class="card card-lg mb-5 mt-3">
                        <div class="card-body">
                            <!-- Heading -->
                            <h6 class="mt-0 mb-3 h5">Order Total</h6>

                            <!-- List group -->
                            <ul>
                                <li class="list-group-item d-flex">
                                    <span>Subtotal</span>
                                    <span class="ms-auto">${{number_format($orders->subtotal,2)}}</span>
                                </li>
                                <li class="list-group-item d-flex">
                                    <span>Discount</span>
                                    <span class="ms-auto">${{number_format($orders->discount,2)}}</span>
                                </li>
                                <li class="list-group-item d-flex">
                                    <span>Shipping</span>
                                    <span class="ms-auto">${{number_format($orders->shipping,2)}}</span>
                                </li>
                                <li class="list-group-item d-flex fs-lg fw-bold">
                                    <span>Total</span>
                                    <span class="ms-auto">${{number_format($orders->grand_total,2)}}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection