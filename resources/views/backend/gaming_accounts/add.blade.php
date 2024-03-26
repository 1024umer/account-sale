@php
    $customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Admin - New Gaming Account')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endsection

@section('page-style')
    <style>
        .image-preview {
            position: relative;
            display: inline-block;
            margin: 5px;
        }

        .remove-button {
            position: absolute;
            top: 0;
            right: 0;
            background-color: red;
            color: white;
            border: none;
            border-radius: 50%;
            padding: 2px 6px;
            cursor: pointer;
        }

        .file-input {
            display: block;
            width: 100%;
            height: 100px;
            border: 2px dashed #ccc;
            border-radius: 5px;
            padding: 10px;
            text-align: center;
            font-size: 18px;
            background-color: #f9f9f9;
            color: #333;
            cursor: pointer;
        }

        .file-input:hover {
            border-color: #666;
        }
    </style>
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave-phone.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/form-layouts.js') }}"></script>
    <script>
        $(function() {
            $('#addMore').on('click', function() {
                var dynamicFields = `
                    <div class="email-password-fields">
                        <div class="mb-3">
                            <label class="form-label" for="">Email</label>
                            <input type="email" required class="form-control" name="email[]">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="">Password</label>
                            <input type="text" required class="form-control" name="password[]">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="">Status</label>
                            <select name="channel_status[]" class="form-control" id="">
                                <option value="available">available</option>
                                <option value="sold">sold</option>
                            </select>
                        </div>
                    </div>
                `;
                $('#dynamic-fields-container').append(dynamicFields);
            });
        });
    </script>

    <script>
        $(function() {
            var imagePreviews = $('#imagePreviews');
            var imagesInput = $('#imagesInput');
            var filesArray = [];
            imagesInput.on('change', function() {
                var selectedFiles = this.files;
                var maxFiles = 10;
                if (selectedFiles.length > maxFiles) {
                    alert('You can only upload a maximum of ' + maxFiles + ' images.');
                    $(this).val('');
                    return;
                }
                filesArray = Array.from(selectedFiles);
                imagePreviews.empty();
                filesArray.forEach(function(file, index) {
                    createImagePreview(file, index);
                });
            });

            function createImagePreview(file, index) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    var imgPreview = $('<div class="image-preview">');
                    var img = $('<img style="max-width: 150px" class="m-3">').attr('src', e.target.result);
                    var removeButton = $(
                        '<button type="button" class="remove-button text-sm-center btn btn-sm btn-outline-danger rounded-circle">x</button>'
                    );

                    removeButton.on('click', function() {
                        imgPreview.remove();
                        filesArray.splice(index, 1);
                        var newFiles = new DataTransfer();
                        filesArray.forEach(function(file) {
                            newFiles.items.add(file);
                        });
                        imagesInput[0].files = newFiles.files;
                    });

                    imgPreview.append(img, removeButton);
                    imagePreviews.append(imgPreview);
                };

                reader.readAsDataURL(file);
            }
        });
    </script>

    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script>
        var quill = new Quill('#editor1', {
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline', 'strike'], // toggled buttons
                    ['blockquote', 'code-block'],

                    [{
                        'header': 1
                    }, {
                        'header': 2
                    }], // custom button values
                    [{
                        'list': 'ordered'
                    }, {
                        'list': 'bullet'
                    }],
                    [{
                        'script': 'sub'
                    }, {
                        'script': 'super'
                    }], // superscript/subscript
                    [{
                        'indent': '-1'
                    }, {
                        'indent': '+1'
                    }], // outdent/indent
                    [{
                        'direction': 'rtl'
                    }], // text direction

                    [{
                        'size': ['small', false, 'large', 'huge']
                    }], // custom dropdown
                    [{
                        'header': [1, 2, 3, 4, 5, 6, false]
                    }],

                    [{
                        'color': []
                    }, {
                        'background': []
                    }], // dropdown with defaults from theme
                    [{
                        'font': []
                    }],
                    [{
                        'align': []
                    }],

                    ['clean'] // remove formatting button
                ]
            },
            theme: 'snow'
        });

        $("#identifier").on("submit", function() {
            $("#description").val($("#editor1 > div").html());
        })
    </script>
    <script>
        function stock_delimiter_change(value) {
            if (value == 'custom') {
                $("#stock_field").after(
                    `<div class="mb-3" id="custom_stock_field">
                        <label class="form-label" for="">Custom Stock Delimiter</label>
                        <input type="text" required class="form-control" value=""
                                name="custom_stock_delimiter">
                    </div>`
                );
            } else {
                $("#custom_stock_field").empty();
                $("#custom_stock_field").remove();
            }
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>
    <script>
        $(document).ready(function() {
            // Triggered when the template dropdown changes
            $('#templateSelect').change(function() {
                var templateId = $(this).val();

                $.ajax({
                    url: '/admin/gamingaccounts/new/',
                    type: 'GET',
                    data: {
                        templateId: templateId
                    },
                    success: function(data) {
                        $('#basic-default-fullname').val(data.title);
                        CKEDITOR.instances['editor1'].setData(data.description || '');
                        $('#description').val(data.description);
                        $('#price').val(data.price);
                        $('#discount').val(data.discount);
                        $('#product-sku').val(data.sku);

                        $('#category_product option').filter(function() {
                            return $(this).text() == data.category;
                        }).prop('selected', true);

                        $('#subCategory_product option').filter(function() {
                            return $(this).text() == data.subcategory;
                        }).prop('selected', true);

                        $('#sub_subCategory_product option').filter(function() {
                            return $(this).text() == data.sub_subCategory;
                        }).prop('selected', true);

                        $('#status').val(data.status);
                        $('#options').val(data.options);

                        $('#meta_title').val(data.meta_title);
                        $('#meta_description').val(data.meta_description);
                        $('#meta_keywords').val(data.meta_keywords);
                        $('#custom_stock').val(data.custom_stock);
                        $('#format').val(data.format);
                        $('#stock_list').val(data.stock_list);
                        $('#manual').prop('checked', data.manual === "1");
                        $('#private').prop('checked', data.private === 1);
                        $('#checkbox_value').prop('checked', data.checkbox_value == 1);
                    },
                    error: function(error) {
                        console.log('Error:', error);
                    }
                });
            });
        });
        $(document).ready(function() {
            $('#addMoreFields').click(function() {
                var newFields = '<div class="additional-fields">';
                newFields += '<div class="mb-3">';
                newFields += '<label class="form-label" for="format">Format</label>';
                newFields += '<input type="text" class="form-control" name="additional_format[]" />';
                newFields += '</div>';
                newFields += '<div class="mb-3">';
                newFields += '<label class="form-label" for="stock_list">Stock List</label>';
                newFields +=
                    '<textarea class="form-control" name="additional_stock_list[]" rows="5"></textarea>';
                newFields += '</div>';
                newFields += '</div>';

                $('#additionalFieldsContainer').append(newFields);
            });
        });
    </script>
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Gaming Account/</span> New</h4>
        <a href="{{ route('admin.gamingaccounts.') }}" class="btn btn-primary">Back</a>
    </div>
    <!-- Basic Layout -->
    <form action="{{ route('admin.gamingaccounts.add') }}" id="identifier" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Account Info</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3" id="template">
                            <label class="form-label" for="">Template</label>
                            <select name="template" class="form-control" id="templateSelect">
                                <option value="">Select a Template</option>
                                @foreach ($templates as $template)
                                    <option value="{{ $template->id }}">{{ $template->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Title</label>
                            <input type="text" class="form-control" id="basic-default-fullname"
                                value="{{ old('title') }}" name="title" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-company">Description</label>
                            <input type="hidden" name="description" id="description">
                            <div style="height: 300px;" id="editor1"></div>
                        </div>
                        @php
                            $store = DB::table('stores')->first();
                        @endphp
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Admin Profit %</label>
                            <input type="number" class="form-control" id="basic-default-fullname"
                                value="{{ $store->adminProfit }}" readonly />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Price</label>
                            <input type="number" class="form-control" id="price" value="{{ old('price') }}"
                                name="price" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Discount %</label>
                            <input type="number" class="form-control" id="discount" value="{{ old('discount') }}"
                                name="discount" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Product SKU</label>
                            <input type="text" class="form-control" id="product-sku" value="{{ old('sku') }}"
                                name="sku" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="">Category</label>
                            <select name="category" class="form-control" id="category_product">
                                <option value="">Select a category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="">SubCategory</label>
                            <select name="sub_category" class="form-control" id="subCategory_product">
                                <option value="">Select a subcategory</option>
                                @foreach ($sub_categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="">Sub SubCategory</label>
                            <select name="sub_subcategory" class="form-control" id="sub_subCategory_product">
                                <option value="">Select a sub subcategory</option>
                                @foreach ($sub_subcategories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="">Status</label>
                            <select name="status" class="form-control" id="status">
                                <option value="active">active</option>
                                <option value="inactive">inactive</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="">Options</label>
                            <select name="options" class="form-control" id="options">
                                <option value="Undetected">Undetected</option>
                                <option value="Detected">Detected</option>
                                <option value="Updating">Updating</option>
                                <option value="Testing">Testing</option>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="">Main Image (Image that will be displayed on
                                        the landing pages)</label>
                                    <input type="file" name="main_image" id="main_image" class="form-control"
                                        accept="image/*">
                                    <div class="img-prv p-4">
                                        <img id="mainImagePreview" class="img img-fluid" style="max-height: 250px;"
                                            alt="">
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="">Long Image (Image that will be displayed on
                                        the
                                        sliders can be the same main image)</label>
                                    <input type="file" name="long_image" class="form-control" accept="image/*">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="">Images</label>
                            <input type="file" accept="image/*" max="5" id="imagesInput" name="images[]"
                                class="form-control" multiple>
                            <div id="imagePreviews">
                                <!-- Preview images will be added here -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="input-images"></div>

                <button type="submit" class="btn btn-primary w-100">ADD</button>
            </div>
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Meta Data</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Meta Title</label>
                            <input type="text" class="form-control" id="meta_title" value="{{ old('meta_title') }}"
                                name="meta_title" placeholder="" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-company">Meta Description</label>
                            <textarea name="meta_description" class="form-control" id="meta_description" cols="30" rows="6">{{ old('meta_description') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-phone">Meta Keywords</label>
                            <input type="text" id="meta_keywords" class="form-control"
                                placeholder="Enter keywords comma seperated" value="{{ old('meta_keywords') }}"
                                name="meta_keywords" />
                        </div>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Account Credentials Serials</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-phone">Custom Stock</label>
                            <input type="text" id="custom_stock" class="form-control" placeholder="Enter stock"
                                name="custom_stock" />
                        </div>
                        <div class="mb-3" id="stock_field">
                            <label class="form-label" for="">Stock Delimiter</label>
                            <select name="stock_delimiter" class="form-control" id=""
                                onchange="stock_delimiter_change(this.value)">
                                <option value="comma">Comma</option>
                                <option value="newline">New line</option>
                                <option value="custom">Custom</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-phone">Format</label>
                            <input type="text" id="format" class="form-control" name="format" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="">Serials List</label>
                            <textarea name="stock_list" class="form-control p-1" id="stock_list" placeholder="1, 2, 3, 4 ..." id=""
                                rows="5" style="width: 100%"></textarea>
                        </div>
                        <div id="additionalFieldsContainer">
                            <!-- Existing input fields for format and stock list -->
                        </div>
                        <button class="btn btn-outline-primary" type="button" id="addMoreFields">+</button>

                        <div class="mb-3">
                            <label class="form-check-label" for="manual">Account</label>
                            <input type="checkbox" id="checkbox_value" name="check_box_value" value="1">
                        </div>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">File Upload</h5>
                        {{-- <button class="btn btn-outline-success waves-effect" id="addMore" type="button">+</button> --}}
                    </div>
                    <div class="card-body" id="dynamic-fields-container">
                        {{-- <div class="mb-3">
                            <label class="form-label" for="">Email</label>
                            <input type="email" class="form-control" value="{{ old('email.0') }}"
                                name="email[]">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="">Password</label>
                            <input type="text" class="form-control" name="password[]"
                                value="{{ old('password.0') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="">Status</label>
                            <select name="channel_status[]" class="form-control" id="">
                                <option value="available">available</option>
                                <option value="sold">sold</option>
                            </select>
                        </div> --}}
                        <div class="mb-3">
                            <div class="form-group">
                                <label for="file">Choose or Drag & Drop a File</label>
                                <input type="file" id="file" name="file"
                                    class="form-control-file file-input">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="">How many times file can be sold (-1 for
                                unlimited)</label>
                            <input type="number" class="form-control" name="file_limit" value="-1" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="">Minimum Quantity</label>
                            <input type="number" class="form-control" name="min_quantity" value="1" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="">Maximum Quantity</label>
                            <input type="number" class="form-control" name="max_quantity" value="-1" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-check-label" for="manual">Manual</label>
                            <input type="checkbox" id="manual" name="manual" value="1">
                        </div>
                        <div class="mb-3">
                            <label class="form-check-label" for="manual">Private</label>
                            <input type="checkbox" id="private" name="private" value="1">
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                @if ($errors->any())
                    <div class="alert alert-danger mt-3" role="alert">
                        @foreach ($errors->all() as $error)
                            {{ $error }}
                            <br>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.querySelector('#file');

            fileInput.addEventListener('dragenter', function(e) {
                e.preventDefault();
            });

            fileInput.addEventListener('dragover', function(e) {
                e.preventDefault();
            });

            fileInput.addEventListener('drop', function(e) {
                e.preventDefault();

                const file = e.dataTransfer.files[0];
                fileInput.files = e.dataTransfer.files;
            });
        }); <
        /scrip>
    @endsection
