@extends('frontent.layout.app')
@section('section')
<main>
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{route('front.home')}}">Home</a></li>
                    <li class="breadcrumb-item"><a class="white-text" href="{{route('front.account')}}">My Account</a></li>
                    <li class="breadcrumb-item">My Address</li>
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
                            <h2 class="h4 mb-0 pt-2 pb-2">Shipping Address</h2>
                        </div>
                        @include('frontent.message')  
                        <div class="card-body p-4">
                            <form action="{{route('front.updateAddress')}}" method="POST">
                                @csrf
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
                                        <input type="submit" class="btn btn-dark btn-block btn-lg" value="Save">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection