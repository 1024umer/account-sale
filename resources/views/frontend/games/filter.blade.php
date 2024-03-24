@extends('frontend.layout')

@if ($data)
    @section('meta_title', $data->meta_title . ' games')
    @section('meta_keyowrds', $data->meta_keyowrds)
    @section('meta_description', $data->meta_description)
@endif

@section('page-styles')
<!-- Font Awesome -->
<link
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
rel="stylesheet"
/>
<!-- Google Fonts -->
<link
href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap"
rel="stylesheet"
/>
<!-- MDB -->
<link
href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.css"
rel="stylesheet"
/>
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
            height: 80px;
            width: 70%;
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
    <nav class="navbar navbar-expand-lg navbar-light bg-light" style="padding-top: 130px;">
        <!-- Container wrapper -->
        <div class="container-fluid">
            <!-- Toggle button -->
            <button class="navbar-toggler px-0" type="button" data-mdb-toggle="collapse"
                data-mdb-target="#navbarExample5" aria-controls="navbarExample5" aria-expanded="false"
                aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
    
            <!-- Collapsible wrapper -->
            <div class="collapse navbar-collapse" id="navbarExample5">
                <!-- Left links -->
                <ul class="navbar-nav me-auto ps-lg-0" style="padding-left: 0.15rem">
                    <!-- Navbar dropdown -->
                    @if($categoriesHeader)
                    @foreach ($categoriesHeader as $category)
                    <li class="nav-item dropdown position-static">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-mdb-toggle="dropdown" aria-expanded="false" onmouseover="click()">
                        <img style="width: 30px;" src="{{ $category->image }}">
                        {{ $category->name }}
                        </a>
                        <!-- Dropdown menu -->
                        <div class="dropdown-menu w-100 mt-0" aria-labelledby="navbarDropdown" style="
                                        border-top-left-radius: 0;
                                        border-top-right-radius: 0;
                                    ">
                            <div class="container">
                                <div class="row my-4">
                                    @foreach ($category->subCategories as $sub_category)
                                    <div class="col-md-12 col-lg-4 mb-4 mb-lg-0 border-bottom">
                                        <a href="{{ route('games.category', ['slug' => $sub_category->name]) }}" class="text-uppercase font-weight-bold">
                                            <img style="width: 30px;" src="{{ $sub_category->image }}">
                                            <strong>{{ $sub_category->name }}</strong>
                                        </a>
                                        @foreach ($sub_category->subSubCategory as $subSubCategory)
                                        <a href="{{ route('games.subcategory', ['slug' => $subSubCategory->name]) }}" class="text-dark">
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
                    @endif
                </ul>
                <!-- Left links -->
            </div>
            <!-- Collapsible wrapper -->
        </div>
        <!-- Container wrapper -->
    </nav>
    <section class="popular-section">
        <div class="container pb-5">
            <div class="top-side">
                <div class="d-block d-md-flex align-items-center justify-content-between">
                    <div class="left-side my-2 my-md-auto mb-5 mb-md-0">
                        <h1 class="top-h1">Popular</h1>
                        <img class=" my-2" src="{{ asset('frontend/images/underline.svg') }}" alt="">
                        <h1 class="bottom-h1">Products</h1>
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
                <div class="row bg-light rounded mb-4 align-items-end">
                    <div class="col-md-3">
                        <label for="">Category</label>
                        <select name="" id="category_filter" class="form-select"
                            onchange="showSubCategory(this.value)">
                            <option value="">Select Category</option>
                           
                            @foreach ($categoriesHeader as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="">Sub Category</label>
                        <select name="" id="sub_category_filter" class="form-select"
                            onchange="showSubSubcategory(this.value)">
                            <option value="">Select Sub Category</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="">Sub Sub Category</label>
                        <select name="" id="sub_sub_category_filter" class="form-select">
                            <option value="">Select Sub Sub Category</option>
                        </select>
                    </div>
                    <div class="col-md-3 text-center">
                        <button class="btn btn-primary btn-lg" onclick="apply_filter()">Apply</button>
                    </div>
                </div>
                <div class="row text-center bg-light rounded">
                    <div class="col-md-4">
                        <p class="m-2">Sort By: </p>
                    </div>
                    <div class="col-md-2 col-6 align-self-center">
                        <a class="m-2 d-inline-block" href="{{ route('sorthome', ['slug' => 'atoz']) }}">Name A to Z</a>
                    </div>
                    <div class="col-md-2 col-6 align-self-center">
                        <a class="m-2 d-inline-block" href="{{ route('sorthome', ['slug' => 'ztoa']) }}">Name Z to A</a>
                    </div>
                    <div class="col-md-2 col-6 align-self-center">
                        <a class="m-2 d-inline-block" href="{{ route('sorthome', ['slug' => 'cheaper']) }}">Cheaper</a>
                    </div>
                    <div class="col-md-2 col-6 align-self-center">
                        <a class="m-2 d-inline-block"
                            href="{{ route('sorthome', ['slug' => 'expensive']) }}">Expensive</a>
                    </div>
                </div>
                
                <div class="row row-cols-">
                
                 
                        @foreach($subCategory->subSubCategory as $subSubCategory)
                            <div class="row">
                                <h3 class="w-100 mx-auto fw-bold text-center mt-3 mb-0">
                                    <img style="width: 30px;" src="{{ $subSubCategory->subCategory->image }}">
                                    {{ $subSubCategory->subCategory->name . ' ' . $subSubCategory->name }}
                                </h3>
                            </div>
                            @foreach($subSubCategory->gamingAccounts as $product)
                            <div class="col-md-12 p-4">
                                <div class="game-card shadow-lg">
                                    <a href="{{ route('games.details', ['slug' => $product->title]) }}" style="display: flex;align-items: center;width: 60%">
                                    <div class="card-image text-center">
                                        <img src="{{ $product->main_image }}" alt="">
                                    </div>
                                    <div class="card-content">
                                        <h4 class="d-inline-block mb-0">{{ $product->title }}</h4>
                                        <p class="d-inline-block mb-0">Category: <span>{{ $product->category->name }}</span> / <span>{{ $product->sub_category->name }}</span> / <span>{{ $product->sub_subcategory->name }}</span></p>
                                    </div>
                                    </a>
                                    <div class="card-content" style="width: 40%;display: flex;justify-content: center;">
                                        <p class="d-inline-block m-0">
                                            @if ($product->discount > 0)
                                                <span class="text-center d-inline-block p-2 my-1"
                                                    style="background-color: #3585fe;
                                                    color: white;
                                                    border-radius: 13px;">{{ $product->discount }}%
                                                    OFF</span>
                                            @endif
                                            @if ($product->custom_stock != null &&  $product->custom_stock != 0)
                                            <span class="text-center d-inline-block p-2 my-1"
                                            style="background-color: #0000000f;
                                            color: #3585fe;
                                            border-radius: 7px">{{ $product->custom_stock }}
                                            PCs</span>
                                            @else
                                            <span class="text-center d-inline-block p-2 my-1" style="background-color: #0000000f;
                                            color: #3585fe;
                                            border-radius: 7px">{{ $product->emailChannels()->where('status', 'available')->count() }} PCs</span>
                                            @endif
                                    
                                                
                                            <span class="text-center d-inline-block p-2 my-1"
                                                style="background-color: #0000000f;
                                                color: #3585fe;
                                                border-radius: 7px">Price:
                                                @if ($product->discount > 0)
                                                    <span style="text-decoration: line-through;">{{ $product->price }}$
                                                    </span>
                                                @endif
                                                {{ $product->price - ($product->price * $product->discount) / 100 }}$
                                            </span>
                                            <br />
                                            @if ($product->manual)
                                                <a id="buyManualLink"
                                                    style="box-shadow: 8px 12px 20px 4px lightblue;border: 0px;font-weight: 600;font-size: 13px;line-height: 26px;padding-top: 4px; padding-bottom:4px; padding-left:21px; padding-right:21px"
                                                    class="text-center d-inline-block btn btn-info my-1"
                                                    href="{{ route('store.title.in.session', ['title' => $product->title]) }}">Buy
                                                    Manual</a>
                                            @else
                                                {{-- @if ($product->custom_stock != null && $product->custom_stock != 0) --}}
                                                    <a onclick="addToCart('{{ $product->id }}')"
                                                        class="text-center d-inline-block btn btn-info my-1"
                                                        style="    box-shadow: rgb(53, 133, 254) 0px 0px 13px 4px;
                                                        border: 0px;
                                                        font-weight: 600;
                                                        font-size: 13px;
                                                        line-height: 15px;
                                                        background: transparent;
                                                        color: #3585fe;">
                                                        Add to Cart</a>
                                                {{-- @endif --}}
                                            @endif
                                            {{-- <a href="">
                                            <i class="fa-solid fa-cart-shopping ms-5" style="font-size: 22px"></i>
                                        </a> --}}

                                        </p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @endforeach
                   
                   
                </div>
               
            </div>
        </div>
    </section>
<!-- MDB -->
<script
  type="text/javascript"
  src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.js"
></script>
@endsection
