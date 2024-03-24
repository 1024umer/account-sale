@extends('frontend.layout')

@if ($data)
    @section('meta_title', $data->meta_title . ' Give Away')
    @section('meta_keyowrds', $data->meta_keyowrds)
    @section('meta_description', $data->meta_description)
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
            /* background: rgba(22, 25, 30, .87); */
            cursor: pointer;
            display: flex;
            align-items: center;
        }

        @media screen and (max-width: 991px) {
            .popular-section .products-side .game-card {
                flex-direction: column;
            }
            .popular-section .products-side .game-card .card-content {
                width: 100% !important;
            }
            .popular-section .products-side .game-card a {
                width: 100% !important;
            }
        }

        .popular-section .products-side .game-card img {
            height: 220px;
            object-fit: contain;
            overflow: hidden;
            transition: transform 0.2s ease;
            transform-origin: center center;
        }

        .popular-section .products-side .game-card h4 {
            font-weight: 800;
            font-size: 18px;
            line-height: 24px;
            color: #444;
            transition: .2s;
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

        .popular-section .products-side .game-card:hover img {
            transform: scale(1.1);
            overflow: hidden;
            filter: blur(1px);
        }

        .popular-section .products-side .game-card:hover h4 {
            color: #20ada3;
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
                    <a href="{{ route('giveaway') }}">Give Aways</a>
                </div>
            </div>
            <section class="popular-section mt-5 py-5">
                <div class="container pb-5">
                    <div class="top-side">
                        <div class="d-block d-md-flex align-items-center justify-content-between">
                            <div class="left-side my-2 my-md-auto mb-5 mb-md-0">
                                <h1 class="bottom-h1">GIVE AWAYS</h1>
                                <img class=" my-2" src="{{ asset('frontend/images/underline.svg') }}" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="products-side my-5">
                        <div class="row row-cols-">
                            @foreach($giveAways as $giveAway)
                            <div class="col-md-12 p-4">
                                <div class="game-card shadow-lg">
                                    <div class="card-image text-center">
                                        <img src="{{ $giveAway->image }}" alt="">
                                    </div>
                                    <div class="card-content p-3">
                                        <h4 class="d-inline-block mb-0">{{ $giveAway->title }}</h4>
                                        <p>{!! $giveAway->description !!}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </section>

@endsection
