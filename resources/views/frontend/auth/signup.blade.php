@extends('frontend.auth.layout')

@if ($data)
    @section('meta_title', $data->meta_title . ' Sign Up')
    @section('meta_keyowrds', $data->meta_keyowrds)
    @section('meta_description', $data->meta_description)
@endif

@section('page-styles')
    <style>
        .section {
            background-size: cover;
            background-position: 50%;
            height: 100vh;
            width: 100vw;
            max-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow-x: hidden;
            /* background: url("{{ asset('frontend/images/dust.gif') }}"); */
        }

        .section::before {
            content: "";
            position: fixed;
            left: 0;
            top: 0;
            mix-blend-mode: screen;
            background: url("{{ asset('frontend/images/fullscreen.png') }}");
            background-size: cover;
            background-position: 50%;
            height: 100vh;
            width: 100vw;
        }

        .container1 {
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            height: 100vh;
        }

        .logo {
            margin-top: 20px;
        }

        .logo img {
            max-width: 85px;
            max-height: 60px;
        }


        .card1 {
            padding: 40px;
            position: relative;
            z-index: 1;
            background: rgba(23, 27, 32, .88);
            border: 1px solid hsla(0, 0%, 100%, .03);
            -webkit-backdrop-filter: blur(48px);
            backdrop-filter: blur(48px);
            border-radius: 12px;
            width: 530px;
            box-sizing: border-box;
        }

        .card1 h1 {
            font-weight: 700;
            font-size: 24px;
            line-height: 32px;
            letter-spacing: .012em;
            color: #dbdbdb;
        }

        .footer {
            margin-bottom: 20px;
        }

        .footer p {
            font-weight: 400;
            font-size: 14px;
            line-height: 24px;
            color: #7b7c82;
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
            margin-top: 20px;
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

        form input:focus {
            border: none !important;
        }

        form .form-forgot a {
            font-weight: 600;
            font-size: 12px;
            line-height: 24px;
            letter-spacing: .02em;
            text-transform: uppercase;
            transition: 0.2s;
            color: hsla(0, 0%, 85.9%, .68);
            text-decoration: none;
        }

        form .form-forgot a:hover {
            color: #dbdbdb;
            transition: 0.2s;
        }

        form .form-check-input {
            background: transparent;
            border: 2px solid #62646c;
            transition: 0.2s;
            border-radius: 4px;
            padding: 7px;
            margin-right: 5px;
        }

        form .form-check-input:hover {
            border-color: #dbdbdb;
            cursor: pointer;
            transition: 0.2s;
        }

        form .form-check-input:checked {
            background: #20ada3;
            border-color: #dbdbdb;
        }

        form .form-check label {
            font-weight: 600;
            font-size: 12px;
            line-height: 24px;
            cursor: pointer;
            letter-spacing: .02em;
            text-transform: uppercase;
            transition: 0.2s;
            color: hsla(0, 0%, 85.9%, .68);
        }

        form button {
            background: #20ada3;
            text-transform: none;
            font-weight: 600;
            font-size: 14px;
            line-height: 24px;
            letter-spacing: .02em;
            transition: .25s;
            border: none;
            padding: 20px;
            border-radius: 5px;
        }

        form button:hover {
            background: #dbdbdb;
            transition: 0.25s;
        }

        form  p {
            color: #62646c;
            font-size: 14px;
            letter-spacing: 1px;
        }

        form .signup a {
            color: #20ada3;
            letter-spacing: 1px;
            text-decoration: none;
            font-weight: 600;
        }

        form input:focus {
            outline: none;
        }


        @media (max-width: 767px) {
            .card1 {
                padding: 35px;
                position: relative;
                z-index: 1;
                background: rgba(23, 27, 32, .88);
                border: 1px solid hsla(0, 0%, 100%, .03);
                -webkit-backdrop-filter: blur(48px);
                backdrop-filter: blur(48px);
                border-radius: 12px;
                width: auto;
                box-sizing: border-box;
            }

            form .input {
                display: grid;
                grid-template-columns: 22px 1fr;
                align-content: center;
                grid-gap: 12px;
                gap: 12px;
                height: 64px;
                padding: 0 16px;
                background: hsla(0, 0%, 100%, .03);
                border-radius: 8px;
                margin-top: 20px;
                transition: .25s;
                position: relative;
            }
        }
    </style>
@endsection

@section('content')

    <div class="section">
        <div class="container1">
            <div class="logo">
                <img class="img img-fluid" onclick="window.location.href = '/';" src="{{ $data->main_logo }}" alt="">
            </div>
            <div class="form">
                <div class="card1 text-center">
                    <div class="card-heading">
                        <h1>Sign Up</h1>
                        <img class="img-fluid w-50 m-auto" src="{{ asset('frontend/images/underline.svg') }}" alt="">
                    </div>
                    <div class="card-body">
                        <form action="{{ route('signup.check') }}" method="post">
                            @csrf
                            <div class="input-group mb-1">
                                <div class="input">
                                    <div class="input-icon">
                                        <svg width="22" height="22" viewBox="0 0 22 22" fill="none"
                                            xmlns="http://www.w3.org/2000/svg" class="usericon">
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
                                    <input name="name" type="text" placeholder="Name" value="{{ old('name') }}" required>
                                </div>
                            </div>
                            <div class="input-group mb-1">
                                <div class="input">
                                    <div class="input-icon"><svg width="22" height="22" viewBox="0 0 22 22"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
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
                                    <input name="email" type="email" placeholder="Enter e-mail"
                                        value="{{ old('email') }}" required>
                                </div>
                            </div>
                            <div class="input-group mb-1">
                                <div class="input">
                                    <div class="input-icon"><svg width="22" height="22" viewBox="0 0 22 22"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
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
                                    <input name="password" type="password" placeholder="Enter password" value="" required>
                                </div>
                            </div>
                            <div class="input-group mb-1">
                                <div class="input">
                                    <div class="input-icon"><svg width="22" height="22" viewBox="0 0 22 22"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
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
                                    <input name="confirmation_password" type="password" placeholder="Repeat password"
                                        value="" required>
                                </div>
                            </div>
                            <div class="input-group mb-1">
                                <div class="input">
                                    <div class="input-icon">
                                        <svg width="22" height="22" viewBox="0 0 22 22" fill="none"
                                            xmlns="http://www.w3.org/2000/svg" class="usericon">
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
                                    @if(request()->has('ref'))
                                      <input name="referral" type="text" readonly placeholder="Referral Code" value="{{ request('ref') }}">
                                  @else
                                      <input name="referral" type="text" placeholder="Referral Code" value="{{ $referal_user != null ? $referal_user : '' }}">
                                  @endif
                                </div>
                            </div>
                            <div class="my-4">
                                @if ($errors->any())
                                    <div class="alert alert-danger" role="alert">
                                        @foreach ($errors->all() as $error)
                                            {{ $error }}
                                            <br>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            <div class="my-4">
                                <button class="w-100" type="submit">Create account</button>
                            </div>
                            <div class="my-4 signup">
                                <p>I have a account? <a href="{{ route('signin') }}">Sign In</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="footer">
                <p>Devil Software`s @ 2023 All rights reserved</p>
            </div>
        </div>
    </div>

@endsection
