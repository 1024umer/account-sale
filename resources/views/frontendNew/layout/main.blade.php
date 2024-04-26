<!DOCTYPE html>
<html>

<head>
    @include('frontendNew.layout.link')
    <style>
      /* The switch - the box around the slider */
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

/* Hide default HTML checkbox */
.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
        .light-mode {
            background-color: #fff !important;
            color: #6e6e6e !important;

            nav {
                background-color: #fff !important;
                color: #fff !important;
            }

            .header-main {
                background-color: #fff !important;
                color: #000 !important;
            }

            a {
                color: #6e6e6e !important;
            }

            h1,
            h2,
            h3,
            h4,
            h5,
            h6 {
                color: #fff !important;
            }

            p {
                color: #6e6e6e !important;
            }
        }

        .dark-mode {
            background-color: #6e6e6e !important;
            color: #fff !important;
            ul{
              background-color: #6e6e6e !important;
            }
            .card-title{
              color:#6e6e6e !important;
            }
            .card-body p{
              color:#6e6e6e !important;
            }
            select{
              background-color: #ccc !important;
            }
            nav {
                background-color: #6e6e6e !important;
                color: #fff !important;
            }

            .header-main {
                background-color: #6e6e6e !important;
                color: #fff !important;
            }

            a {
                color: #fff !important;
            }

            h1,
            h2,
            h3,
            h4,
            h5,
            h6 {
                color: #fff !important;
            }

            p {
                color: #fff !important;
            }
        }
    </style>
</head>

<body class="">
    <div class="page-wrapper">
        <main class="main-wrapper light-teal">
            @include('frontendNew.layout.navbar')
            @yield('body')
            @include('frontendNew.layout.footer')
            @include('frontendNew.layout.links')
        </main>
    </div>
</body>
@stack('js')

</html>
