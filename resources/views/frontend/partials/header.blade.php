<!DOCTYPE html>
<html>
<head>
    <title>Laravel Add To Cart Function - ItSolutionStuff.com</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg py-4 m-auto">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}"><img src="" alt=""></a>
            <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarWith Draw RequestsedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon btn-white"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'current' : '' }}" aria-current="page"
                            href="{{ route('home') }}">HOME</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('games*') ? 'current' : '' }}"
                            href="{{ route('games') }}">Accounts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('giveaway') ? 'current' : '' }}"
                            href="{{ route('giveaway') }}">Give Aways</a>
                    </li>
                    @if (Auth::check())
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('profile.referral') ? 'current' : '' }}"
                                href="{{ route('profile.referral') }}">Refferal</a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('contact') ? 'current' : '' }}"
                            href="{{ route('contact') }}">CONTACT US</a>
                    </li>
                </ul>
                <form class="d-flex" role="search">

                    @if (Auth::check())
                        <div class="header-profile">
                            <div class="user-avatar">
                                <img src="{{ asset('frontend/images/avatar-user.png') }}" alt="">
                            </div>
                            <div class="header-dropdown">
                                <div class="header-dropdown__overlay"></div>
                                <div class="header-dropdown__content">
                                    <a href="{{ route('profile.purchses') }}" class="header-dropdown__item">
                                        <svg width="25" height="24" viewBox="0 0 54 54" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M35.505 4.5H18.495C9.99 4.5 7.875 6.7725 7.875 15.84V41.175C7.875 47.16 11.16 48.5775 15.1425 44.3025L15.165 44.28C17.01 42.3225 19.8225 42.48 21.42 44.6175L23.6925 47.655C25.515 50.0625 28.4625 50.0625 30.285 47.655L32.5575 44.6175C34.1775 42.4575 36.99 42.3 38.835 44.28C42.84 48.555 46.1025 47.1375 46.1025 41.1525V15.84C46.125 6.7725 44.01 4.5 35.505 4.5ZM33.75 26.4375H20.25C19.3275 26.4375 18.5625 25.6725 18.5625 24.75C18.5625 23.8275 19.3275 23.0625 20.25 23.0625H33.75C34.6725 23.0625 35.4375 23.8275 35.4375 24.75C35.4375 25.6725 34.6725 26.4375 33.75 26.4375ZM36 17.4375H18C17.0775 17.4375 16.3125 16.6725 16.3125 15.75C16.3125 14.8275 17.0775 14.0625 18 14.0625H36C36.9225 14.0625 37.6875 14.8275 37.6875 15.75C37.6875 16.6725 36.9225 17.4375 36 17.4375Z"
                                                fill="#62646C"></path>
                                        </svg>
                                        My purchses
                                    </a>
                                    <a href="{{ route('profile.tickets') }}" class="header-dropdown__item">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M21.9999 12.86C21.9999 15.15 20.8199 17.18 18.9999 18.46L17.6599 21.41C17.3499 22.08 16.4499 22.21 15.9799 21.64L14.4999 19.86C12.6399 19.86 10.9299 19.23 9.62988 18.18L10.2299 17.47C14.8499 17.12 18.4999 13.46 18.4999 9.00002C18.4999 8.24002 18.3899 7.49002 18.1899 6.77002C20.4599 7.97002 21.9999 10.25 21.9999 12.86Z"
                                                fill="#62646C"></path>
                                            <path
                                                d="M16.3 6.07C15.13 3.67 12.52 2 9.5 2C5.36 2 2 5.13 2 9C2 11.29 3.18 13.32 5 14.6L6.34 17.55C6.65 18.22 7.55 18.34 8.02 17.78L8.57 17.12L9.5 16C13.64 16 17 12.87 17 9C17 7.95 16.75 6.96 16.3 6.07ZM12 9.75H7C6.59 9.75 6.25 9.41 6.25 9C6.25 8.59 6.59 8.25 7 8.25H12C12.41 8.25 12.75 8.59 12.75 9C12.75 9.41 12.41 9.75 12 9.75Z"
                                                fill="#62646C"></path>
                                        </svg>
                                        Online support
                                    </a>
                                    <a href="{{ route('profile.settings') }}"
                                        class="header-dropdown__item header-dropdown__item_active">
                                        <svg width="25" height="24" viewBox="0 0 25 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M20.6 9.22006C18.79 9.22006 18.05 7.94006 18.95 6.37006C19.47 5.46006 19.16 4.30006 18.25 3.78006L16.52 2.79006C15.73 2.32006 14.71 2.60006 14.24 3.39006L14.13 3.58006C13.23 5.15006 11.75 5.15006 10.84 3.58006L10.73 3.39006C10.28 2.60006 9.26 2.32006 8.47 2.79006L6.74 3.78006C5.83 4.30006 5.52 5.47006 6.04 6.38006C6.95 7.94006 6.21 9.22006 4.4 9.22006C3.36 9.22006 2.5 10.0701 2.5 11.1201V12.8801C2.5 13.9201 3.35 14.7801 4.4 14.7801C6.21 14.7801 6.95 16.0601 6.04 17.6301C5.52 18.5401 5.83 19.7001 6.74 20.2201L8.47 21.2101C9.26 21.6801 10.28 21.4001 10.75 20.6101L10.86 20.4201C11.76 18.8501 13.24 18.8501 14.15 20.4201L14.26 20.6101C14.73 21.4001 15.75 21.6801 16.54 21.2101L18.27 20.2201C19.18 19.7001 19.49 18.5301 18.97 17.6301C18.06 16.0601 18.8 14.7801 20.61 14.7801C21.65 14.7801 22.51 13.9301 22.51 12.8801V11.1201C22.5 10.0801 21.65 9.22006 20.6 9.22006ZM12.5 15.2501C10.71 15.2501 9.25 13.7901 9.25 12.0001C9.25 10.2101 10.71 8.75006 12.5 8.75006C14.29 8.75006 15.75 10.2101 15.75 12.0001C15.75 13.7901 14.29 15.2501 12.5 15.2501Z"
                                                fill="#62646C"></path>
                                        </svg>
                                        Settings
                                    </a>
                                    <a href="{{ route('logout') }}"
                                        class="header-dropdown__item header-dropdown__item_active">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M16.8 2H14.2C11 2 9 4 9 7.2V11.25H15.25C15.66 11.25 16 11.59 16 12C16 12.41 15.66 12.75 15.25 12.75H9V16.8C9 20 11 22 14.2 22H16.79C19.99 22 21.99 20 21.99 16.8V7.2C22 4 20 2 16.8 2Z"
                                                fill="#DBDBDB"></path>
                                            <path
                                                d="M4.55945 11.25L6.62945 9.17997C6.77945 9.02997 6.84945 8.83997 6.84945 8.64997C6.84945 8.45997 6.77945 8.25997 6.62945 8.11997C6.33945 7.82997 5.85945 7.82997 5.56945 8.11997L2.21945 11.47C1.92945 11.76 1.92945 12.24 2.21945 12.53L5.56945 15.88C5.85945 16.17 6.33945 16.17 6.62945 15.88C6.91945 15.59 6.91945 15.11 6.62945 14.82L4.55945 12.75H8.99945V11.25H4.55945Z"
                                                fill="#DBDBDB"></path>
                                        </svg>
                                        Logout
                                    </a>
                                </div>
                            </div>

                        </div>
                        <div class="supportBtn d-flex gap-3 align-items-center py-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-wallet2" viewBox="0 0 16 16">
                                <path
                                    d="M12.136.326A1.5 1.5 0 0 1 14 1.78V3h.5A1.5 1.5 0 0 1 16 4.5v9a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 13.5v-9a1.5 1.5 0 0 1 1.432-1.499L12.136.326zM5.562 3H13V1.78a.5.5 0 0 0-.621-.484L5.562 3zM1.5 4a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-13z" />
                            </svg>
                            {{ Auth::user()->balance + Auth::user()->referral_balance }}$
                        </div>
                    @else
                        <button class="signInBtn" onclick="window.location.href = './signin';" type="button">
                            <svg width="22" class="me-1" height="22" viewBox="0 0 22 22" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M11.1467 9.96421C11.055 9.95504 10.945 9.95504 10.8442 9.96421C8.66249 9.89087 6.92999 8.10337 6.92999 5.90337C6.92999 3.65754 8.74499 1.83337 11 1.83337C13.2458 1.83337 15.07 3.65754 15.07 5.90337C15.0608 8.10337 13.3283 9.89087 11.1467 9.96421Z"
                                    stroke="#DBDBDB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                </path>
                                <path
                                    d="M6.56335 13.3466C4.34501 14.8316 4.34501 17.2516 6.56335 18.7275C9.08418 20.4141 13.2183 20.4141 15.7392 18.7275C17.9575 17.2425 17.9575 14.8225 15.7392 13.3466C13.2275 11.6691 9.09335 11.6691 6.56335 13.3466Z"
                                    stroke="#DBDBDB" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round">
                                </path>
                            </svg>
                            Sign In
                        </button>
                    @endif
                    <button class="supportBtn" type="button"
                        onclick="window.location.href = '{{ Auth::check() ? './profile/tickets' : './signin' }}';">
                        <svg width="22" class="me-1" height="22" viewBox="0 0 22 22" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M17.4821 17.4807C14.6806 20.2825 10.5323 20.8878 7.13756 19.3179C6.63641 19.1161 6.22554 18.953 5.83493 18.953C4.74696 18.9595 3.39275 20.0144 2.68892 19.3114C1.9851 18.6075 3.04083 17.2523 3.04083 16.1577C3.04083 15.7671 2.88422 15.3635 2.68247 14.8614C1.11177 11.4672 1.71794 7.3175 4.51941 4.51665C8.09564 0.939103 13.9059 0.939104 17.4821 4.51573C21.0648 8.0988 21.0583 13.9041 17.4821 17.4807Z"
                                stroke="#111317" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            </path>
                            <path d="M14.6111 11.3786H14.6194" stroke="#111317" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M10.9362 11.3786H10.9445" stroke="#111317" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M7.26131 11.3786H7.26956" stroke="#111317" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                        Support
                    </button>
                </form>
            </div>

            <div class="dropdown">
                <button type="button" class="btn btn-info" data-toggle="dropdown">
                    <i class="fa fa-shopping-cart" aria-hidden="true"></i> Cart <span class="badge badge-pill badge-danger">{{ count((array) session('cart')) }}</span>
                </button>
                <div class="dropdown-menu">
                    <div class="row total-header-section">
                        <div class="col-lg-6 col-sm-6 col-6">
                            <i class="fa fa-shopping-cart" aria-hidden="true"></i> <span class="badge badge-pill badge-danger">{{ count((array) session('cart')) }}</span>
                        </div>
                        @php $total = 0 @endphp
                        @foreach((array) session('cart') as $id => $details)
                            @php $total += $details['price'] * $details['quantity'] @endphp
                        @endforeach
                        <div class="col-lg-6 col-sm-6 col-6 total-section text-right">
                            <p>Total: <span class="text-info">$ {{ $total }}</span></p>
                        </div>
                    </div>
                    @if(session('cart'))
                        @foreach(session('cart') as $id => $details)
                        @php
                         $image = App\Models\GamingAccount::findOrFail($id);
                            @endphp
                            <div class="row cart-detail">
                                <div class="col-lg-4 col-sm-4 col-4 cart-detail-img">
                                    <img width="100%"  src="{{ $image->main_image}}" />
                                </div>
                                <div class="col-lg-8 col-sm-8 col-8 cart-detail-product">
                                    <p>{{ $details['name'] }}</p>
                                    <span class="price text-info"> ${{ $details['price'] }}</span> <span class="count"> Quantity:{{ $details['quantity'] }}</span>
                                </div>
                            </div>
                        @endforeach
                    @endif
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-12 text-center checkout">
                            <a href="{{ route('view.cart') }}" class="btn btn-primary btn-block">View all</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>
