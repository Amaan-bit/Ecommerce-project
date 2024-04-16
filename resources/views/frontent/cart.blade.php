@extends('frontent.layout.app')
@section('section')
<main>
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{route('front.home')}}">Home</a></li>
                    <li class="breadcrumb-item"><a class="white-text" href="{{route('front.shop')}}">Shop</a></li>
                    <li class="breadcrumb-item">Cart</li>
                </ol>
            </div>
        </div>
    </section>

    <section class=" section-9 pt-4">
        <div class="container">
            <div class="row">
            @if ($cartContent->isNotEmpty())
                <div class="col-md-8">
                    <div class="table-responsive">
                        <table class="table" id="cart">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if ($cartContent->isNotEmpty())
                                @foreach ($cartContent as $items)
                                <tr id="item-{{$items->rowId}}">
                                    <td>
                                        <div class=" d-flex align-items-center justify-content-start">
                                            <img src="{{asset('public/admin/img/products')}}/{{$items->options->image}}" width="" height="">
                                            <h2>{{$items->name}}</h2>
                                        </div>
                                    </td>
                                    <td>${{$items->price}}</td>
                                    <td>
                                        <div class="input-group quantity mx-auto" style="width: 100px;">
                                            <div class="input-group-btn">
                                                <button class="btn btn-sm btn-dark btn-minus p-2 pt-1 pb-1" data-rowid="{{$items->rowId}}">
                                                    <i class="fa fa-minus"></i>
                                                </button>
                                            </div>
                                            <input type="text" readonly class="form-control qty form-control-sm  border-0 text-center" value="{{$items->qty}}">
                                            <div class="input-group-btn">
                                                <button class="btn btn-sm btn-dark btn-plus p-2 pt-1 pb-1" data-rowid="{{$items->rowId}}">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        ${{$items->price*$items->qty}}
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-danger removeCart" data-rowid="{{$items->rowId}}"><i class="fa fa-times"></i></button>
                                    </td>
                                </tr> 
                                @endforeach
                            @else

                            @endif
                                                            
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-4">            
                    <div class="card cart-summery">
                        <div class="sub-title">
                            <h2 class="bg-white">Cart Summery</h3>
                        </div> 
                        <div class="card-body">
                            <div class="d-flex justify-content-between pb-2">
                                <div>Subtotal</div>
                                <div>${{Cart::subtotal()}}</div>
                            </div>
                            <div class="d-flex justify-content-between pb-2">
                                <div>Shipping</div>
                                <div>$0</div>
                            </div>
                            <div class="d-flex justify-content-between pb-2">
                                <div>Discount</div>
                                <div>$0</div>
                            </div>
                            <div class="d-flex justify-content-between summery-end">
                                <div>Total</div>
                                <div>${{Cart::subtotal()}}</div>
                            </div>
                            <div class="pt-5">
                                <a href="{{route('front.checkout')}}" class="btn-dark btn btn-block w-100">Proceed to Checkout</a>
                            </div>
                        </div>
                    </div>     
                    <div class="input-group apply-coupan mt-4">
                        <input type="text" placeholder="Coupon Code" class="form-control">
                        <button class="btn btn-dark" type="button" id="button-addon2">Apply Coupon</button>
                    </div> 
                </div>
            @else
                <div class="card text-center shadow">
                  <div class="card-body">
                    <h4 class="card-title">Cart Empty</h4>
                  </div>
                </div>
            @endif
            </div>
        </div>
    </section>
</main>
@endsection

@push('script')
    <script>
        $(document).ready(function () {
            $('.btn-plus').on('click',function(){
                var qtyinput = $(this).parent().prev();
                var qty = parseInt(qtyinput.val());
                var rowId = $(this).data('rowid');
                if(qty<10){
                    qty = qty+1;
                    qtyinput.val(qty);
                    updateCart(rowId,qty);
                } 
            });

            $('.btn-minus').on('click',function(){
                var qtyinput = $(this).parent().next();
                var qty = parseInt(qtyinput.val());
                var rowId = $(this).data('rowid');
                if(qty>1){
                    qty = qty-1;
                    qtyinput.val(qty);
                    updateCart(rowId,qty);
                }
            });

            $('.removeCart').on('click',function(){
               var id =  $(this).data('rowid');
               console.log(id);
                $.ajax({
                    type: "post",
                    url: "{{route('front.removecart')}}",
                    data: "id="+id+"&_token={{csrf_token()}}",
                    success: function (response) {
                        if(response.status==true){
                            $('#item-'+id).remove();
                            Swal.fire({
                            title: (response.status==true)?'Removed':'Sorry!',
                            text: response.message,
                            icon: (response.status==true)?'success':'warning',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Ok'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href="{{route('front.cart')}}";
                                }
                            });
                        }
                        
                    }
                });
            });

            function updateCart(rowId,qty){
                $.ajax({
                    type: "post",
                    url: "{{route('front.updateCart')}}",
                    data: "id="+rowId+"&qty="+qty+"&_token={{csrf_token()}}",
                    success: function (response) {
                        Swal.fire({
                        title: (response.status==true)?'Updated':'Sorry!',
                        text: response.message,
                        icon: (response.status==true)?'success':'warning',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Ok'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href="{{route('front.cart')}}";
                            }
                        });
                    }
               });
            }
        });
    </script>
@endpush