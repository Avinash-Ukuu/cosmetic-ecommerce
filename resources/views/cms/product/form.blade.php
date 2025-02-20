@extends('cms.layouts.master')
@section('headerLinks')
    <style>
        .image-upload-container {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }

        .image-upload-label {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100px;
            height: 100px;
            border: 2px dashed #ccc;
            cursor: pointer;
            font-size: 14px;
            color: #888;
            text-align: center;
        }

        .image-preview-grid {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .image-preview-item {
            position: relative;
            display: inline-block;
            width: 100px;
            height: 100px;
            border: 1px solid #ddd;
            overflow: hidden;
            border-radius: 5px;
        }

        .image-preview-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .image-preview-item .delete-btn {
            position: absolute;
            top: 5px;
            right: 5px;
            background: rgba(255, 0, 0, 0.7);
            border: none;
            color: white;
            font-size: 12px;
            cursor: pointer;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-12 col-xl-12 text-right">
                    <div class="justify-content-end d-flex">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-custom">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('product.index') }}">Product List</a></li>
                                <li class="breadcrumb-item active" aria-current="page"><span>Product Form</span></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Product form</h4>

                {!! Form::model($object, [
                    'url' => $url,
                    'method' => $method,
                    'onSubmit' => "document.getElementById('submit').disabled=true;",
                    'files' => true,
                    'class' => 'forms-sample',
                ]) !!}
                <input type="hidden" name="id" value="{{ $object->id }}">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            {!! Form::label('category_id', 'Select Category') !!}<span style="color: red;"> *</span>
                            {!! Form::select('category_id', $categories, null, [
                                'class' => 'form-control select2',
                                'id' => 'category_id',
                                'required',
                                'data-placeholder' => 'Select Category',
                                'placeholder' => 'Select Category',
                            ]) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('name', 'Name') !!}<span style="color: red;"> *</span>
                            {!! Form::text('name', null, ['class' => 'form-control name', 'placeholder' => 'Enter Name', 'required']) !!}
                        </div>

                        <div class="row">
                            <div class="form-group col-4">
                                {!! Form::label('price_without_tax', 'Price Without Tax') !!}<span style="color: red;"> *</span>
                                {!! Form::number('price_without_tax', null, [
                                    'class' => 'form-control price',
                                    'id' => 'price_without_tax',
                                    'placeholder' => 'Enter Price Without Tax',
                                    'required','step'=>'0.01',
                                    'min' => '0',
                                ]) !!}
                            </div>

                            <div class="form-group col-4">
                                {!! Form::label('tax', 'Tax (%)') !!}<span style="color: red;"> *</span>
                                {!! Form::number('tax', null, [
                                    'class' => 'form-control',
                                    'placeholder' => 'Enter Tax',
                                    'id' => 'tax',
                                    'required','step'=>'0.01',
                                    'min' => '0',
                                ]) !!}
                            </div>

                            <div class="form-group col-4">
                                {!! Form::label('sale_price', 'Sale Price') !!}
                                {!! Form::number('sale_price', null, [
                                    'class' => 'form-control','id'=> 'sale_price',
                                    'placeholder' => 'Sale Price',
                                    'min' => '0',
                                    'readonly'
                                ]) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('mrp_price', 'MRP Price (Optional)') !!}
                            {!! Form::number('mrp_price', null, [
                                'class' => 'form-control price',
                                'placeholder' => 'Enter MRP Price',
                                'required','step'=>'0.01',
                                'min' => '0',
                            ]) !!}
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group ">
                            {!! Form::label('description', 'Description') !!}<span style="color: red;"> *</span>
                            {!! Form::textArea('description', null, [
                                'class' => 'form-control description',
                                'placeholder' => 'Enter Description',
                                'required',"id"=>"summernote"
                            ]) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-4">
                        {!! Form::label('brand_id', 'Select Brand') !!}
                        {!! Form::select('brand_id', $brands, null, [
                            'class' => 'form-control select2',
                            'id' => 'brand_id',
                            'data-placeholder' => 'Select Brand',
                            'placeholder' => 'Select Brand',
                        ]) !!}
                    </div>

                    {{-- <div class="form-group col-4">
                        {!! Form::label('unit', 'Select Unit') !!}<span style="color: red;"> *</span>
                        {!! Form::select('unit', ['pc' => 'Pc', 'kg' => 'Kg'], null, [
                            'class' => 'form-control',
                            'id' => 'unit',
                            'required',
                            'placeholder' => 'Select Unit',
                        ]) !!}
                    </div> --}}

                    <div class="form-group col-4">
                        {!! Form::label('weight', 'Weight') !!}<span style="color: red;"> *</span>
                        {!! Form::text('weight', null, [
                            'class' => 'form-control weight',
                            'placeholder' => 'Enter Weight',
                            'required',
                        ]) !!}
                    </div>
                    <div class="form-group col-4">
                        {!! Form::label('quantity', 'Quantity') !!}<span style="color: red;"> *</span>
                        {!! Form::number('quantity', null, [
                            'class' => 'form-control quantity',
                            'placeholder' => 'Enter Quantity',
                            'min'=>'0',
                            'required',
                        ]) !!}
                    </div>

                </div>
                <div class="row ml-1 mb-1">
                    {!! Form::label('product_images', 'Product Images') !!}
                    <div class="image-upload-container ml-2" data-existing-count="{{ count($object->productImages) }}">
                        <label for="image_uploads" class="image-upload-label">Add Images</label>
                        <input type="file" id="image_uploads" name="images[]" accept="image/*,video/*" multiple hidden>
                        <div id="image_preview" class="image-preview-grid">
                        </div>

                        @if ($object->productImages->isNotEmpty())
                            @foreach ($object->productImages as $file)
                                @if (!empty($file->url) && file_exists('uploads/products/' . $object->id . '/' . $file->url))
                                    @if (in_array(pathinfo($file->url, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif', 'bmp']))
                                        <img src="{{ asset('uploads/products/' . $object->id . '/' . $file->url) }}"
                                            alt="Product Image" style="width: 100px; height: 100px;">
                                    @elseif (in_array(pathinfo($file->url, PATHINFO_EXTENSION), ['mp4', 'mov', 'avi', 'mkv']))
                                        <video width="100" height="100" controls>
                                            <source src="{{ asset('uploads/products/' . $object->id . '/' . $file->url) }}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    @endif
                                    <input type="checkbox" name="delete_files[]" data-file-id="{{ $file->id }}"
                                        class="delete-checkbox" value="{{ $file->id }}"> Delete
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
                <button type="submit" id="submit" class="btn btn-primary me-2">Submit</button>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
@section('footerScripts')
    <script>
        $(document).ready(function() {
            var name = $(".name").val();
            if (name == "") {
                $('#submit').prop('disabled', true);
            }
            $('.name').on('input', function() {
                var inputValue = $(this).val();
                var specialCharacter = "!@#\\$%\^&*_\\+=\\[\\]{};:\"<>?\\|`~";
                var emojiRegex = /[\uD800-\uDBFF][\uDC00-\uDFFF]|[\u2600-\u27FF]/;
                var hasSpecialCharacter = false;

                for (var i = 0; i < specialCharacter.length; i++) {
                    if (inputValue.includes(specialCharacter[i])) {
                        hasSpecialCharacter = true;
                        break;
                    }
                }

                if (hasSpecialCharacter || emojiRegex.test(inputValue)) {
                    $('#submit').prop('disabled', true);
                } else {
                    $('#submit').prop('disabled', false);
                }
            });

            function calculateSalePrice() {
                var priceWithoutTax = parseFloat($('#price_without_tax').val()) || 0;
                var tax = parseFloat($('#tax').val()) || 0;

                // Calculate the sale price with tax
                var salePrice = priceWithoutTax + (priceWithoutTax * tax / 100);

                // Update the sale price field with the calculated value
                $('#sale_price').val(salePrice.toFixed(2));
            }

            // Trigger calculation on input change
            $('#price_without_tax, #tax').on('input', function () {
                calculateSalePrice();
            });


            document.getElementById('image_uploads').addEventListener('change', function() {
                const previewContainer = document.getElementById('image_preview');
                const existingCount = parseInt(document.querySelector('.image-upload-container').getAttribute('data-existing-count')) || 0;
                const files = this.files;
                const totalFiles = existingCount + files.length;

                if (totalFiles > 6) {
                    alert('You can only have up to 6 files in total.');
                    this.value = ''; // Clear the file input
                    return;
                }
                if (files.length === 0) {
                    return;
                }

                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        const previewItem = document.createElement('div');
                        previewItem.classList.add('image-preview-item');

                        // Check if the file is an image or video
                        if (file.type.startsWith('image/')) {
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.style.width = '100px';
                            img.style.height = '100px';
                            previewItem.appendChild(img);
                        } else if (file.type.startsWith('video/')) {
                            const video = document.createElement('video');
                            video.src = e.target.result;
                            video.controls = true;
                            video.style.width = '100px';
                            video.style.height = '100px';
                            previewItem.appendChild(video);
                        }

                        // Delete button for preview
                        const deleteBtn = document.createElement('button');
                        deleteBtn.classList.add('delete-btn');
                        deleteBtn.innerHTML = '&times;';
                        deleteBtn.onclick = function() {
                            previewItem.remove();
                        };
                        previewItem.appendChild(deleteBtn);

                        previewContainer.appendChild(previewItem);
                    };

                    reader.readAsDataURL(file); // Read file as Data URL for preview
                }
            });

            $('.delete-checkbox').on('change', function() {
                var fileId = $(this).data('file-id');
                var fileWrapper = $('#file-wrapper-' + fileId);
                if (this.checked) {
                    var confirmation = confirm('Are you sure you want to delete this file?');
                    if (confirmation) {
                        $.ajax({
                            url: "{{ route('productImageDelete') }}",
                            method: 'POST',
                            data: {
                                image_id: fileId,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.success) {
                                    fileWrapper.remove(); // Remove the wrapper on success
                                    toastr.success('File deleted successfully.');
                                    location.reload();
                                } else {
                                    alert('Failed to delete the file.');
                                }
                            },
                            error: function() {
                                alert('An error occurred while trying to delete the file.');
                            }
                        });
                    } else {
                        this.checked = false;
                    }
                }
            });



        });
    </script>
@endsection
