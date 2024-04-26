<header class="header">
    <div class="header-main bg-white love-sticky">
        <div class="container">
            <div class="row align-items-center position-relative">
                <div class="col-lg-2 col-sm-3 col-5">
                    <div class="logo">
                        <a href="{{ route('home') }}">
                            <img src="/FrontendNew/assets/img/sticky-logo.png" alt="">
                        </a>
                    </div>
                </div>
                <div class="col-lg-10 col-sm-9 col-7 d-flex align-items-center justify-content-end position-static">
                    <div class="nav-wrapper">
                        <ul class="nav">
                            <li class="nav-item">
                                <a class="{{ request()->routeIs('home') ? 'current-menu-parent' : '' }}"
                                    href="{{ route('home') }}">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="{{ request()->routeIs('games*') ? 'current-menu-parent' : '' }}"
                                    href="{{ route('games') }}">Account</a>
                            </li>
                            <li class="nav-item">
                                <a class="{{ request()->routeIs('giveaway*') ? 'current-menu-parent' : '' }}"
                                    href="{{ route('giveaway') }}">Give Aways</a>
                            </li>
                            @if (Auth::check())
                                <li class="nav-item">
                                    <a class="{{ request()->routeIs('profile.referral') ? 'current-menu-parent' : '' }}"
                                        href="{{ route('profile.referral') }}">Referral</a>
                                </li>
                            @endif
                            <li class="nav-item">
                                <a class="{{ request()->routeIs('contact') ? 'current-menu-parent' : '' }}"
                                    href="{{ route('contact') }}">Contact</a>
                            </li>
                            <li class="nav-item">
                                <a
                                    onclick="window.location.href = '{{ Auth::check() ? './profile/tickets' : './signin' }}';">Support</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link" href="#" id="cartDropdown" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i style="font-size: 25px;" class="fa fa-shopping-cart"></i> Cart
                                    <span class="badge badge-warning"
                                        id="lblCartCount">{{ count((array) session('cart')) }}</span>
                                </a>
                                <div class="dropdown-menu" style="width: 270px; line-height:0.6; padding:10px"
                                    aria-labelledby="cartDropdown">
                                    @if (session('cart'))
                                        <div class="cart-items">
                                            @php $total = 0 @endphp
                                            @foreach (session('cart') as $id => $details)
                                                @php $total += $details['price'] * $details['quantity'] @endphp
                                                <div class="cart-item">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="item-image">
                                                                @php
                                                                    $image = App\Models\GamingAccount::findOrFail($id);
                                                                @endphp
                                                                <img width="50" src="{{ $image->main_image }}"
                                                                    alt="{{ $details['name'] }}" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="item-details">
                                                                <p>{{ $details['name'] }}</p>
                                                                <span class="price text-info">
                                                                    ${{ $details['price'] }}</span>
                                                                <span class="count"> Quantity:
                                                                    {{ $details['quantity'] }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                    <div class="total-header-section">
                                        <div class="total-section text-right">

                                            <p>Total: <span class="text-info">$ {{ isset($total) ? $total : '' }}</span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-sm-12 col-12 text-center checkout mt-2">
                                            <a href="{{ route('view.cart') }}" class="btn btn-primary btn-block">View
                                                all</a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @if (Auth::check())
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Profile</a>
                                    <ul class="sub-menu">
                                        <li>
                                            <a>Balance
                                                {{ Auth::user()->balance + Auth::user()->referral_balance }}$</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('profile.purchses') }}"> My purchases</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('profile.tickets') }}">Online support</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('profile.settings') }}"> Settings</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('logout') }}"> Logout</a>
                                        </li>
                                    </ul>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a class="{{ request()->routeIs('contact') ? 'current-menu-parent' : '' }} btn btn-primary text-white"
                                        href="{{ Auth::check() ? './profile/tickets' : './signin' }}">Sign In</a>
                                </li>
                            @endif
                        </ul>
                    </div>
                    <div class="d-flex align-items-center mr-2 mr-sm-4">
                        <!-- Additional content here if needed -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="form-check form-switch">
  <label class="switch">
    <input type="checkbox"  onclick="toggleMode()">
    <span class="slider round"></span>
  </label>
    {{-- <input class="form-check-input" type="checkbox" role="switch" id="modeToggleSwitch">
    <label class="form-check-label" for="flexSwitchCheckDefault">Default switch checkbox input</label> --}}
</div>

@php
    $isHome = request()->routeIs('home');
@endphp

@unless ($isHome)
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <!-- Navbar Toggler -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#categoriesNavbar"
                aria-controls="categoriesNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Categories Navbar -->
            <div class="collapse navbar-collapse" id="categoriesNavbar">
                <ul class="navbar-nav">
                    @foreach ($categoriesHeader as $category)
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="categoryDropdown{{ $category->id }}"
                                role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                onmouseover="openDropdown(this)" onmouseout="closeDropdown(this)">
                                {{ $category->name }}
                            </a>
                            <div class="dropdown-menu" aria-labelledby="categoryDropdown{{ $category->id }}"
                                onmouseleave="closeDropdown(this)">
                                <!-- Subcategories for the current category -->
                                @foreach ($category->subCategories as $subCategory)
                                    <a class="dropdown-item"
                                        href="{{ route('games.category', ['slug' => $subCategory->name]) }}">{{ $subCategory->name }}</a>
                                @endforeach

                                <!-- SubSubcategories for the current subcategory -->
                                @foreach ($subCategory->subSubCategory as $subSubCategory)
                                    <a class="dropdown-item"
                                        href="{{ route('games.subcategory', ['slug' => $subSubCategory->name]) }}">{{ $subSubCategory->name }}</a>
                                @endforeach
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </nav>

    @endunless
    @push('js')
        <script>
            function toggleMode() {
                var body = document.body;
                if (body.classList.contains('light-mode')) {
                    body.classList.remove('light-mode');
                    body.classList.add('dark-mode');
                } else {
                    body.classList.remove('dark-mode');
                    body.classList.add('light-mode');
                }
            }

            function openDropdown(element) {
                var dropdownMenu = element.nextElementSibling;
                dropdownMenu.classList.add('show');
            }

            function closeDropdown(element) {
                var dropdownMenu = element;
                dropdownMenu.classList.remove('show');
            }
        </script>
    @endpush
