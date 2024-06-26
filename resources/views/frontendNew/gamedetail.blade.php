@extends('frontendNew.layout.main')


@section('body')
<style>
    .banner {
        height: 200px !important;
    }
</style>


<script
  type="text/javascript"
  src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.js"
></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<section class="service  pb-90" data-bg-img="assets/img/media/service-bg.png">
    <div class="container">

        <div class="row">



        <div class="row my-4">
                    <div class="col-md-8">
                        <div class="left-side row p-4">
                            <div class="col-md-3 main-img-cont pe-3">
                                <img class="main-img h-100" src="{{ $product->long_image }}" alt="product image">
                            </div>
                            <div class="col-md-9">
                                <div class="top">
                                    <div class="d-flex heading-div pb-3 mb-1 justify-content-between align-items-center">
                                        <div class="heading">
                                            <p>{{ $product->title }}</p>
                                        </div>
                                    </div>
                                    <h6>
                                      @foreach ($product->emailChannels as $emailChannel)
                                          @if ($emailChannel->checkbox_value == 1)
                                              @if ($product->sub_category && $username)
                                                  <a target="_blank" style="color: #007bff" href="https://www.{{ str_replace(' ', '', $product->sub_category->name) }}.com/{{ $username }}">
                                                      https://www.{{ $product->sub_category->name }}.com/{{ $username }}
                                                  </a>
                                              @endif
                                          @endif
                                      @endforeach
                                  </h6>
                                      <div
                                        class="images-div mt-3 d-flex overflow-auto justify-content-start align-items-center">
                                        @foreach ($product->medias as $media)
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="my-3 row">
                            <div class="description-div content p-4 d-flex align-items-center">
                                <svg class="me-3" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M12.678 19.957C12.9528 20.0209 12.9779 20.3807 12.7103 20.4699L11.1303 20.9899C7.16034 22.2699 5.07034 21.1999 3.78034 17.2299L2.50034 13.2799C1.22034 9.30992 2.28034 7.20992 6.25034 5.92992L6.77434 5.75639C7.1772 5.62297 7.56927 6.02703 7.45487 6.43571C7.39817 6.63828 7.34362 6.84968 7.29034 7.06992L6.31034 11.2599C5.21034 15.9699 6.82034 18.5699 11.5303 19.6899L12.678 19.957Z">
                                    </path>
                                    <path
                                        d="M17.1702 3.2105L15.5002 2.8205C12.1602 2.0305 10.1702 2.6805 9.00018 5.1005C8.70018 5.7105 8.46018 6.4505 8.26018 7.3005L7.28018 11.4905C6.30018 15.6705 7.59018 17.7305 11.7602 18.7205L13.4402 19.1205C14.0202 19.2605 14.5602 19.3505 15.0602 19.3905C18.1802 19.6905 19.8402 18.2305 20.6802 14.6205L21.6602 10.4405C22.6402 6.2605 21.3602 4.1905 17.1702 3.2105ZM15.2902 13.3305C15.2002 13.6705 14.9002 13.8905 14.5602 13.8905C14.5002 13.8905 14.4402 13.8805 14.3702 13.8705L11.4602 13.1305C11.0602 13.0305 10.8202 12.6205 10.9202 12.2205C11.0202 11.8205 11.4302 11.5805 11.8302 11.6805L14.7402 12.4205C15.1502 12.5205 15.3902 12.9305 15.2902 13.3305ZM18.2202 9.9505C18.1302 10.2905 17.8302 10.5105 17.4902 10.5105C17.4302 10.5105 17.3702 10.5005 17.3002 10.4905L12.4502 9.2605C12.0502 9.1605 11.8102 8.7505 11.9102 8.3505C12.0102 7.9505 12.4202 7.7105 12.8202 7.8105L17.6702 9.0405C18.0802 9.1305 18.3202 9.5405 18.2202 9.9505Z">
                                    </path>
                                </svg>
                                <h1>Description</h1>
                            </div>
                            <div class="description p-4">
                                {!! $product->description !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 right-side p-4">
                        <div class="product-rate w-100">
                            <div class="top">
                                <div class="region">
                                    CHECKOUT
                                </div>
                            </div>
                            <div class="bottom p-4 pt-5 pb-2">
                                <div class="rates p-2 add-background mb-3">
                                    <div class="rate  p-2 d-flex align-items-center justify-content-between">
                                        <div class="rate-left d-flex align-items-center">
                                            <input class="form-check-input form-check-input1 m-2 p-2"
                                                value="{{ $product->price - ($product->price * $product->discount / 100) }}" checked type="radio"
                                                name="flexRadioDefault" id="flexRadioDefault1">
                                            <p class="mb-0 ml-2 ms-1">Credentials</p>
                                        </div>
                                        <div class="right-side">
                                            <h4 class="m-auto">${{ $product->price - ($product->price * $product->discount / 100) }}<p>.00</p>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="dividor-svg">
                                <svg width="450" height="56" viewBox="0 0 450 56" fill="none"
                                    xmlns="http://www.w3.org/2000/svg" class="page-product-rates__check"
                                    style="width:100%;">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M450 0H0V18C5.40274 18.0001 9.7825 22.4772 9.7825 28C9.7825 33.5228 5.40274 37.9999 0 38V56H450V38C444.597 38 440.217 33.5228 440.217 28C440.217 22.4772 444.597 18 450 18V0ZM30.8477 25C30.0192 25 29.3477 25.6716 29.3477 26.5C29.3477 27.3284 30.0192 28 30.8477 28H32.8288C33.6572 28 34.3288 27.3284 34.3288 26.5C34.3288 25.6716 33.6572 25 32.8288 25H30.8477ZM42.7345 25C41.9061 25 41.2345 25.6716 41.2345 26.5C41.2345 27.3284 41.9061 28 42.7345 28H46.6968C47.5252 28 48.1968 27.3284 48.1968 26.5C48.1968 25.6716 47.5252 25 46.6968 25H42.7345ZM56.6025 25C55.7741 25 55.1025 25.6716 55.1025 26.5C55.1025 27.3284 55.7741 28 56.6025 28H60.5648C61.3933 28 62.0648 27.3284 62.0648 26.5C62.0648 25.6716 61.3933 25 60.5648 25H56.6025ZM70.4706 25C69.6421 25 68.9706 25.6716 68.9706 26.5C68.9706 27.3284 69.6421 28 70.4706 28H74.4328C75.2613 28 75.9328 27.3284 75.9328 26.5C75.9328 25.6716 75.2613 25 74.4328 25H70.4706ZM84.3386 25C83.5101 25 82.8386 25.6716 82.8386 26.5C82.8386 27.3284 83.5101 28 84.3386 28H88.3009C89.1293 28 89.8009 27.3284 89.8009 26.5C89.8009 25.6716 89.1293 25 88.3009 25H84.3386ZM98.2066 25C97.3781 25 96.7066 25.6716 96.7066 26.5C96.7066 27.3284 97.3781 28 98.2066 28H102.169C102.997 28 103.669 27.3284 103.669 26.5C103.669 25.6716 102.997 25 102.169 25H98.2066ZM112.075 25C111.246 25 110.575 25.6716 110.575 26.5C110.575 27.3284 111.246 28 112.075 28H116.037C116.865 28 117.537 27.3284 117.537 26.5C117.537 25.6716 116.865 25 116.037 25H112.075ZM125.943 25C125.114 25 124.443 25.6716 124.443 26.5C124.443 27.3284 125.114 28 125.943 28H129.905C130.733 28 131.405 27.3284 131.405 26.5C131.405 25.6716 130.733 25 129.905 25H125.943ZM139.811 25C138.982 25 138.311 25.6716 138.311 26.5C138.311 27.3284 138.982 28 139.811 28H143.773C144.601 28 145.273 27.3284 145.273 26.5C145.273 25.6716 144.601 25 143.773 25H139.811ZM153.679 25C152.85 25 152.179 25.6716 152.179 26.5C152.179 27.3284 152.85 28 153.679 28H157.641C158.469 28 159.141 27.3284 159.141 26.5C159.141 25.6716 158.469 25 157.641 25H153.679ZM167.547 25C166.718 25 166.047 25.6716 166.047 26.5C166.047 27.3284 166.718 28 167.547 28H171.509C172.337 28 173.009 27.3284 173.009 26.5C173.009 25.6716 172.337 25 171.509 25H167.547ZM181.415 25C180.586 25 179.915 25.6716 179.915 26.5C179.915 27.3284 180.586 28 181.415 28H185.377C186.205 28 186.877 27.3284 186.877 26.5C186.877 25.6716 186.205 25 185.377 25H181.415ZM195.283 25C194.454 25 193.783 25.6716 193.783 26.5C193.783 27.3284 194.454 28 195.283 28H199.245C200.073 28 200.745 27.3284 200.745 26.5C200.745 25.6716 200.073 25 199.245 25H195.283ZM209.151 25C208.322 25 207.651 25.6716 207.651 26.5C207.651 27.3284 208.322 28 209.151 28H213.113C213.941 28 214.613 27.3284 214.613 26.5C214.613 25.6716 213.941 25 213.113 25H209.151ZM223.019 25C222.19 25 221.519 25.6716 221.519 26.5C221.519 27.3284 222.19 28 223.019 28H226.981C227.809 28 228.481 27.3284 228.481 26.5C228.481 25.6716 227.809 25 226.981 25H223.019ZM236.887 25C236.058 25 235.387 25.6716 235.387 26.5C235.387 27.3284 236.058 28 236.887 28H240.849C241.677 28 242.349 27.3284 242.349 26.5C242.349 25.6716 241.677 25 240.849 25H236.887ZM250.755 25C249.926 25 249.255 25.6716 249.255 26.5C249.255 27.3284 249.926 28 250.755 28H254.717C255.545 28 256.217 27.3284 256.217 26.5C256.217 25.6716 255.545 25 254.717 25H250.755ZM264.623 25C263.794 25 263.123 25.6716 263.123 26.5C263.123 27.3284 263.794 28 264.623 28H268.585C269.413 28 270.085 27.3284 270.085 26.5C270.085 25.6716 269.413 25 268.585 25H264.623ZM278.491 25C277.662 25 276.991 25.6716 276.991 26.5C276.991 27.3284 277.662 28 278.491 28H282.453C283.281 28 283.953 27.3284 283.953 26.5C283.953 25.6716 283.281 25 282.453 25H278.491ZM292.359 25C291.53 25 290.859 25.6716 290.859 26.5C290.859 27.3284 291.53 28 292.359 28H296.321C297.149 28 297.821 27.3284 297.821 26.5C297.821 25.6716 297.149 25 296.321 25H292.359ZM306.227 25C305.398 25 304.727 25.6716 304.727 26.5C304.727 27.3284 305.398 28 306.227 28H310.189C311.017 28 311.689 27.3284 311.689 26.5C311.689 25.6716 311.017 25 310.189 25H306.227ZM320.095 25C319.266 25 318.595 25.6716 318.595 26.5C318.595 27.3284 319.266 28 320.095 28H324.057C324.885 28 325.557 27.3284 325.557 26.5C325.557 25.6716 324.885 25 324.057 25H320.095ZM333.963 25C333.134 25 332.463 25.6716 332.463 26.5C332.463 27.3284 333.134 28 333.963 28H337.925C338.753 28 339.425 27.3284 339.425 26.5C339.425 25.6716 338.753 25 337.925 25H333.963ZM347.831 25C347.002 25 346.331 25.6716 346.331 26.5C346.331 27.3284 347.002 28 347.831 28H351.793C352.621 28 353.293 27.3284 353.293 26.5C353.293 25.6716 352.621 25 351.793 25H347.831ZM361.699 25C360.87 25 360.199 25.6716 360.199 26.5C360.199 27.3284 360.87 28 361.699 28H365.661C366.49 28 367.161 27.3284 367.161 26.5C367.161 25.6716 366.49 25 365.661 25H361.699ZM375.567 25C374.738 25 374.067 25.6716 374.067 26.5C374.067 27.3284 374.738 28 375.567 28H379.529C380.358 28 381.029 27.3284 381.029 26.5C381.029 25.6716 380.358 25 379.529 25H375.567ZM389.435 25C388.606 25 387.935 25.6716 387.935 26.5C387.935 27.3284 388.606 28 389.435 28H393.397C394.226 28 394.897 27.3284 394.897 26.5C394.897 25.6716 394.226 25 393.397 25H389.435ZM403.303 25C402.474 25 401.803 25.6716 401.803 26.5C401.803 27.3284 402.474 28 403.303 28H407.265C408.094 28 408.765 27.3284 408.765 26.5C408.765 25.6716 408.094 25 407.265 25H403.303ZM417.171 25C416.342 25 415.671 25.6716 415.671 26.5C415.671 27.3284 416.342 28 417.171 28H419.152C419.98 28 420.652 27.3284 420.652 26.5C420.652 25.6716 419.98 25 419.152 25H417.171Z"
                                        fill="#171B20"></path>
                                </svg>
                            </div>
                            <div class="pay-div p-4 pt-2">
                                <div class="d-flex align-items-center justify-content-between">
                                    <p>To pay:</p>
                                    <h4 class="total-p">$<span class="totalPrice">{{ $product->price - ($product->price * $product->discount / 100) }}</span>
                                        <p>.00</p>
                                    </h4>
                                </div>
                                @if ($available_channels_count > 0)
                                @foreach ($product->emailChannels as $emailChannel)
                                    @if ($emailChannel->status == 'available')
                                        <input type="checkbox" id="acceptCheckbox" value="Easy Mode">
                                        <label for="acceptCheckbox" style="color: black">&nbsp; Easy Mode</label>
                                        <button data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="w-100  btn btn-primary payBtn my-2">Go To Pay</button>
                                        <!-- You may want to add a break here if you only want to process the first available email channel -->
                                        @break
                                    @endif
                                @endforeach
                            @endif

                                {{-- <div class="d-flex mt-3">
                                  <p class="simpleResult">{!! nl2br($product->emailChannels->first()->format) !!}</p>

                                </div>
                                <div class="d-flex mt-3">
                                  <br>
                                  <p class="simpleResult">{!! nl2br($product->emailChannels->first()->value1) !!}</p>
                                </div>
                                <div class="d-flex mt-3">
                                  <p class="confirmresult clicked" style="display: none;"></p>
                                </div> --}}
                                  <!-- Container for clicked state -->
                                <div class="my-3">
                                    @if ($errors->any())
                                        <div class="alert alert-danger mt-3" role="alert">
                                            @foreach ($errors->all() as $error)
                                                {{ $error }} <br>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                                <div class="d-flex mt-3">
                                    <input class="form-check-input me-2 p-2 privacyCheck" checked type="checkbox"
                                        id="flexCheckDefault">
                                    <p class="confirm">By confirming the order, I accept the <a
                                            href="{{ route('terms') }}">terms of the user agreement</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="product-h">
                            <p class="p-4">Account will be delivered directly to your mail id and in ur account.</p>
                        </div>
                    </div>
                </div>




        </div>
    </div>
</section>
<script>
      document.addEventListener("DOMContentLoaded", function () {
          var acceptCheckbox = document.getElementById('acceptCheckbox');
          var easyModeCheckbox = document.getElementById('easyModeCheckbox');

          acceptCheckbox.addEventListener('change', function () {
              easyModeCheckbox.value = acceptCheckbox.checked ? 'Easy Mode Accepted' : '';
          });
      });
      </script>

<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('stripe.pay') }}" id="paymentForm" class="require-validation" data-stripe-publishable-key="{{ $data->stripe_key }}" id="checkout-form" method="post">
            @csrf
            <input type="hidden" name="easy_mode" id="easyModeCheckbox" value="">
            <input type="hidden" required name="product_type" value="GamingAccount">
            <input type="hidden" required name="product_id" value="{{ $product->id }}">
            <input type="hidden" required name="quantity" id="quantity_input" value="1">
            <input type="hidden" name="payment_method" id="payment_method">
            <input type="hidden" required class="totalPriceInput" name="totalPrice" value="{{ $product->price - ($product->price * $product->discount / 100) }}">

            <div class="modal-content">
                <div class="modal-body p-0">
                  <div class="text-right">
                    <button class="btn-close" type="button" data-bs-dismiss="modal">x</button>
                  </div>
                    <div class="row">
                        <div class="col-md-6 left-side p-4">
                            <div class="top p-3">
                                <p>{{ $product->title }}</p>
                                <h3>Payment</h3>
                            </div>
                            @if (!Auth::check())
                                <div class="new-user pl-3">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input name="name" required type="text" class="form-control" placeholder="Name" value="{{ old('name') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input name="email" required type="email" class="form-control" placeholder="Enter e-mail" value="{{ old('email') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input name="password" required type="password" class="form-control" placeholder="Enter password" value="">
                                    </div>
                                </div>
                            @endif
                            <div class="bottom p-2">
                                <div class="d-flex my-3 align-items-center justify-content-between">
                                    <p class="mb-0">To Pay:</p>
                                    <h4 class="mb-0">$<span class="totalPrice">{{ $product->price - ($product->price * $product->discount / 100) }}</span><span class="m-auto d-inline">.00</span></h4>
                                </div>
                                <div class="qualtity d-flex justify-content-between align-items-center">
                                    <div class="counter">
                                        <button class="plusBtn btn btn-secondary btn-sm" type="button">+</button>
                                        <div class="counter__number">1</div>
                                        <button class="minusBtn btn btn-secondary btn-sm" type="button">-</button>
                                    </div>
                                    <button class="payBtn2 paymentBtn btn btn-primary">Pay</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 right p-4">
                            <div class="top p-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <p>POPULAR PAYMENT SYSTEMS:</p>
                                </div>
                                <div class="icons-div my-4">
                                    @if ($data->paybis_account)
                                        <div class="icons py-icons my-2 p-4 me-3 d-block" data-bs-toggle="modal" data-bs-target="#staticPaybis">
                                            <p>Paybis (Manual payment)</p>
                                        </div>
                                    @endif
                                    @if ($data->payeer_account)
                                        <div class="icons py-icons my-2 p-4 me-3 d-block" data-bs-toggle="modal" data-bs-target="#staticPayeer">
                                            <p>Payeer (Manual payment)</p>
                                        </div>
                                    @endif
                                    @if ($data->paypal_secret)
                                        <div class="icons py-icons my-2 p-4 me-3 d-block" data-value="paypal">PayPal</div>
                                    @endif
                                    @if ($data->stripe_secret)
                                        <div class="icons py-icons my-2 bg-border p-4 d-block" data-value="stripe">Stripe</div>
                                    @endif
                                    @if ($data->coinbase_api_key)
                                        <div class="icons py-icons my-2 p-4 d-block" data-value="coinbase">Coinbase</div>
                                    @endif
                                    @if ($user != null && $product->price - ($product->price * $product->discount / 100) < $user->balance)
                                        <div class="icons py-icons my-2 p-4 d-block" id="pay_by_balance" data-value="balance">Balance</div>
                                    @endif
                                    @if ($data->perfect_money_accountid)
                                        <div class="icons py-icons my-2 p-4 d-block" data-value="perfectmoney">Perfect Money</div>
                                    @endif
                                    @if ($data->payeer_shop)
                                        <div class="icons py-icons my-2 p-4 d-block" data-value="payeer">Payeer</div>
                                    @endif
                                </div>
                                <div class="warning p-2">
                                    <p>Each of the payment systems has different methods of accepting payments, such as Qiwi, WebMoney, YuMoney, Card, PIX, Unionpay, etc. Differences in each payment system in% rate, the possibility of accepting foreign cards, as well as various payment methods</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


    <div class="modal fade" id="staticPaybis" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">

        <form action="{{ route('stripe.pay') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="text" name="easy_mode" id="easyModeCheckbox" value="">

            <input type="hidden" required name="product_type" value="GamingAccount">
            {{-- <input type="hidden" required name="product_id" value="{{ $product->id }}">
            <input type="hidden" required name="quantity" id="quantity_input" value="1"> --}}
            <input type="hidden" name="payment_method" value="paybis_manual">
            <input type="hidden" required class="totalPriceInput" name="totalPrice" value="{{ $product->price - ($product->price * $product->discount / 100) }}">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="row">
                        <div class="col-md-12 left-side p-4">
                            <div class="top p-3">
                                <p style="display: flex;justify-content: space-between;">
                                    <span class=">{{ $product->title }}</span><button
                                        class="btn btn-close" type="button" data-bs-dismiss="modal">x</button>
                                </p>
                                <h1>Paybis (Manual Payment)</h1>
                                <img class="img img-fluid w-auto" src="{{ asset('frontend/images/underline.svg') }}"
                                    alt="">
                            </div>
                            <p class=">1. To pay with debit/credit card, go to <a
                                    href="https://paybis.com/" target="_blank">paybis.com</a></p>
                            <p class="">2. Select USD (debit or credit card) to buy Bitcoin (BTC) - currency
                                that we accept as
                                payment.
                                Put ${{ $product->price - ($product->price * $product->discount / 100) }} in the field
                                and click Buy bitcoin</p>
                            <p class="">3. Paste in your e-mail to complete registration.</p>
                            <p class="">4. Click External wallet and Paste in this bitcoin address:</p>
                            <div class="d-flex">
                                <p class=" d-inline-block" id="address"
                                    style="padding-bottom: 0px;margin-bottom: 0px;padding-top: 4px;">
                                    {{ $data->paybis_account }}</p>
                                <button id="copyButton" class="btn btn-primary" type="button"
                                    style="border-radius: 50px !important; padding: 5px 20px !important">Copy</button>
                            </div><br>
                            <p class="">5. Pay with your debit/credit card.
                            </p>
                            <p class="">6. Make a quick verification if the site prompts you to
                            </p>
                            <p class="">7. Return to <a
                                    href="http://localhost/finalwebsite_2/">Webcreatorzone</a> with the payment receipt
                                and upload
                                file in the below!
                            </p>
                            <input name="payment_proof" class="form-control py-3" required type="file">
                            <input type="submit" class="w-100 payBtn my-2">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="staticPayeer" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">

        <form action="{{ route('stripe.pay') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="text" name="easy_mode" id="easyModeCheckbox" value="">

            <input type="hidden" required name="product_type" value="GamingAccount">
            <input type="hidden" required name="product_id" value="{{ $product->id }}">
            <input type="hidden" required name="quantity" id="quantity_input" value="1">
            <input type="hidden" name="payment_method" value="payeer_manual">
            <input type="hidden" required class="totalPriceInput" name="totalPrice" value="{{ $product->price - ($product->price * $product->discount / 100) }}">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="row">
                        <div class="col-md-12 left-side p-4">
                            <div class="top p-3">
                                <p style="display: flex;justify-content: space-between;">
                                    <span class="">{{ $product->title }}</span><button
                                        class="btn btn-close" type="button" data-bs-dismiss="modal">x</button>
                                </p>
                                <h1>Payeer (Manual Payment)</h1>
                                <img class="img img-fluid w-auto" src="{{ asset('frontend/images/underline.svg') }}"
                                    alt="">
                            </div>
                            <p class="">1. To pay with debit/credit card, go to <a
                                    href="https://paybis.com/" target="_blank">paybis.com</a></p>
                            <p class="">2. Select USD (debit or credit card) to buy Bitcoin (BTC) - currency
                                that we accept as
                                payment.
                                Put ${{ $product->price - ($product->price * $product->discount / 100) }} in the field
                                and click Buy bitcoin</p>
                            <p class="">3. Paste in your e-mail to complete registration.</p>
                            <p class="">4. Click External wallet and Paste in this bitcoin address:</p>
                            <div class="d-flex">
                                <p class=" d-inline-block" id="address"
                                    style="padding-bottom: 0px;margin-bottom: 0px;padding-top: 4px;">
                                    {{ $data->payeer_account }}</p>
                                <button id="copyButton" class="btn btn-primary" type="button"
                                    style="border-radius: 50px !important; padding: 5px 20px !important">Copy</button>
                            </div><br>
                            <p class="">5. Pay with your debit/credit card.
                            </p>
                            <p class="">6. Make a quick verification if the site prompts you to
                            </p>
                            <p class="">7. Return to <a
                                    href="http://localhost/finalwebsite_2/">Webcreatorzone</a> with the payment receipt
                                and upload
                                file in the below!
                            </p>
                            <input name="payment_proof" class="form-control py-3" required type="file">
                            <input type="submit" class="w-100 payBtn my-2">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
    <div class="modal fade" id="staticPaybis" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">

            <form action="{{ route('stripe.pay') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="text" name="easy_mode" id="easyModeCheckbox" value="">

                <input type="hidden" required name="product_type" value="GamingAccount">
                {{-- <input type="hidden" required name="product_id" value="{{ $product->id }}">
                <input type="hidden" required name="quantity" id="quantity_input" value="1"> --}}
                <input type="hidden" name="payment_method" value="paybis_manual">
                <input type="hidden" required class="totalPriceInput" name="totalPrice" value="{{ $product->price - ($product->price * $product->discount / 100) }}">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <div class="row">
                            <div class="col-md-12 left-side p-4">
                                <div class="top p-3">
                                    <p style="display: flex;justify-content: space-between;">
                                        <span class="">{{ $product->title }}</span><button
                                            class="btn btn-close" type="button" data-bs-dismiss="modal">x</button>
                                    </p>
                                    <h1>Paybis (Manual Payment)</h1>
                                    <img class="img img-fluid w-auto" src="{{ asset('frontend/images/underline.svg') }}"
                                        alt="">
                                </div>
                                <p class="">1. To pay with debit/credit card, go to <a
                                        href="https://paybis.com/" target="_blank">paybis.com</a></p>
                                <p class="">2. Select USD (debit or credit card) to buy Bitcoin (BTC) - currency
                                    that we accept as
                                    payment.
                                    Put ${{ $product->price - ($product->price * $product->discount / 100) }} in the field
                                    and click Buy bitcoin</p>
                                <p class="">3. Paste in your e-mail to complete registration.</p>
                                <p class="">4. Click External wallet and Paste in this bitcoin address:</p>
                                <div class="d-flex">
                                    <p class=" d-inline-block" id="address"
                                        style="padding-bottom: 0px;margin-bottom: 0px;padding-top: 4px;">
                                        {{ $data->paybis_account }}</p>
                                    <button id="copyButton" class="btn btn-primary" type="button"
                                        style="border-radius: 50px !important; padding: 5px 20px !important">Copy</button>
                                </div><br>
                                <p class="">5. Pay with your debit/credit card.
                                </p>
                                <p class="">6. Make a quick verification if the site prompts you to
                                </p>
                                <p class="">7. Return to <a
                                        href="http://localhost/finalwebsite_2/">Webcreatorzone</a> with the payment receipt
                                    and upload
                                    file in the below!
                                </p>
                                <input name="payment_proof" class="form-control py-3" required type="file">
                                <input type="submit" class="w-100 payBtn my-2">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="staticPayeer" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">

            <form action="{{ route('stripe.pay') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="text" name="easy_mode" id="easyModeCheckbox" value="">

                <input type="hidden" required name="product_type" value="GamingAccount">
                <input type="hidden" required name="product_id" value="{{ $product->id }}">
                <input type="hidden" required name="quantity" id="quantity_input" value="1">
                <input type="hidden" name="payment_method" value="payeer_manual">
                <input type="hidden" required class="totalPriceInput" name="totalPrice" value="{{ $product->price - ($product->price * $product->discount / 100) }}">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <div class="row">
                            <div class="col-md-12 left-side p-4">
                                <div class="top p-3">
                                    <p style="display: flex;justify-content: space-between;">
                                        <span class="">{{ $product->title }}</span><button
                                            class="btn btn-close" type="button" data-bs-dismiss="modal">x</button>
                                    </p>
                                    <h1>Payeer (Manual Payment)</h1>
                                    <img class="img img-fluid w-auto" src="{{ asset('frontend/images/underline.svg') }}"
                                        alt="">
                                </div>
                                <p class="">1. To pay with debit/credit card, go to <a
                                        href="https://paybis.com/" target="_blank">paybis.com</a></p>
                                <p class="">2. Select USD (debit or credit card) to buy Bitcoin (BTC) - currency
                                    that we accept as
                                    payment.
                                    Put ${{ $product->price - ($product->price * $product->discount / 100) }} in the field
                                    and click Buy bitcoin</p>
                                <p class="">3. Paste in your e-mail to complete registration.</p>
                                <p class="">4. Click External wallet and Paste in this bitcoin address:</p>
                                <div class="d-flex">
                                    <p class=" d-inline-block" id="address"
                                        style="padding-bottom: 0px;margin-bottom: 0px;padding-top: 4px;">
                                        {{ $data->payeer_account }}</p>
                                    <button id="copyButton" class="btn btn-primary" type="button"
                                        style="border-radius: 50px !important; padding: 5px 20px !important">Copy</button>
                                </div><br>
                                <p class="">5. Pay with your debit/credit card.
                                </p>
                                <p class="">6. Make a quick verification if the site prompts you to
                                </p>
                                <p class="">7. Return to <a
                                        href="http://localhost/finalwebsite_2/">Webcreatorzone</a> with the payment receipt
                                    and upload
                                    file in the below!
                                </p>
                                <input name="payment_proof" class="form-control py-3" required type="file">
                                <input type="submit" class="w-100 payBtn my-2">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="staticBackdropNotify" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">

            <form action="{{ route('games.out_of_stock') }}" id="notifyForm" class="require-validation"
                data-stripe-publishable-key="{{ $data->stripe_key }}" method="post">
                @csrf
                <input type="text" name="easy_mode" id="easyModeCheckbox" value="">

                <input type="hidden" required name="product_id" value="{{ $product->id }}">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <div class="row">
                            <div class="col-md-12 left-side p-4">
                                <div class="top p-3">
                                    <p style="display: flex;justify-content: space-between;">
                                        <span>{{ $product->title }}</span><button class="btn btn-close" type="button"
                                            data-bs-dismiss="modal">x</button>
                                    </p>
                                    <h1>Out Of Stock</h1>
                                    <img class="img img-fluid w-auto" src="{{ asset('frontend/images/underline.svg') }}"
                                        alt="">
                                </div>
                                <h3 style="color: white;">Notify Me</h3>
                                <input name="notify_email" class="form-control py-3" required type="email"
                                    placeholder="Enter e-mail" value="">
                                <input type="submit" class="w-100 payBtn my-2">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


    @if ($available_channels_count <= 0)
    <button data-bs-toggle="modal" style="display: none;" id="notify_btn" data-bs-target="#staticBackdropNotify"></button>
    <script>
        $(document).ready(function() {
            document.getElementById("notify_btn").click();
        });
    </script>
@endif

<!-- MDB -->
<script
  type="text/javascript"
  src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.js"
></script>



@endsection
