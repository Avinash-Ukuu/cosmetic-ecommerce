<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Learntribe Ecommerce</title>
</head>

<body>
    <p>Dear {{$data['vendorName']}},</p>
    <p>{!! $data['body'] !!}</p>

    <p>Best regards,</p><br>
    <p>[Your Name]</p><br>
    <p>[Your Position]</p><br>
    <p>[Your Company Name]</p><br>
    <p>[Your Contact Information]</p><br>


</body>

</html>
