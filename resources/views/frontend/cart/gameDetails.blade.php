@extends('frontend.layout')

{{-- @if ($data)
    @section('meta_title', $data->meta_title . ' ' . $product->meta_title)
    @section('meta_keyowrds', $data->meta_keyowrds . ' ' . $product->meta_keyowrds)
    @section('meta_description', $data->meta_description . ' ' . $product->meta_description)
@endif --}}

@section('page-styles')
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.css" rel="stylesheet" />
    <style>
        .hero-section {
            padding-top: 14vh;
            /* background-image: url("{{ asset('frontend/images/page-bg.png') }}"); */
            min-height: 100vh;
            width: 100vw;
            background-position: top;
            background-repeat: no-repeat;
            background-size: 100%;
        }

        .hero-section .container-heading a {
            text-decoration: none;
            color: #62646c;
            transition: 0.2s;
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
            margin-right: 10px;
        }

        .hero-section .container-heading a:hover {
            transition: 0.2s;
            color: #20ada3;
        }

        .hero-section .left-side .text h1 {
            font-weight: 700;
            font-size: 36px;
            line-height: 100%;
            color: #dbdbdb;
        }

        .hero-section .left-side .text img {
            max-width: 190px;
        }

        .hero-section .left-side .text p {
            font-weight: 500;
            font-size: 14px;
            line-height: 24px;
            letter-spacing: .012em;
            color: #95979f;
        }

        .hero-section .left-side h4 {
            color: #62646c;
            margin-top: 10px;
            margin-bottom: 10px;
            font-weight: 400;
            font-size: 14px;
            line-height: 24px;
            text-transform: uppercase;
        }

        .hero-section .left-side a {
            font-weight: 600;
            text-decoration: none;
            font-size: 13px;
            line-height: 24px;
            letter-spacing: .012em;
            color: #95979f;
        }

        .hero-section .left-side svg {
            fill: #95979f;
        }

        .hero-section .left-side .icon-svg {
            padding-top: 25px;
            padding-bottom: 25px;
            border-bottom: 1px solid hsla(0, 0%, 100%, .03);
        }

        .hero-section .left-side .social a {
            padding: 2px;
            margin-right: 5px;
            transition: 0.2s;
        }

        .hero-section .left-side .social a:hover svg {
            transition: 0.2s;
            fill: #20ada3 !important;
        }

        @media (max-width: 767px) {
            .breadcrumb {
                padding-top: 30px;
            }

            .hero-section .left-side {
                padding-left: 20px;
                padding-right: 20px;
            }

            .page-contacts-form {
                padding: 20px;
                width: auto;
            }
        }

        .right-side .product-rate {
            border-radius: 12px;
            overflow: hidden;
            -webkit-backdrop-filter: blur(24px);
            backdrop-filter: blur(24px);
        }

        .right-side .product-rate .top {
            background-color: #1b2026;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 80px;
            padding: 0 30px;
            box-sizing: border-box;
        }

        .right-side .product-rate .top .region {
            color: #3496a9;
            height: 100%;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            grid-gap: 12px;
            gap: 12px;
            cursor: pointer;
            font-weight: 600;
            font-size: 13px;
            line-height: 24px;
            letter-spacing: .02em;
            position: relative;
            transition: .25s;
        }

        .right-side .product-rate .top .region::after {
            opacity: 1;
            content: "";
            position: absolute;
            bottom: -4px;
            height: 8px;
            width: 100%;
            left: 0;
            background: linear-gradient(89.98deg, #5777a5, #09bbad);
            border-radius: 8px;
            transition: .25s;
        }

        .right-side .bottom {
            background-color: #171b20;
        }



        .right-side .bottom .rates .rate p {
            font-weight: 600;
            font-size: 14px;
            line-height: 20px;
            letter-spacing: .02em;
            font-feature-settings: "pnum" on, "lnum" on;
            color: #62646c;
            transition: .25s;
        }

        .right-side .rates {
            background: hsla(0, 0%, 100%, .02);
            border-radius: 10px;
        }

        .right-side .dividor-svg {
            margin-top: -5px;
        }

        .right-side .payBtn {
            background: #76dba1;
            border-radius: 12px;
            padding: 18px;
            text-transform: uppercase;
            border: none;
            font-weight: 600;
            font-size: 14px;
            transition: 0.2s;
            color: #171b20;
        }

        .payBtn {
            background: #76dba1;
            border-radius: 12px;
            padding: 18px;
            text-transform: uppercase;
            border: none;
            font-weight: 600;
            font-size: 14px;
            transition: 0.2s;
            color: #171b20;
        }

        .payBtn:hover {
            background: #20ada3;
        }

        .right-side .payBtn:hover {
            background: #20ada3;
        }

        .right-side .pay-div {
            background-color: hsla(0, 0%, 100%, .03);
            margin-top: -5px;
        }

        .right-side h4 p {
            margin: 0;
        }

        .right-side p {
            font-weight: 600;
            font-size: 14px;
            line-height: 24px;
            display: inline-block;
            letter-spacing: .012em;
            color: #62646c;
        }

        .right-side h4 {
            font-weight: 600;
            line-height: 34px;
            display: inline-block;
            letter-spacing: .02em;
            color: #dbdbdb;
        }

        .right-side .pay-div a {
            font-weight: 600;
            text-decoration: none;
            color: #dbdbdb;
        }

        .right-side .pay-div .confirm {
            font-weight: 500;
        }

        .right-side .product-h {
            background-color: hsla(0, 0%, 100%, .03);
            border-radius: 12px;
            margin-top: 10px;
            text-align: center;
        }

        .right-side .product-h p {
            margin: auto;
            font-size: 11px;
        }

        .add-background {
            background: linear-gradient(90deg, #5975a4, #07bcad) !important;
        }

        .add-background p {
            color: #dbdbdb !important;
        }

        section .left-side .badge-div {
            padding: 4px 8px;
            background: rgba(118, 219, 161, .12);
            backdrop-filter: blur(24px);
            border-radius: 8px;
            align-items: center;
            font-weight: 600;
            font-size: 10px;
            line-height: 24px;
            text-transform: uppercase;
        }

        section .left-side {
            background-color: hsla(0, 0%, 100%, .03);
            margin-top: 24px;
            height: fit-content;
            border-radius: 12px;
        }

        section .left-side .main-img {
            width: 100%;
            border-radius: 12px;
        }

        section .left-side .badge-div.Undetected {
            color: #76dba1;
        }

        section .left-side .badge-div.Undetected svg {
            fill: #76dba1;
        }

        .left-side .badge-div.Updating {
            color: #1a85dd;
        }

        .left-side .badge-div.Updating svg {
            fill: #1a85dd;
        }


        .left-side .badge-div.Testing {
            color: #dadd1a;
        }

        .left-side .badge-div.Testing svg {
            fill: #dadd1a;
        }

        .left-side .badge-div.Detected {
            color: #dd581a;
        }

        .left-side .badge-div.Detected svg {
            fill: #dd581a;
        }

        section .left-side .top .heading-div {
            border-bottom: 1px solid hsla(0, 0%, 100%, .05);
        }

        section .left-side .heading h1 {
            font-weight: 700;
            font-size: 28px;
            line-height: 34px;
            letter-spacing: .02em;
            color: #dbdbdb;
        }

        .left-side .heading p {
            font-weight: 600;
            font-size: 14px;
            line-height: 24px;
            display: inline-block;
            letter-spacing: .012em;
            color: #62646c;
        }

        .left-side .icons-div {
            height: 48px;
            width: 100%;
            padding-top: 5px;
            background: linear-gradient(90deg, rgba(39, 46, 55, 0), rgba(39, 46, 55, .24) 51.04%, rgba(39, 46, 55, 0));
            -webkit-mask-image: linear-gradient(90deg, rgba(23, 27, 32, .18) 9.38%, #272e37 48.75%, rgba(23, 27, 32, .18) 93.23%);
            mask-image: linear-gradient(90deg, rgba(23, 27, 32, .18) 9.38%, #272e37 48.75%, rgba(23, 27, 32, .18) 93.23%);
        }

        .overflow-auto::-webkit-scrollbar {
            width: 0;
            height: 0;
        }

        .left-side .icons-div .icon {
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            grid-gap: 12px;
            gap: 12px;
            padding: 0 27px;
            white-space: nowrap;
            border-right: 1px solid hsla(0, 0%, 100%, .05);
            position: relative;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        .left-side .icons-div .icon p {
            color: hsla(0, 0%, 89.8%, .78);
            font-weight: 700;
            margin: auto;
            font-size: 12px;
            line-height: 20px;
            letter-spacing: .02em;
            text-transform: uppercase;
        }

        .left-side .img-div .main-img {
            height: 500px;
        }

        .left-side .img-div img {
            width: auto;
            border-radius: 10px;
            max-height: 160px;
            display: block;
        }

        form .input {
            display: grid;
            grid-template-columns: 22px 1fr;
            align-content: center;
            grid-gap: 12px;
            width: 100%;
            gap: 12px;
            height: 64px;
            padding: 0 16px;
            background: hsla(0, 0%, 100%, .03);
            border-radius: 8px;
            transition: .25s;
            position: relative;
        }

        form .input input {
            height: 100%;
            background: transparent;
            font-weight: 500;
            font-size: 14px;
            line-height: 24px;
            color: #dbdbdb;
            border: none;
        }

        .form-container .input-group {
            border-bottom: 1px solid hsla(0, 0%, 100%, .03);
        }

        input {
            outline: none;
        }

        input:focus {
            outline: none;
        }

        input:focus {
            .input {
                border: 1px solid #3496a9;
            }
        }

        .form-container label {
            font-weight: 400;
            font-size: 12px;
            line-height: 24px;
            text-transform: uppercase;
            color: #62646c;
            margin-bottom: 10px;
        }

        .description-div.content {
            background: #171b20;
            color: #3496a9;
            border-radius: 12px;
        }

        .description-div.content h1 {
            font-weight: 600;
            font-size: 18px;
            line-height: 24px;
            display: inline;
            margin-top: auto;
            margin-bottom: auto;
        }

        .description-div.content svg {
            fill: #3496a9;
            display: inline;
        }

        .description {
            margin-top: -5px;
            background: rgba(23, 25, 29, .48);
        }

        .modal .modal-content {
            background-color: #111317;
            min-width: 40vw;
            margin: auto;
        }

        .modal p {
            font-weight: 700;
            font-size: 14px;
            line-height: 20px;
            letter-spacing: .02em;
            font-variant: small-caps;
            color: #62646c;
            text-transform: uppercase;
        }

        .modal h1 {
            margin-top: 10px;
            font-weight: 700;
            font-size: 24px;
            line-height: 29px;
            letter-spacing: .02em;
            color: #dbdbdb;
        }

        .modal .right {
            padding: 30px;
            background: #181c22;
            -webkit-backdrop-filter: blur(48px);
            backdrop-filter: blur(48px);
            border-radius: 0 12px 12px 0;
        }

        .modal .counter {
            display: grid;
            grid-template-columns: 48px 1fr 48px;
            grid-gap: 10px;
            gap: 10px;
            align-items: center;
            background: hsla(0, 0%, 100%, .03);
            border-radius: 12px;
            padding: 10px;
        }

        .modal .counter button {
            width: 100%;
            height: 100%;
            background: transparent;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border: none;
            padding: 10px;
        }

        .modal .counter__number {
            min-width: 32px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #dbdbdb;
            font-weight: 700;
            font-size: 16px;
            line-height: 20px;
            letter-spacing: .02em;
            text-transform: uppercase;
            background: transparent;
            text-align: center;
        }

        .modal .payBtn2 {
            padding: 15px 18px;
            width: auto;
            letter-spacing: 1px;
            font-weight: 600;
            background: #76dba1;
            border-radius: 12px;
            text-decoration: none;
            color: #181c22;
            font-size: 12px;
            border: none;
        }

        .modal .payBtn2:hover {
            background-color: #09bbad;
        }

        .modal .icons-div .icons {
            background: transparent;
            display: inline;
            position: relative;
            cursor: pointer;
        }

        .modal .icons-div .icons img {
            height: 60px;
            max-width: 80px;
        }

        .modal .bg-border {
            border: 1px solid #2d9cdb;
            border-radius: 5px;
            background: hsla(0, 0%, 100%, .03);
        }

        .modal .warning {
            background-color: rgba(224, 173, 50, .04);
            border-radius: 6px;
        }

        .modal .warning p {
            font-weight: 500;
            color: rgba(224, 173, 50, .88);
            margin: auto;
            font-size: 12px;
            line-height: 20px;
            letter-spacing: .012em;
        }

        .modal .btn-close {
            color: #dbdbdb;
        }
    </style>
@endsection
@section('page-scripts')
    <script>
        $(function() {
            var va = $('.form-check-input1').val();
            $('.form-check-input1').change(function() {
                var value = $(this).val();
                if ($(this).val() != '') {
                    $('.form-check-input').not(this).parent().parent().parent().removeClass(
                        'add-background');
                    $(this).parent().parent().parent().addClass('add-background');
                }
                $('.totalPrice').html(value);
                $('.totalPriceInput').val(value);
                @if ($user != null)
                    if (value > {{ $user->balance }}) {
                        $('#pay_by_balance').css('display', 'none');
                        $('#payment_method').val('');
                    } else {
                        $('#pay_by_balance').css('display', 'block');
                    }
                @endif
            });

            $('.payBtn').on('click', function() {
                if (!$('.privacyCheck').prop('checked')) {
                    alert('Please accept the terms of user agreement');
                }
            });

            $('.plusBtn').on('click', function() {
                var temp = parseInt($('#quantity_input').val());
                var max = parseInt($('#max_input').val());
                if (max == temp) {
                    return;
                }

                var value = parseInt($('.totalPriceInput').val());
                var unit = value / (temp);
                value += unit;
                temp += 1;
                $('.totalPrice').html(value);
                $('.totalPriceInput').val(value);
                @if ($user != null)
                    if (value > {{ $user->balance }}) {
                        $('#pay_by_balance').css('display', 'none');
                        $('#payment_method').val('');
                    } else {
                        $('#pay_by_balance').css('display', 'block');
                    }
                @endif
                $('#quantity_input').val(temp);
                $('.counter__number').empty();
                $('.counter__number').html(temp);
            });
            $('.minusBtn').on('click', function() {
                var temp = parseInt($('#quantity_input').val());
                if (temp == 1) {
                    return;
                }
                var value = parseInt($('.totalPriceInput').val());
                var unit = value / (temp);
                value -= unit;
                temp -= 1;
                $('.totalPrice').html(value);
                $('.totalPriceInput').val(value);
                @if ($user != null)
                    if (value > {{ $user->balance }}) {
                        $('#pay_by_balance').css('display', 'none');
                        $('#payment_method').val('');
                    } else {
                        $('#pay_by_balance').css('display', 'block');
                    }
                @endif
                $('#quantity_input').val(temp);
                $('.counter__number').empty();
                $('.counter__number').html(temp);
            });

            $('.py-icons').on('click tap touchstart', function() {
                $('.py-icons').removeClass('bg-border');
                $(this).addClass('bg-border');
                var value = $(this).data('value');
                if (value == 'paypal') {
                    $('#paymentForm').prop('action', '{{ route('paypal.pay') }}');
                    $('#payment_method').val('paypal');
                } else if (value == 'stripe') {
                    $('#payment_method').val('stripe');
                    $('#paymentForm').prop('action', '{{ route('stripe.pay') }}');
                } else if (value == 'coinbase') {
                    $('#payment_method').val('coinbase');
                    $('#paymentForm').prop('action', '{{ route('coinbase.pay') }}');
                } else if (value == 'perfectmoney') {
                    $('#payment_method').val('perfectmoney');
                    $('#paymentForm').prop('action', '{{ route('perfectmoney.pay') }}');
                } else if (value == 'payeer') {
                    $('#payment_method').val('payeer');
                    $('#paymentForm').prop('action', '{{ route('payeer.pay') }}');
                } else if (value == 'balance') {
                    $('#payment_method').val('balance');
                    $('#paymentForm').prop('action', '{{ route('stripe.pay') }}');
                }
            });
        });
    </script>
@endsection
@section('content')
    <nav class="navbar navbar-expand-lg navbar-light bg-light" style="padding-top: 130px;">
        <!-- Container wrapper -->
        <div class="container-fluid">
            <!-- Toggle button -->
            <button class="navbar-toggler px-0" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarExample5"
                aria-controls="navbarExample5" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>

            <!-- Collapsible wrapper -->
            <div class="collapse navbar-collapse" id="navbarExample5">
                <!-- Left links -->
                <ul class="navbar-nav me-auto ps-lg-0" style="padding-left: 0.15rem">
                    <!-- Navbar dropdown -->
                    @foreach ($categoriesHeader as $category)
                        <li class="nav-item dropdown position-static">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-mdb-toggle="dropdown" aria-expanded="false" onmouseover="click()">
                                <img style="width: 30px;" src="{{ $category->image }}">
                                {{ $category->name }}
                            </a>
                            <!-- Dropdown menu -->
                            <div class="dropdown-menu w-100 mt-0" aria-labelledby="navbarDropdown"
                                style="
                                        border-top-left-radius: 0;
                                        border-top-right-radius: 0;
                                    ">
                                <div class="container">
                                    <div class="row my-4">
                                        @foreach ($category->subCategories as $sub_category)
                                            <div class="col-md-12 col-lg-4 mb-4 mb-lg-0 border-bottom">
                                                <a href="{{ route('games.category', ['slug' => $sub_category->name]) }}"
                                                    class="text-uppercase font-weight-bold">
                                                    <img style="width: 30px;" src="{{ $sub_category->image }}">
                                                    <strong>{{ $sub_category->name }}</strong>
                                                </a>
                                                @foreach ($sub_category->subSubCategory as $subSubCategory)
                                                    <a href="{{ route('games.subcategory', ['slug' => $subSubCategory->name]) }}"
                                                        class="text-dark">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <p class="mb-2">
                                                                    {{ $subSubCategory->name }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                @endforeach
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <!-- Left links -->
            </div>
            <!-- Collapsible wrapper -->
        </div>
        <!-- Container wrapper -->
    </nav>
    {{-- <input type="hidden" name="max_input" value="{{ $maxInput }}" id="max_input"> --}}
    <section class="hero-section">
        <div class="page-head">
            <div class="container">
                <div class=" container-heading breadcrumb">
                    <a href="{{ route('home') }}">Home > </a>
                    <a href="{{ route('games') }}">Games > </a>
                    {{-- <a href="#">{{ $product->title }}</a> --}}
                </div>
                <div class="row my-4">
                    @if (!empty($cartItems))
                        {{-- @php
                            $totalAmount = 0; // Initialize the total amount variable
                        @endphp --}}
                        @foreach ($cartItems as $collection)
                            @foreach ($collection->services as $product)
                                <div class="col-md-4">
                                    <div class="left-side row p-4">
                                        {{-- <div class="col-md-3 main-img-cont pe-3">
                                            <img class="main-img h-100" src="{{ $product->long_image }}"
                                                alt="product image">
                                        </div>
                                        <div class="col-md-9">
                                            <div class="top">
                                                <div
                                                    class="d-flex heading-div pb-3 mb-1 justify-content-between align-items-center">
                                                    <div class="heading">
                                                        <p>{{ $product->title }}</p>
                                                        <h1>Devil Software</h1>
                                                    </div>
                                                    <div class="badge-div {{ $product->options }}">
                                                        <svg width="18" height="18" viewBox="0 0 18 18"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M15 5.56064V6.78272C15 7.21011 14.786 7.6108 14.415 7.85788L6.56718 13.2404C6.06064 13.5876 5.36861 13.5876 4.8692 13.2337L3.84186 12.5125C3.37812 12.1853 3 11.4774 3 10.9365V5.56064C3 4.8127 3.61356 3.98462 4.36266 3.72418L8.26516 2.35518C8.67182 2.21494 9.32818 2.21494 9.73484 2.35518L13.6373 3.72418C14.3864 3.98462 15 4.8127 15 5.56064Z">
                                                            </path>
                                                            <path
                                                                d="M13.9543 9.13219C14.3884 8.80335 15 9.12534 15 9.6871V10.975C15 11.5299 14.6514 12.2493 14.2239 12.585L10.6264 15.3869C10.3108 15.6267 9.88984 15.75 9.46893 15.75C9.04802 15.75 8.6271 15.6267 8.31142 15.3801L7.76554 14.9553C7.4104 14.6813 7.4104 14.1264 7.77212 13.8523L13.9543 9.13219Z">
                                                            </path>
                                                        </svg>
                                                        <span>{{ $product->options }}</span>
                                                    </div>
                                                </div>
                                                <div class="icons-div my-4 py-0 d-flex align-items-center overflow-auto">
                                                    <div class="icon">
                                                        <img src="{{ asset('frontend/images/skins.png') }}" alt="icon">
                                                        <p>quests</p>
                                                    </div>
                                                    <div class="icon">
                                                        <img src="{{ asset('frontend/images/aim.png') }}" alt="icon">
                                                        <p>aim</p>
                                                    </div>
                                                    <div class="icon">
                                                        <img src="{{ asset('frontend/images/dots-circle.png') }}"
                                                            alt="icon">
                                                        <p>misc</p>
                                                    </div>
                                                    <div class="icon">
                                                        <img src="{{ asset('frontend/images/aim.png') }}" alt="icon">
                                                        <p>aim</p>
                                                    </div>
                                                    <div class="icon">
                                                        <img src="{{ asset('frontend/images/radar.png') }}" alt="icon">
                                                        <p>radar</p>
                                                    </div>
                                                    <div class="icon">
                                                        <img src="{{ asset('frontend/images/skins.png') }}" alt="icon">
                                                        <p>skins</p>
                                                    </div>
                                                    <div class="icon">
                                                        <img src="{{ asset('frontend/images/colors.png') }}"
                                                            alt="icon">
                                                        <p>colors</p>
                                                    </div>
                                                    <div class="icon">
                                                        <img src="{{ asset('frontend/images/settings.png') }}"
                                                            alt="icon">
                                                        <p>settings</p>
                                                    </div>
                                                    <div class="icon">
                                                        <img src="{{ asset('frontend/images/skins.png') }}" alt="icon">
                                                        <p>loot</p>
                                                    </div>
                                                </div>
                                                <div
                                                    class="images-div mt-3 d-flex overflow-auto justify-content-start align-items-center">
                                                    @foreach ($product->medias as $media)
                                                        <div class="img-div p-2">
                                                            <img src="{{ $media->image }}" alt="">
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div> --}}
                                    </div>
                                    {{-- <div class="my-3 row">
                                        <div class="description-div content p-4 d-flex align-items-center">
                                            <svg class="me-3" width="24" height="24" viewBox="0 0 24 24"
                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M12.678 19.957C12.9528 20.0209 12.9779 20.3807 12.7103 20.4699L11.1303 20.9899C7.16034 22.2699 5.07034 21.1999 3.78034 17.2299L2.50034 13.2799C1.22034 9.30992 2.28034 7.20992 6.25034 5.92992L6.77434 5.75639C7.1772 5.62297 7.56927 6.02703 7.45487 6.43571C7.39817 6.63828 7.34362 6.84968 7.29034 7.06992L6.31034 11.2599C5.21034 15.9699 6.82034 18.5699 11.5303 19.6899L12.678 19.957Z">
                                                </path>
                                                <path
                                                    d="M17.1702 3.2105L15.5002 2.8205C12.1602 2.0305 10.1702 2.6805 9.00018 5.1005C8.70018 5.7105 8.46018 6.4505 8.26018 7.3005L7.28018 11.4905C6.30018 15.6705 7.59018 17.7305 11.7602 18.7205L13.4402 19.1205C14.0202 19.2605 14.5602 19.3505 15.0602 19.3905C18.1802 19.6905 19.8402 18.2305 20.6802 14.6205L21.6602 10.4405C22.6402 6.2605 21.3602 4.1905 17.1702 3.2105ZM15.2902 13.3305C15.2002 13.6705 14.9002 13.8905 14.5602 13.8905C14.5002 13.8905 14.4402 13.8805 14.3702 13.8705L11.4602 13.1305C11.0602 13.0305 10.8202 12.6205 10.9202 12.2205C11.0202 11.8205 11.4302 11.5805 11.8302 11.6805L14.7402 12.4205C15.1502 12.5205 15.3902 12.9305 15.2902 13.3305ZM18.2202 9.9505C18.1302 10.2905 17.8302 10.5105 17.4902 10.5105C17.4302 10.5105 17.3702 10.5005 17.3002 10.4905L12.4502 9.2605C12.0502 9.1605 11.8102 8.7505 11.9102 8.3505C12.0102 7.9505 12.4202 7.7105 12.8202 7.8105L17.6702 9.0405C18.0802 9.1305 18.3202 9.5405 18.2202 9.9505Z">
                                                </path>
                                            </svg>
                                            <h1>Description</h1>
                                        </div>

                                        <div class="description p-4">
                                            {!! $product->description !!}
                                        </div>
                                        <div class="description-div content p-4 d-flex align-items-center">
                                            <svg class="me-3" width="24" height="24" viewBox="0 0 24 24"
                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M12.678 19.957C12.9528 20.0209 12.9779 20.3807 12.7103 20.4699L11.1303 20.9899C7.16034 22.2699 5.07034 21.1999 3.78034 17.2299L2.50034 13.2799C1.22034 9.30992 2.28034 7.20992 6.25034 5.92992L6.77434 5.75639C7.1772 5.62297 7.56927 6.02703 7.45487 6.43571C7.39817 6.63828 7.34362 6.84968 7.29034 7.06992L6.31034 11.2599C5.21034 15.9699 6.82034 18.5699 11.5303 19.6899L12.678 19.957Z">
                                                </path>
                                                <path
                                                    d="M17.1702 3.2105L15.5002 2.8205C12.1602 2.0305 10.1702 2.6805 9.00018 5.1005C8.70018 5.7105 8.46018 6.4505 8.26018 7.3005L7.28018 11.4905C6.30018 15.6705 7.59018 17.7305 11.7602 18.7205L13.4402 19.1205C14.0202 19.2605 14.5602 19.3505 15.0602 19.3905C18.1802 19.6905 19.8402 18.2305 20.6802 14.6205L21.6602 10.4405C22.6402 6.2605 21.3602 4.1905 17.1702 3.2105ZM15.2902 13.3305C15.2002 13.6705 14.9002 13.8905 14.5602 13.8905C14.5002 13.8905 14.4402 13.8805 14.3702 13.8705L11.4602 13.1305C11.0602 13.0305 10.8202 12.6205 10.9202 12.2205C11.0202 11.8205 11.4302 11.5805 11.8302 11.6805L14.7402 12.4205C15.1502 12.5205 15.3902 12.9305 15.2902 13.3305ZM18.2202 9.9505C18.1302 10.2905 17.8302 10.5105 17.4902 10.5105C17.4302 10.5105 17.3702 10.5005 17.3002 10.4905L12.4502 9.2605C12.0502 9.1605 11.8102 8.7505 11.9102 8.3505C12.0102 7.9505 12.4202 7.7105 12.8202 7.8105L17.6702 9.0405C18.0802 9.1305 18.3202 9.5405 18.2202 9.9505Z">
                                                </path>
                                            </svg>
                                            <h1>Price</h1>
                                        </div>
                                        <div class="description p-4">
                                            {{$product->price - ($product->price * $product->discount) / 100;}}
                                        </div>
                                    </div> --}}
                                </div>
                                {{-- @php
                                    $totalAmount += $product->price - ($product->price * $product->discount) / 100; // Accumulate the price for each item
                                @endphp --}}
                            @endforeach
                        @endforeach
                    @endif

                </div>
                <div class="row d-flex justify-content-center" >
                    {{-- @php
                    if(isset($value))
                    {
                        $totalAmount = $totalAmount-($totalAmount * $value) / 100;
                    }
                    @endphp --}}
                    <div class="col-md-4 right-side p-4">
                        <div class="product-rate w-100">
                            <div class="top">
                                <div class="region">
                                    <svg width="25" height="24" viewBox="0 0 25 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <mask id="mask0_932_5370" maskUnits="userSpaceOnUse" x="0" y="0" width="25"
                                            height="24" style="mask-type:alpha">
                                            <circle cx="12.5" cy="12" r="12" fill="#C4C4C4"></circle>
                                        </mask>
                                        <g mask="url(#mask0_932_5370)">
                                            <mask id="mask1_932_5370" maskUnits="userSpaceOnUse" x="-4" y="0"
                                                width="33" height="24" style="mask-type:alpha">
                                                <rect x="-3.86377" width="32.7273" height="24" rx="2"
                                                    fill="white"></rect>
                                            </mask>
                                            <g mask="url(#mask1_932_5370)">
                                                <rect x="0.5" width="24" height="24" fill="#043CAE">
                                                </rect>
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M11.4184 5.43531L12.4997 5.11861L13.581 5.43531L13.2643 4.35401L13.581 3.27271L12.4997 3.58941L11.4184 3.27271L11.7351 4.35401L11.4184 5.43531ZM11.4184 20.7275L12.4997 20.4108L13.581 20.7275L13.2643 19.6462L13.581 18.5649L12.4997 18.8816L11.4184 18.5649L11.7351 19.6462L11.4184 20.7275ZM20.1457 12.7648L19.0644 13.0815L19.3811 12.0002L19.0644 10.9189L20.1457 11.2356L21.227 10.9189L20.9103 12.0002L21.227 13.0815L20.1457 12.7648ZM3.77246 13.0815L4.85377 12.7648L5.93508 13.0815L5.61837 12.0002L5.93508 10.9189L4.85377 11.2356L3.77246 10.9189L4.08917 12.0002L3.77246 13.0815ZM19.1215 8.94211L18.0402 9.25882L18.3569 8.17752L18.0402 7.09621L19.1215 7.41292L20.2028 7.09621L19.8861 8.17752L20.2028 9.25882L19.1215 8.94211ZM4.79691 16.9045L5.87821 16.5878L6.95952 16.9045L6.64281 15.8232L6.95952 14.7419L5.87821 15.0586L4.79691 14.7419L5.11361 15.8232L4.79691 16.9045ZM16.3228 6.1432L15.2415 6.4599L15.5582 5.3786L15.2415 4.2973L16.3228 4.614L17.4042 4.2973L17.0874 5.3786L17.4042 6.4599L16.3228 6.1432ZM7.59557 19.7032L8.67688 19.3864L9.75819 19.7032L9.44148 18.6219L9.75819 17.5405L8.67688 17.8573L7.59557 17.5405L7.91228 18.6219L7.59557 19.7032ZM19.1215 16.5878L18.0402 16.9045L18.3569 15.8232L18.0402 14.7419L19.1215 15.0586L20.2028 14.7419L19.8861 15.8232L20.2028 16.9045L19.1215 16.5878ZM4.79691 9.25882L5.87821 8.94211L6.95952 9.25882L6.64281 8.17752L6.95952 7.09621L5.87821 7.41292L4.79691 7.09621L5.11361 8.17752L4.79691 9.25882ZM16.3228 19.3864L15.2415 19.7032L15.5582 18.6219L15.2415 17.5405L16.3228 17.8573L17.4042 17.5405L17.0874 18.6219L17.4042 19.7032L16.3228 19.3864ZM7.59557 6.4599L8.67688 6.1432L9.75819 6.4599L9.44148 5.3786L9.75819 4.2973L8.67688 4.614L7.59557 4.2973L7.91228 5.3786L7.59557 6.4599Z"
                                                    fill="#FFD429"></path>
                                            </g>
                                        </g>
                                    </svg>
                                    Global Region
                                </div>
                            </div>
                            <div class="bottom p-4 pt-5 pb-2">
                                <div class="rates p-2 add-background mb-3">
                                    <div class="rate  p-2 d-flex align-items-center justify-content-between">
                                        <div class="rate-left d-flex align-items-center">
                                            <input class="form-check-input form-check-input1 m-2 p-2"
                                                value="{{ $totalAmount }}" checked type="radio"
                                                name="flexRadioDefault" id="flexRadioDefault1">
                                            <p class="mb-0 ml-2 ms-1">Credentials</p>
                                        </div>
                                        <div class="right-side">
                                            <h4 class="m-auto">
                                                ${{ $totalAmount }}<p>.00
                                                </p>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="dividor-svg">
                                <svg width="450" height="56" viewBox="0 0 450 56" fill="none"
                                    xmlns="http://www.w3.org/2000/svg" class="page-product-rates__check"
                                    style="width:100%;">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M450 0H0V18C5.40274 18.0001 9.7825 22.4772 9.7825 28C9.7825 33.5228 5.40274 37.9999 0 38V56H450V38C444.597 38 440.217 33.5228 440.217 28C440.217 22.4772 444.597 18 450 18V0ZM30.8477 25C30.0192 25 29.3477 25.6716 29.3477 26.5C29.3477 27.3284 30.0192 28 30.8477 28H32.8288C33.6572 28 34.3288 27.3284 34.3288 26.5C34.3288 25.6716 33.6572 25 32.8288 25H30.8477ZM42.7345 25C41.9061 25 41.2345 25.6716 41.2345 26.5C41.2345 27.3284 41.9061 28 42.7345 28H46.6968C47.5252 28 48.1968 27.3284 48.1968 26.5C48.1968 25.6716 47.5252 25 46.6968 25H42.7345ZM56.6025 25C55.7741 25 55.1025 25.6716 55.1025 26.5C55.1025 27.3284 55.7741 28 56.6025 28H60.5648C61.3933 28 62.0648 27.3284 62.0648 26.5C62.0648 25.6716 61.3933 25 60.5648 25H56.6025ZM70.4706 25C69.6421 25 68.9706 25.6716 68.9706 26.5C68.9706 27.3284 69.6421 28 70.4706 28H74.4328C75.2613 28 75.9328 27.3284 75.9328 26.5C75.9328 25.6716 75.2613 25 74.4328 25H70.4706ZM84.3386 25C83.5101 25 82.8386 25.6716 82.8386 26.5C82.8386 27.3284 83.5101 28 84.3386 28H88.3009C89.1293 28 89.8009 27.3284 89.8009 26.5C89.8009 25.6716 89.1293 25 88.3009 25H84.3386ZM98.2066 25C97.3781 25 96.7066 25.6716 96.7066 26.5C96.7066 27.3284 97.3781 28 98.2066 28H102.169C102.997 28 103.669 27.3284 103.669 26.5C103.669 25.6716 102.997 25 102.169 25H98.2066ZM112.075 25C111.246 25 110.575 25.6716 110.575 26.5C110.575 27.3284 111.246 28 112.075 28H116.037C116.865 28 117.537 27.3284 117.537 26.5C117.537 25.6716 116.865 25 116.037 25H112.075ZM125.943 25C125.114 25 124.443 25.6716 124.443 26.5C124.443 27.3284 125.114 28 125.943 28H129.905C130.733 28 131.405 27.3284 131.405 26.5C131.405 25.6716 130.733 25 129.905 25H125.943ZM139.811 25C138.982 25 138.311 25.6716 138.311 26.5C138.311 27.3284 138.982 28 139.811 28H143.773C144.601 28 145.273 27.3284 145.273 26.5C145.273 25.6716 144.601 25 143.773 25H139.811ZM153.679 25C152.85 25 152.179 25.6716 152.179 26.5C152.179 27.3284 152.85 28 153.679 28H157.641C158.469 28 159.141 27.3284 159.141 26.5C159.141 25.6716 158.469 25 157.641 25H153.679ZM167.547 25C166.718 25 166.047 25.6716 166.047 26.5C166.047 27.3284 166.718 28 167.547 28H171.509C172.337 28 173.009 27.3284 173.009 26.5C173.009 25.6716 172.337 25 171.509 25H167.547ZM181.415 25C180.586 25 179.915 25.6716 179.915 26.5C179.915 27.3284 180.586 28 181.415 28H185.377C186.205 28 186.877 27.3284 186.877 26.5C186.877 25.6716 186.205 25 185.377 25H181.415ZM195.283 25C194.454 25 193.783 25.6716 193.783 26.5C193.783 27.3284 194.454 28 195.283 28H199.245C200.073 28 200.745 27.3284 200.745 26.5C200.745 25.6716 200.073 25 199.245 25H195.283ZM209.151 25C208.322 25 207.651 25.6716 207.651 26.5C207.651 27.3284 208.322 28 209.151 28H213.113C213.941 28 214.613 27.3284 214.613 26.5C214.613 25.6716 213.941 25 213.113 25H209.151ZM223.019 25C222.19 25 221.519 25.6716 221.519 26.5C221.519 27.3284 222.19 28 223.019 28H226.981C227.809 28 228.481 27.3284 228.481 26.5C228.481 25.6716 227.809 25 226.981 25H223.019ZM236.887 25C236.058 25 235.387 25.6716 235.387 26.5C235.387 27.3284 236.058 28 236.887 28H240.849C241.677 28 242.349 27.3284 242.349 26.5C242.349 25.6716 241.677 25 240.849 25H236.887ZM250.755 25C249.926 25 249.255 25.6716 249.255 26.5C249.255 27.3284 249.926 28 250.755 28H254.717C255.545 28 256.217 27.3284 256.217 26.5C256.217 25.6716 255.545 25 254.717 25H250.755ZM264.623 25C263.794 25 263.123 25.6716 263.123 26.5C263.123 27.3284 263.794 28 264.623 28H268.585C269.413 28 270.085 27.3284 270.085 26.5C270.085 25.6716 269.413 25 268.585 25H264.623ZM278.491 25C277.662 25 276.991 25.6716 276.991 26.5C276.991 27.3284 277.662 28 278.491 28H282.453C283.281 28 283.953 27.3284 283.953 26.5C283.953 25.6716 283.281 25 282.453 25H278.491ZM292.359 25C291.53 25 290.859 25.6716 290.859 26.5C290.859 27.3284 291.53 28 292.359 28H296.321C297.149 28 297.821 27.3284 297.821 26.5C297.821 25.6716 297.149 25 296.321 25H292.359ZM306.227 25C305.398 25 304.727 25.6716 304.727 26.5C304.727 27.3284 305.398 28 306.227 28H310.189C311.017 28 311.689 27.3284 311.689 26.5C311.689 25.6716 311.017 25 310.189 25H306.227ZM320.095 25C319.266 25 318.595 25.6716 318.595 26.5C318.595 27.3284 319.266 28 320.095 28H324.057C324.885 28 325.557 27.3284 325.557 26.5C325.557 25.6716 324.885 25 324.057 25H320.095ZM333.963 25C333.134 25 332.463 25.6716 332.463 26.5C332.463 27.3284 333.134 28 333.963 28H337.925C338.753 28 339.425 27.3284 339.425 26.5C339.425 25.6716 338.753 25 337.925 25H333.963ZM347.831 25C347.002 25 346.331 25.6716 346.331 26.5C346.331 27.3284 347.002 28 347.831 28H351.793C352.621 28 353.293 27.3284 353.293 26.5C353.293 25.6716 352.621 25 351.793 25H347.831ZM361.699 25C360.87 25 360.199 25.6716 360.199 26.5C360.199 27.3284 360.87 28 361.699 28H365.661C366.49 28 367.161 27.3284 367.161 26.5C367.161 25.6716 366.49 25 365.661 25H361.699ZM375.567 25C374.738 25 374.067 25.6716 374.067 26.5C374.067 27.3284 374.738 28 375.567 28H379.529C380.358 28 381.029 27.3284 381.029 26.5C381.029 25.6716 380.358 25 379.529 25H375.567ZM389.435 25C388.606 25 387.935 25.6716 387.935 26.5C387.935 27.3284 388.606 28 389.435 28H393.397C394.226 28 394.897 27.3284 394.897 26.5C394.897 25.6716 394.226 25 393.397 25H389.435ZM403.303 25C402.474 25 401.803 25.6716 401.803 26.5C401.803 27.3284 402.474 28 403.303 28H407.265C408.094 28 408.765 27.3284 408.765 26.5C408.765 25.6716 408.094 25 407.265 25H403.303ZM417.171 25C416.342 25 415.671 25.6716 415.671 26.5C415.671 27.3284 416.342 28 417.171 28H419.152C419.98 28 420.652 27.3284 420.652 26.5C420.652 25.6716 419.98 25 419.152 25H417.171Z"
                                        fill="#171B20"></path>
                                </svg>
                            </div>
                            <div class="pay-div p-4 pt-2">
                                <div class="d-flex align-items-center justify-content-between">
                                    <p>To pay:</p>
                                    <h4 class="total-p">$<span class="totalPrice">{{ $totalAmount }}</span>
                                        <p>.00</p>
                                    </h4>
                                </div>
                                @if ($product->product_status == 'available')

                                    <button data-bs-toggle="modal" data-bs-target="#staticBackdrop"
                                        class="w-100 payBtn my-2">Go To Pay</button>
                                @endif
                                <div class="my-3">
                                    @if ($errors->any())
                                        <div class="alert alert-danger mt-3" role="alert">
                                            @foreach ($errors->all() as $error)
                                                {{ $error }} <br>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                                <div class="d-flex mt-3">
                                    <input class="form-check-input me-2 p-2 privacyCheck" checked type="checkbox"
                                        id="flexCheckDefault">
                                    <p class="confirm">By confirming the order, I accept the <a
                                            href="{{ route('terms') }}">terms of the user agreement</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="product-h">
                            <p class="p-4">Key activation and operation is available in all countries</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form action="{{ route('stripe.pay') }}" id="paymentForm" class="require-validation"
                data-stripe-publishable-key="{{ $data->stripe_key }}" id="checkout-form" method="post">
                @csrf
                <input type="hidden" required name="product_type" value="GamingAccount">
                <input type="hidden" required name="product_id" value="{{ $product->id }}">
                <input type="hidden" required name="quantity" id="quantity_input" value="1">
                <input type="hidden" name="payment_method" id="payment_method">
                <input type="hidden" required class="totalPriceInput" name="totalPrice" value="{{ $totalAmount }}">

                <div class="modal-content">
                    <div class="modal-body p-0">
                        <div class="row">
                            <div class="col-md-6 left-side p-4">
                                <div class="top p-3">
                                    <p>{{ $product->title }}</p>
                                    <h3>Payment</h3>
                                    <img class="img img-fluid w-auto" src="{{ asset('frontend/images/underline.svg') }}"
                                        alt="">
                                </div>
                                @if (!Auth::check())
                                    <div class="new-user">
                                        <div class="input-group mb-1 p-3">
                                            <div class="input">
                                                <div class="input-icon">
                                                    <svg width="22" height="22" viewBox="0 0 22 22"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg"
                                                        class="usericon">
                                                        <path
                                                            d="M11.1467 9.96421C11.055 9.95504 10.945 9.95504 10.8442 9.96421C8.66249 9.89087 6.92999 8.10337 6.92999 5.90337C6.92999 3.65754 8.74499 1.83337 11 1.83337C13.2458 1.83337 15.07 3.65754 15.07 5.90337C15.0608 8.10337 13.3283 9.89087 11.1467 9.96421Z"
                                                            stroke="#DBDBDB" stroke-width="1.5" stroke-linecap="round"
                                                            stroke-linejoin="round"></path>
                                                        <path
                                                            d="M6.56335 13.3466C4.34501 14.8316 4.34501 17.2516 6.56335 18.7275C9.08418 20.4141 13.2183 20.4141 15.7392 18.7275C17.9575 17.2425 17.9575 14.8225 15.7392 13.3466C13.2275 11.6691 9.09335 11.6691 6.56335 13.3466Z"
                                                            stroke="#DBDBDB" stroke-width="1.5" stroke-linecap="round"
                                                            stroke-linejoin="round"></path>
                                                    </svg>
                                                </div>
                                                <input name="name" required type="text" placeholder="Name"
                                                    value="{{ old('name') }}">
                                            </div>
                                        </div>
                                        <div class="input-group mb-1 p-3">
                                            <div class="input">
                                                <div class="input-icon"><svg width="22" height="22"
                                                        viewBox="0 0 22 22" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M15.582 18.7917H6.41536C3.66536 18.7917 1.83203 17.4167 1.83203 14.2084V7.79171C1.83203 4.58337 3.66536 3.20837 6.41536 3.20837H15.582C18.332 3.20837 20.1654 4.58337 20.1654 7.79171V14.2084C20.1654 17.4167 18.332 18.7917 15.582 18.7917Z"
                                                            stroke="#95979F" stroke-width="1.5" stroke-miterlimit="10"
                                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                                        <path
                                                            d="M15.5846 8.25L12.7155 10.5417C11.7713 11.2933 10.2221 11.2933 9.27796 10.5417L6.41797 8.25"
                                                            stroke="#95979F" stroke-width="1.5" stroke-miterlimit="10"
                                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg>
                                                </div>
                                                <input name="email" required type="email" placeholder="Enter e-mail"
                                                    value="{{ old('email') }}">
                                            </div>
                                        </div>
                                        <div class="input-group mb-1 p-3">
                                            <div class="input">
                                                <div class="input-icon"><svg width="22" height="22"
                                                        viewBox="0 0 22 22" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M5.5 9.16671V7.33337C5.5 4.29921 6.41667 1.83337 11 1.83337C15.5833 1.83337 16.5 4.29921 16.5 7.33337V9.16671"
                                                            stroke="#95979F" stroke-width="1.5" stroke-linecap="round"
                                                            stroke-linejoin="round"></path>
                                                        <path
                                                            d="M10.9987 16.9583C12.2644 16.9583 13.2904 15.9323 13.2904 14.6667C13.2904 13.401 12.2644 12.375 10.9987 12.375C9.73305 12.375 8.70703 13.401 8.70703 14.6667C8.70703 15.9323 9.73305 16.9583 10.9987 16.9583Z"
                                                            stroke="#95979F" stroke-width="1.5" stroke-linecap="round"
                                                            stroke-linejoin="round"></path>
                                                        <path
                                                            d="M15.582 20.1666H6.41536C2.7487 20.1666 1.83203 19.25 1.83203 15.5833V13.75C1.83203 10.0833 2.7487 9.16663 6.41536 9.16663H15.582C19.2487 9.16663 20.1654 10.0833 20.1654 13.75V15.5833C20.1654 19.25 19.2487 20.1666 15.582 20.1666Z"
                                                            stroke="#95979F" stroke-width="1.5" stroke-linecap="round"
                                                            stroke-linejoin="round"></path>
                                                    </svg>
                                                </div>
                                                <input name="password" required type="password"
                                                    placeholder="Enter password" value="">
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="bottom p-2">
                                    <div class="d-flex my-3 align-items-center justify-content-between">
                                        <p class="mb-0">To Pay:</p>
                                        <h1>$<span class="totalPrice">{{ $totalAmount }}</span>
                                            <p class="m-auto d-inline">.00</p>
                                        </h1>
                                    </div>
                                    <div class="qualtity d-flex justify-content-between align-items-center">
                                        {{-- <div class="counter">
                                            <button class="plusBtn" type="button">
                                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M8 1V8M8 8V15M8 8H1M8 8H15" stroke="#62646C" stroke-width="2"
                                                        stroke-linecap="round"></path>
                                                </svg>
                                            </button>
                                            <div class="counter__number">
                                                1
                                            </div>
                                            <button class="minusBtn" type="button">
                                                <svg width="16" height="2" viewBox="0 0 16 2" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M1 1H8H15" stroke="#62646C" stroke-width="2"
                                                        stroke-linecap="round"></path>
                                                </svg>
                                            </button>
                                        </div> --}}
                                        <button class="payBtn2 paymentBtn">Pay</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 right p-4">
                                <div class="top p-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p>POPULAR PAYMENT SYSTEMS:</p>
                                        <button class="btn btn-close" type="button" data-bs-dismiss="modal">x</button>
                                    </div>
                                    <div class="icons-div my-4">
                                        @if ($data->paybis_account)
                                            <div class="icons py-icons my-2 p-4 me-3 d-block" data-bs-toggle="modal"
                                                data-bs-target="#staticPaybis">
                                                <p>Paybis (Manual payment)</p>
                                            </div>
                                        @endif

                                        @if ($data->payeer_account)
                                            <div class="icons py-icons my-2 p-4 me-3 d-block" data-bs-toggle="modal"
                                                data-bs-target="#staticPayeer">
                                                <p>Payeer (Manual payment)</p>
                                            </div>
                                        @endif

                                        @if ($data->paypal_secret)
                                            <div class="icons py-icons my-2 p-4 me-3 d-block" data-value="paypal">
                                                <img src="{{ asset('frontend/images/paypal.svg') }}" alt="">
                                            </div>
                                        @endif
                                        @if ($data->stripe_secret)
                                            <div class="icons py-icons my-2 bg-border p-4 d-block" data-value="stripe">
                                                <img src="{{ asset('frontend/images/stripe.png') }}" alt="">
                                            </div>
                                        @endif
                                        @if ($data->coinbase_api_key)
                                            <div class="icons py-icons my-2 p-4 d-block" data-value="coinbase">
                                                <img src="{{ asset('frontend/images/coinbase.png') }}" alt="">
                                            </div>
                                        @endif
                                        @if ($user != null)
                                            @if ($totalAmount < $user->balance)
                                                <div class="icons py-icons my-2 p-4 d-block" id="pay_by_balance"
                                                    data-value="balance">
                                                    <img src="{{ asset('frontend/images/balance.png') }}" alt="">
                                                </div>
                                            @endif
                                        @endif
                                        @if ($data->perfect_money_accountid)
                                            <div class="icons py-icons my-2 p-4 d-block" data-value="perfectmoney">
                                                <img src="{{ asset('frontend/images/perfectmoney.png') }}"
                                                    alt="">
                                            </div>
                                        @endif
                                        @if ($data->payeer_shop)
                                            <div class="icons py-icons my-2 p-4 d-block" data-value="payeer">
                                                <img src="{{ asset('frontend/images/payeer.png') }}" alt="">
                                            </div>
                                        @endif
                                    </div>

                                    <div class="warning p-2">
                                        <p>Each of the payment systems has different methods of accepting payments, such as
                                            Qiwi, WebMoney, YuMoney, Card, PIX, Unionpay, etc.
                                            <br>
                                            <br>
                                            Differences in each payment system in% rate, the possibility of accepting
                                            foreign cards, as well as various payment methods
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div class="modal fade" id="staticBackdropNotify" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">

            <form action="{{ route('games.out_of_stock') }}" id="notifyForm" class="require-validation"
                data-stripe-publishable-key="{{ $data->stripe_key }}" method="post">
                @csrf
                <input type="hidden" required name="product_id" value="{{ $product->id }}">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <div class="row">
                            <div class="col-md-12 left-side p-4">
                                <div class="top p-3">
                                    <p style="display: flex;justify-content: space-between;">
                                        <span>{{ $product->title }}</span><button class="btn btn-close" type="button"
                                            data-bs-dismiss="modal">x</button>
                                    </p>
                                    <h1>Out Of Stock</h1>
                                    <img class="img img-fluid w-auto" src="{{ asset('frontend/images/underline.svg') }}"
                                        alt="">
                                </div>
                                <h3 style="color: white;">Notify Me</h3>
                                <input name="notify_email" class="form-control py-3" required type="email"
                                    placeholder="Enter e-mail" value="">
                                <input type="submit" class="w-100 payBtn my-2">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div class="modal fade" id="staticPaybis" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">

            <form action="{{ route('stripe.pay') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" required name="product_type" value="GamingAccount">
                <input type="hidden" required name="product_id" value="{{ $product->id }}">
                <input type="hidden" required name="quantity" id="quantity_input" value="1">
                <input type="hidden" name="payment_method" value="paybis_manual">
                <input type="hidden" required class="totalPriceInput" name="totalPrice" value="{{ $totalAmount }}">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <div class="row">
                            <div class="col-md-12 left-side p-4">
                                <div class="top p-3">
                                    <p style="display: flex;justify-content: space-between;">
                                        <span class="text-white">{{ $product->title }}</span><button
                                            class="btn btn-close" type="button" data-bs-dismiss="modal">x</button>
                                    </p>
                                    <h1>Paybis (Manual Payment)</h1>
                                    <img class="img img-fluid w-auto" src="{{ asset('frontend/images/underline.svg') }}"
                                        alt="">
                                </div>
                                <p class="text-white">1. To pay with debit/credit card, go to <a
                                        href="https://paybis.com/" target="_blank">paybis.com</a></p>
                                <p class="text-white">2. Select USD (debit or credit card) to buy Bitcoin (BTC) - currency
                                    that we accept as
                                    payment.
                                    Put ${{ $totalAmount }} in the field
                                    and click Buy bitcoin</p>
                                <p class="text-white">3. Paste in your e-mail to complete registration.</p>
                                <p class="text-white">4. Click External wallet and Paste in this bitcoin address:</p>
                                <div class="d-flex">
                                    <p class="text-white d-inline-block" id="address"
                                        style="padding-bottom: 0px;margin-bottom: 0px;padding-top: 4px;">
                                        {{ $data->paybis_account }}</p>
                                    <button id="copyButton" class="btn btn-primary" type="button"
                                        style="border-radius: 50px !important; padding: 5px 20px !important">Copy</button>
                                </div><br>
                                <p class="text-white">5. Pay with your debit/credit card.
                                </p>
                                <p class="text-white">6. Make a quick verification if the site prompts you to
                                </p>
                                <p class="text-white">7. Return to <a
                                        href="http://localhost/finalwebsite_2/">Webcreatorzone</a> with the payment receipt
                                    and upload
                                    file in the below!
                                </p>
                                <input name="payment_proof" class="form-control py-3" required type="file">
                                <input type="submit" class="w-100 payBtn my-2">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="staticPayeer" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">

            <form action="{{ route('stripe.pay') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" required name="product_type" value="GamingAccount">
                <input type="hidden" required name="product_id" value="{{ $product->id }}">
                <input type="hidden" required name="quantity" id="quantity_input" value="1">
                <input type="hidden" name="payment_method" value="payeer_manual">
                <input type="hidden" required class="totalPriceInput" name="totalPrice" value="{{ $totalAmount }}">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <div class="row">
                            <div class="col-md-12 left-side p-4">
                                <div class="top p-3">
                                    <p style="display: flex;justify-content: space-between;">
                                        <span class="text-white">{{ $product->title }}</span><button
                                            class="btn btn-close" type="button" data-bs-dismiss="modal">x</button>
                                    </p>
                                    <h1>Payeer (Manual Payment)</h1>
                                    <img class="img img-fluid w-auto" src="{{ asset('frontend/images/underline.svg') }}"
                                        alt="">
                                </div>
                                <p class="text-white">1. To pay with debit/credit card, go to <a
                                        href="https://paybis.com/" target="_blank">paybis.com</a></p>
                                <p class="text-white">2. Select USD (debit or credit card) to buy Bitcoin (BTC) - currency
                                    that we accept as
                                    payment.
                                    Put ${{ $totalAmount }} in the field
                                    and click Buy bitcoin</p>
                                <p class="text-white">3. Paste in your e-mail to complete registration.</p>
                                <p class="text-white">4. Click External wallet and Paste in this bitcoin address:</p>
                                <div class="d-flex">
                                    <p class="text-white d-inline-block" id="address"
                                        style="padding-bottom: 0px;margin-bottom: 0px;padding-top: 4px;">
                                        {{ $data->payeer_account }}</p>
                                    <button id="copyButton" class="btn btn-primary" type="button"
                                        style="border-radius: 50px !important; padding: 5px 20px !important">Copy</button>
                                </div><br>
                                <p class="text-white">5. Pay with your debit/credit card.
                                </p>
                                <p class="text-white">6. Make a quick verification if the site prompts you to
                                </p>
                                <p class="text-white">7. Return to <a
                                        href="http://localhost/finalwebsite_2/">Webcreatorzone</a> with the payment receipt
                                    and upload
                                    file in the below!
                                </p>
                                <input name="payment_proof" class="form-control py-3" required type="file">
                                <input type="submit" class="w-100 payBtn my-2">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if ($product->product_status == 'sold' && session('notifyCheck') == '')
        <button data-bs-toggle="modal" style="display: none;" id="notify_btn"
            data-bs-target="#staticBackdropNotify"></button>
        <script>
            document.getElementById("notify_btn").click();
        </script>
    @endif

    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.js"></script>

    <script>
        // Get a reference to the "Copy" button and the address element
        const copyButton = document.getElementById("copyButton");
        const addressElement = document.getElementById("address");

        // Add a click event listener to the "Copy" button
        copyButton.addEventListener("click", () => {
            // Create a range object to select the text in the address element
            const range = document.createRange();
            range.selectNode(addressElement);
            window.getSelection().removeAllRanges();
            window.getSelection().addRange(range);

            // Copy the selected text to the clipboard
            document.execCommand("copy");

            // Deselect the text
            window.getSelection().removeAllRanges();

            // Provide user feedback that the text has been copied (you can use a tooltip or an alert)
            alert("Address copied to clipboard");
        });
    </script>



@endsection
