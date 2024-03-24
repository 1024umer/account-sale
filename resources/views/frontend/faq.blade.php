@extends('frontend.layout')

@if ($data)
    @section('meta_title', $data->meta_title . ' order cancelled')
    @section('meta_keyowrds', $data->meta_keyowrds)
    @section('meta_description', $data->meta_description)
@endif

@section('page-styles')
    <style>
        .hero-section {
            padding-top: 14vh;
            /* background-image: url("{{ asset('frontend/images/page-bg.png') }}"); */
            min-height: 100vh;
            width: 100vw;
            background-position: top;
            background-repeat: no-repeat;
            background-size: 100%;
        }

        .hero-section .container-heading a {
            text-decoration: none;
            color: #62646c;
            transition: 0.2s;
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
            margin-right: 10px;
        }

        .hero-section .container-heading a:hover {
            transition: 0.2s;
            color: #20ada3;
        }

        .hero-section .left-side .text h1 {
            font-weight: 700;
            font-size: 36px;
            line-height: 100%;
            color: #dbdbdb;
        }

        .hero-section .left-side .text img {
            max-width: 190px;
        }

        .hero-section .left-side .text p {
            font-weight: 500;
            font-size: 14px;
            line-height: 24px;
            letter-spacing: .012em;
            color: #95979f;
        }

        .hero-section .left-side h4 {
            color: #62646c;
            margin-top: 10px;
            margin-bottom: 10px;
            font-weight: 400;
            font-size: 14px;
            line-height: 24px;
            text-transform: uppercase;
        }

        .popular-section .top-side .left-side h1 {
            font-size: 3.5rem;
            font-weight: 1000;
            letter-spacing: 1px;
            color: #20ada3;
        }

        .popular-section .top-side .left-side h3 {
            font-weight: 600;
            font-size: 24px;
            line-height: 30px;
            letter-spacing: .012em;
            text-transform: capitalize;
            color: #dbdbdb;
            margin-bottom: 12px;
        }

        .popular-section .top-side .right-side p {
            color: hsla(0, 0%, 100%, 0.404);
            font-size: 16px;
            font-weight: 600;
        }

        .popular-section .container {
            border-bottom: 1px solid hsla(0, 0%, 100%, .03);
            ;
        }

        @media (max-width: 767px) {
            .breadcrumb {
                padding-top: 30px;
            }

            .hero-section .left-side {
                padding-left: 20px;
                padding-right: 20px;
            }
        }

        .popular-section .inner {
            background-color: hsla(0, 0%, 100%, .03);
            border-radius: 12px;
        }

        .popular-section .inner .top {
            border-bottom: 1px solid hsla(0, 0%, 100%, .03);
        }

        .popular-section .inner h5 {
            font-weight: 600;
            font-size: 14px;
            line-height: 20px;
            letter-spacing: .02em;
            color: #dbdbdb;
        }

        .popular-section .inner p {
            font-size: 10px;
            line-height: 20px;
            letter-spacing: .02em;
            text-transform: uppercase;
            color: #62646c;
            margin-top: 8px;
        }

        .popular-section .inner a {
            text-decoration: none;
            margin-top: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            border: 2px solid hsla(0, 0%, 100%, .03);
            border-radius: 100px;
            height: 48px;
            font-weight: 600;
            font-size: 13px;
            line-height: 24px;
            letter-spacing: .012em;
            color: #95979f;
            transition: .25s;
        }
        .popular-section .inner a:hover {
            background-color: #62646c;
        }
        .popular-section .text {
            font-weight: 500;
            font-size: 14px;
            line-height: 24px;
            color: #62646c;
        }
    </style>

@endsection

