@extends('frontent.layout.app')
@section('section')
<main>
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="#">Home</a></li>
                    <li class="breadcrumb-item">Register</li>
                </ol>
            </div>
        </div>
    </section>

    <section class=" section-10">
        <div class="container">
            <div class="login-form">    
                <form action="{{route('front.registration')}}" method="post">
                    @csrf
                    <h4 class="modal-title">Register Now</h4>
                    <div class="form-group">
                        <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Name" value="{{old('name')}}" name="name">
                        @error('name')
							<span class="text-danger">{{$message}}</span>
					    @enderror
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{old('email')}}" name="email">
                        @error('email')
							<span class="text-danger">{{$message}}</span>
					    @enderror
                    </div>
                    <div class="form-group">
                        <input type="tel" class="form-control @error('phone') is-invalid @enderror" placeholder="Phone" value="{{old('phone')}}" name="phone">
                        @error('phone')
							<span class="text-danger">{{$message}}</span>
					    @enderror
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control @error('password') is-invalid @enderror" placeholder="Password" value="{{old('password')}}" name="password">
                        @error('password')
							<span class="text-danger">{{$message}}</span>
					    @enderror
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control @error('confirm_password') is-invalid @enderror" placeholder="Confirm Password" name="confirm_password">
                        @error('confirm_password')
							<span class="text-danger">{{$message}}</span>
					    @enderror
                    </div>
                    <div class="form-group small">
                        <a href="#" class="forgot-link">Forgot Password?</a>
                    </div> 
                    <button type="submit" class="btn btn-dark btn-block btn-lg" value="Register">Register</button>
                </form>			
                <div class="text-center small">Already have an account? <a href="{{route('front.login')}}">Login Now</a></div>
            </div>
        </div>
    </section>
</main>
@endsection