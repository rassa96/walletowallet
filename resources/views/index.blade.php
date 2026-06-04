<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, viewport-fit=cover">

    <!-- font -->
    <link rel="stylesheet" href="{{ asset('fonts/fonts.css') }}">
    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('icons/icomoon/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/swiper-bundle.min.css') }}">
    <link rel="manifest" href="{{ asset('_manifest.json') }}" data-pwa-version="set_in_manifest_and_pwa_js">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/styles.css') }}" />

    <!-- Favicon and Touch Icons  -->
    <link rel="shortcut icon" href="{{ asset('images/logo/40.png') }}" />
    <link rel="apple-touch-icon-precomposed" href="{{ asset('images/logo/40.png') }}" />

    <title>EasyPay</title>
</head>

<body class="bg-color-primary-100">

    <!-- preloade -->
    <div class="preload preload-container">
        <div class="logo-img">
            <img src="{{ asset('images/logo/logo.svg') }}" alt="Image">
        </div>
        <div class="spinner-circle lg success">
            <span class="spinner-circle1 spinner-child"></span>
            <span class="spinner-circle2 spinner-child"></span>
            <span class="spinner-circle3 spinner-child"></span>
            <span class="spinner-circle4 spinner-child"></span>
            <span class="spinner-circle5 spinner-child"></span>
            <span class="spinner-circle6 spinner-child"></span>
            <span class="spinner-circle7 spinner-child"></span>
            <span class="spinner-circle8 spinner-child"></span>
            <span class="spinner-circle9 spinner-child"></span>
        </div>
    </div>
    <!-- /preload -->

    <div class="bg-shape-top-h2"></div>
    <div class="main-content pb-100">
        <div class="header-home">
            <div class="tf-container">
                <div class="header-content">
                    <a href="@auth{{ route('dashboard') }}@else{{ route('login') }}@endauth" class="left d-flex align-items-center g-10 wg-user style-white text-decoration-none">
                        <div class="image">
                            @auth
                                <img loading="lazy" width="45" height="45" src="{{ auth()->user()->profile_image ? asset(auth()->user()->profile_image) : asset('images/avatar/avatar-1.jpg') }}" alt="Image">
                            @else
                                <img loading="lazy" width="45" height="45" src="{{ asset('images/avatar/avatar-1.jpg') }}" alt="Image">
                            @endauth
                        </div>
                        <div class="content">
                            @auth
                                <p class="title fw-5">Hi, {{ auth()->user()->name }} 👋</p>
                                <p class="sub-title text-small">Welcome back to Stock!</p>
                            @else
                                <p class="title fw-5">Hi, Andreas 👋</p>
                                <p class="sub-title text-small">Welcome back to Stock!</p>
                            @endauth
                        </div>
                    </a>
                    <div class="right d-flex align-items-center g-5">
                        <a href="{{ asset('chat.html') }}" class="mess-btn btn-icon style-white">
                            <i class="icon-message"></i>
                            <span></span>
                        </a>
                        <a href="#notification" class="btn-icon style-white" data-bs-toggle="modal">
                            <i class="icon-bell"></i>
                            <span></span>
                        </a>
                        @auth
                        <a href="{{ route('logout') }}" class="btn-icon style-white" title="Logout">
                            <i class="icon-logout"></i>
                            <span></span>
                        </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>

        <div class="tf-container">
            <div class="asset-card-row mb-24">
                <div class="wg-total-asset-card">
                    <div class="top-card">
                        <div class="text text-small fw-5">Total asset value</div>
                        <div class="price-asset-card h4 d-flex align-items-center g-8 box-auth-pass">
                            <input type="text" value="$18,908.00" class="price password-field2" size="5">
                            <a href="#" class="show-pass2 active"><i class="icon-eye-outline"></i></a>
                        </div>
                        <p class="d-flex align-items-center g-4"><i class="icon-arrow-circle-up"></i> <span class="text-xsmall">4.78% (+0.20%) vs Last week</span></p>
                    </div>
                    <div class="list-image-logo">
                        <img loading="lazy" width="32" height="32" src="{{ asset('images/icon/amazon.jpg') }}" alt="Image" class="img-logo">
                        <img loading="lazy" width="32" height="32" src="{{ asset('images/icon/airbnb.jpg') }}" alt="Image" class="img-logo">
                        <img loading="lazy" width="32" height="32" src="{{ asset('images/icon/amd.jpg') }}" alt="Image" class="img-logo">
                        <img loading="lazy" width="32" height="32" src="{{ asset('images/icon/zoom.jpg') }}" alt="Image" class="img-logo">
                    </div>
                </div>
                <div class="add-card">
                    <a href="{{ asset('add-new-card.html') }}" class="tf-btn style-3 w-100"><span><i class="icon-plus"></i> Add Card</span></a>
                </div>
            </div>
        </div>

        <div class="tf-container">
            <div class="grid-2 g-8 mb-24">
                <a href="{{ asset('select-contact-all-contact-send.html') }}" class="tf-btn style-2 py-17 style-white">
                    <i class="icon-icon-send"></i>
                    <span>Deposit</span>
                </a>
                <a href="{{ asset('select-contact-all-contact-request.html') }}" class="tf-btn style-2 py-17 style-white">
                    <i class="icon-icon-request"></i>
                    <span>Withdraw</span>
                </a>
            </div>
        </div>

        <div class="wg-transactions">
            <div class="tf-container">
                <div class="top-wg d-flex justify-content-between mb-16">
                    <h5 class="title fw-5">Transactions</h5>
                    <a href="{{ asset('all-transactions-2.html') }}" class="tf-btn-arrow-2"><span class="text-large">View all</span> <i class="icon-arrow-up-right"></i></a>
                </div>

                <a href="{{ asset('analytics-history.html') }}" class="transactions-item style-border mb-16">
                    <span class="left">
                        <span class="image">
                            <img loading="lazy" width="40" height="40" src="{{ asset('images/icon/amd-2.jpg') }}" alt="Image">
                        </span>
                        <span class="content">
                            <span class="text-medium fw-5">AMD</span>
                            <span class="text text-small">Advanced Micro Devices</span>
                        </span>
                    </span>
                    <span class="price-transactions fw-6">$72.21</span>
                </a>

                <!-- more transaction items omitted for brevity but kept in final template -->

            </div>
        </div>
    </div>

    <div class="menubar-footer footer-fixed d-flex justify-content-between align-items-center">
        <div class="left inner-bar position-relative">
            <a href="{{ asset('index.html') }}" class="inner-bar-item active"><i class="icon-home-2"></i></a>
            <a href="{{ asset('my-card.html') }}" class="inner-bar-item"><i class="icon-receipt-item"></i></a>
        </div>
        <div class="middle">
            <a href="#more-services" class="inner-bar-item v2" data-bs-toggle="modal"><i class="icon-scan"></i></a>
        </div>
        <div class="left inner-bar position-relative">
            <a href="{{ asset('bill-pay.html') }}" class="inner-bar-item"><i class="icon-bill"></i></a>
            <a href="@auth{{ route('dashboard') }}@else{{ route('login') }}@endauth" class="inner-bar-item"><i class="icon-profile-circle"></i></a>
        </div>
    </div>

    <a href="#menu-mobile" data-bs-toggle="modal" class="btn-nenu"><i class="icon-menu-2"></i></a>

    <div class="modal fade modalDown pop-up-more-services" id="more-services">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="wg-more-services">
                    <div class="tf-container">
                        <div class="divider mb-24"></div>
                        <h5 class="title mb-24">More Services</h5>
                        <div class="list-box-icon d-flex align-items-center justify-content-between mb-24">
                            <a href="#top-up-methods" class="box-icon v3" data-bs-toggle="modal">
                                <div class="icon"><i class="icon-top-up"></i></div>
                                <span class="text text-medium fw-5">Top Up</span>
                            </a>
                            <a href="{{ asset('select-contact-all-contact-send.html') }}" class="box-icon v3">
                                <div class="icon"><i class="icon-transfer"></i></div>
                                <span class="text text-medium fw-5">Transfer</span>
                            </a>
                            <a href="{{ asset('withdraw.html') }}" class="box-icon v3">
                                <div class="icon"><i class="icon-withdraw"></i></div>
                                <span class="text text-medium fw-5">Withdraw</span>
                            </a>
                        </div>
                        <!-- ... more modal content ... -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modalDown pop-up-top-up-methods" id="top-up-methods">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="wg-top-up-methods">
                    <div class="tf-container">
                        <div class="divider mb-24"></div>
                        <div class="mb-24">
                            <div class="title color-text-4 text-medium color-text-6 mb-16">Credit/Debit Card</div>
                            <a href="{{ asset('add-new-card.html') }}" class="btn-add-new-card"><span class="icon"><i class="icon-plus"></i></span><span class="fw-5">Add New Card</span></a>
                        </div>
                        <!-- truncated for brevity -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modalRight pop-up-menu-mobile" id="menu-mobile">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-sidebar">
                <span class="icon-close icon-close-popup" data-bs-dismiss="modal"></span>
                <div class="sidebar-header">
                    <a href="{{ asset('index.html') }}" class="sidebar-logo"><img src="{{ asset('images/logo/144.png') }}" alt="img"></a>
                    <p class="text-medium fw-7">Wallet to wallet Finance App</p>
                </div>
                <div class="sidebar-content">
                    <div class="d-flex g-10 align-items-center mb-20">
                        <div class="avatar avt-40"><img src="{{ asset('images/avatar/avatar-1.jpg') }}" alt="img"></div>
                        <div class="content-right">
                            <p class="text-1">Good morning</p>
                            <h6 class="fw-7">Hello! Smith</h6>
                        </div>
                    </div>
                    <ul class="pt-20 pb-20">
                        <li class="text-xlarge fw-7">Main menu</li>
                        <li class="mt-18 sub-menu" id="accordionExample">
                            <a href="#menu-home" class="nav-link-item collapsed" data-bs-toggle="collapse"><span>Home</span></a>
                            <div id="menu-home" class="nav-content collapse" data-bs-parent="#accordionExample">
                                <ul>
                                    <li><a href="{{ url('/') }}" class="nav-link-item no-page"><span>Home</span></a></li>
                                    <li><a href="{{ asset('home-2.html') }}" class="nav-link-item no-page"><span>Home 2</span></a></li>
                                </ul>
                            </div>
                        </li>
                        @auth
                        <li class="mt-18">
                            <a href="{{ route('dashboard') }}" class="nav-link-item"><span>Dashboard</span></a>
                        </li>
                        <li class="mt-18">
                            <a href="{{ route('logout') }}" class="nav-link-item"><span>Logout</span></a>
                        </li>
                        @endauth
                        @guest
                        <li class="mt-18">
                            <a href="{{ route('login') }}" class="nav-link-item"><span>Login</span></a>
                        </li>
                        @endguest
                        <!-- more sidebar links -->
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modalRight" id="modalPage">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-second">
                <div class="header header-fix mb-12">
                    <div class="tf-container">
                        <div class="header-content">
                            <a href="javascript:void(0);" class="tf-btn-arrow" data-bs-dismiss="modal"><i class="icon-icon-arrow-narrow-left-2"></i></a>
                            <h5 class="title fw-5">Page</h5>
                        </div>
                    </div>
                </div>
                <div class="overflow-auto pb-32">
                    <div class="tf-container">
                        <ul>
                            <li><a href="{{ asset('splash-screen.html') }}" class="nav-link-item no-page"><span>Splash Screen</span></a></li>
                            <li><a href="{{ asset('on-boarding.html') }}" class="nav-link-item no-page"><span>On Boarding 1</span></a></li>
                            <li><a href="{{ asset('on-boarding-2.html') }}" class="nav-link-item no-page"><span>On Boarding 2</span></a></li>
                            <li><a href="{{ asset('login.html') }}" class="nav-link-item no-page"><span>Login</span></a></li>
                            <!-- more page links... -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modalLeft pop-up-notification" id="notification">
        <div class="modal-dialog m-0" role="document">
            <div class="modal-content">
                <div class="header header-fix">
                    <div class="tf-container">
                        <div class="header-content">
                            <a href="#" class="tf-btn-arrow" data-bs-dismiss="modal"><i class="icon-icon-arrow-narrow-left-2"></i></a>
                            <h5 class="title fw-5">Notifications</h5>
                        </div>
                    </div>
                </div>

                <div class="list-notifications">
                    <a href="#" class="notifications-item">
                        <span class="icon"><i class="icon-coin"></i></span>
                        <span class="content">
                            <span class="title text-medium fw-6 lsp--05">Deposit Success</span>
                            <span class="text text-small lsp--05">You have successfully deposited $450.00 into the Investor's account. Thank you for using Invester!</span>
                            <span class="date-time text-xsmall"><span class="date">Nov 13</span>, <span class="time">06:26 AM</span></span>
                        </span>
                    </a>
                    <!-- more notifications -->
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('js/multiple-modal.js') }}"></script>
    <script src="{{ asset('js/count-down.js') }}"></script>
    <script src="{{ asset('js/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('js/carousel.js') }}"></script>
    <script src="{{ asset('js/init.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>

</body>

</html>
