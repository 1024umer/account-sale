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
<div class="banner layer gradient-section-bg style--two">
    <img src="/FrontendNew/assets/img/media/home2-banner-shape.png" alt="" class="banner-shape">
    <div class="container">
          <!-- Breadcrumbs added here -->
          <div class="breadcrumbs">
            <a href="/">Home</a> / <span>Payment and delivery</span>
        </div>
        <!-- End of Breadcrumbs -->
        <div class="row align-items-center">
            <div class="col-lg-7">
                <div class="banner-content">
                    <h1>Payment and delivery</h1>
                    <p>For cooperation or any other information, you can contact us at the following contacts</p>


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



<section class="service pt-120 pb-90" data-bg-img="assets/img/media/service-bg.png">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title title-shape text-center">
                    <h2>PAYMENT AND DELIVERY</h2>
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Facilis necessitatibus id aliquam maiores quasi voluptas amet porro velit ipsa fuga tempore odit quaerat dignissimos doloribus ullam quae, numquam perspiciatis nulla..</p>
                </div>
            </div>
        </div>
        <div class="row">




            <div class="policy">
                {!! $data->payment_and_delivery !!}
            </div>

        </div>
    </div>
</section>


@endsection