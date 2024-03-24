@extends('frontend.layout')

@if ($data)
    @section('meta_title', $data->meta_title . ' policy')
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

        .hero-section .page-head .main-text p {
            font-weight: 600;
            font-size: 14px;
            line-height: 17px;
            text-transform: capitalize;
            color: #dbdbdb;
        }

        .hero-section .page-head .main-text h4 {
            font-weight: 800;
            font-size: 24px;
            line-height: 29px;
            text-transform: capitalize;
            color: #20ada3;
            margin: 12px 0;
        }

        .policy {
            color: #62646c !important;
            font-size: 14px !important;
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
                    <a href="{{ route('policy') }}">Policy</a>
                </div>
                <div class="main-text text-center my-5">
                    <p>Devil Software's</p>
                    <h4>Privacy Policy</h4>
                    <img src="{{ asset('frontend/images/underline.svg') }}" class="img-fluid" alt="">
                </div>
                <div class="policy">
                    {!! $data->privacy_policy !!}
                </div>
            </div>
        </div>
    </section>
@endsection
