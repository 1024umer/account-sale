<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('meta_title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description')">
    <meta name="keywords" content="@yield('meta_keywords')">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@800&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    {{-- font awesome --}}

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        * {
            font-family: 'Montserrat';
        }
    </style>
    <link rel="stylesheet" href="{{ asset('frontend/header.css?v=9') }}">
    <link rel="stylesheet" href="{{ asset('frontend/footer.css?v=9') }}">
    <link rel="stylesheet" href="{{ asset('frontend/product_style.css') }}">
    @yield('page-styles')
   <style>
.info1{
    color:#000;
    top:100px;
    left:50px;
    text-decoration:none;
    text-align:center;
  }



.info1 span{display: none}

.info1:hover span{ /*the span will display just on :hover state*/
    display:block;
    position:absolute;
    top:-60px;
    width:15em;
    border:5px solid #0cf;
    background-color:#cff; color:#000;
    text-align: center;
    padding:10px;
  }

  .info1:hover span:after{ /*the span will display just on :hover state*/
    content:'';
    position:absolute;
    bottom:-11px;
    width:10px;
    height:10px;
    border-bottom:5px solid #0cf;
    border-right:5px solid #0cf;
    background:#cff;
    left:50%;
    margin-left:-5px;
    -moz-transform:rotate(45deg);
    -webkit-transform:rotate(45deg);
    transform:rotate(45deg);
  }


</style>
</head>

<body>
    @include('frontend.partials.header')
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session('success') }}',
            })
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
            })
        </script>
    @endif

    @yield('content')
    @include('frontend.partials.footer')
    <script>
        $(function() {
            $('.header-profile').on('click', function() {
                $('.header-dropdown').toggle();
            });
        });
    </script>
    @yield('page-scripts')
</body>

</html>
