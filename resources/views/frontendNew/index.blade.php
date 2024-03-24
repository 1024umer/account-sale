@extends('frontendNew.layout.main')


@section('body')
<style>
    .circle-container {
      display: flex;
      justify-content: center;
    }

    .circle {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      overflow: hidden;
      margin: 10px;
    }

    .circle img {
        width: 100%;
      height: 100%;
      object-fit: cover;
      filter: brightness(70%);
    }

    .circle p {
        position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      text-align: center;
      color: white; /* Change the text color as needed */
      z-index: 1;
      width: 100%; /* Ensure text takes full width */
    }
  </style>
   <section id="hero" class="d-flex align-items-center justify-content-center">
    <div class="container" data-aos="fade-up">

      <div class="row justify-content-center" data-aos="fade-up" data-aos-delay="150">
        <div class="col-xl-6 col-lg-8">
          <h1>Popular Products <span>.</span></h1>
          <h2>MORE THAN 3+ YEARS OF WORK</h2>
          <h3 class="text-white" >IN CATALOG 12 GAMES IN CATEGORIES 30 ACTIVE PRODUCTS</h3>
        </div>
      </div>

      <div class="row gy-4 mt-5 justify-content-center" data-aos="zoom-in" data-aos-delay="250">
      @foreach ($categoriesHeader as $category)
      <div class="col-xl-2 col-md-4">
          <div class="icon-box">
            <img  src="https://kandan.dev/storage/app/{{ $category->image }}" />
            <h3><a href="">{{ $category->name }}</a></h3>
          </div>
        </div>
        @endforeach
       
      </div>

    </div>
  </section>
<!-- <div class="banner layer">
    <div class="container">
        <div class="row">
            <div class="col-lg-7">
                <div class="banner-content">

                    <h1>Popular Products</h1>
                    <p>MORE THAN 3+ YEARS OF WORK</p>
                    <p>IN CATALOG 12 GAMES</p>
                    <p>IN CATEGORIES 30 ACTIVE PRODUCTS</p>
                  
                </div>
            </div>
            <div class="col-lg-5">
                <div class="banner-img d-none d-xl-block"><img src="/FrontendNew/assets/images/main-img.png" alt="main img" data-rjs="2" class="main-img"> <img src="/FrontendNew/assets/images/setting.png" alt="setting" data-rjs="2" class="setting-img"> <img src="/FrontendNew/assets/images/sheild.png" alt="sheild" data-rjs="2" class="sheild-img"> <img src="/FrontendNew/assets/images/lock.png" alt="lock" data-rjs="2" class="lock-img">
                    <img src="/FrontendNew/assets/images/card.png" alt="card" data-rjs="2" class="card-img"> <img src="/FrontendNew/assets/images/box.png" alt="box" data-rjs="2" class="box-img"> <img src="/FrontendNew/assets/images/check.png" alt="check" data-rjs="2" class="check-img"> <img src="/FrontendNew/assets/images/setting2.png" alt="setting2" data-rjs="2" class="setting2-img">
                </div>
                <div class="banner-img-responsive d-block d-xl-none"><img src="/FrontendNew/assets/images/banner-img.png" data-rjs="2" alt></div>
            </div>
        </div>
    </div>
</div> -->
<!-- <div class="container mt-5">
  <div class="row circle-container">
  @foreach ($categoriesHeader as $category)
    <div class="col-2">
      <div class="circle">
        <img src="{{ $category->image }}" alt="Image 1">
        <p>{{ $category->name }}</p>
      </div>
    </div>
    @endforeach
  

    <!-- Add more columns as needed -->
  </div>
</div> -->