@section('content')
    <section class="hero-section">
        <div class="page-head">
            <div class="container">
                <div class=" container-heading breadcrumb">
                    <a href="{{ route('home') }}">Home > </a>
                    <a href="{{ route('faq') }}">Support</a>
                </div>
            </div>
            <section class="popular-section mt-5 py-5">
                <div class="container pb-5">
                    <div class="top-side">
                        <div class="d-block d-md-flex align-items-center justify-content-between">
                            <div class="left-side my-2 my-md-auto mb-5 mb-md-0">
                                <h3 class="top-h1">Devil Sofware's</h3>
                                <h1 class="bottom-h1">SUPPORT</h1>
                                <img class=" my-2" src="{{ asset('frontend/images/underline.svg') }}" alt="">
                            </div>
                            <div class="right-side d-flex align-items-center">
                                <p class="m-auto w-75 text-end text-dark">Be sure to update and download all drivers
                                    and necessary programs</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container py-5">
                    <div class="text">
                        <p class="m-0">RECOMMENDED DRIVERS</p>
                    </div>
                    <div class="row my-4">
                        <div class="col-md-4">
                            <div class="inner p-4">
                                <div class="top d-flex p-2 pb-3 align-items-center">
                                    <img class="me-3" src="{{ asset('frontend/images/microsoftvs.png') }}" alt="">
                                    <div class="details">
                                        <h5>Microsoft Visual C++ 2005-2019</h5>
                                        <p class="mb-0">PACKAGE WITH COMPONENTS</p>
                                    </div>
                                </div>
                                <div class="bottom">
                                    <a target="blank" href="https://www.techpowerup.com/download/visual-c-redistributable-runtime-package-all-in-one/">Download</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 my-3 my-md-0">
                            <div class="inner p-4">
                                <div class="top d-flex p-2 pb-3 align-items-center">
                                    <img class="me-3" src="{{ asset('frontend/images/directx.png') }}" alt="">
                                    <div class="details">
                                        <h5>Directx 12</h5>
                                        <p class="mb-0">PACKAGE WITH COMPONENTS</p>
                                    </div>
                                </div>
                                <div class="bottom">
                                    <a target="blank" href="https://download.microsoft.com/download/1/7/1/1718CCC4-6315-4D8E-9543-8E28A4E18C4C/dxwebsetup.exe">Download</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="inner p-4">
                                <div class="top d-flex p-2 pb-3 align-items-center">
                                    <img class="me-3" src="{{ asset('frontend/images/dotnet.png') }}" alt="">
                                    <div class="details">
                                        <h5>Microsoft Net Framework 4.7.1</h5>
                                        <p class="mb-0">PACKAGE WITH COMPONENTS</p>
                                    </div>
                                </div>
                                <div class="bottom">
                                    <a target="blank" href="https://www.microsoft.com/ru-RU/download/details.aspx?id=55167">Download</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row my-4">
                        <div class="col-md-4">
                            <div class="inner p-4">
                                <div class="top d-flex p-2 pb-3 align-items-center">
                                    <img class="me-3" src="{{ asset('frontend/images/nvidea.png') }}" alt="">
                                    <div class="details">
                                        <h5>NVIDIA</h5>
                                        <p class="mb-0">VIDEO DRIVER UPDATE</p>
                                    </div>
                                </div>
                                <div class="bottom">
                                    <a target="blank" href="https://www.nvidia.ru/Download/index.aspx?lang=ru">Download</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 my-3 my-md-0">
                            <div class="inner p-4">
                                <div class="top d-flex p-2 pb-3 align-items-center">
                                    <img class="me-3" src="{{ asset('frontend/images/amd.png') }}" alt="">
                                    <div class="details">
                                        <h5>AMD</h5>
                                        <p class="mb-0">VIDEO DRIVER UPDATE</p>
                                    </div>
                                </div>
                                <div class="bottom">
                                    <a target="blank" href="https://www.amd.com/ru/support">Download</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 my-3 my-md-0">
                            <div class="inner p-4">
                                <div class="top d-flex p-2 pb-3 align-items-center">
                                    <img class="me-3" src="{{ asset('frontend/images/driverpack.png') }}" alt="">
                                    <div class="details">
                                        <h5>DriverPack</h5>
                                        <p class="mb-0">INSTALLING ALL DRIVERS</p>
                                    </div>
                                </div>
                                <div class="bottom">
                                    <a target="blank" href="https://www.google.com/search?q=driverpack+solution&oq=driverpack">Download</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text">
                        <p>Also, if you have anti-cheats installed, like FaceIt or ESEA, then you definitely need to remove them! If you have Valorant installed on your computer, then remove Riot Guard (This item is for DLC on all games except Valorant)</p>
                    </div>
                </div>
                <div class="container py-5">
                    <div class="text">
                        <p>DISABLING PROTECTION
                        </p>
                    </div>
                    <div class="row my-4">
                        <div class="col-md-4">
                            <div class="inner p-4">
                                <div class="top d-flex p-2 pb-3 align-items-center">
                                    <img class="me-3" src="{{ asset('frontend/images/wss.png') }}" alt="">
                                    <div class="details">
                                        <h5>Auto turn off Windows Smart Screen</h5>
                                    </div>
                                </div>
                                <div class="bottom">
                                    <a target="blank" href="https://disk.yandex.com/d/WnIQNa5k3TLPsq">Download</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 my-3 my-md-0">
                            <div class="inner p-4">
                                <div class="top d-flex p-2 pb-3 align-items-center">
                                    <img class="me-3" src="{{ asset('frontend/images/defender.png') }}" alt="">
                                    <div class="details">
                                        <h5>Windows Defender Management</h5>
                                    </div>
                                </div>
                                <div class="bottom">
                                    <a target="blank" href="https://www.softportal.com/software-43861-defender-control.html">View</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 my-3 my-md-0">
                            <div class="inner p-4">
                                <div class="top d-flex p-2 pb-3 align-items-center">
                                    <img class="me-3" src="{{ asset('frontend/images/uac.png') }}" alt="">
                                    <div class="details">
                                        <h5>Auto Disable Accounts (UAC)</h5>
                                    </div>
                                </div>
                                <div class="bottom">
                                    <a target="blank" href="https://disk.yandex.ru/d/jDyGM3TN3TLPt2">Download</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row my-4">
                        <div class="col-md-4">
                            <div class="inner p-4">
                                <div class="top d-flex p-2 pb-3 align-items-center">
                                    <img class="me-3" src="{{ asset('frontend/images/bios.png') }}" alt="">
                                    <div class="details">
                                        <h5>Disable Secure Boot in bios</h5>
                                    </div>
                                </div>
                                <div class="bottom">
                                    <a target="blank" href="https://www.youtube.com/watch?v=RjwT85icNHg">View</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 my-3 my-md-0">
                            <div class="inner p-4">
                                <div class="top d-flex p-2 pb-3 align-items-center">
                                    <img class="me-3" src="{{ asset('frontend/images/bios.png') }}" alt="">
                                    <div class="details">
                                        <h5>
                                            Enable UEFI in BIOS</h5>
                                    </div>
                                </div>
                                <div class="bottom">
                                    <a target="blank" href="https://learn.microsoft.com/ru-ru/windows/deployment/mbr-to-gpt?source=recommendations">View</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container py-5">
                    <div class="text">
                        <p>AUXILIARY PROGRAMS
                        </p>
                    </div>
                    <div class="row my-4">
                        <div class="col-md-3">
                            <div class="inner p-4">
                                <div class="top d-flex p-2 pb-3 align-items-center">
                                    <img class="me-3" src="{{ asset('frontend/images/winrar.png') }}" alt="">
                                    <div class="details">
                                        <h5>Working with WinRar archives</h5>
                                    </div>
                                </div>
                                <div class="bottom">
                                    <a target="blank" href="https://www.win-rar.com/start.html?&L=0">Download</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 my-3 my-md-0">
                            <div class="inner p-4">
                                <div class="top d-flex p-2 pb-3 align-items-center">
                                    <img class="me-3" src="{{ asset('frontend/images/screenshot.png') }}" alt="">
                                    <div class="details">
                                        <h5>Screenshot of your problem</h5>
                                    </div>
                                </div>
                                <div class="bottom">
                                    <a target="blank" href="https://winsorconsulting.com/take-screenshot-windows-10-11/#:~:text=The%20Windows%20key%20%2B%20Print%20Screen,be%20saved%20to%20the%20folder.">View</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 my-3 my-md-0">
                            <div class="inner p-4">
                                <div class="top d-flex p-2 pb-3 align-items-center">
                                    <img class="me-3" src="{{ asset('frontend/images/teamviewer.png') }}" alt="">
                                    <div class="details">
                                        <h5>Teamviewer remote access</h5>
                                    </div>
                                </div>
                                <div class="bottom">
                                    <a target="blank" href="https://www.teamviewer.com/apac/">Download</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 my-3 my-md-0">
                            <div class="inner p-4">
                                <div class="top d-flex p-2 pb-3 align-items-center">
                                    <img class="me-3" src="{{ asset('frontend/images/anydesk.png') }}" alt="">
                                    <div class="details">
                                        <h5>AnyDesk Remote Access</h5>
                                    </div>
                                </div>
                                <div class="bottom">
                                    <a target="blank" href="https://anydesk.com/">Download</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </section>
@endsection
