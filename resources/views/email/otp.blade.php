<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Otp Email</title>
    </head>
   <body>
      <div style="font-family: Helvetica,Arial,sans-serif;line-height:2">
         <div style="margin:50px auto;width:80%;padding:20px 0">
            <div style="border-bottom:5px solid #eee">
               <a href="" style="font-size:30px;color: #f7c800;text-decoration:none;font-weight:600">Laravel Shop</a>
            </div>
            <p style="font-size:15px">Hello {{$data['name']}},</p>
            <p>Thank you for choosing Laravel Shop. Use this OTP to complete your forget password procedures and verify your account on Laravel shop.</p>
            <p>Remember, Never share this OTP with anyone.This otp is only valid for 3 minutes</p>
            <h2 style="background: #00466a;margin: 0 auto;width: max-content;padding: 0 10px;color: #fff;border-radius: 4px;">{{$data['otp']}}</h2>
            <p style="font-size:15px;">Regards,<br />Team Laravel Shop</p>
            <hr style="border:none;border-top:5px solid #eee" />
         </div>
      </div>
   </body>
</html>