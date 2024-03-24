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

        .text_card {
            background-color: #67696d !important;
            color: #fff !important;
        }

        .make_money td,
        .make_money th {
            padding-bottom: 20px !important;
            padding-top: 20px !important;
            padding-left: 15px !important;
            border-bottom: 0px !important;
        }

        .make_money td {
            background-color: #515253 !important;
            color: #fff !important;
        }

        .make_money th {
            background-color: #626468 !important;
            color: #fff !important;
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
    <section class="make_money" style="padding-top: 18vh">
        <div class="page-head">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 mt-3">
                        <div class="card text_card p-3 mb-5">
                            <h1 class="text-center mb-3">Make Money - Affiliates System</h1>
                            <p>- Share your reffral link and get 5% comminssion from the user payments you invite, you can
                                spend
                                your earnings on the panel.</p>
                            <p>- All you have to do is to add members to our site via your Invite link. Remember, you will
                                only
                                earn bonuses from memberships that register through
                                the link defined in your account. Theere is no invitation limit, you reach as many users as
                                you
                                want and share your reference link.
                            </p>

                            <ul class="ps-3">
                                <li>Only newly recruited users are paid.</li>
                                <li>No payment is made for those who are self-referential and their accounts on the site are
                                    closed when they are noticed, as soon as the service is provided!</li>
                                <li>You cannaot submit a request without earning $10 on referrals.</li>
                                <li>You get 5% bonus from every payment your reffrals make.</li>
                                <li>When the minimum payment amount is reached, the "Send Payment Request" button will
                                    appear on
                                    the screen.</li>
                            </ul>
                        </div>

                        <div class="table-responsive mt-5">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col" style="border-top-left-radius: 15px !important;">Reffral Link
                                        </th>
                                        <th scope="col" style="border-top-right-radius: 15px !important;">Commission rate</th>
                                        {{-- <th scope="col" style="border-top-right-radius: 15px !important;">Minimum Payout
                                        </th> --}}
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td style="border-bottom-left-radius: 15px !important;">
                                            <a href="{{url('signup/' . $user->username)}}" target="_blank" style="color: white; text-decoration:none"> {{url('signup/' . $user->username) }} </a> <i class="fa-solid fa-clone"></i></td>
                                        <td style="border-bottom-right-radius: 15px !important;">
                                            {{ $data['referral_percentage'] }}% (amount you will get from order)</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="table-responsive mt-5">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th style="border-top-left-radius: 15px !important;" scope="col">Reffrals</th>
                                        <th scope="col">Referral Names</th>
                                        <th scope="col" style="border-top-right-radius: 15px !important;">Available
                                            earnings</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="border-bottom-left-radius: 15px !important;">{{ $refferal }}</td>
                                        <td>
                                            @foreach ($refferals as $refferal)
                                                {{ $refferal->username }},
                                            @endforeach
                                        </td>
                                        <td style="border-bottom-right-radius: 15px !important;">{{ Auth::user()->referral_balance }}$</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="my-4">
                            <form action="{{ route('profile.withdraw') }}" id="withdrawform" method="post">
                                @csrf
                                <div class="page-contacts-form text-center">
                                    <label for="" class="mb-1" style="font-weight: bold;color: white;">Referral Balance ($)</label>
                                    <div class="input">
                                        <div class="input-icon">
                                            <input type="text" name="referral_balance" value="{{ $user->referral_balance }}" readonly />
                                        </div>
                                    </div>
                                    <label for="" class="mb-1" style="font-weight: bold;color: white;">Crypto Address</label>
                                    <div class="input">
                                        <div class="input-icon">
                                            <input type="text" name="secret_key" placeholder="Enter Crypto Address" required />
                                        </div>
                                    </div>
                                    <button class="btn-large">With Draw</button>
                                </div>
                            </form>
                        </div>

                        <div class="table-responsive mt-5">
                            <table class="table">
                                <thead style="background-color: #626468 !important;">
                                    <tr style="background-color: #626468 !important;">
                                        <th scope="col" style=" border-top-left-radius: 15px !important;">Payout Date
                                        </th>
                                        <th scope="col">Payout amount</th>
                                        <th scope="col">Payout method</th>
                                        <th scope="col" style="border-top-right-radius: 15px !important;">Payout status
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($withdraw as $item)
                                    <tr>
                                        <td>{{ $item->created_at->format('d-m-Y') }}</td>
                                        <td>{{ $item->amount}}</td>
                                        <td>{{ $item->payment_method}}</td>
                                        <td>{{ $item->status}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
