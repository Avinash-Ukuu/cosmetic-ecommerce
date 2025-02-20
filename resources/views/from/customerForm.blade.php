<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <meta name="token" content="{{ csrf_token() }}">
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family: sans-serif
        }

        .container {
            width: 1200px;
            margin: 0 auto;
        }

        input {

            width: 100%;
            padding: 8px;
            border: 1pt solid #cccccc;
            margin-bottom: 12px;
            border-radius: 4px;
        }


        form {

            max-width: 600px;
            margin: auto;
            padding: 20px;
            border-radius: 5px;
            background-color: #f9f9f9;
            box-shadow: rgba(50, 50, 93, 0.25) 0px 13px 27px -5px, rgba(0, 0, 0, 0.3) 0px 8px 16px -8px;
        }

        #button {
            width: 20%;
            margin: auto;
            background-color: #4CAf50;
            text-align: center;
            color: #ffffff;
            border: none;
            cursor: pointer;
            font-size: 16px;
            padding: 10px 15px;
            margin-right: auto;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 8px;
            font-size: 16px;

        }

        #button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <div class="container">
        <form action="{{ route('customer.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <label for="name"> Name </label>
            <input type="text" name="name" value="" required>
            <br>
            <label for="email"> Enter Email</label>
            <input type="email" name="email" value="" id="email" required>
            <br>
            <label for="phone_number"> Enter Phone Number</label>
            <input type="number" name="phone_number" value="" id="phone_number" required>
            <br>
            <label for="address_line1">Address 1</label>
            <input type="textarea" cols="" value="" name="address_line1" required>
            <br>
            <label for="address_line2">Address 2</label>
            <input type="textarea" cols="" value="" name="address_line2" required>
            <br>
            <label for="city"> City </label>
            <input type="text" name="city" value="" required>
            <br>
            <label for="state"> State </label>
            <input type="text" name="state" value="" required>
            <br>
            <label for="zip_code"> Zip Code </label>
            <input type="text" name="zip_code" value="" required>
            <br>
            <label for="country"> Country </label>
            <input type="text" name="country" value="" required>
            <br>
            <label for="profile picture ">Profile picture </label><input id="imageUpload" type="file"
                name="profile_pic" placeholder="Photo" required capture>

            <button type="submit" id="button">Submit</button>
        </form>
    </div>
</body>

</html>
