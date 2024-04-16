@extends('admin.layout.app')
@section('content')
<section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Orders</h1>
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
        <div class="card">
            <div class="card-body table-responsive p-4">								
                <table class="table table-hover text-nowrap" id="myTable">
                    <thead>
                        <tr>
                            <th>Orders #</th>											
                            <th>Customer</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th>Date Purchased</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>
                                    <a href="{{route('admin.order.detail',$order->orderId)}}">#{{$order->orderId}}</a>
                                </td>
                                <td>{{$order->first_name}} {{$order->last_name}}</td>
                                <td>{{$order->email}}</td>
                                <td>{{$order->mobile}}</td>
                                <td>
                                    @if ($order->order_status=='pending')
                                        <span class="badge bg-warning">Pending</span>
                                    @elseif($order->order_status=='shipped')
                                        <span class="badge bg-warning">Shipped</span>
                                    @elseif ($order->order_status=='delivered')
                                        <span class="badge bg-success">Delivered</span>
                                    @elseif($order->order_status=='cancel')
                                        <span class="badge bg-danger">Cancel</span>
                                    @endif
                                </td>
                                <td>${{number_format($order->grand_total,2)}}</td>
                                <td>{{Carbon\Carbon::parse($order->created_at)->format('d M , Y')}}</td>
                            </tr> 
                        @endforeach 
                    </tbody>
                </table>											
            </div>
        </div>
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->
@endsection