@extends('admin.layout.app')
@section('content')
<section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Order: #{{$orders->orderId}}</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{route('admin.order.list')}}" class="btn btn-primary">Back</a>
            </div>
        </div>
        @include('admin.message')
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header pt-3">
                        <div class="row invoice-info">
                            <div class="col-sm-4 invoice-col">
                            <h1 class="h5 mb-3">Shipping Address</h1>
                            <address>
                                <strong>{{$orders->first_name}} {{$orders->last_name}}</strong><br>
                                {{$orders->apartment}}, {{$orders->address}}<br>
                                {{$orders->city}}, {{$orders->state}} {{$orders->zip}}<br>
                                Phone: {{$orders->mobile}}<br>
                                Email: {{$orders->email}}
                            </address>
                            </div>
                            
                            
                            
                            <div class="col-sm-4 invoice-col">
                                <h1 class="h5 mb-3">Order Details</h1>
                                <b>Order ID:</b> {{$orders->orderId}}<br>
                                <b>Order Date:</b> <span class="text-dark">{{Carbon\Carbon::parse($orders->created_at)->format('d M , Y')}}</span> 
                                <br>
                                <b>Total:</b> ${{number_format($orders->grand_total,2)}}<br>
                                <b>Status:</b> @if ($orders->order_status=='pending')
                                            <span class="text-warning">Pending</span>
                                        @elseif($orders->order_status=='shipped')
                                            <span class="text-warning">Shipped</span>
                                        @elseif ($orders->order_status=='delivered')
                                            <span class="text-success">Delivered</span>
                                        @elseif($orders->order_status=='cancelled')
                                            <span class="text-danger">Cancelled</span>
                                        @endif
                                <br>
                                <b>{{ucfirst($orders->order_status)}} Date:</b> <span class="text-dark">{{Carbon\Carbon::parse($orders->updated_at)->format('d M , Y')}}</span> 
                                <br>
                            </div>

                            <div class="col-sm-4 invoice-col">
                                <h1 class="h5 mb-3">Payment Details</h1>
                                <b>Payment Method:</b> {{$orders->payment_method}}<br>
                                <b>Payment Status:</b> {{$orders->payment_status}}<br>
                                @if($orders->payment_method=='paypal')
                                <b>Txn ID:</b> {{$transaction->txn_id}}</span><br>
                                <b>Txn Status:</b> {{$transaction->txn_status}}</span><br>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-3">								
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th width="100">Price</th>
                                    <th width="100">Qty</th>                                        
                                    <th width="100">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orderItems as $orderItem)
                                    <tr>
                                        <td>{{$orderItem->name}}</td>
                                        <td>${{number_format($orderItem->price,2)}}</td>                                        
                                        <td>{{$orderItem->qty}}</td>
                                        <td>${{number_format($orderItem->total,2)}}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <th colspan="3" class="text-right">Subtotal:</th>
                                    <td>${{number_format($orders->subtotal,2)}}</td>
                                </tr>
                                
                                <tr>
                                    <th colspan="3" class="text-right">Shipping:</th>
                                    <td>${{number_format($orders->shipping,2)}}</td>
                                </tr>
                                <tr>
                                    <th colspan="3" class="text-right">Discount:</th>
                                    <td>${{($orders->discount!=null)?$orders->discount:'0'}}</td>
                                </tr>
                                <tr>
                                    <th colspan="3" class="text-right">Grand Total:</th>
                                    <td>${{number_format($orders->grand_total,2)}}</td>
                                </tr>
                            </tbody>
                        </table>								
                    </div>                            
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h2 class="h4 mb-3">Order Status</h2>
                        <form action="{{route('admin.order.status')}}" method="post">
                            @csrf
                            <div class="mb-3">
                                <input type="hidden" name="id" value="{{$orders->id}}">
                                <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                                    <option value="" disabled selected>Select Status</option>
                                    <option value="shipped" {{($orders->order_status=='shipped')?'selected':''}}>Shipped</option>
                                    <option value="delivered" {{($orders->order_status=='delivered')?'selected':''}}>Delivered</option>
                                    <option value="cancelled" {{($orders->order_status=='cancelled')?'selected':''}}>Cancelled</option>
                                </select>
                                @error('status')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
                {{-- <div class="card">
                    <div class="card-body">
                        <h2 class="h4 mb-3">Send Inovice Email</h2>
                        <div class="mb-3">
                            <select name="status" id="status" class="form-control">
                                <option value="">Customer</option>                                                
                                <option value="">Admin</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary">Send</button>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->
@endsection