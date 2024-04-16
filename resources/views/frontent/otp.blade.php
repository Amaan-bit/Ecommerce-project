@extends('frontent.layout.app')
@section('section')
<style>
    .inputfield {
        width: 100%;
        display: flex;
        justify-content: space-around;
    }
    .input {
        height: 3em;
        width: 3em;
        border: 2px solid #dad9df;
        outline: none;
        text-align: center;
        font-size: 1.5em;
        border-radius: 0.3em;
        background-color: #ffffff;
        outline: none;
        /*Hide number field arrows*/
        -moz-appearance: textfield;
    }
    input[type="number"]::-webkit-outer-spin-button,
    input[type="number"]::-webkit-inner-spin-button {
    -webkit-appearance: none;
        margin: 0;
    }
    .show {
        display: block;
    }
    .hide {
        display: none;
    }
    .input:disabled {
        color: #89888b;
    }
    .input:focus {
        border: 3px solid #ffb800;
    }
</style>
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

    <section class="section-10">
        <div class="container">
            <div class="login-form"> 
                @include('frontent.message')
                <form id="otp-form">   
                    <h4 class="modal-title">Your OTP</h4>
                    <div class="inputfield">
                        <input type="number" maxlength="1" name="otp1" class="input" id="otp1" disabled />
                        <input type="number" maxlength="1" name="otp2" class="input" id="otp2" disabled />
                        <input type="number" maxlength="1" name="otp3" class="input" id="otp3" disabled />
                        <input type="number" maxlength="1" name="otp4" class="input" id="otp4" disabled />
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="{{route('front.resend.otp',session('user_id'))}}" class="mt-3">Resend Otp?</a>
                    </div>
                    <div class="text-center mt-3">
                        <input type="hidden" name="user_id" id="user_id" value="{{(session()->has('user_id'))? session('user_id'):''}}">
                        <button id="save" class="btn btn-dark btn-block">Submit</button>    
                    </div>	
                </form>	
            </div>
        </div>
    </section>
</main>
@endsection
@push('script')
    <script>
        const input = document.querySelectorAll(".input");
        const inputField = document.querySelector(".inputfield");
        const submitButton = document.getElementById("submit");
        let inputCount = 0,
        finalInput = "";

        //Update input
        const updateInputConfig = (element, disabledStatus) => {
        element.disabled = disabledStatus;
        if (!disabledStatus) {
            element.focus();
        } else {
            element.blur();
        }
        };

        input.forEach((element, index) => {
        element.addEventListener("keyup", (e) => {
            e.target.value = e.target.value.replace(/[^0-9]/g, "");
            let { value } = e.target;

            if (value.length == 1) {
            updateInputConfig(e.target, true);
            if (inputCount <= 3 && e.key != "Backspace") {
                finalInput += value;
                if (inputCount < 3) {
                updateInputConfig(e.target.nextElementSibling, false);
                }
            }
            inputCount += 1;
            } else if (value.length == 0 && e.key == "Backspace") {
            finalInput = finalInput.substring(0, finalInput.length - 1);
            if (inputCount == 0) {
                updateInputConfig(e.target, false);
                return false;
            }
            updateInputConfig(e.target, true);
            e.target.previousElementSibling.value = "";
            updateInputConfig(e.target.previousElementSibling, false);
            inputCount -= 1;
            } else if (value.length > 1) {
            e.target.value = value.split("")[0];
            }

            submitButton.classList.add("hide");
        });
        });

        window.addEventListener("keyup", (e) => {
        if (inputCount > 3) {
            submitButton.classList.remove("hide");
            submitButton.classList.add("show");
            if (e.key == "Backspace") {
            finalInput = finalInput.substring(0, finalInput.length - 1);
            updateInputConfig(inputField.lastElementChild, false);
            inputField.lastElementChild.value = "";
            inputCount -= 1;
            submitButton.classList.add("hide");
            }
        }
        });

        const validateOTP = () => {
        alert("Success");
        };

        //Start
        const startInput = () => {
        inputCount = 0;
        finalInput = "";
        input.forEach((element) => {
            element.value = "";
        });
        updateInputConfig(inputField.firstElementChild, false);
        };

        window.onload = startInput;
        $(document).ready(function () {
            var otp = '';
            $('#otp1').on('change',function(){
                var otp1 = $('#otp1').val();
                otp = otp+otp1;
            });
            $('#otp2').on('change',function(){
                var otp2 = $('#otp2').val();
                otp = otp+otp2;
            });
            $('#otp3').on('change',function(){
                var otp3 = $('#otp3').val();
                otp = otp+otp3;
            });
            $('#otp4').on('change',function(){
                var otp4 = $('#otp4').val();
                otp = otp+otp4;
            });
            $('#save').on('click',function(){
                event.preventDefault()
                var user_id = $('#user_id').val();
                $.ajax({
                    type: "post",
                    url: "{{route('front.otp_verify')}}",
                    data: "otp="+otp+"&user_id="+user_id+"&_token={{csrf_token()}}",
                    success: function (response) {
                        if(response.status==false){
                            Swal.fire({
                            title: '',
                            text: response.message,
                            icon: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Ok'
                            }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                            });
                        }else if(response.status==true){
                            window.location.href="{{route('front.new.password')}}"
                        }
                    }
                });
            });

        });
    </script>
@endpush