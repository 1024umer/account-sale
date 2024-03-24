@php
    $customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Admin - Store Settings')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/swiper/swiper.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css') }}" />
@endsection

@section('page-style')
    <!-- Page -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/cards-advance.css') }}">
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/swiper/swiper.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/dashboards-analytics.js') }}"></script>
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
        var quill = new Quill('#editor2', {
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

        var quill = new Quill('#editor3', {
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
            $("#description1").val($("#editor1 > div").html());
            $("#description2").val($("#editor2 > div").html());
            $("#description3").val($("#editor3 > div").html());
        })
    </script>
    @if($store)
    <script>
        $(function (){
            $("#editor1 > div").html(`{!! $store->privacy_policy !!}`);
            $("#editor2 > div").html(`{!! $store->terms_of_use !!}`);
            $("#editor3 > div").html(`{!! $store->payment_and_delivery !!}`);
        });
    </script>
    @endif
@endsection

@section('content')

    <div class="d-flex justify-content-between align-items-center">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Store Settings</span></h4>
    </div>

    <div class="row">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Store Data</h5>
            </div>
            <div class="card-body">
                <form id="identifier" action="{{ route('admin.store.update') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="basic-default-fullname">Meta Title</label>
                        <input type="text" class="form-control" id="basic-default-fullname"
                            value="{{ $store ? $store->meta_title : '' }}" name="meta_title" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="basic-default-fullname">Meta Keywords</label>
                        <input type="text" class="form-control" id="basic-default-fullname"
                            value="{{ $store ? $store->meta_keywords : '' }}" name="meta_keywords" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="basic-default-fullname">Meta Description</label>
                        <textarea name="meta_description" class="form-control" id="" cols="30" rows="4">{{ $store ? $store->meta_description : '' }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="basic-default-fullname">Stripe API Key</label>
                        <input type="text" class="form-control" id="basic-default-fullname"
                            value="{{ $store ? $store->stripe_key : '' }}" name="stripe_key" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="basic-default-fullname">Stripe API Key Secret</label>
                        <input type="text" class="form-control" id="basic-default-fullname"
                            value="{{ $store? $store->stripe_secret : '' }}" name="stripe_secret" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="basic-default-fullname">CoinBase API Key</label>
                        <input type="text" class="form-control" id="basic-default-fullname"
                            value="{{ $store? $store->coinbase_api_key : '' }}" name="coinbase_api_key" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="basic-default-fullname">CoinBase API Version</label>
                        <input type="text" class="form-control" id="basic-default-fullname"
                            value="{{ $store? $store->coinbase_api_version : '2018-03-22' }}" name="coinbase_api_version" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="basic-default-fullname">PayPal Client ID</label>
                        <input type="text" class="form-control" id="basic-default-fullname"
                            value="{{ $store? $store->paypal_client_id : '' }}" name="paypal_client_id" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="basic-default-fullname">PayPal Secret</label>
                        <input type="text" class="form-control" id="basic-default-fullname"
                            value="{{ $store? $store->paypal_secret : '' }}" name="paypal_secret" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="basic-default-fullname">PayPal Mode</label>
                        <select name="paypal_mode" id="" class="form-control">
                            <option value="test">Test</option>
                            <option value="live">Live</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="basic-default-fullname">Perfect Money AccountID</label>
                        <input type="text" class="form-control" id="basic-default-fullname"
                            value="{{ $store? $store->perfect_money_accountid : '' }}" name="perfect_money_accountid" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="basic-default-fullname">Payeer Shop</label>
                        <input type="text" class="form-control" id="basic-default-fullname"
                            value="{{ $store? $store->payeer_shop : '' }}" name="payeer_shop" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="basic-default-fullname">Payeer Merchant Key</label>
                        <input type="text" class="form-control" id="basic-default-fullname"
                            value="{{ $store? $store->payeer_merchant_key : '' }}" name="payeer_merchant_key" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="basic-default-fullname">Paybis Account (Manual)</label>
                        <input type="text" class="form-control" id="basic-default-fullname"
                            value="{{ $store? $store->paybis_account : '' }}" name="paybis_account" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="basic-default-fullname">Payeer Account (Manual)</label>
                        <textarea name="payeer_account" class="form-control" id="" cols="30" rows="4">{{ $store ? $store->payeer_account : '' }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="basic-default-fullname">Referral Percentage (%) (amount refree will get from order)</label>
                        <input type="text" class="form-control" id="basic-default-fullname"
                            value="{{ $store? $store->referral_percentage : '' }}" name="referral_percentage" />
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="">Facebook Link</label>
                                <input type="text" name="facebook_link" value="{{ $store? $store->facebook_link : '' }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="">Instagram Link</label>
                                <input type="text" name="instagram_link" value="{{ $store? $store->instagram_link : '' }}" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="">Youtube Link</label>
                                <input type="text" name="youtube_link" value="{{ $store? $store->youtube_link : '' }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="">Discord Link</label>
                                <input type="text" name="discord_link" value="{{ $store? $store->discord_link : '' }}" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="">Telegram Link</label>
                                <input type="text" name="telegram_link" value="{{ $store? $store->telegram_link : '' }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="">Company Email</label>
                                <input type="text" name="company_email" value="{{ $store? $store->company_email : '' }}" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="">Privacy Policy page</label>
                                <input type="hidden" name="privacy_policy" id="description1">
                                <div style="height: 300px;" id="editor1"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="">Terms of use page</label>
                                <input type="hidden" name="terms_of_use" id="description2">
                                <div style="height: 300px;" id="editor2"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="">Payment and Delivery Page</label>
                                <input type="hidden" name="payment_and_delivery" id="description3">
                                <div style="height: 300px;" id="editor3"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="">Main Logo</label>
                                <input type="file" name="main_logo" class="form-control">
                                <div class="img-container my-2">
                                    @if($store)
                                    <img class="img-fluid" src="{{ $store->main_logo }}" alt="">
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="">Favicon</label>
                                <input type="file" name="favicon" class="form-control">
                                <div class="img-container my-2">
                                    @if($store)
                                    <img class="img-fluid" style="height: 180px" src="{{ $store->favicon }}" alt="">
                                    @endif
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
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>

@endsection
