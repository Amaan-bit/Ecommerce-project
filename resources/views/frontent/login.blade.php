@extends('frontent.layout.app')
@section('section')
<main>
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{route('front.home')}}">Home</a></li>
                    <li class="breadcrumb-item">Login</li>
                </ol>
            </div>
        </div>
    </section>

    <section class=" section-10">
        <div class="container">
            <div class="login-form">  
                @include('frontent.message')  
                <form action="{{route('front.auth')}}" method="post">
                    @csrf
                    <h4 class="modal-title">Login to Your Account</h4>
                    <div class="form-group">
                        <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email" value="{{old('email')}}">
                        @error('email')
							<span class="text-danger">{{$message}}</span>
					    @enderror
                    </div>
                    
                    <div class="form-group">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password">
                        @error('password')
							<span class="text-danger">{{$message}}</span>
						@enderror
                    </div>
                    <div class="form-group small">
                        <a href="{{route('front.forget')}}" class="forgot-link">Forgot Password?</a>
                    </div> 
                    <input type="submit" class="btn btn-dark btn-block btn-lg" value="Login"> 
                    <div class="text-center">
                        <p>or</p>   
                        <a href="{{route('front.google')}}" class="login-with-google-btn" >
                            Sign in with Google
                        </a>
                    </div>             
                </form>	
                <div class="text-center small">Don't have an account? <a href="{{route('front.register')}}">Sign up</a></div>
            </div>
        </div>
    </section>
</main>
@endsection