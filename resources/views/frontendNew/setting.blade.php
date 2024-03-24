@extends('frontendNew.layout.main')


@section('body')
<style>
    .banner {
        height: 200px !important;
    }
</style>




<section class="service  pb-90" data-bg-img="assets/img/media/service-bg.png">
    <div class="container">

        <div class="row">
            <div class="col-md-4">
                <a href="{{ route('profile.purchses') }}">
                    <div class="card mb-4 ">
                        <center><i class="fa fa-list"></i><br>
                            My Purchase
                        </center>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('profile.tickets') }}" >
                    <div class="card mb-4 ">
                        <center><i class="fa fa-support"></i><br>
                            Support
                        </center>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('profile.settings') }}" style="color: white;">
                    <div class="card mb-4 bg-primary ">
                        <center><i class="fa fa-gear"></i><br>
                            Setting
                        </center>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header">
                        Welcome back,
                        <a href="{{ route('logout') }}" style="color: black;">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="yes" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16.8 2H14.2C11 2 9 4 9 7.2V11.25H15.25C15.66 11.25 16 11.59 16 12C16 12.41 15.66 12.75 15.25 12.75H9V16.8C9 20 11 22 14.2 22H16.79C19.99 22 21.99 20 21.99 16.8V7.2C22 4 20 2 16.8 2Z">
                                </path>
                                <path d="M4.55945 11.25L6.62945 9.17997C6.77945 9.02997 6.84945 8.83997 6.84945 8.64997C6.84945 8.45997 6.77945 8.25997 6.62945 8.11997C6.33945 7.82997 5.85945 7.82997 5.56945 8.11997L2.21945 11.47C1.92945 11.76 1.92945 12.24 2.21945 12.53L5.56945 15.88C5.85945 16.17 6.33945 16.17 6.62945 15.88C6.91945 15.59 6.91945 15.11 6.62945 14.82L4.55945 12.75H8.99945V11.25H4.55945Z">
                                </path>
                            </svg>
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="user-avatar">
                                    <img class="img img-circle" width="70" src="{{ asset('frontend/images/avatar-user.png') }}" alt="">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="mt-4">

                                    <h3 class="username">{{ $user->name }}</h3>

                                </div>
                            </div>
                        </div>


                    </div>
                </div>
          



            </div>
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header">
                       Update Profile 
                    </div>
                    <div class="card-body">
                    <div class="form">
    <form action="{{ route('profile.update') }}" method="post">
        @csrf

        <div class="form-group my-2 py-2 pb-4">
            <label for="name">PERSONAL INFORMATION</label>
            <input name="name" class="form-control" type="text" placeholder="Enter name" value="{{ $user->name }}">
        </div>

        <div class="form-group my-2 py-2 pb-4">
            <label for="email">E-MAIL</label>
            <input name="email" class="form-control" type="email" placeholder="Enter e-mail" value="{{ $user->email }}">
        </div>

        <div class="row my-2 py-2">
            <div class="col-md-6">
                <label for="password">PASSWORD</label>
                <div class="input-group pb-4">
                    <input name="password" class="form-control" type="password" placeholder="Enter password">
                </div>
            </div>

            <div class="col-md-6">
                <label for="confirmation_password">CONFIRM PASSWORD</label>
                <div class="input-group pb-4">
                    <input name="confirmation_password" class="form-control" type="password" placeholder="Confirm password">
                </div>
            </div>
        </div>

        <div class="my-4">
            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    @foreach ($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="form-group my-2 py-2 pb-4">
            <button class="btn btn-primary w-100">Save Changes</button>
        </div>
    </form>
</div>

                    </div>
                </div>
            </div>





        </div>
    </div>
</section>
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('stripe.addbalance') }}" id="paymentForm2" class="require-validation" data-stripe-publishable-key="{{ $data->stripe_key }}" id="checkout-form" method="post">
            @csrf

            <input type="hidden" name="payment_method" id="payment_method">

            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="row">
                        <div class="col-md-6 left-side p-4">
                            <div class="top p-3">
                                <p>User Balance</p>
                                <h1>Add Balance</h1>
                                <img class="img img-fluid w-auto" src="{{ asset('frontend/images/underline.svg') }}" alt="">
                            </div>
                            @if (!Auth::check())
                            <div class="new-user">
                                <div class="input-group mb-1 p-3">
                                    <div class="input">
                                        <div class="input-icon">
                                            <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg" class="usericon">
                                                <path d="M11.1467 9.96421C11.055 9.95504 10.945 9.95504 10.8442 9.96421C8.66249 9.89087 6.92999 8.10337 6.92999 5.90337C6.92999 3.65754 8.74499 1.83337 11 1.83337C13.2458 1.83337 15.07 3.65754 15.07 5.90337C15.0608 8.10337 13.3283 9.89087 11.1467 9.96421Z" stroke="#DBDBDB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                <path d="M6.56335 13.3466C4.34501 14.8316 4.34501 17.2516 6.56335 18.7275C9.08418 20.4141 13.2183 20.4141 15.7392 18.7275C17.9575 17.2425 17.9575 14.8225 15.7392 13.3466C13.2275 11.6691 9.09335 11.6691 6.56335 13.3466Z" stroke="#DBDBDB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                            </svg>
                                        </div>
                                        <input name="name" required type="text" placeholder="Name" value="{{ old('name') }}">
                                    </div>
                                </div>
                                <div class="input-group mb-1 p-3">
                                    <div class="input">
                                        <div class="input-icon"><svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M15.582 18.7917H6.41536C3.66536 18.7917 1.83203 17.4167 1.83203 14.2084V7.79171C1.83203 4.58337 3.66536 3.20837 6.41536 3.20837H15.582C18.332 3.20837 20.1654 4.58337 20.1654 7.79171V14.2084C20.1654 17.4167 18.332 18.7917 15.582 18.7917Z" stroke="#95979F" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                                <path d="M15.5846 8.25L12.7155 10.5417C11.7713 11.2933 10.2221 11.2933 9.27796 10.5417L6.41797 8.25" stroke="#95979F" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                            </svg>
                                        </div>
                                        <input name="email" required type="email" placeholder="Enter e-mail" value="{{ old('email') }}">
                                    </div>
                                </div>
                                <div class="input-group mb-1 p-3">
                                    <div class="input">
                                        <div class="input-icon"><svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M5.5 9.16671V7.33337C5.5 4.29921 6.41667 1.83337 11 1.83337C15.5833 1.83337 16.5 4.29921 16.5 7.33337V9.16671" stroke="#95979F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                <path d="M10.9987 16.9583C12.2644 16.9583 13.2904 15.9323 13.2904 14.6667C13.2904 13.401 12.2644 12.375 10.9987 12.375C9.73305 12.375 8.70703 13.401 8.70703 14.6667C8.70703 15.9323 9.73305 16.9583 10.9987 16.9583Z" stroke="#95979F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                <path d="M15.582 20.1666H6.41536C2.7487 20.1666 1.83203 19.25 1.83203 15.5833V13.75C1.83203 10.0833 2.7487 9.16663 6.41536 9.16663H15.582C19.2487 9.16663 20.1654 10.0833 20.1654 13.75V15.5833C20.1654 19.25 19.2487 20.1666 15.582 20.1666Z" stroke="#95979F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                            </svg>
                                        </div>
                                        <input name="password" required type="password" placeholder="Enter password" value="">
                                    </div>
                                </div>
                            </div>
                            @endif
                            <div class="bottom p-2">
                                <div class="d-flex my-3 align-items-center justify-content-between">
                                    <p class="mb-0">Enter Balance:</p>
                                    <input type="number" required class="totalPriceInput form-control" name="totalPrice" value="">
                                </div>
                                <div class="qualtity d-flex justify-content-between align-items-center">
                                    <button class="btn btn-primary payBtn2 paymentBtn">Add Balance</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 right p-4">
                            <div class="top p-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <p>POPULAR PAYMENT SYSTEMS:</p>
                                    <button class="btn btn-close" type="button" data-bs-dismiss="modal">x</button>
                                </div>
                                <div class="icons-div my-4">
                                    @if($data->paypal_secret)
                                    <div class="icons py-icons my-2 p-4 me-3 d-block" data-value="paypal">
                                        <img src="{{ asset('frontend/images/paypal.svg') }}" alt="">
                                    </div>
                                    @endif
                                    @if($data->stripe_secret)
                                    <div class="icons py-icons my-2 bg-border p-4 d-block" data-value="stripe">
                                        <img src="{{ asset('frontend/images/stripe.png') }}" alt="">
                                    </div>
                                    @endif
                                    @if($data->coinbase_api_key)
                                    <div class="icons py-icons my-2 p-4 d-block" data-value="coinbase">
                                        <img src="{{ asset('frontend/images/coinbase.png') }}" alt="">
                                    </div>
                                    @endif
                                    @if($data->perfect_money_accountid)
                                    <div class="icons py-icons my-2 p-4 d-block" data-value="perfectmoney">
                                        <img src="{{ asset('frontend/images/perfectmoney.png') }}" alt="">
                                    </div>
                                    @endif
                                </div>

                                <div class="warning p-2">
                                    <p>Each of the payment systems has different methods of accepting payments, such as
                                        Qiwi, WebMoney, YuMoney, Card, PIX, Unionpay, etc.
                                        <br>
                                        <br>
                                        Differences in each payment system in% rate, the possibility of accepting
                                        foreign cards, as well as various payment methods
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script>
    // jQuery script to open the Bootstrap modal on button click
    $(document).ready(function() {
        $("#openModalBtn").click(function() {
            $("#staticBackdrop").modal('show');
        });
    });
</script>


@endsection