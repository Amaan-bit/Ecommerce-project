@extends('frontent.layout.app')
@section('section')
<main>
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{route('front.home')}}">Home</a></li>
                    <li class="breadcrumb-item">Contact Us</li>
                </ol>
            </div>
        </div>
    </section>

    <section class=" section-10">
        <div class="container">
            <div class="section-title mt-5 ">
                <h2>Love to Hear From You</h2>
            </div>   
        </div>
    </section>

    <section>
        <div class="container">          
            <div class="row">
                <div class="col-md-6 mt-3 pe-lg-5">
                    <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using Content.</p>
                    <address>
                    Cecilia Chapman <br>
                    711-2880 Nulla St.<br> 
                    Mankato Mississippi 96522<br>
                    <a href="tel:+xxxxxxxx">(XXX) 555-2368</a><br>
                    <a href="mailto:jim@rock.com">jim@rock.com</a>
                    </address>                    
                </div>

                <div class="col-md-6">
                    <form method="post" id="contactForm" name="contact-form" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="mb-2" for="name">Name</label>
                            <input class="form-control" id="name" type="text" name="name">
                            <span class="text-danger"></span>
                        </div>
                        
                        <div class="mb-3">
                            <label class="mb-2" for="email">Email</label>
                            <input class="form-control" id="email" type="text" name="email">
                            <span class="text-danger"></span>
                        </div>
                        
                        <div class="mb-3">
                            <label class="mb-2">Subject</label>
                            <input class="form-control" id="msg_subject" type="text" name="subject">
                            <span class="text-danger"></span>
                        </div>
                        
                        <div class="mb-3">
                            <label for="message" class="mb-2">Message</label>
                            <textarea class="form-control" rows="3" id="message" name="message"></textarea>
                            <span class="text-danger"></span>
                        </div>

                        <div class="mb-3">
                            <label class="mb-2">Image</label>
                            <input class="form-control" id="image" type="file" name="image">
                            <span class="text-danger"></span>
                        </div>

                        <div class="mb-3">
                            <label class="mb-2">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option selected disabled>Select Option</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                            <span class="text-danger"></span>
                        </div>
                      
                        <div>
                            <button type="submit" class="btn btn-dark"><i class="material-icons mdi mdi-message-outline"></i> Send Message</button>
                            <div id="msgSubmit" class="h3 text-center hidden"></div>
                            <div class="clearfix"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
@push('script')
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                }
            });
            $('#contactForm').submit(function (e) { 
                e.preventDefault();
                var element = $(this);
                $.ajax({
                    type: "post",
                    url: "{{route('front.contact.data')}}",
                    data: element.serializeArray(),
                    dataType: "json",
                    success: function (response) {
                        var error = response.error;
                        if(error.name){
                            $('#name').addClass('is-invalid')
                            .siblings('span').html(error.name);
                        }else{
                            $('#name').removeClass('is-invalid')
                            .siblings('span').html('');
                        }

                        if(error.email){
                            $('#email').addClass('is-invalid')
                            .siblings('span').html(error.email);
                        }else{
                            $('#email').removeClass('is-invalid')
                            .siblings('span').html('');
                        }

                        if(error.image){
                            $('#image').addClass('is-invalid')
                            .siblings('span').html(error.image);
                        }else{
                            $('#image').removeClass('is-invalid')
                            .siblings('span').html('');
                        }

                        if(error.status){
                            $('#status').addClass('is-invalid')
                            .siblings('span').html(error.status);
                        }else{
                            $('#status').removeClass('is-invalid')
                            .siblings('span').html('');
                        }
                    }
                });
                
            });
        });
    </script>
@endpush