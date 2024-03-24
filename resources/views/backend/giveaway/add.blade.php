@php
    $customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Admin - New Give Away')

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
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Give Away/</span> New</h4>
        <a href="{{ route('admin.giveaway.') }}" class="btn btn-primary">Back</a>
    </div>
    <!-- Basic Layout -->
    <form action="{{ route('admin.giveaway.add') }}" id="identifier" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Give Away Info</h5>
                    </div>
                    <div class="card-body">
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
                        <div class="mb-3">
                            <label class="form-label" for="">Status</label>
                            <select name="status" class="form-control" id="">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="">Image</label>
                            <input type="file" accept="image/*" id="imagesInput" name="image"
                                class="form-control">
                            <div id="imagePreviews">
                                <!-- Preview images will be added here -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="input-images"></div>

                <button type="submit" class="btn btn-primary w-100">ADD</button>
            </div>
        </div>
    </form>


@endsection