<section class="contact pt-120 pb-120 bg-img" style="background-image: url(&quot;assets/img/media/contact-form-bg.png&quot;);">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-12">
                <div class="contact-form-wrap">
                    <h2 class="mb-4">Popular Products</h2>
                    <form action="https://themelooks.net/demo/dvpn/html/preview/sendmail.php" class="contact-form">
                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <select name="" id="category_filter" class="form-control" onchange="showSubCategory(this.value)">
                                        <option value="">Select Category</option>
                                        @foreach ($categoriesHeader as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <select name="" id="sub_category_filter" class="form-control" onchange="showSubSubcategory(this.value)">
                                        <option value="">Select Sub Category</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <select name="" id="sub_sub_category_filter" class="form-control">
                                        <option value="">Select Sub Sub Category</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <center>
                                    <div class="btn-wrap">
                                        <span></span>
                                        <button onclick="apply_filter()" type="button" class="btn">Apply</button>
                                    </div>
                                </center>
                            </div>
                        </div>
                    </form>
                    <div class="form-response"></div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="contact-form-wrap">
                    <h2 class="mb-4">Filter</h2>
                    <form action="https://themelooks.net/demo/dvpn/html/preview/sendmail.php" class="contact-form">
                        <div class="row">
                            <div class="col-2">
                                <div style="color: #5551ef;" class="form-group">
                                    Sort By:
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div style="color: #5551ef;" class="form-group">
                                    <a href="{{ route('sorthome', ['slug' => 'atoz']) }}">Name A to Z </a>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div style="color: #5551ef;" class="form-group">
                                    <a href="{{ route('sorthome', ['slug' => 'ztoa']) }}">Name Z to A</a>
                                </div>
                            </div>

                            <div style="color: #5551ef;" class="col-lg-2">
                                <a href="{{ route('sorthome', ['slug' => 'cheaper']) }}">Cheaper </a>
                            </div>
                            <div class="col-lg-2">
                                <div style="color: #5551ef;" class="form-group">
                                    <a href="{{ route('sorthome', ['slug' => 'expensive']) }}">Expensive </a>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="form-response"></div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="contact-form-wrap">
                    <br>
                    <form action="https://themelooks.net/demo/dvpn/html/preview/sendmail.php" class="contact-form">
                        <div class="row">
                            <div class="col-lg-5">
                                <div class="form-group">
                                    <input type="number" name="name" class="form-control" id="minimun" placeholder="$0" value="" type="number">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <input type="number" name="name" class="form-control" id="maximum" placeholder="$1,0000" value="" type="number">
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <center>
                                    <div class="btn-wrap">
                                        <span></span>
                                        <button onclick="price_filter()" type="button" class="btn">Apply</button>
                                    </div>
                                </center>
                            </div>
                        </div>
                    </form>
                    <div class="form-response"></div>
                </div>
            </div>
        </div>
    </div>
</section>


<section>
    <br>
    <div class="container" style="line-height: 0.2;">
        @foreach ($subSubCategories as $subSubCategory)
        <center>
            <h1>{{ $subSubCategory->name }}</h1>
        </center>
        <div class="row">
            @foreach ($subSubCategory->gamingAccounts as $product)
            @if ($product->private == 0)
            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="row ">
                        <div class="col-md-2 text-center" style=" display: flex;
justify-content: center;
    align-items: center;
    ">
                            @if ($product->manual)
                            <img src="{{ $product->main_image }}" alt="" width="70" class=" rounded-start">
                            @else
                            <img src="{{ $product->main_image }}" alt="" width="70" class=" rounded-start">
                            @endif
                        </div>
                        <div class="col-md-6">
                            <div class="card-body">
                                @if ($product->discount > 0)
                                <div class="badge badge-danger ">{{ $product->discount }}% OFF</div>
                                @endif
                                <a href="{{ route('games.details', ['slug' => $product->title]) }}"  title="{{ $product->description }}" ><h5 class="card-title">{{ $product->title }}</h5></a>
                               
                                <p class="">Price:
                                    @if ($product->discount > 0)
                                    <del>${{ $product->price }}</del>
                                    @endif
                                    ${{ $product->price - ($product->price * $product->discount) / 100 }}
                                </p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card-body ">
                                @if ($product->manual)
                                <a href="{{ route('store.title.in.session', ['title' => $product->title]) }}" class="btn btn-primary">Buy Manual</a>
                                @else
                                @if ($product->emailChannels()->where('status', 'available')->count() > 0)
                                <a href="{{ route('games.details', ['slug' => $product->title]) }}" class="btn btn-primary btn-sm">Buy Now</a>
                                @else
                                <button class="btn btn-secondary btn-sm mb-2" onclick="addToCart()">Buy Now</button>
                                <!-- JavaScript function to handle the click event -->
                                <script>
                                    function addToCart() {
                                        // Product is out of stock, show alert message
                                        alert("This product is currently out of stock.");
                                    }
                                </script>

                                @endif

                                @if($product->emailChannels()->where('status', 'available')->count() > 0)
                                <a href="{{ route('add.to.cart', $product->id) }}" class="btn btn-success btn-sm">Add to Cart</a>
                                @else
                                <button class="btn btn-secondary btn-sm" onclick="addToCart()">Add to Cart</button>
                                <!-- JavaScript function to handle the click event -->
                                <script>
                                    function addToCart() {
                                        // Product is out of stock, show alert message
                                        alert("This product is currently out of stock.");
                                    }
                                </script>
                                @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @endforeach
        </div>
        @endforeach
    </div>
</section>


<section class="testimonial section-bg pb-140 bg-img" style="background-image: url(&quot;assets/img/media/testimonial-bg.png&quot;);">
    <div class="container" style="line-height: 1.67;">
        <div class="row">
            <div class="col-12">
                <div class="section-title title-shape text-center">
                    <h2>Customer Feedback</h2>
                    <p>These speeds are excellent. It’s rare that a fast connection safety <br>Internet leading speeds
                        across its network. </p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="testimonial-carousel owl-carousel owl-loaded owl-drag" data-owl-items="2" data-owl-margin="40" data-owl-dots="true" data-owl-autoplay="true" data-owl-responsive="{&quot;0&quot;: {&quot;items&quot;: &quot;1&quot;}, &quot;991&quot;: {&quot;items&quot;: &quot;2&quot;}}">
                    <div class="owl-stage-outer">
                        <div class="owl-stage" style="transform: translate3d(-2300px, 0px, 0px); transition: all 0.45s ease 0s; width: 4025px;">
                            <div class="owl-item cloned" style="width: 535px; margin-right: 40px;">
                                <div class="single-testimonial">
                                    <div class="quote">
                                        <img src="/FrontendNew/assets/img/icons/quote.svg" alt="" class="svg">
                                    </div>
                                    <div class="testimonial-content">
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="media review-info align-items-center">
                                            <div class="testimonial-img">
                                                <img src="/FrontendNew/assets/img/media/testimonial_2.png" data-rjs="2" alt="">
                                            </div>
                                            <div class="testimonial-name">
                                                <h4>Ben Horowitz</h4>
                                                <span>Chief Officer</span>
                                            </div>
                                        </div>
                                        <div class="rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="owl-item cloned" style="width: 535px; margin-right: 40px;">
                                <div class="single-testimonial">
                                    <div class="quote">
                                        <img src="/FrontendNew/assets/img/icons/quote.svg" alt="" class="svg">
                                    </div>
                                    <div class="testimonial-content">
                                        <p>Program easy to use, I feel very safe, very affordable the I can watchs my
                                            favorites shows France its the America problem whatsoever to offer that
                                            others.</p>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="media review-info align-items-center">
                                            <div class="testimonial-img">
                                                <img src="/FrontendNew/assets/img/media/testimonial_3.png" data-rjs="2" alt="">
                                            </div>
                                            <div class="testimonial-name">
                                                <h4>Ben Horowitz</h4>
                                                <span>Project Manager</span>
                                            </div>
                                        </div>
                                        <div class="rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="owl-item" style="width: 535px; margin-right: 40px;">
                                <div class="single-testimonial">
                                    <div class="quote">
                                        <img src="/FrontendNew/assets/img/icons/quote.svg" alt="" class="svg">
                                    </div>
                                    <div class="testimonial-content">
                                        <p>Program easy to use, I feel very safe, very affordable the I can watchs my
                                            favorites shows France its the America problem whatsoever to offer that
                                            others.</p>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="media review-info align-items-center">
                                            <div class="testimonial-img">
                                                <img src="/FrontendNew/assets/img/media/testimonial_1-2.png" data-rjs="2" alt="">
                                            </div>
                                            <div class="testimonial-name">
                                                <h4>William Blake</h4>
                                                <span>Co-Founder</span>
                                            </div>
                                        </div>
                                        <div class="rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="owl-item" style="width: 535px; margin-right: 40px;">
                                <div class="single-testimonial">
                                    <div class="quote">
                                        <img src="/FrontendNew/assets/img/icons/quote.svg" alt="" class="svg">
                                    </div>
                                    <div class="testimonial-content">
                                        <p>Program easy to use, I feel very safe, very affordable the I can watchs my
                                            favorites shows France its the America problem whatsoever to offer that
                                            others.</p>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="media review-info align-items-center">
                                            <div class="testimonial-img">
                                                <img src="/FrontendNew/assets/img/media/testimonial_2.png" data-rjs="2" alt="">
                                            </div>
                                            <div class="testimonial-name">
                                                <h4>Ben Horowitz</h4>
                                                <span>Chief Officer</span>
                                            </div>
                                        </div>
                                        <div class="rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="owl-item active" style="width: 535px; margin-right: 40px;">
                                <div class="single-testimonial">
                                    <div class="quote">
                                        <img src="/FrontendNew/assets/img/icons/quote.svg" alt="" class="svg">
                                    </div>
                                    <div class="testimonial-content">
                                        <p>Program easy to use, I feel very safe, very affordable the I can watchs my
                                            favorites shows France its the America problem whatsoever to offer that
                                            others.</p>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="media review-info align-items-center">
                                            <div class="testimonial-img">
                                                <img src="/FrontendNew/assets/img/media/testimonial_3.png" data-rjs="2" alt="">
                                            </div>
                                            <div class="testimonial-name">
                                                <h4>Ben Horowitz</h4>
                                                <span>Project Manager</span>
                                            </div>
                                        </div>
                                        <div class="rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="owl-item cloned active" style="width: 535px; margin-right: 40px;">
                                <div class="single-testimonial">
                                    <div class="quote">
                                        <img src="/FrontendNew/assets/img/icons/quote.svg" alt="" class="svg">
                                    </div>
                                    <div class="testimonial-content">
                                        <p>Program easy to use, I feel very safe, very affordable the I can watchs my
                                            favorites shows France its the America problem whatsoever to offer that
                                            others.</p>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="media review-info align-items-center">
                                            <div class="testimonial-img">
                                                <img src="/FrontendNew/assets/img/media/testimonial_1-2.png" data-rjs="2" alt="">
                                            </div>
                                            <div class="testimonial-name">
                                                <h4>William Blake</h4>
                                                <span>Co-Founder</span>
                                            </div>
                                        </div>
                                        <div class="rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="owl-item cloned" style="width: 535px; margin-right: 40px;">
                                <div class="single-testimonial">
                                    <div class="quote">
                                        <img src="/FrontendNew/assets/img/icons/quote.svg" alt="" class="svg">
                                    </div>
                                    <div class="testimonial-content">
                                        <p>Program easy to use, I feel very safe, very affordable the I can watchs my
                                            favorites shows France its the America problem whatsoever to offer that
                                            others.</p>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="media review-info align-items-center">
                                            <div class="testimonial-img">
                                                <img src="/FrontendNew/assets/img/media/testimonial_2.png" data-rjs="2" alt="">
                                            </div>
                                            <div class="testimonial-name">
                                                <h4>Ben Horowitz</h4>
                                                <span>Chief Officer</span>
                                            </div>
                                        </div>
                                        <div class="rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="owl-nav disabled">
                        <button type="button" role="presentation" class="owl-prev">
                            <i class="fa fa-angle-left"></i>
                        </button>
                        <button type="button" role="presentation" class="owl-next">
                            <i class="fa fa-angle-right"></i>
                        </button>
                    </div>
                    <div class="owl-dots">
                        <button role="button" class="owl-dot">
                            <span></span>
                        </button>
                        <button role="button" class="owl-dot active">
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<br><br>

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

<script>
   function showSubCategory(id) {
    $.ajax({
        type: 'GET',
        url: '{{ url("games/showsubcategory/") }}/' + id,
        data: '',
        success: function(data) {
            $("#sub_category_filter").html(data.options);
        }
    });
}
function apply_filter() {
            if (document.getElementById('category_filter').value != '')
                window.location.href = '{{ url("games/filter") }}/' + document.getElementById('category_filter').value +
                '/' + document.getElementById('sub_category_filter').value + '/' + document.getElementById(
                    'sub_sub_category_filter').value;
        }

        function price_filter() {

            if (document.getElementById('maximum').value != '')
                window.location.href = '{{ url("price/filter") }}/' + document.getElementById('minimun').value +
                '/' + document.getElementById('maximum').value ;
        }


    function showSubSubcategory(id) {
        $.ajax({
            type: 'GET',
            url: '{{ url("games/showsubsubcategory/") }}/' + id,
            data: '',
            success: function(data) {
                $("#sub_sub_category_filter").html(data.options);
            }
        });
    }
</script>
@endsection