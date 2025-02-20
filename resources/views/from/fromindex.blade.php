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
            font-family: sans-serif;
        }

        .container {
            width: 1200px;
            margin: 0 auto;
        }

        input, select {
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
            background-color: #4CAF50;
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
        <form action="{{ route('vendor.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <label for="name">Name</label>
            <input type="text" name="name" value="" required>

            <label for="email">Email</label>
            <input type="email" name="email" value="" required>

            <label for="gender">Gender</label>
            <input type="text" name="gender" value="" required>

            <label for="dob">Date of Birth</label>
            <input type="date" name="dob" value="" required>

            <label for="residential_address">Residential Address</label>
            <input type="text" name="residential_address" value="" required>

            <label for="city">City</label>
            <input type="text" name="city" value="" required>

            <label for="phone_number">Phone Number</label>
            <input type="number" name="phone_number" value="" required>

            <label for="store_name">Store Name</label>
            <input type="text" name="store_name" value="" required>

            <label for="store_address">Store Address</label>
            <input type="text" name="store_address" value="" required>

            <label for="aadhar_card">Aadhar Card</label>
            {{-- <input type="text" name="aadhar_card" value="" required> --}}
            <input id="imageUpload" type="file" name="aadhar_card" placeholder="Aadhar Card" required capture>

            <label for="dl">Driving License</label>
            {{-- <input type="text" name="dl" value="" required> --}}
            <input id="imageUpload" type="file" name="dl" placeholder="Driving License" required capture>

            <label for="voter_card">Voter Card</label>
            {{-- <input type="text" name="voter_card" value="" required> --}}
            <input id="imageUpload" type="file" name="voter_card" placeholder="Voter Card" required capture>

            <label for="gst_number">GST Number</label>
            <input type="text" name="gst_number" value="">

            <label for="business_type">Business Type</label>
            <select name="business_type" required>
                <option value="">Select a business type</option>
                <option value="Manufacture/design products">Manufacture/design products</option>
                <option value="Reseller of products">Reseller of products</option>
                <option value="Deal in raw materials">Deal in raw materials </option>
                <option value="Others">Others</option>
            </select>

            {{-- <label for="profile_pic">Profile Picture</label>
            <input id="imageUpload" type="file" name="profile_pic" placeholder="Photo" required capture> --}}

            <button type="submit" id="button">Submit</button>
        </form>
    </div>
</body>

</html>
