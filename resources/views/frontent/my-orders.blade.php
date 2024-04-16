@extends('frontent.layout.app')
@section('section')
<main>
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{route('front.home')}}">Home</a></li>
                    <li class="breadcrumb-item"><a class="white-text" href="{{route('front.account')}}">My Account</a></li>
                    <li class="breadcrumb-item">My Order</li>
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
                @if ($orders->isNotEmpty())
                <div class="card">
                    <div class="card-header">
                        <h2 class="h5 mb-0 pt-2 pb-2">My Orders</h2>
                    </div>
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table">
                                <thead> 
                                    <tr>
                                        <th>Orders #</th>
                                        <th>Date Purchased</th>
                                        <th>Payment Method</th>
                                        <th>Payment Status</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                    <tr>
                                        <td>
                                            <a href="{{route('front.orderdetail',$order->orderId)}}">#{{$order->orderId}}</a>
                                        </td>
                                        <td>{{Carbon\Carbon::parse($order->created_at)->format('d M , Y')}}</td>
                                        <td>{{$order->payment_method}}</td>
                                        <td>{{$order->payment_status}}</td>
                                        <td>
                                            @if ($order->order_status=='pending')
                                                <span class="badge bg-warning">Pending</span>
                                            @elseif($order->order_status=='shipped')
                                                <span class="badge bg-warning">Shipped</span>
                                            @elseif ($order->order_status=='delivered')
                                                <span class="badge bg-success">Delivered</span>
                                            @elseif($order->order_status=='cancelled')
                                                <span class="badge bg-danger">Cancelled</span>
                                            @endif
                                        </td>
                                        <td>${{number_format($order->grand_total,2)}}</td>
                                    </tr> 
                                    @endforeach                                
                                </tbody>
                            </table>
                        </div> 
                        <nav aria-label="Page navigation example">
                            {{ $orders->links() }}
                       </nav>                           
                    </div>
                </div>
                @else
                <div class="card text-center shadow">
                    <div class="card-body">
                      <h4 class="card-title">No Orders Found</h4>
                    </div>
                  </div>
                @endif
                    
                </div>
            </div>
        </div>
    </section>
</main>
@endsection