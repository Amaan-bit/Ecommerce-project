@extends('frontent.layout.app')
@section('section')
<main>
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{route('front.home')}}">Home</a></li>
                    <li class="breadcrumb-item"><a class="white-text" href="{{route('front.shop')}}">Shop</a></li>
                    <li class="breadcrumb-item">Checkout</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="section-9 pt-4">
        <div class="container">
            <form action="{{route('front.checkout.process')}}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <div class="sub-title">
                            <h2>Shipping Address</h2>
                        </div>
                        <div class="card shadow-lg border-0">
                            <div class="card-body checkout-form">
                                <div class="row">
                                    
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <input type="text" name="first_name" id="first_name" value="{{(!empty($customerAddress))? $customerAddress->first_name:old('first_name')}}" class="form-control @error('first_name') is-invalid @enderror" placeholder="First Name">
                                            @error('first_name')
                                                <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>            
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <input type="text" name="last_name" id="last_name" value="{{(!empty($customerAddress))? $customerAddress->last_name:old('last_name')}}" class="form-control @error('last_name') is-invalid @enderror" placeholder="Last Name">
                                            @error('last_name')
                                                <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>            
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <input type="text" name="email" id="email" value="{{(!empty($customerAddress))? $customerAddress->email:old('email')}}" class="form-control @error('email') is-invalid @enderror" placeholder="Email">
                                            @error('email')
                                                <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>            
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <input type="tel" name="mobile" value="{{(!empty($customerAddress))? $customerAddress->mobile:old('mobile')}}" id="mobile" class="form-control @error('mobile') is-invalid @enderror" placeholder="Mobile No.">
                                            @error('mobile')
                                                <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>            
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <textarea name="address" id="address" cols="30" rows="3" placeholder="Address" class="form-control @error('address') is-invalid @enderror">{{(!empty($customerAddress))? $customerAddress->address:old('address')}}</textarea>
                                            @error('address')
                                                <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>            
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <input type="text" name="apartment" value="{{(!empty($customerAddress))? $customerAddress->apartment:old('apartment')}}" id="appartment" class="form-control" placeholder="Apartment, suite, unit, etc. (optional)">
                                        </div>            
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <input type="text" name="city" value="{{(!empty($customerAddress))? $customerAddress->city:old('city')}}" id="city" class="form-control @error('city') is-invalid @enderror" placeholder="City">
                                            @error('city')
                                                <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>            
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <input type="text" name="state" value="{{(!empty($customerAddress))? $customerAddress->state:old('state')}}" id="state" class="form-control @error('state') is-invalid @enderror" placeholder="State">
                                            @error('state')
                                                <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>            
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <input type="tel" name="zip" value="{{(!empty($customerAddress))? $customerAddress->zip:old('zip')}}" id="zip" class="form-control @error('zip') is-invalid @enderror" placeholder="Zip">
                                            @error('zip')
                                                <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>            
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <textarea name="order_notes" id="order_notes" cols="30" rows="2" placeholder="Order Notes (optional)" class="form-control">{{old('order_notes')}}</textarea>
                                        </div>            
                                    </div>

                                </div>
                            </div>
                        </div>    
                    </div>
                    <div class="col-md-4">
                    <div class="sub-title">
                        <h2>Order Summery</h3>
                    </div>                    
                    <div class="card cart-summery">
                        <div class="card-body">
                        @if ($items->isNotEmpty())
                            @foreach ($items as $item)
                            <div class="d-flex justify-content-between pb-2">
                                <div class="h6">{{$item->name}} <strong>X {{$item->qty}}</strong></div>
                                <div class="h6">${{$item->price}}</div>
                            </div>
                            @endforeach
                        @endif
                            
                            <div class="d-flex justify-content-between summery-end">
                                <div class="h6"><strong>Subtotal</strong></div>
                                <div class="h6"><strong>${{Cart::subtotal()}}</strong></div>
                            </div>
                            <div class="d-flex justify-content-between mt-2">
                                <div class="h6"><strong>Shipping</strong></div>
                                <div class="h6"><strong>$0</strong></div>
                            </div>
                            <div class="d-flex justify-content-between mt-2">
                                <div class="h6"><strong>Discount</strong></div>
                                <div class="h6"><strong>$0</strong></div>
                            </div>
                            <div class="d-flex justify-content-between mt-2 summery-end">
                                <div class="h5"><strong>Total</strong></div>
                                <div class="h5"><strong>${{Cart::subtotal()}}</strong></div>
                            </div>                            
                        </div>
                    </div>   
                    
                    <div class="card payment-form ">   
                        <h3 class="card-title h5 mb-3">Payment Method</h3>   
                        <div class="">
                            <input checked type="radio" name="payment_method" value="cod" id="payment_method_one">
                            <label for="payment_method_one" class="form-check-label">COD</label>
                        </div>
                        <div class="">
                            {{-- <input type="radio" name="payment_method" value="stripe" id="payment_method_two">
                            <label for="payment_method_two" class="form-check-label">Stripe</label> --}}
                            <input type="radio" name="payment_method" value="paypal">
                            <label for="payment_method_two" class="form-check-label">Pay with Paypal</label>
                        </div>
                        
                        <div class="card-body mt-3 p-0 d-none" id="card-detail">
                            <div class="mb-3">
                                <label for="card_number" class="mb-2">Card Number</label>
                                <input type="text" name="card_number" id="card_number" placeholder="Valid Card Number" class="form-control">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="expiry_date" class="mb-2">Expiry Date</label>
                                    <input type="text" name="expiry_date" id="expiry_date" placeholder="MM/YYYY" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label for="expiry_date" class="mb-2">CVV Code</label>
                                    <input type="text" name="cvv" id="expiry_date" placeholder="123" class="form-control">
                                </div>
                            </div>
                        </div> 
                        <div class="pt-4">
                            <button type="submit" class="btn-dark btn btn-block w-100">Order Now</button>
                        </div>                       
                    </div>

                        
                    <!-- CREDIT CARD FORM ENDS HERE -->
                    
                </div>
            </form>
        </div>
    </section>
</main>
@endsection
@push('script')
    <script>
        $(document).ready(function () {
            $('#payment_method_one').on('click',function(){
                if($(this).is(':checked')==true){
                    $('#card-detail').addClass('d-none');
                }
            });
            $('#payment_method_two').on('click',function(){
                if($(this).is(':checked')==true){
                    $('#card-detail').removeClass('d-none');
                }
            });
        });
    </script>
@endpush