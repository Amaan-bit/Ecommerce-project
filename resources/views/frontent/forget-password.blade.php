@extends('frontent.layout.app')
@section('section')
<main>
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{route('front.home')}}">Home</a></li>
                    <li class="breadcrumb-item">Forget Password</li>
                </ol>
            </div>
        </div>
    </section>

    <section class=" section-10">
        <div class="container">
            <div class="login-form">  
                @include('frontent.message')  
                <form action="{{route('front.email.verify')}}" method="post">
                    @csrf
                    <h4 class="modal-title">Forget Your Password</h4>
                    <div class="form-group">
                        <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Enter Your Email" value="{{old('email')}}">
                        @error('email')
							<span class="text-danger">{{$message}}</span>
					    @enderror
                    </div>
                    <div class="text-center mt-3">
                        <input type="submit" class="btn btn-dark btn-block" value="Submit">    
                    </div>  
                </form>			
                <div class="text-center small">Don't have an account? <a href="{{route('front.register')}}">Sign up</a></div>
            </div>
        </div>
    </section>
</main>
@endsection