@extends('frontend.layout')

@if ($data)
    @section('meta_title', $data->meta_title . ' tickets')
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

        .custom-table .order-status.answered {
            border: 1px solid #20ada3;
            padding: 10px;
            width: auto;
            display: inline-block;
            color: #20ada3;
            font-weight: 600;
            font-size: 10px;
            border-radius: 6px;
        }

        .custom-table .order-status.open {
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

            .custom-table .order-status.answered {
                padding: 5px;
            }

            .custom-table .order-status.open {
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
            margin-top: 10px;
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
            margin-top: 30px;
            background: #20ada3;
            text-transform: none;
            font-weight: 600;
            font-size: 14px;
            line-height: 24px;
            letter-spacing: .02em;
            transition: .25s;
            border: none;
            padding: 18px;
            border-radius: 12px;
            width: 100%;
        }

        .page-contacts-form .btn-large:hover {
            background: #dbdbdb;
        }

        .input-textarea textarea {
            resize: none;
            width: 100%;
            height: 185px;
            margin-top: 20px;
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
    </style>

@endsection


@section('content')
    <section class="hero-section">
        <div class="page-head">
            <div class="container">
                <div class=" container-heading breadcrumb">
                    <a href="{{ route('home') }}">Home > </a>
                    <a href="{{ route('profile.tickets') }}">Tickets</a>
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
                    </div>
                    <div class="col-md-8">
                        <div class="form-container my-4 p-0 p-md-4">
                            <div class="heading my-2 pb-2">
                                <h1>Account Details ({{ count($emailchannels)  }})</h1>
                            </div>
                            @foreach ($emailchannels as $emailchannel)
                            <div class="table-section">
                                <div class="custom-table p-1 mt-3">
                                    <div class="table-head p-3">
                                        <div class="table-row my-auto">
                                            <div class="row">
                                                <div class="col">
                                                    <p style="color: white">Details</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-body">

                                        @if ($emailchannel->value1)
                                        <div class="table-row p-3 my-3">
                                            <div class="row">
                                                <div class="col">

                                                  @if($order->easy_mode == 'Easy Mode Accepted')
                                                  <?php
                                                  // Split the string into an array of labels and values
                                                  $labelArray = explode('/', $emailchannel->format);
                                                  $valueArray = explode('/', $emailchannel->value1);

                                                  // Output the formatted values
                                                  foreach ($labelArray as $index => $label) {
                                                    echo '<p style="color: white;">' . ucfirst($label) . ': ' . $valueArray[$index] . '</p>';
                                                  }
                                                  ?>
                                                  @else
                                                  <p style="color: white">{{ $emailchannel->format }}</p>
                                                  <p style="color: white">{{ $emailchannel->value1 }}</p>                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        @if ($emailchannel->value2)
                                        <div class="table-row p-3 my-3">
                                            <div class="row">
                                                <div class="col">
                                                    <p style="color: white">Details 2: {{ $emailchannel->value2 }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        @if ($emailchannel->value3)
                                        <div class="table-row p-3 my-3">
                                            <div class="row">
                                                <div class="col">
                                                    <p style="color: white">Details 3: {{ $emailchannel->value3 }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        @if ($emailchannel->value4)
                                        <div class="table-row p-3 my-3">
                                            <div class="row">
                                                <div class="col">
                                                    <p style="color: white">Details 4: {{ $emailchannel->value4 }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        @if ($emailchannel->value5)
                                        <div class="table-row p-3 my-3">
                                            <div class="row">
                                                <div class="col">
                                                    <p style="color: white">Details 5: {{ $emailchannel->value5 }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        @if ($emailchannel->value6)
                                        <div class="table-row p-3 my-3">
                                            <div class="row">
                                                <div class="col">
                                                    <p style="color: white">Details 6: {{ $emailchannel->value6 }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        @if ($emailchannel->value7)
                                        <div class="table-row p-3 my-3">
                                            <div class="row">
                                                <div class="col">
                                                    <p style="color: white">Details 7: {{ $emailchannel->value7 }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        @if ($emailchannel->value8)
                                        <div class="table-row p-3 my-3">
                                            <div class="row">
                                                <div class="col">
                                                    <p style="color: white">Details 8: {{ $emailchannel->value8 }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
