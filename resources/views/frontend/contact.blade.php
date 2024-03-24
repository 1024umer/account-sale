@extends('frontend.layout')

@if ($data)
    @section('meta_title', $data->meta_title . ' contact')
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

        .page-contacts-form {
            background: rgba(23, 27, 32, .88);
            border: 1px solid hsla(0, 0%, 100%, .03);
            -webkit-backdrop-filter: blur(48px);
            backdrop-filter: blur(48px);
            border-radius: 12px;
            padding: 40px;
        }

        .input {
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
            height: 258px;
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
    </style>
@endsection

@section('content')
    <section class="hero-section">
        <div class="page-head">
            <div class="container">
                <div class=" container-heading breadcrumb">
                    <a href="{{ route('home') }}">Home > </a>
                    <a href="{{ route('contact') }}">Contact</a>
                </div>
                <div class="row mt-5 py-5 d-block d-md-flex justify-content-between">
                    <div class="col-md-5 col-lg-5 left-side">
                        <div class="text pb-4">
                            <h1>Contact</h1>
                            <img class="mb-4 mt-2" src="{{ asset('frontend/images/underline.svg') }}" alt="">
                            <p>For cooperation or any other information, you can contact us at the following contacts:</p>
                        </div>
                        <div class="info">
                            <h4>info</h4>
                            <div class="icon-svg">
                                <svg width="40" height="40" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M28 12.6022L24.9946 28.2923C24.9946 28.2923 24.5741 29.3801 23.4189 28.8584L16.4846 23.3526L16.4524 23.3364C17.3891 22.4654 24.6524 15.7027 24.9698 15.3961C25.4613 14.9214 25.1562 14.6387 24.5856 14.9974L13.8568 22.053L9.71764 20.6108C9.71764 20.6108 9.06626 20.3708 9.00359 19.8491C8.9401 19.3265 9.73908 19.0439 9.73908 19.0439L26.6131 12.1889C26.6131 12.1889 28 11.5579 28 12.6022Z">
                                    </path>
                                </svg>
                                <a href="{{ $data->telegram_link }}">Telegram</a>
                            </div>
                            <div class="icon-svg">
                                <svg width="40" height="40" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M29.0275 14.0267C27.3762 12.7466 25.3945 12.1067 23.3028 12L22.9725 12.32C24.844 12.7466 26.4954 13.6 28.0367 14.7733C26.1651 13.8133 24.0734 13.1733 21.8715 12.96C21.211 12.8533 20.6605 12.8533 20 12.8533C19.3395 12.8533 18.789 12.8533 18.1285 12.96C15.9266 13.1733 13.8348 13.8133 11.9633 14.7733C13.5045 13.6 15.156 12.7466 17.0275 12.32L16.6972 12C14.6055 12.1067 12.6238 12.7466 10.9725 14.0267C9.10092 17.44 8.11009 21.28 8 25.2266C9.65135 26.9333 11.9633 28 14.3853 28C14.3853 28 15.156 27.1467 15.7064 26.4C14.2752 26.08 12.9541 25.3333 12.0734 24.16C12.844 24.5866 13.6146 25.0133 14.3853 25.3333C15.3762 25.76 16.367 25.9733 17.3578 26.1867C18.2386 26.2933 19.1193 26.4 20 26.4C20.8807 26.4 21.7614 26.2933 22.6422 26.1867C23.633 25.9733 24.6238 25.76 25.6147 25.3333C26.3854 25.0133 27.156 24.5866 27.9266 24.16C27.0459 25.3333 25.7248 26.08 24.2936 26.4C24.844 27.1467 25.6147 28 25.6147 28C28.0367 28 30.3486 26.9333 32 25.2266C31.8899 21.28 30.8991 17.44 29.0275 14.0267ZM16.367 23.3066C15.2661 23.3066 14.2753 22.3466 14.2753 21.1733C14.2753 20 15.2661 19.04 16.367 19.04C17.4679 19.04 18.4587 20 18.4587 21.1733C18.4587 22.3466 17.4679 23.3066 16.367 23.3066ZM23.633 23.3066C22.5321 23.3066 21.5413 22.3466 21.5413 21.1733C21.5413 20 22.5321 19.04 23.633 19.04C24.7339 19.04 25.7248 20 25.7248 21.1733C25.7248 22.3466 24.7339 23.3066 23.633 23.3066Z">
                                    </path>
                                </svg>
                                <a href="https://discord.gg/872653281523023922">kandan03</a>
                            </div>
                        </div>
                        <div class="social my-4">
                            <h4>social networks for communication</h4>
                            <div class="d-flex">
                                <a href="{{ $data->discord_link }}">
                                    <svg width="40" height="40" viewBox="0 0 40 40"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M29.0275 14.0267C27.3762 12.7466 25.3945 12.1067 23.3028 12L22.9725 12.32C24.844 12.7466 26.4954 13.6 28.0367 14.7733C26.1651 13.8133 24.0734 13.1733 21.8715 12.96C21.211 12.8533 20.6605 12.8533 20 12.8533C19.3395 12.8533 18.789 12.8533 18.1285 12.96C15.9266 13.1733 13.8348 13.8133 11.9633 14.7733C13.5045 13.6 15.156 12.7466 17.0275 12.32L16.6972 12C14.6055 12.1067 12.6238 12.7466 10.9725 14.0267C9.10092 17.44 8.11009 21.28 8 25.2266C9.65135 26.9333 11.9633 28 14.3853 28C14.3853 28 15.156 27.1467 15.7064 26.4C14.2752 26.08 12.9541 25.3333 12.0734 24.16C12.844 24.5866 13.6146 25.0133 14.3853 25.3333C15.3762 25.76 16.367 25.9733 17.3578 26.1867C18.2386 26.2933 19.1193 26.4 20 26.4C20.8807 26.4 21.7614 26.2933 22.6422 26.1867C23.633 25.9733 24.6238 25.76 25.6147 25.3333C26.3854 25.0133 27.156 24.5866 27.9266 24.16C27.0459 25.3333 25.7248 26.08 24.2936 26.4C24.844 27.1467 25.6147 28 25.6147 28C28.0367 28 30.3486 26.9333 32 25.2266C31.8899 21.28 30.8991 17.44 29.0275 14.0267ZM16.367 23.3066C15.2661 23.3066 14.2753 22.3466 14.2753 21.1733C14.2753 20 15.2661 19.04 16.367 19.04C17.4679 19.04 18.4587 20 18.4587 21.1733C18.4587 22.3466 17.4679 23.3066 16.367 23.3066ZM23.633 23.3066C22.5321 23.3066 21.5413 22.3466 21.5413 21.1733C21.5413 20 22.5321 19.04 23.633 19.04C24.7339 19.04 25.7248 20 25.7248 21.1733C25.7248 22.3466 24.7339 23.3066 23.633 23.3066Z">
                                        </path>
                                    </svg>
                                </a>
                                <a href="{{ $data->telegram_link }}">
                                    <svg width="40" height="40" viewBox="0 0 40 40"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M28 12.6022L24.9946 28.2923C24.9946 28.2923 24.5741 29.3801 23.4189 28.8584L16.4846 23.3526L16.4524 23.3364C17.3891 22.4654 24.6524 15.7027 24.9698 15.3961C25.4613 14.9214 25.1562 14.6387 24.5856 14.9974L13.8568 22.053L9.71764 20.6108C9.71764 20.6108 9.06626 20.3708 9.00359 19.8491C8.9401 19.3265 9.73908 19.0439 9.73908 19.0439L26.6131 12.1889C26.6131 12.1889 28 11.5579 28 12.6022Z">
                                        </path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 col-lg-5 right-side ">
                        <form action="{{ route('contact.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="page-contacts-form">
                                <div class="input">
                                    <div class="input-icon">
                                        <svg width="22" height="22" viewBox="0 0 22 22" fill="none"
                                            xmlns="http://www.w3.org/2000/svg" class="usericon">
                                            <path
                                                d="M11.1467 9.96421C11.055 9.95504 10.945 9.95504 10.8442 9.96421C8.66249 9.89087 6.92999 8.10337 6.92999 5.90337C6.92999 3.65754 8.74499 1.83337 11 1.83337C13.2458 1.83337 15.07 3.65754 15.07 5.90337C15.0608 8.10337 13.3283 9.89087 11.1467 9.96421Z"
                                                stroke="#DBDBDB" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round">
                                            </path>
                                            <path
                                                d="M6.56335 13.3466C4.34501 14.8316 4.34501 17.2516 6.56335 18.7275C9.08418 20.4141 13.2183 20.4141 15.7392 18.7275C17.9575 17.2425 17.9575 14.8225 15.7392 13.3466C13.2275 11.6691 9.09335 11.6691 6.56335 13.3466Z"
                                                stroke="#DBDBDB" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round"></path>
                                        </svg>
                                    </div>
                                    <input name="name" type="text" placeholder="Your name"
                                        value="{{ $userName }}">
                                </div>
                                <div class="input">
                                    <div class="input-icon">
                                        <svg width="22" height="22" viewBox="0 0 22 22" fill="none"
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
                                    <input name="email" type="email" placeholder="E-mail" value="{{ $userEmail }}">
                                </div>
                                <div class="input">
                                    <div class="input-icon"><svg width="22" height="22" viewBox="0 0 22 22"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M4.03769 14.2325L8.19019 18.385C9.89519 20.09 12.6635 20.09 14.3777 18.385L18.4019 14.3608C20.1069 12.6558 20.1069 9.8875 18.4019 8.17334L14.2402 4.03C13.3694 3.15917 12.1685 2.69167 10.9402 2.75584L6.35686 2.97584C4.52353 3.05834 3.06603 4.51584 2.97436 6.34L2.75436 10.9233C2.69936 12.1608 3.16686 13.3617 4.03769 14.2325Z"
                                                stroke="#95979F" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round"></path>
                                            <path
                                                d="M8.92448 11.2075C10.1901 11.2075 11.2161 10.1815 11.2161 8.91581C11.2161 7.65016 10.1901 6.62415 8.92448 6.62415C7.65883 6.62415 6.63281 7.65016 6.63281 8.91581C6.63281 10.1815 7.65883 11.2075 8.92448 11.2075Z"
                                                stroke="#95979F" stroke-width="1.5" stroke-linecap="round"></path>
                                            <path d="M12.1328 15.7908L15.7995 12.1241" stroke="#95979F" stroke-width="1.5"
                                                stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round">
                                            </path>
                                            @if (session('product_title'))
                                        </svg></div> <input name="subject" type="text" placeholder="Subject"
                                        value="{{ session('product_title') }}">
                                        @else
                                    </svg></div> <input name="subject" type="text" placeholder="Subject"
                                    value="{{ old('subject') }}">
                                         @endif

                                </div>
                                <div name="message" class="input-textarea">
                                    <textarea placeholder="Message" name="message" value="">{{ old('message') }}</textarea>
                                </div>
                                <div class="input">
                                    <div class="input-icon">
                                    </div>
                                    <input type="file" name="ticketfile">
                                </div>
                                <div class="mt-2">
                                    @if ($errors->any())
                                        <div class="alert alert-danger mt-3" role="alert">
                                            @foreach ($errors->all() as $error)
                                                {{ $error }}
                                                <br>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                                <button href="" class="btn-large">Send</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
