@php
    $customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Admin - Edit Licence Key')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
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

        .remove-button-2 {
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
                        <label class="form-label" for="">Key</label>
                        <input type="text" required class="form-control" name="key[]">
                        </div>
                        <div class="mb-3">
                        <label class="form-label" for="">Price</label>
                        <input type="number" required class="form-control" name="price[]">
                        </div>
                        <div class="mb-3">
                        <label class="form-label" for="">Valid Days</label>
                        <input type="number" required class="form-control" name="days[]">
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
    <script>
        $(document).ready(function() {
            $(".remove-button-2").click(function() {
                var imageId = $(this).data("id");
                var removedImageInput = $("#image_to_remove");
                $(this).parent().remove();
                var currentRemovedImages = removedImageInput.val();
                if (currentRemovedImages === "") {
                    removedImageInput.val(imageId);
                } else {
                    removedImageInput.val(currentRemovedImages + "," + imageId);
                }
            });
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
        $(function() {
            $("#editor1 > div").html(`{!! $key->description !!}`);
        });
    </script>
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Licence Key/</span> Edit</h4>
        <a href="{{ route('admin.licencekeys.') }}" class="btn btn-primary">Back</a>
    </div>
    <!-- Basic Layout -->
    <form class="dropzone" id="identifier" action="{{ route('admin.licencekeys.update') }}" method="post"
        enctype="multipart/form-data">
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Key Info</h5>
                    </div>
                    <div class="card-body">
                        @csrf
                        <input type="hidden" value="{{ $key->id }}" name="id">
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Title</label>
                            <input type="text" class="form-control" id="basic-default-fullname"
                                value="{{ $key->title }}" name="title" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-company">Description</label>
                            <input type="hidden" name="description" id="description">
                            <div style="height: 300px;" id="editor1"></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Product SKU</label>
                            <input type="text" class="form-control" id="basic-default-fullname"
                                value="{{ $key->sku }}" name="sku" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="">Category</label>
                            <select name="category" class="form-control" id="">
                                <option value="">Select a category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ $key->category->id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="">Status</label>
                            <select name="status" class="form-control" id="">
                                <option value="active">active</option>
                                <option value="inactive">inactive</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="">Options</label>
                            <select name="options" class="form-control" id="">
                                <option value="Undetected" {{ $key->options == 'Undetected' ? 'selected' : '' }}>Undetected
                                </option>
                                <option value="Detected" {{ $key->options == 'Detected' ? 'selected' : '' }}>Detected
                                </option>
                                <option value="Updating" {{ $key->options == 'Updating' ? 'selected' : '' }}>Updating
                                </option>
                                <option value="Testing" {{ $key->options == 'Testing' ? 'selected' : '' }}>Testing</option>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="">Main Image (Image that will be displayed on the
                                        landing pages)</label>
                                    <input type="file" name="main_image" class="form-control" accept="image/*">
                                    <div class="img-prv p-4">
                                        <img src="{{ $key->main_image }}" class="img img-fluid"
                                            style="max-height: 250px;" alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="">Long Image (Image that will be displayed on
                                        the
                                        sliders can be the same main image)</label>
                                    <input type="file" name="long_image" class="form-control" accept="image/*">
                                    <div class="img-prv p-4">
                                        <img src="{{ $key->long_image }}" class="img img-fluid"
                                            style="max-height: 250px;" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="">Images</label>
                            <input type="file" id="imagesInput" name="images[]" class="form-control" multiple>
                            <div id="imagePreviews"></div>
                            <div id="imagePreviews-2">
                                @foreach ($key->medias as $image)
                                    <div class="image-preview">
                                        <img style="max-width: 150px" class="m-3" src="{{ $image->image }}">
                                        <button data-id="{{ $image->id }}" type="button"
                                            class="remove-button-2 text-sm-center btn btn-sm btn-outline-danger rounded-circle">x</button>
                                    </div>
                                @endforeach
                                <input type="hidden" name="image_to_remove" id="image_to_remove" value="">
                            </div>
                        </div>
                    </div>
                </div>
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
                            <input type="text" class="form-control" value="{{ $key->meta_title }}" name="meta_title"
                                placeholder="" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-company">Meta Description</label>
                            <textarea name="meta_description" class="form-control" cols="30" rows="6">{{ $key->meta_description }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-phone">Meta Keywords</label>
                            <input type="text" id="basic-default-phone" class="form-control"
                                placeholder="Enter keywords comma seperated" value="{{ $key->meta_keywords }}"
                                name="meta_keywords" />
                        </div>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Account Credentials</h5>
                        <button class="btn btn-outline-success waves-effect" id="addMore" type="button">+</button>
                    </div>
                    <div class="card-body" id="dynamic-fields-container">
                        @foreach ($key->keyChannels as $channel)
                            <div class="mb-3">
                                <label class="form-label" for="">Key</label>
                                <input type="text" value="{{ $channel->key }}" required class="form-control"
                                    name="key[]">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="">Price</label>
                                <input type="number" value="{{ $channel->price }}" required class="form-control"
                                    name="price[]">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="">Valid Days</label>
                                <input type="number" value="{{ $channel->days }}" required class="form-control"
                                    name="days[]">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="">Status</label>
                                <select name="channel_status[]" class="form-control" id="">
                                    <option value="available" {{ $channel->status == 'available' ? 'selected' : '' }}>
                                        available</option>
                                    <option value="sold" {{ $channel->status == 'sold' ? 'selected' : '' }}>sold
                                    </option>
                                </select>
                            </div>
                        @endforeach
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


@endsection