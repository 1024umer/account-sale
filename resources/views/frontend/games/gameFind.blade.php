@extends('frontend.layout')

@if ($data)
    @section('meta_title', $data->meta_title . ' ' . $product->meta_title)
    @section('meta_keyowrds', $data->meta_keyowrds . ' ' . $product->meta_keywords)
    @section('meta_description', $data->meta_description . ' ' . $product->meta_description)
@endif

@section('page-styles')
    <style>
        .popular-section .top-side .left-side h1 {
            font-size: 3.5rem;
            font-weight: 1000;
            letter-spacing: 1px;
            color: #20ada3;
        }

        .popular-section .top-side .left-side h3 {
            font-weight: 600;
            font-size: 24px;
            line-height: 30px;
            letter-spacing: .012em;
            text-transform: capitalize;
            color: #dbdbdb;
            margin-bottom: 12px;
        }

        .popular-section .top-side .left-side img {
            display: inline-block;
            max-width: 75%;
            vertical-align: middle;
        }

        .popular-section .top-side .right-side h1 {
            font-size: 3.5rem;
            font-weight: 1000;
        }

        .popular-section .top-side .right-side p {
            color: hsla(0, 0%, 100%, 0.404);
            text-transform: uppercase;
            font-size: 14px;
            letter-spacing: 1px;
        }

        .popular-section .top-side .right-side .border-right {
            position: relative;
        }

        .popular-section .top-side .right-side .border-right::before {
            content: '';
            position: absolute;
            top: 50%;
            right: -1px;
            transform: translateY(-50%);
            height: 50%;
            border-right: 1px solid hsla(0, 0%, 100%, .03);
        }

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

        .popular-section .products-side .game-card {
            overflow: hidden;
            border-radius: 12px;
            text-decoration: none;
            background: rgba(22, 25, 30, .87);
            cursor: pointer;
        }

        .popular-section .products-side .game-card .card-image img {
            height: 250px;
            width: 100%;
            object-fit: cover;
            overflow: hidden;
            transition: transform 0.2s ease;
            transform-origin: center center;
        }

        .popular-section .products-side .game-card h4 {
            font-weight: 800;
            font-size: 20px;
            line-height: 24px;
            position: relative;
            color: #dbdbdb;
            transition: .2s;
        }

        .popular-section .products-side a {
            text-decoration: none;
        }

        .popular-section .products-side .game-card p {
            font-weight: 600;
            font-size: 13px;
            line-height: 26px;
            color: #95979f;
        }

        .popular-section .products-side .game-card p span {
            color: #20ada3;
        }

        .popular-section .products-side .game-card .card-content {
            margin-top: -5px;
        }

        .popular-section .products-side .game-card:hover .card-image img {
            transform: scale(1.1);
            overflow: hidden;
            filter: blur(1px);
        }

        .popular-section .products-side .game-card .card-image {
            position: relative;
            background-position: 50%;
        }

        .popular-section .products-side .game-card .card-image .badge-div {
            position: absolute;
            margin: 20px;
            padding: 4px 8px;
            background: rgba(118, 219, 161, .12);
            backdrop-filter: blur(24px);
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            font-weight: 600;
            font-size: 10px;
            line-height: 24px;
            text-transform: uppercase;
            top: 0;
            right: 0;
        }

        .popular-section .products-side .game-card .card-image .badge-div.Undetected {
            color: #76dba1;
        }

        .popular-section .products-side .game-card .card-image .badge-div.Undetected svg {
            fill: #76dba1;
        }

        .popular-section .products-side .game-card .card-image .badge-div.Updating {
            color: #1a85dd;
        }

        .popular-section .products-side .game-card .card-image .badge-div.Updating svg {
            fill: #1a85dd;
        }


        .popular-section .products-side .game-card .card-image .badge-div.Testing {
            color: #dadd1a;
        }

        .popular-section .products-side .game-card .card-image .badge-div.Testing svg {
            fill: #dadd1a;
        }

        .popular-section .products-side .game-card .card-image .badge-div.Detected {
            color: #dd581a;
        }

        .popular-section .products-side .game-card .card-image .badge-div.Detected svg {
            fill: #dd581a;
        }

        .popular-section .products-side .game-card:hover h4 {
            color: #20ada3;
        }

        .popular-section .products-side .game-card .icons-side {
            padding-top: 15px;
            border-top: 1px solid hsla(0, 0%, 100%, .03);
            background: linear-gradient(90deg, rgba(39, 46, 55, 0), rgba(39, 46, 55, .24) 51.04%, rgba(39, 46, 55, 0));
            -webkit-mask-image: linear-gradient(90deg, rgba(23, 27, 32, .18) 9.38%, #272e37 48.75%, rgba(23, 27, 32, .18) 93.23%);
            padding-bottom: 15px;
            align-items: center;
            justify-content: space-between;
            display: flex;
            width: 100%;
        }

        .popular-section .products-side .game-card .icons-side img {
            padding-left: 10px;
            padding-right: 10px;
        }

        @media (max-width: 767px) {
            .breadcrumb {
                padding-top: 30px;
            }

            .hero-section .left-side {
                padding-left: 20px;
                padding-right: 20px;
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
                    <a href="{{ route('games') }}">Games > </a>
                    <a href="#">{{ $product->title }}</a>
                </div>
            </div>
            <section class="popular-section mt-5 py-5">
                <div class="container pb-5">
                    <div class="top-side">
                        <div class="d-block d-md-flex align-items-center justify-content-between">
                            <div class="left-side my-2 my-md-auto mb-5 mb-md-0">
                                <h3 class="top-h1">Game Soft</h3>
                                <h1 class="bottom-h1">{{ $product->title }}</h1>
                                <img class=" my-2" src="{{ asset('frontend/images/underline.svg') }}" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="products-side my-5">
                        <div class="row row-cols-">
                            <div class="col-md-3 p-4">
                                <a href="{{ route('games.details', ['slug' => $product->title]) }}">
                                    <div class="game-card">
                                        <div class="card-image w-100">
                                            <img src="{{ $product->main_image }}" alt="">
                                            <div class="badge-div {{ $product->options }}">
                                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M15 5.56064V6.78272C15 7.21011 14.786 7.6108 14.415 7.85788L6.56718 13.2404C6.06064 13.5876 5.36861 13.5876 4.8692 13.2337L3.84186 12.5125C3.37812 12.1853 3 11.4774 3 10.9365V5.56064C3 4.8127 3.61356 3.98462 4.36266 3.72418L8.26516 2.35518C8.67182 2.21494 9.32818 2.21494 9.73484 2.35518L13.6373 3.72418C14.3864 3.98462 15 4.8127 15 5.56064Z"
                                                        ></path>
                                                    <path
                                                        d="M13.9543 9.13219C14.3884 8.80335 15 9.12534 15 9.6871V10.975C15 11.5299 14.6514 12.2493 14.2239 12.585L10.6264 15.3869C10.3108 15.6267 9.88984 15.75 9.46893 15.75C9.04802 15.75 8.6271 15.6267 8.31142 15.3801L7.76554 14.9553C7.4104 14.6813 7.4104 14.1264 7.77212 13.8523L13.9543 9.13219Z"
                                                        ></path>
                                                </svg>
                                                <span>{{ $product->options }}</span>
                                            </div>
                                        </div>
                                        <div class="card-content w-100 px-5 pt-3 pb-1 text-center">
                                            <h4 class="mt-2">Devil Software</h4>
                                            <p class="mt-2 mb-1">Start with: <span>{{ $product->price }}$</span></p>
                                        </div>
                                        <div class="icons-side">
                                            <img src="{{ asset('frontend/images/aim.png') }}" alt="">
                                            <img src="{{ asset('frontend/images/radar.png') }}" alt="">
                                            <img src="{{ asset('frontend/images/dots-circle.png') }}" alt="">
                                            <img src="{{ asset('frontend/images/skins.png') }}" alt="">
                                            <img src="{{ asset('frontend/images/aim.png') }}" alt="">
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </section>

@endsection
