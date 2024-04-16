<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Order Email</title>
</head>
<body style="font-family: Arial, Helvetica, sans-serif; font-size:16px;">
    <h2>Thanks for your order!!</h2>
    <h3>Your order Id is #{{$data['orders']->orderId}}</h3>
    <h4>Products</h4>
    <table cellpadding="3" cellspacing="3" border="0" style="width: 100%">
        <thead>
            <tr style="background-color: #CCC">
                <th>Product</th>
                <th>Price</th>
                <th>Qty</th>                                        
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data['order_items'] as $orderItem)
                <tr>
                    <td>{{$orderItem->name}}</td>
                    <td>${{number_format($orderItem->price,2)}}</td>                                        
                    <td>{{$orderItem->qty}}</td>
                    <td>${{number_format($orderItem->total,2)}}</td>
                </tr>
            @endforeach
            <tr>
                <th colspan="3" align="right">Subtotal:</th>
                <td>${{number_format($data['orders']->subtotal,2)}}</td>
            </tr>
            
            <tr>
                <th colspan="3" align="right">Shipping:</th>
                <td>${{number_format($data['orders']->shipping,2)}}</td>
            </tr>
            <tr>
                <th colspan="3" align="right">Discount:</th>
                <td>${{($data['orders']->discount!=null)?$data['orders']->discount:'0'}}</td>
            </tr>
            <tr>
                <th colspan="3" align="right">Grand Total:</th>
                <td>${{number_format($data['orders']->grand_total,2)}}</td>
            </tr>
        </tbody>
    </table>		
</body>
</html>