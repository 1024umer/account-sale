@extends('frontend.layout')

@if ($data)
    @section('meta_title', $data->meta_title . ' purchses')
    @section('meta_keyowrds', $data->meta_keyowrds)
    @section('meta_description', $data->meta_description)
@endif

@section('page-styles')
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

        .page-profile-sidebar__card {
            display: grid;
            grid-template-columns: 48px 1fr 48px;
            grid-gap: 20px;
            gap: 20px;
            align-items: center;
            background: linear-gradient(90.14deg, #647adc .12%, #20ada3 99.9%);
            box-shadow: inset 2px 2px 2px hsla(0, 0%, 100%, .24);
            border-radius: 12px;
            padding: 20px 30px;
            height: 110px;
        }

        .page-profile-sidebar__card p {
            color: #dbdbdb;
        }

        .page-profile-sidebar__card img {
            height: 48px;
            width: 48px;
        }


        .page-profile-sidebar__card .username {
            font-weight: 600;
        }

        .username {
            font-weight: 600;
            color: #dbdbdb;
        }

        .page-profile-sidebar__card svg {
            fill: #fff;
        }

        .page-profile-sidebar__card-logout {
            border: 2px solid hsla(0, 0%, 89.8%, .24);
            width: 48px;
            transition: fill 0.3s;
            height: 48px;
            border-radius: 50%;
        }

        .page-profile-sidebar__card-logout:hover {
            background: #fff;
        }

        .page-profile-sidebar__card-logout:hover svg {
            fill: #000;
            transition: fill 0.3s;
        }

        .tab-container {
            height: 110px;
            background: #171b20;
            border-radius: 12px;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }

        .tab {
            flex: 1;
            text-align: center;
            transition: 0.2s;
            padding: 20px;
            color: #95979f;
            font-weight: 600;
        }

        .tab a {
            color: #62646c;
            padding: 25px;
            text-decoration: none;
        }

        .tab:hover a {
            color: #dbdbdb;
            transition: 0.2s;
        }

        .tab.active {
            color: #3496a9;
            border-bottom: 3px solid #3496a9;
        }

        .tab.active a {
            color: #3496a9;
        }

        .tab.active svg {
            fill: #3496a9;
        }

        .tab svg {
            fill: #62646c;
        }


        .tab:hover svg {
            fill: #dbdbdb;
        }

        .form-container {
            background: rgba(23, 27, 32, .68);
            border-radius: 12px;
        }

        .form-container h1 {
            font-weight: 700;
            font-size: 16px;
            line-height: 20px;
            letter-spacing: .012em;
            color: #dbdbdb;
        }

        .form-container .heading {
            border-bottom: 1px solid hsla(0, 0%, 100%, .03);
        }

        .empty .empty-title {
            line-height: 24px;
            font-weight: 600;
            letter-spacing: .012em;
            color: #dbdbdb;
        }

        .empty .empty-text {
            font-weight: 500;
            font-size: 14px;
            color: #62646c;
            max-width: 280px;
            letter-spacing: 1px;
            margin: 16px auto;
        }

        .empty a {
            text-decoration: none;
            padding: 12px 18px;
            border: 2px solid hsla(0, 0%, 100%, .03);
            border-radius: 100px;
            font-weight: 600;
            font-size: 13px;
            line-height: 24px;
            letter-spacing: .012em;
            color: #95979f;
            transition: .25s;
        }

        .empty a:hover {
            background: hsla(0, 0%, 100%, .03);
            margin: 10px auto;
        }

        .custom-table .table-head {
            background: hsla(0, 0%, 100%, .01);
            border-radius: 4px;
            border-bottom: 1px solid hsla(0, 0%, 100%, .03);
        }

        .custom-table .table-body .table-row {
            border-bottom: 1px solid hsla(0, 0%, 100%, .03);
        }

        .custom-table p {
            font-weight: 700;
            font-size: 12px;
            line-height: 24px;
            letter-spacing: .02em;
            text-transform: uppercase;
            margin: 0;
            color: #62646c;
        }

        .custom-table .order-status.success {
            border: 1px solid #20ada3;
            padding: 10px;
            width: auto;
            display: inline-block;
            color: #20ada3;
            font-weight: 600;
            font-size: 10px;
            border-radius: 6px;
        }

        .custom-table .order-status.pending {
            border: 1px solid #ada320;
            padding: 10px;
            width: auto;
            display: inline-block;
            color: #ada320;
            font-weight: 600;
            font-size: 10px;
            border-radius: 6px;
        }

        @media (max-width: 767px) {
            .breadcrumb {
                padding-top: 30px;
            }

            .tab-container {
                max-width: 95vw;
                margin-top: 20px;
            }

            .tab {
                padding: 10px;
            }

            .tab a {
                padding: 5px;
                font-size: 9px;
            }

            .tab svg {
                display: block;
                text-align: center;
                margin: auto;
            }

            .custom-table p {
                font-size: 10px;
            }

            .custom-table .table-head p {
                font-size: 8px;
            }

            .custom-table .order-status.success {
                padding: 5px;
            }
            .custom-table .order-status.pending {
                padding: 5px;
            }
        }

        .page-contacts-form {
            background: rgba(23, 27, 32, .88);
            border: 1px solid hsla(0, 0%, 100%, .03);
            -webkit-backdrop-filter: blur(48px);
            backdrop-filter: blur(48px);
            border-radius: 12px;
            padding: 15px;
        }

        .input {
            display: grid;
            grid-template-columns: 22px 1fr;
            align-content: center;
            grid-gap: 12px;
            gap: 12px;
            height: 55px;
            padding: 0 16px;
            background: hsla(0, 0%, 100%, .03);
            border-radius: 8px;
            transition: .25s;
            position: relative;
        }

        .input:before {
            content: "";
            position: absolute;
            width: 100%;
            height: 100%;
            left: -0.75px;
            top: -0.75px;
            border: 1.5px solid #20ada3;
            border-radius: 8px;
            opacity: 0;
            transition: .25s;
            pointer-events: none;
        }

        .input input {
            height: 100%;
            background: transparent;
            font-weight: 500;
            font-size: 14px;
            border: none;
            outline: none;
            line-height: 24px;
            color: #dbdbdb;
        }

        .page-contacts-form .btn-large {
            margin-top: 10px;
            background: #20ada3;
            text-transform: none;
            font-weight: 600;
            font-size: 14px;
            line-height: 24px;
            letter-spacing: .02em;
            transition: .25s;
            border: none;
            padding: 10px;
            border-radius: 12px;
            width: 40%;
        }

        .page-contacts-form .btn-large:hover {
            background: #dbdbdb;
        }

        .input-textarea textarea {
            resize: none;
            width: 100%;
            height: 100px;
            background: hsla(0, 0%, 100%, .03);
            border-radius: 8px;
            padding: 16px;
            box-sizing: border-box;
            font-family: "Montserrat";
            font-style: normal;
            font-weight: 500;
            font-size: 14px;
            border: none;
            outline: none;
            line-height: 24px;
            color: #dbdbdb;
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

<script>
    $(function() {

        $('.py-icons').on('click', function() {
            $('.py-icons').removeClass('bg-border');
            $(this).addClass('bg-border');
            var value = $(this).data('value');
            if (value == 'paypal') {
                $('#paymentForm2').prop('action', '{{ route('paypal.addbalance') }}');
                $('#payment_method').val('paypal');
            } else if (value == 'stripe') {
                $('#payment_method').val('stripe');
                $('#paymentForm2').prop('action', '{{ route('stripe.addbalance') }}');
            } else if (value == 'perfectmoney') {
                $('#payment_method').val('perfectmoney');
                $('#paymentForm2').prop('action', '{{ route('perfectmoney.addbalance') }}');
            } else if (value == 'coinbase') {
                $('#payment_method').val('coinbase');
                $('#paymentForm2').prop('action', '{{ route('coinbase.addbalance') }}');
            }
        });
    });
</script>

@endsection

@section('content')
    <section class="hero-section">
        <div class="page-head">
            <div class="container">
                <div class=" container-heading breadcrumb">
                    <a href="{{ route('home') }}">Home > </a>
                    <a href="{{ route('profile.purchses') }}">Purchses</a>
                </div>
                <div class="row mt-5">
                    <div class="col-md-4">
                        <div class="page-profile-sidebar__card">
                            <div class="user-avatar">
                                <img class="img img-circle" src="{{ asset('frontend/images/avatar-user.png') }}"
                                    alt="">
                            </div>
                            <div class="page-profile-sidebar__card-content">
                                <p class="text">Welcome back,</p>
                                <p class="username">{{ $user->name }}</p>
                            </div>
                            <div class="page-profile-sidebar__card-logout d-flex justify-content-center align-items-center">
                                <a href="{{ route('logout') }}">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M16.8 2H14.2C11 2 9 4 9 7.2V11.25H15.25C15.66 11.25 16 11.59 16 12C16 12.41 15.66 12.75 15.25 12.75H9V16.8C9 20 11 22 14.2 22H16.79C19.99 22 21.99 20 21.99 16.8V7.2C22 4 20 2 16.8 2Z">
                                        </path>
                                        <path
                                            d="M4.55945 11.25L6.62945 9.17997C6.77945 9.02997 6.84945 8.83997 6.84945 8.64997C6.84945 8.45997 6.77945 8.25997 6.62945 8.11997C6.33945 7.82997 5.85945 7.82997 5.56945 8.11997L2.21945 11.47C1.92945 11.76 1.92945 12.24 2.21945 12.53L5.56945 15.88C5.85945 16.17 6.33945 16.17 6.62945 15.88C6.91945 15.59 6.91945 15.11 6.62945 14.82L4.55945 12.75H8.99945V11.25H4.55945Z">
                                        </path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <div class="my-4">
                            <div class="page-contacts-form">
                                <p class="username">Referral Code</p>
                                <div class="input-textarea">
                                    <textarea readonly style="height: 60px;">{{ $user->username }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="my-4">
                            <div class="page-contacts-form">
                                <p class="username">Affiliate Link</p>
                                <div class="input-textarea">
                                    <textarea readonly style="height: 105px;">{{ url('signup/'.$user->username) }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="my-4">
                            <div class="page-contacts-form text-center">
                                <div class="input">
                                    <div class="input-icon">
                                        <input type="text" value="{{ 'User Balance: '.$user->balance.'$' }}" readonly />
                                    </div>
                                </div>
                                <button class="btn-large" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Add Balance</button>
                            </div>
                        </div>
                        
                        <div class="my-4">
                            <div class="page-contacts-form">
                                <audio controls autoplay loop id="audio">
                                    <source src="{{ asset('frontend/music/music.mp3') }}" type="audio/mpeg">
                                </audio> 
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="tab-container">
                            <div class="tab active">
                                <a href="{{ route('profile.purchses') }}">
                                    <svg width="24" height="24" viewBox="0 0 54 54" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M35.505 4.5H18.495C9.99 4.5 7.875 6.7725 7.875 15.84V41.175C7.875 47.16 11.16 48.5775 15.1425 44.3025L15.165 44.28C17.01 42.3225 19.8225 42.48 21.42 44.6175L23.6925 47.655C25.515 50.0625 28.4625 50.0625 30.285 47.655L32.5575 44.6175C34.1775 42.4575 36.99 42.3 38.835 44.28C42.84 48.555 46.1025 47.1375 46.1025 41.1525V15.84C46.125 6.7725 44.01 4.5 35.505 4.5ZM33.75 26.4375H20.25C19.3275 26.4375 18.5625 25.6725 18.5625 24.75C18.5625 23.8275 19.3275 23.0625 20.25 23.0625H33.75C34.6725 23.0625 35.4375 23.8275 35.4375 24.75C35.4375 25.6725 34.6725 26.4375 33.75 26.4375ZM36 17.4375H18C17.0775 17.4375 16.3125 16.6725 16.3125 15.75C16.3125 14.8275 17.0775 14.0625 18 14.0625H36C36.9225 14.0625 37.6875 14.8275 37.6875 15.75C37.6875 16.6725 36.9225 17.4375 36 17.4375Z">
                                        </path>
                                    </svg>
                                    My purchses
                                </a>
                            </div>
                            <div class="tab">
                                <a href="{{ route('profile.tickets') }}">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M21.9999 12.86C21.9999 15.15 20.8199 17.18 18.9999 18.46L17.6599 21.41C17.3499 22.08 16.4499 22.21 15.9799 21.64L14.4999 19.86C12.6399 19.86 10.9299 19.23 9.62988 18.18L10.2299 17.47C14.8499 17.12 18.4999 13.46 18.4999 9.00002C18.4999 8.24002 18.3899 7.49002 18.1899 6.77002C20.4599 7.97002 21.9999 10.25 21.9999 12.86Z">
                                        </path>
                                        <path
                                            d="M16.3 6.07C15.13 3.67 12.52 2 9.5 2C5.36 2 2 5.13 2 9C2 11.29 3.18 13.32 5 14.6L6.34 17.55C6.65 18.22 7.55 18.34 8.02 17.78L8.57 17.12L9.5 16C13.64 16 17 12.87 17 9C17 7.95 16.75 6.96 16.3 6.07ZM12 9.75H7C6.59 9.75 6.25 9.41 6.25 9C6.25 8.59 6.59 8.25 7 8.25H12C12.41 8.25 12.75 8.59 12.75 9C12.75 9.41 12.41 9.75 12 9.75Z">
                                        </path>
                                    </svg>
                                    Support
                                </a>
                            </div>
                            <div class="tab">
                                <a href="{{ route('profile.settings') }}">
                                    <svg width="25" height="24" viewBox="0 0 25 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M20.6 9.22006C18.79 9.22006 18.05 7.94006 18.95 6.37006C19.47 5.46006 19.16 4.30006 18.25 3.78006L16.52 2.79006C15.73 2.32006 14.71 2.60006 14.24 3.39006L14.13 3.58006C13.23 5.15006 11.75 5.15006 10.84 3.58006L10.73 3.39006C10.28 2.60006 9.26 2.32006 8.47 2.79006L6.74 3.78006C5.83 4.30006 5.52 5.47006 6.04 6.38006C6.95 7.94006 6.21 9.22006 4.4 9.22006C3.36 9.22006 2.5 10.0701 2.5 11.1201V12.8801C2.5 13.9201 3.35 14.7801 4.4 14.7801C6.21 14.7801 6.95 16.0601 6.04 17.6301C5.52 18.5401 5.83 19.7001 6.74 20.2201L8.47 21.2101C9.26 21.6801 10.28 21.4001 10.75 20.6101L10.86 20.4201C11.76 18.8501 13.24 18.8501 14.15 20.4201L14.26 20.6101C14.73 21.4001 15.75 21.6801 16.54 21.2101L18.27 20.2201C19.18 19.7001 19.49 18.5301 18.97 17.6301C18.06 16.0601 18.8 14.7801 20.61 14.7801C21.65 14.7801 22.51 13.9301 22.51 12.8801V11.1201C22.5 10.0801 21.65 9.22006 20.6 9.22006ZM12.5 15.2501C10.71 15.2501 9.25 13.7901 9.25 12.0001C9.25 10.2101 10.71 8.75006 12.5 8.75006C14.29 8.75006 15.75 10.2101 15.75 12.0001C15.75 13.7901 14.29 15.2501 12.5 15.2501Z">
                                        </path>
                                    </svg>
                                    Settings
                                </a>
                            </div>
                        </div>
                        <div class="form-container my-4 p-0 p-md-4">
                            <div class="heading my-2 pb-2">
                                <h1>History of you purchases</h1>
                            </div>
                            <div class="table-section">
                                @if (count($orders) > 0)
                                    <div class="custom-table p-1 mt-3">
                                        <div class="table-head p-3">
                                            <div class="table-row my-auto">
                                                <div class="row">
                                                    <div class="col">
                                                        <p style="color: #dbdbdb;"># order</p>
                                                    </div>
                                                    <div class="col">
                                                        <p style="color: #dbdbdb;">product name</p>
                                                    </div>
                                                    <div class="col">
                                                        <p style="color: #dbdbdb;">amount</p>
                                                    </div>
                                                    <div class="col">
                                                        <p style="color: #dbdbdb;">status</p>
                                                    </div>
                                                    <div class="col">
                                                        <p style="color: #dbdbdb;">date</p>
                                                    </div>
                                                    <div class="col">
                                                        <p style="color: #dbdbdb;">support</p>
                                                    </div>
                                                    <div class="col">
                                                        <p style="color: #dbdbdb;">actions</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-body">
                                            @foreach ($orders as $order)
                                                <div class="table-row p-3 my-3">
                                                    <div class="row">
                                                        <div class="col">
                                                            <p style="color: #dbdbdb;">{{ $order->id }}</p>
                                                        </div>
                                                        <div class="col">
                                                            <a href="{{ $order->status == 'success' ? route('profile.viewaccount', ['slug' => $order->id]): '#' }}">
                                                                <p style="color: #dbdbdb;">{{ $order->orderable->title }}</p>
                                                            </a>
                                                        </div>
                                                        <div class="col">
                                                            <p style="color: #dbdbdb;">{{ $order->amount }}$</p>
                                                        </div>
                                                        <div class="col">
                                                            <p>
                                                            <div
                                                                class="order-status {{ $order->status == 'success' ? 'success' : 'pending' }}">
                                                                {{ $order->status }}
                                                            </div>
                                                            </p>
                                                        </div>
                                                        <div class="col">
                                                            <p style="color: #dbdbdb;">{{ $order->created_at->format('M, d Y H:i') }}</p>
                                                        </div>
                                                        <div class="col">
                                                            <p>
                                                                <button data-bs-toggle="modal" id="{{ $order->id }}" onclick="document.getElementById('order_id').value = this.id;document.getElementById('ticket_order_id').innerText = '#'+this.id;" data-bs-target="#staticBackdropSupport" class="order-status success bg-transparent">
                                                                    Support
                                                                </button>
                                                            </p>
                                                        </div>
                                                        <div class="col">
                                                            <p>
                                                                @if ($order->status == 'success')
                                                                    <button data-bs-toggle="modal" id="{{ $order->id }}" onclick="document.getElementById('order_id_download').value = this.id;" style="font-size: 8px;padding-left: 5px;padding-right: 5px;" class="order-status success mb-1 bg-transparent text-decoration-none" data-bs-target="#staticBackdropDownload">
                                                                        Download
                                                                    </button>
                                                                    <a href="{{ route('profile.viewaccount', ['slug' => $order->id]) }}" class="order-status pending mb-1 bg-transparent text-decoration-none">
                                                                        View
                                                                    </a>
                                                                @else
                                                                    &nbsp;&nbsp;&nbsp;
                                                                @endif
                                                            </p>    
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @else
                                    <div class="empty text-center my-5">
                                        <div>
                                            <svg width="54" height="54" viewBox="0 0 54 54" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M35.505 4.5H18.495C9.99 4.5 7.875 6.7725 7.875 15.84V41.175C7.875 47.16 11.16 48.5775 15.1425 44.3025L15.165 44.28C17.01 42.3225 19.8225 42.48 21.42 44.6175L23.6925 47.655C25.515 50.0625 28.4625 50.0625 30.285 47.655L32.5575 44.6175C34.1775 42.4575 36.99 42.3 38.835 44.28C42.84 48.555 46.1025 47.1375 46.1025 41.1525V15.84C46.125 6.7725 44.01 4.5 35.505 4.5ZM33.75 26.4375H20.25C19.3275 26.4375 18.5625 25.6725 18.5625 24.75C18.5625 23.8275 19.3275 23.0625 20.25 23.0625H33.75C34.6725 23.0625 35.4375 23.8275 35.4375 24.75C35.4375 25.6725 34.6725 26.4375 33.75 26.4375ZM36 17.4375H18C17.0775 17.4375 16.3125 16.6725 16.3125 15.75C16.3125 14.8275 17.0775 14.0625 18 14.0625H36C36.9225 14.0625 37.6875 14.8275 37.6875 15.75C37.6875 16.6725 36.9225 17.4375 36 17.4375Z"
                                                    fill="#62646C"></path>
                                            </svg>
                                            <p class="empty-title" style="color: #dbdbdb;">You have no items ;(</p>
                                            <p class="empty-text" style="color: #dbdbdb;">Go to our games catalog to buy quality software.</p>
                                            <div class="empty-action">
                                                <a href="#">Games Catalog</a>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form action="{{ route('stripe.addbalance') }}" id="paymentForm2" class="require-validation"
                data-stripe-publishable-key="{{ $data->stripe_key }}" id="checkout-form" method="post">
                @csrf
                
                <input type="hidden" name="payment_method" id="payment_method">
                
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <div class="row">
                            <div class="col-md-6 left-side p-4">
                                <div class="top p-3">
                                    <p>User Balance</p>
                                    <h1>Add Balance</h1>
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
                                        <p class="mb-0">Enter Balance:</p>
                                        <input type="number" required class="totalPriceInput" name="totalPrice" value="">
                                    </div>
                                    <div class="qualtity d-flex justify-content-between align-items-center">
                                        <button class="payBtn2 paymentBtn">Add Balance</button>
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
                                        @if($data->paypal_secret)
                                        <div class="icons py-icons my-2 p-4 me-3 d-block" data-value="paypal">
                                            <img src="{{ asset('frontend/images/paypal.svg') }}" alt="">
                                        </div>
                                        @endif
                                        @if($data->stripe_secret)
                                        <div class="icons py-icons my-2 bg-border p-4 d-block" data-value="stripe">
                                            <img src="{{ asset('frontend/images/stripe.png') }}" alt="">
                                        </div>
                                        @endif
                                        @if($data->coinbase_api_key)
                                        <div class="icons py-icons my-2 p-4 d-block" data-value="coinbase">
                                            <img src="{{ asset('frontend/images/coinbase.png') }}" alt="">
                                        </div>
                                        @endif
                                        @if($data->perfect_money_accountid)
                                        <div class="icons py-icons my-2 p-4 d-block" data-value="perfectmoney">
                                            <img src="{{ asset('frontend/images/perfectmoney.png') }}" alt="">
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

    <div class="modal fade" id="staticBackdropSupport" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropSupport" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
                
            <form action="{{ route('games.userticket') }}" id="userTicketForm" class="require-validation"
                data-stripe-publishable-key="{{ $data->stripe_key }}" method="post">
                @csrf
                <input type="hidden" required name="order_id" id="order_id" value="">
                <input name="email" required type="hidden" value="{{ $user->email }}">
                <input name="name" required type="hidden" value="{{ $user->name }}">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <div class="row">
                            <div class="col-md-12 left-side p-4">
                                <div class="top p-3">
                                    <p style="display: flex;justify-content: space-between;"><span id="ticket_order_id">User Ticket</span><button class="btn btn-close" type="button" data-bs-dismiss="modal">x</button></p>
                                    <h1>Support</h1>
                                    <img class="img img-fluid w-auto" src="{{ asset('frontend/images/underline.svg') }}"
                                        alt="">
                                </div>
                                <h3 style="color: white;">Notify Me</h3>
                                <select name="subject" id="subject" class="form-control" required>
                                    <option value="">Select Subject</option>
                                    <option value="I have a problem with the product">I have a problem with the product</option>
                                    <option value="I did not receive the product automatically">I did not receive the product automatically</option>
                                    <option value="I have a simple question/Need consult">I have a simple question/Need consult</option>
                                </select>
                                <div class="form-group my-2">
                                    <textarea rows="4" class="form-control" required placeholder="Message" name="message"></textarea>
                                </div>
                                <div class="text-center">
                                    <input class="btn btn-primary" type="submit" class="w-100 payBtn my-2">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="staticBackdropDownload" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropDownload" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
                
            <form action="{{ route('profile.downloadaccount') }}" id="downloadAccountForm" class="require-validation" method="post">
                @csrf
                <input type="hidden" required name="order_id" id="order_id_download" value="">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <div class="row">
                            <div class="col-md-12 left-side p-4">
                                <div class="top p-3">
                                    <p style="display: flex;justify-content: space-between;"><span id="ticket_order_id">Download</span><button class="btn btn-close" type="button" data-bs-dismiss="modal">x</button></p>
                                    <h1>Download</h1>
                                    <img class="img img-fluid w-auto" src="{{ asset('frontend/images/underline.svg') }}"
                                        alt="">
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
                                <div class="text-center">
                                    <input class="btn btn-primary" type="submit" class="w-100 payBtn my-2">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script defer>
        document.getElementById('audio').play();
    </script>
@endsection
