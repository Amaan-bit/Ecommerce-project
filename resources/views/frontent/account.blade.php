@extends('frontent.layout.app')
@section('section')
<main>
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{route('front.home')}}">Home</a></li>
                    <li class="breadcrumb-item"><a class="white-text" href="{{route('front.account')}}">My Account</a></li>
                    <li class="breadcrumb-item">My Profile</li>
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
                            <h2 class="h4 mb-0 pt-2 pb-2">My Profile</h2>
                        </div>
                        @include('frontent.message')  
                        <div class="card-body p-4">
                            <form action="{{route('front.updateInfo')}}" method="POST">
                                @csrf
                                <div class="row">    
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <input type="text" name="name" id="name" value="{{(!empty($account))? $account->name:old('name')}}" class="form-control @error('name') is-invalid @enderror" placeholder="Name">
                                            @error('name')
                                                <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>            
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <input type="text" name="email" id="email" value="{{(!empty($account))? $account->email:old('email')}}" class="form-control @error('email') is-invalid @enderror" placeholder="Email">
                                            @error('email')
                                                <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>            
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <input type="tel" name="phone" value="{{(!empty($account))? $account->phone:old('phone')}}" id="mobile" class="form-control @error('phone') is-invalid @enderror" placeholder="Phone No.">
                                            @error('phone')
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