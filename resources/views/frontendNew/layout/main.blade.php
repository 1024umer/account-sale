<!DOCTYPE html>
<html>

<head>
    @include('frontendNew.layout.link')
</head>

  <body class="body-light" >
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
