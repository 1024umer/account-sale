@extends('frontendNew.layout.main')


@section('body')
<style>
    .banner {
        height: 200px !important;
    }
    .banner {
    position: relative;
}

.breadcrumbs {
    position: absolute;
    top: 20px;
    left: 20px;
    font-size: 16px;
    color: #fff;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
    z-index: 1;
}

.breadcrumbs a {
    color: #fff;
    text-decoration: none;
}

.breadcrumbs a:hover {
    text-decoration: underline;
}

</style>




<div class="banner layer gradient-section-bg style--two position-relative">
    <img src="/FrontendNew/assets/img/media/home2-banner-shape.png" alt="" class="banner-shape">
    <div class="container">
        <!-- Breadcrumbs added here -->
        <div class="breadcrumbs">
            <a href="/">Home</a> / <span>Popular Products</span>
        </div>
        <!-- End of Breadcrumbs -->

        <div class="row align-items-center">
            <div class="col-lg-7">
                <div class="banner-content">
                    <h1>Popular Products </h1>
                    <p>MORE THAN 3+ YEARS OF WORK</p>
                    <p>IN CATALOG 12 GAMES</p>
                    <p>IN CATEGORIES 30 ACTIVE PRODUCTS</p>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="banner-img">
                    <img src="/FrontendNew/assets/img/media/banner-img2.png" data-rjs="2" alt="">
                </div>
            </div>
        </div>
    </div>
</div>




<br><br>
<section class="contact  bg-img" style="background-image: url(&quot;assets/img/media/contact-form-bg.png&quot;);">
    <div class="container ">
        <div class="row justify-content-between">
           


                <div class="col-md-3">
                    <h2>Categories</h2>
                    <ul class="list-group">
                        @foreach ($categoriesHeader as $category)
                        <li class="list-group-item">
                            {{ $category->name }}
                            <ul class="list-group mt-2">
                                @foreach ($category->subCategories as $sub_category)
                                <li class="list-group-item">
                                    <a href="{{ route('games.category', ['slug' => $sub_category->name]) }}" class="text-uppercase font-weight-bold">
                                        {{ $sub_category->name }}
                                    </a>
                                    <ul class="list-group mt-2">
                                        @foreach ($sub_category->subSubCategory as $subSubCategory)
                                        <li class="list-group-item">
                                            <a href="{{ route('games.subcategory', ['slug' => $subSubCategory->name]) }}" class="text-dark"> {{ $subSubCategory->name }} </a>
                                        </li>
                                        @endforeach
                                    </ul>
                                </li>
                                @endforeach

                            </ul>
                        </li>
                        @endforeach

                    </ul>
                </div>
                <div class="col-md-9">
                    <div class="row">
                    @foreach($categoriesHeader as $category)
                        <div class="col-lg-4 col-md-6">
                            <div class="single-feature">
                                <div class="feature-icon"><img src="{{ $category->image }}" alt></div>
                                <div class="feature-content">
                                    <a href="{{ url('games/filter').'/'.$category->id }}" ><h3>{{ $category->name }}</h3></a>
                                    <p class="m-0">Total Groups: {{ $category->subCategories->count() }}</p>
                                    <p class="m-0">Total Products: {{ $category->gamingAccounts->count() }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                      
                      
                   
                </div>
            </div>
        </div>
    </div>
</section>

<section class="service-details pb-120 bg-img" style="background-image: url(&quot;assets/img/media/service-details-shape.png&quot;);">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="content pb-2">
                    <h2>How it Works</h2>
                </div>
                <div class="accordion mb-4">
                    <div data-accordion-tab="toggle" class="">
                        <h3>Wait! What are our Popular Products</h3>
                        <div class="accordion-content" style="display: none;">Security companies are working all
                            around the world to protect homes, offices and other buildings. Many security companies are
                            using slogans and taglines to distinguish themselves from their competitors and to tell the
                            public why they are the best &amp; why they should hire them for their security Thinking a
                            slogan or tagline for a security company can be very hard. In this post, we have gathered
                        </div>
                    </div>

                </div>
                <div class="accordion mb-4">
                    <div data-accordion-tab="toggle" class="">
                        <h3>Wait! What are our Popular Products</h3>
                        <div class="accordion-content" style="display: none;">Security companies are working all
                            around the world to protect homes, offices and other buildings. Many security companies are
                            using slogans and taglines to distinguish themselves from their competitors and to tell the
                            public why they are the best &amp; why they should hire them for their security Thinking a
                            slogan or tagline for a security company can be very hard. In this post, we have gathered
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>


@endsection