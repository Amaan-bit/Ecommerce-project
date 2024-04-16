<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Order Email</title>
</head>
<body>
    <div style="font-family: Arial, Helvetica, sans-serif; font-size:16px;">
        <h2> Hey, {{$data['name']}}</h2>
        <h3> Your order #{{$data['orderId']}} has been {{$data['status']}}. <br></h3>
        <p> 
            Thank you for ordering with us.  <br>
            
            You can review your order status at any time by visiting Your Account <br>
            
            Any orders placed within an hour of each other may be shipped together. <br>
            
            We hope you enjoyed your shopping experience with us and that you will visit us again soon.
            </p>
    </div>
</body>
</html>