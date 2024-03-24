@extends('frontend.layout')

@if ($data)
    @section('meta_title', $data->meta_title . ' licence keys')
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
            background: rgba(22, 25, 30, .87);
            cursor: pointer;
        }

        .popular-section .products-side .game-card img {
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
                    <a href="{{ route('licence.keys') }}">PRODUCTS</a>
                </div>
            </div>
            <section class="popular-section mt-5 py-5">
                <div class="container pb-5">
                    <div class="top-side">
                        <div class="d-block d-md-flex align-items-center justify-content-between">
                            <div class="left-side my-2 my-md-auto mb-5 mb-md-0">
                                <h3 class="top-h1"> License Keys</h3>
                                <h1 class="bottom-h1">PRODUCTS</h1>
                                <img class=" my-2" src="{{ asset('frontend/images/underline.svg') }}" alt="">
                            </div>
                            <div class="right-side d-flex align-items-center">
                                <div class="text-center px-4 border-right">
                                    <p class="text-dark">MORE THAN</p>
                                    <h1 class="text-dark">3+</h1>
                                    <p class="text-dark">YEARS OF WORK</p>
                                </div>
                                <div class="text-center px-4 border-right">
                                    <p class="text-dark">in catalog</p>
                                    <h1 class="text-dark">12</h1>
                                    <p class="text-dark">games</p>
                                </div>
                                <div class="text-center px-4">
                                    <p class="text-dark">in categories</p>
                                    <h1 class="text-dark">30</h1>
                                    <p class="text-dark">active products</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="products-side my-5">
                        <div class="row row-cols-">
                            @foreach($licenceKeys as $product)
                            <div class="col-md-3 p-4">
                                <a href="{{ route('licence.keys.find', ['slug' => $product->title]) }}">
                                    <div class="game-card">
                                        <div class="card-image w-100">
                                            <img src="{{ $product->main_image }}"
                                            alt="">
                                        </div>
                                        <div class="card-content w-100 px-5 pt-3">
                                            <h4 class="mt-2">{{ $product->title }}</h4>
                                            <p class="mt-2 mb-1">Start with: <span>{{ $product->keyChannels[0]->price }}$</span></p>
                                            <p>Category: <span>{{ $product->category->name }}</span></p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </section>
        </div>
    </section>

@endsection
