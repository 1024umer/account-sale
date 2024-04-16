<!DOCTYPE html>
<html>

<head>
    @include('frontendNew.layout.link')
    <style>
      .light-mode{
        background-color: #fff !important;
        color:#6e6e6e !important;
        a{
          color:#6e6e6e !important;
        }
        h1,h2,h3,h4,h5,h6{
          color: #000 !important;
        }
        p{
          color:#6e6e6e !important;
        }
      }
      .dark-mode{
        background-color: #6e6e6e !important;
        color:#fff !important;
        a{
          color:#fff !important;
        }
        h1,h2,h3,h4,h5,h6{
          color: #fff !important;
        }
        p{
          color:#fff !important;
        }
      }
    </style>
</head>

  <body class="" >
        <div class="page-wrapper">
            <main class="main-wrapper light-teal">
    @include('frontendNew.layout.navbar')
    @yield('body')
    @include('frontendNew.layout.footer')
    @include('frontendNew.layout.links')
</main>
</div>
</body>

</html>
