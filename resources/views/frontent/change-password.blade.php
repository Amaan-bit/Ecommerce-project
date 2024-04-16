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
                            <h2 class="h5 mb-0 pt-2 pb-2">Change Password</h2>
                        </div>
                        @include('frontent.message')  
                        <div class="card-body p-4">
                            <form action="{{route('front.changePasswordProcess')}}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="mb-3">               
                                        <label for="name">Old Password</label>
                                        <input type="password" name="old_password" placeholder="Old Password" value="{{old('old_password')}}" class="form-control @error('old_password') is-invalid @enderror">
                                        @error('old_password')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">               
                                        <label for="name">New Password</label>
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
            </div>
        </div>
    </section>
</main>
@endsection