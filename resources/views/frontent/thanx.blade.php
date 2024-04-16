@extends('frontent.layout.app')
@section('section')
<main>
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{route('front.home')}}">Home</a></li>
                    <li class="breadcrumb-item"><a class="white-text" href="{{route('front.shop')}}">Shop</a></li>
                    <li class="breadcrumb-item">Order</li>
                </ol>
            </div>
        </div>
    </section>

    <section class=" section-10">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card text-center shadow">
                        <div class="card-body py-5">
                            <img src="{{asset('public/frontend/images/delivery-box.png')}}" alt="box" style="width:100px">
                            <h4 class="my-3">Your order has been successfully <strong>submitted!</strong></h4>
                            <h5>Thank you for ordering with us</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection