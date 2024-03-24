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
            <a href="/">Home</a> / <span>Contact Us</span>
        </div>
        <!-- End of Breadcrumbs -->
        <div class="row align-items-center">
            <div class="col-lg-7">
                <div class="banner-content">
                    <h1>Contact Us </h1>
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






<section class="contact pt-120 pb-120 bg-img" style="background-image: url(&quot;assets/img/media/contact-form-bg.png&quot;);">
  <div class="container">
    <div class="row justify-content-between">
      <div class="col-lg-7">
        <div class="contact-form-wrap">
          <form action="{{ route('contact.store') }}" method="post" enctype="multipart/form-data" class="contact-form">
            <div class="row">
              <div class="col-12">
                <div class="form-group">
                  <input type="text" name="name" value="{{ $userName }}"  class="form-control" placeholder="Name">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <input type="email" name="email" class="form-control" value="{{ $userEmail }}" placeholder="Email Address">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                @if (session('product_title'))
                  <input type="text" name="subject" value="{{ session('product_title') }}" class="form-control" placeholder="Subject.">
                  @else
                  <input type="text" name="subject"  value="{{ old('subject') }}" class="form-control" placeholder="Subject.">
                @endif
                </div>
              </div>
              <div class="col-lg-12">
                <textarea class="form-control" name="message" placeholder="Messages">{{ old('message') }}</textarea>
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
              <div class="col-lg-12 mt-3">
                <div class="btn-wrap">
                  <span></span>
                  <button type="submit" class="btn">Submit</button>
                </div>
              </div>
            </div>
          </form>
          <div class="form-response"></div>
        </div>
      </div>
     <div class="col-lg-4">
         <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d109823.23880895347!2d73.0123344327729!3d30.662798324914846!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3922b62cd8405a6d%3A0x6cce79c0f78cbfb7!2sSahiwal%2C%20Sahiwal%20District%2C%20Punjab%2C%20Pakistan!5e0!3m2!1sen!2s!4v1706012719712!5m2!1sen!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
     </div>
    </div>
    <div class="row mt-4">
        <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="card">
                <div class="card-body">
            <center><span class="text-primary"> <svg width="40" height="40" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M28 12.6022L24.9946 28.2923C24.9946 28.2923 24.5741 29.3801 23.4189 28.8584L16.4846 23.3526L16.4524 23.3364C17.3891 22.4654 24.6524 15.7027 24.9698 15.3961C25.4613 14.9214 25.1562 14.6387 24.5856 14.9974L13.8568 22.053L9.71764 20.6108C9.71764 20.6108 9.06626 20.3708 9.00359 19.8491C8.9401 19.3265 9.73908 19.0439 9.73908 19.0439L26.6131 12.1889C26.6131 12.1889 28 11.5579 28 12.6022Z">
                                    </path>
                                </svg>
                                <a href="{{ $data->telegram_link }}">Telegram</a>
            </center>
        </div>
        </div>
        </div>
     <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="card">
                <div class="card-body">
            <center><span class="text-primary"> 
                <svg width="40" height="40" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M29.0275 14.0267C27.3762 12.7466 25.3945 12.1067 23.3028 12L22.9725 12.32C24.844 12.7466 26.4954 13.6 28.0367 14.7733C26.1651 13.8133 24.0734 13.1733 21.8715 12.96C21.211 12.8533 20.6605 12.8533 20 12.8533C19.3395 12.8533 18.789 12.8533 18.1285 12.96C15.9266 13.1733 13.8348 13.8133 11.9633 14.7733C13.5045 13.6 15.156 12.7466 17.0275 12.32L16.6972 12C14.6055 12.1067 12.6238 12.7466 10.9725 14.0267C9.10092 17.44 8.11009 21.28 8 25.2266C9.65135 26.9333 11.9633 28 14.3853 28C14.3853 28 15.156 27.1467 15.7064 26.4C14.2752 26.08 12.9541 25.3333 12.0734 24.16C12.844 24.5866 13.6146 25.0133 14.3853 25.3333C15.3762 25.76 16.367 25.9733 17.3578 26.1867C18.2386 26.2933 19.1193 26.4 20 26.4C20.8807 26.4 21.7614 26.2933 22.6422 26.1867C23.633 25.9733 24.6238 25.76 25.6147 25.3333C26.3854 25.0133 27.156 24.5866 27.9266 24.16C27.0459 25.3333 25.7248 26.08 24.2936 26.4C24.844 27.1467 25.6147 28 25.6147 28C28.0367 28 30.3486 26.9333 32 25.2266C31.8899 21.28 30.8991 17.44 29.0275 14.0267ZM16.367 23.3066C15.2661 23.3066 14.2753 22.3466 14.2753 21.1733C14.2753 20 15.2661 19.04 16.367 19.04C17.4679 19.04 18.4587 20 18.4587 21.1733C18.4587 22.3466 17.4679 23.3066 16.367 23.3066ZM23.633 23.3066C22.5321 23.3066 21.5413 22.3466 21.5413 21.1733C21.5413 20 22.5321 19.04 23.633 19.04C24.7339 19.04 25.7248 20 25.7248 21.1733C25.7248 22.3466 24.7339 23.3066 23.633 23.3066Z">
                                    </path>
                                </svg>
                                <a href="https://discord.gg/872653281523023922">kandan03</a>
            </center>
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


@endsection