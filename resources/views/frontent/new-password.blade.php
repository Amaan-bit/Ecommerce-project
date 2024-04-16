@extends('frontent.layout.app')
@section('section')
<main>
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{route('front.home')}}">Home</a></li>
                    <li class="breadcrumb-item">New Password</li>
                </ol>
            </div>
        </div>
    </section>

    <section class=" section-10">
        <div class="container">
            <div class="card col-md-5 mx-auto">
                <div class="card-header">
                    <h2 class="h5 mb-0 pt-2 pb-2">New Password</h2>
                </div>
                @include('frontent.message')  
                <div class="card-body p-4">
                    <form action="{{route('front.new.password.process')}}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="mb-3">               
                                <label for="name">New Password</label>
                                <input type="hidden" name="user_id" id="user_id" value="{{(session()->has('user_id'))? session('user_id'):''}}">
                                <input type="password" name="new_password" placeholder="New Password" value="{{old('new_password')}}" class="form-control @error('new_password') is-invalid @enderror">
                                @error('new_password')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="mb-3">               
                                <label for="name">Confirm Password</label>
                                <input type="password" name="confirm_password" placeholder="Confirm Password" value="{{old('confirm_password')}}" class="form-control @error('confirm_password') is-invalid @enderror">
                                @error('confirm_password')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="d-flex">
                                <button class="btn btn-dark">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
