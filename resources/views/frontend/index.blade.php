@extends('frontend.layout')

@if ($data)
    @section('meta_title', $data->meta_title)
    @section('meta_keyowrds', $data->meta_keyowrds)
    @section('meta_description', $data->meta_description)
@endif

@section('page-styles')
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .popular-section .top-side .left-side h1 {
            font-size: 3.5rem;
            font-weight: 1000;
            letter-spacing: 1px;
        }

        .popular-section .top-side .left-side .top-h1 {
            color: #20ada3;
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



        .catalog-section {
            background-image: url("{{ asset('frontend/images/hint.png') }}");
            background-size: cover;
            background-position: 50%;
        }

        .catalog-section h4 {
            font-weight: 550;
            font-size: 20px;
            line-height: 29px;
            text-align: center;
            letter-spacing: .02em;
            font-feature-settings: "smcp";
            font-variant: small-caps;
            color: #bbf1b5;
            text-transform: uppercase;
        }

        .catalog-section a {
            text-decoration: none;
            font-weight: 700;
            font-size: 64px;
            line-height: 78px;
            letter-spacing: .015em;
            font-feature-settings: "smcp";
            font-variant: small-caps;
            color: #dbdbdb;
            transition: .25s;
        }

        .catalog-section a:hover {
            color: #20ada3;
            transition: .25s;
        }
    </style>
    <style>
        .hero-section {
            padding-top: 32vh;
            /* background-image: url("{{ asset('frontend/images/page-bg.png') }}"); */
            min-height: 100vh;
            width: 100vw;
            background-position: top;
            background-repeat: no-repeat;
            background-size: 100%;
        }

        .hero-section .left-side .tag {
            display: inline-flex;
            margin-bottom: 28px;
            align-items: center;
            -webkit-user-select: none;
            user-select: none;
            background: linear-gradient(90deg, rgba(18, 193, 188, .12), rgba(100, 125, 178, .12));
            border-radius: 100px;
            padding: 10px 16px;
            grid-gap: 10px;
            gap: 10px;
        }

        .hero-section .left-side .tag p {
            font-weight: 800;
            font-size: 12px;
            line-height: 24px;
            margin-bottom: 0;
            font-feature-settings: "smcp";
            font-variant: small-caps;
            background: linear-gradient(90deg, #e3fbae, #25cdcc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-section .left-side h1 {
            font-weight: 1000;
            font-size: 6vh;
            line-height: 145%;
            letter-spacing: 1px;
        }

        .hero-section .left-side h1::after {
            content: "";
            position: relative;
            display: inline-block;
            width: 100px;
            height: 74px;
            background-image: url("{{ asset('frontend/images/zigzag_dark.png') }}");
            background-size: cover;
            background-position: 50%;
            background-repeat: no-repeat;
            margin-left: 50px;
            transform: translateY(15px);

        }

        .hero-section hr {
            color: hsla(0, 0%, 100%, 0.164);
        }

        .hero-section .left-side .under-heading p {
            width: 50%;
            font-weight: 500;
            font-size: 16px;
            line-height: 24px;
            letter-spacing: .02em;
            color: #62646c;
        }

        .hero-section .left-side .catBtn {
            color: #111317;
            background: #20ada3;

        }

        .hero-section .left-side .catBtn:hover {
            background: #fff;
            transition: 0.2s;
        }

        .hero-section .left-side .signBtn {
            background: hsla(0, 0%, 100%, .03);
            color: #dbdbdb;
            font-weight: 500;
        }

        .hero-section .left-side .signBtn:hover {
            background: hsla(0, 0%, 100%, .12);
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

        .popular-section .products-side a {
            text-decoration: none;
        }

        #carouselExampleIndicators {
            height: 80vh;
            margin-bottom: -30px;
        }

        .slider-div {
            margin-top: -10vh;
        }

        .carousel-item {
            height: 80vh;
            background-image: url("{{ asset('frontend/images/slider-bg.png') }}");
            background-position: center;
            border-radius: 20px;
            background-size: cover;
            background-repeat: no-repeat;
        }

        .carousel-item a {
            text-decoration: none;
            color: #000000;
        }

        .carousel-h4 {
            font-weight: 600;
        }
        .icon-control {
    margin-top: 5px;
    float: right;
    font-size: 80%;
}



.btn-light {
    background-color: #fff;
    border-color: #e4e4e4;
}

.list-menu {
    list-style: none;
    margin: 0;
    padding-left: 0;
}
.list-menu a {
    color: #343a40;
}

.card-product-grid .info-wrap {
    overflow: hidden;
    padding: 18px 20px;
}

[class*='card-product'] a.title {
    color: #212529;
    display: block;
}

.card-product-grid:hover .btn-overlay {
    opacity: 1;
}
.card-product-grid .btn-overlay {
    -webkit-transition: .5s;
    transition: .5s;
    opacity: 0;
    left: 0;
    bottom: 0;
    color: #fff;
    width: 100%;
    padding: 5px 0;
    text-align: center;
    position: absolute;
    background: rgba(0, 0, 0, 0.5);
}
.img-wrap {
    overflow: hidden;
    position: relative;
}

    </style>
@endsection

@section('page-scripts')
    <script>
        function showSubCategory(id) {
            $.ajax({
                type: 'GET',
                url: '{{ url('games/showsubcategory/') }}/' + id,
                data: '',
                success: function(data) {
                    $("#sub_category_filter").html(data.options);
                }
            });
        }

        function showSubSubcategory(id) {
            $.ajax({
                type: 'GET',
                url: '{{ url('games/showsubsubcategory/') }}/' + id,
                data: '',
                success: function(data) {
                    $("#sub_sub_category_filter").html(data.options);
                }
            });
        }
    </script>
@endsection

@section('content')
    <nav class="navbar navbar-expand-lg navbar-light bg-light" style="padding-top: 130px;">
        <!-- Container wrapper -->
        <div class="container-fluid">
            <!-- Toggle button -->
            <button class="navbar-toggler px-0" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarExample5"
                aria-controls="navbarExample5" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>

            <!-- Collapsible wrapper -->
            <div class="collapse navbar-collapse" id="navbarExample5">
                <!-- Left links -->
                <ul class="navbar-nav me-auto ps-lg-0" style="padding-left: 0.15rem">
                    <!-- Navbar dropdown -->
                    @foreach ($categoriesHeader as $category)
                        <li class="nav-item dropdown position-static">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-mdb-toggle="dropdown" aria-expanded="false" onmouseover="click()">
                                <img style="width: 30px;" src="{{ $category->image }}">
                                {{ $category->name }}
                            </a>
                            <!-- Dropdown menu -->

                            <div class="dropdown-menu mt-0" aria-labelledby="navbarDropdown"
                                style="
                                        border-top-left-radius: 0;
                                        border-top-right-radius: 0;
                                        width: 300px;
                                        height: 240px;
                                        overflow-y: scroll;
                                    ">
                                <div class="container">
                                    <div class="row my-4">
                                        @foreach ($category->subCategories as $sub_category)
                                            <div class="col-md-12 col-lg-12 mb-4 mb-lg-0 border-bottom">
                                                <a href="{{ route('games.category', ['slug' => $sub_category->name]) }}"
                                                    class="text-uppercase font-weight-bold">
                                                    <img style="width: 30px;" src="{{ $sub_category->image }}">
                                                    <strong>{{ $sub_category->name }}</strong>
                                                </a>
                                                @foreach ($sub_category->subSubCategory as $subSubCategory)
                                                    <a href="{{ route('games.subcategory', ['slug' => $subSubCategory->name]) }}"
                                                        class="text-dark">
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




                <div class="filter-content collapse show" id="collapse_3" style="">
			<div class="card-body">
				<input type="range"  class="custom-range" min="0" max="100" name="">
				<div class="form-row">
				<div class="form-group col-md-6">
				  <label>Min</label>
				  <input class="form-control" id="minimun" placeholder="$0" value="" type="number">
				</div>
				<div class="form-group text-right col-md-6">
				  <label>Max</label>
				  <input class="form-control" id="maximum" placeholder="$1,0000" value="" type="number">
				</div>
				</div> <!-- form-row.// -->
				<button onclick="price_filter()" class="btn btn-block btn-primary">Apply</button>
			</div><!-- card-body.// -->
		</div>
        </form>

                <div class="row">
                    @foreach ($subSubCategories as $subSubCategory)
                        <div class="row">
                            <h3 class="w-100 mx-auto fw-bold text-center mt-3 mb-0">
                                <img style="width: 30px;" src="{{ $subSubCategory->subCategory->image }}">
                                {{ $subSubCategory->subCategory->name . ' ' . $subSubCategory->name }}
                            </h3>
                        </div>
                        @foreach ($subSubCategory->gamingAccounts as $product)
                        @if ($product->private == 0)
                            <div class="col-md-12 p-4">
                                <div class="game-card shadow-lg">
                                    @if ($product->manual)
                                        <a href="{{ route('store.title.in.session', ['title' => $product->title]) }}"
                                            style="display: flex;align-items: center;width: 60%">
                                            <div class="card-image text-center">
                                                <img src="{{ $product->main_image }}" alt="">
                                            </div>
                                            <div class="card-content info1" >
                                              <h4 class="d-inline-block mb-0 product-title" >{{ $product->title }}<span>{!! $product->description !!}</span></h4>
                                          </div>
                                        </a>
                                    @else
                                    <a href="{{ route('games.details', ['slug' => $product->title]) }}" style="display: flex;align-items: center;width: 60%">
                                        <div class="card-image text-center">
                                           <img src="{{ $product->main_image }}" alt="">
                                        </div>

                                    <div class="card-content info1" >
                                        <h4 class="d-inline-block mb-0 product-title" >{{ $product->title }}<span>{!! $product->description !!}</span></h4>
                                    </div>




                                     </a>
                                    @endif

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

    @if($product->emailChannels()->where('status', 'available')->count() > 0)
    <a style="box-shadow: 0px 0px 13px 4px #3585fe;
    border: 0px;
    font-weight: 600;
    font-size: 13px;
    line-height: 15px;" class="text-center d-inline-block btn btn-info p-2 my-1 mb-2" href="{{ route('games.details', ['slug' => $product->title]) }}">Buy Now</a>
@else

    <a style="box-shadow: 0px 0px 13px 4px #3585fe;
    border: 0px;
    font-weight: 600;
    font-size: 13px;
    line-height: 15px;" class="text-center d-inline-block btn btn-info p-2 my-1 mb-2" href="#" onclick="addToCart()">Buy Now</a>
@endif

<!-- JavaScript function to handle the click event -->
<script>
    function addToCart() {
        // Product is out of stock, show alert message
        alert("This product is currently out of stock.");
    }
</script>



                                               @if($product->emailChannels()->where('status', 'available')->count() > 0)
                                                <p class="btn-holder">
                                                    <a href="{{ route('add.to.cart', $product->id) }}" class="btn btn-warning btn-block text-center" role="button">Add to cart</a>
                                                </p>
                                            @else
                                                <p class="btn-holder">
                                                    <a href="#" onclick="addToCart()" class="btn btn-warning btn-block text-center" role="button">Add to cart</a>
                                                </p>
                                            @endif

                                            <!-- JavaScript function to handle the click event -->
                                            <script>
                                                function addToCart() {
                                                    // Product is out of stock, show alert message
                                                    alert("This product is currently out of stock.");
                                                }
                                            </script>


                                                {{-- @endif --}}
                                            @endif
                                            {{-- <a href="">
                                            <i class="fa-solid fa-cart-shopping ms-5" style="font-size: 22px"></i>
                                        </a> --}}

                                        </p>
                                    </div>
                                </div>
                            </div>
                            @endif
                        @endforeach
                    @endforeach
                </div>

            </div>
        </div>
    </section>



    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        function apply_filter() {
            if (document.getElementById('category_filter').value != '')
                window.location.href = '{{ url('games/filter') }}/' + document.getElementById('category_filter').value +
                '/' + document.getElementById('sub_category_filter').value + '/' + document.getElementById(
                    'sub_sub_category_filter').value;
        }

        function price_filter() {

            if (document.getElementById('maximum').value != '')
                window.location.href = '{{ url('price/filter') }}/' + document.getElementById('minimun').value +
                '/' + document.getElementById('maximum').value ;
        }


 $(document).ready(function () {
        // Initialize price slider
        $("#priceSlider").slider({
            range: true,
            min: 0,
            max: 1000,
            values: [0, 1000],
            slide: function (event, ui) {
                $("#priceMin").text("Min: $" + ui.values[0]);
                $("#priceMax").text("Max: $" + ui.values[1]);
            }
        });
    });

    function applyPriceFilter() {
        // Retrieve the selected price range
        var minPrice = $("#priceSlider").slider("values", 0);
        var maxPrice = $("#priceSlider").slider("values", 1);

        // You can send an AJAX request to apply the filter in your Laravel backend
        // Example:
        // $.ajax({
        //     url: '/products',
        //     type: 'GET',
        //     data: {minPrice: minPrice, maxPrice: maxPrice},
        //     success: function(response) {
        //         // Handle the filtered product list
        //         console.log(response);
        //     }
        // });

        // For now, let's just log the selected range
        console.log("Selected Price Range: $" + minPrice + " - $" + maxPrice);
    }
</script>

@endsection
