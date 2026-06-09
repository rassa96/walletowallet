<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, viewport-fit=cover">

    <!-- font -->
    <link rel="stylesheet" href="{{ asset('fonts/fonts.css') }}">
    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('icons/icomoon/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/nouislider.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/styles.css') }}" />
    <style>
        html,
        body.page-scroll {
            min-height: 100%;
            overflow-y: auto !important;
        }

        body.page-scroll::-webkit-scrollbar {
            width: 8px;
        }

        body.page-scroll::-webkit-scrollbar-thumb {
            background: rgba(17, 24, 39, 0.28);
            border-radius: 8px;
        }

        body.page-scroll::-webkit-scrollbar-track {
            background: rgba(17, 24, 39, 0.06);
        }
    </style>
    <!-- Favicon and Touch Icons  -->
    <link rel="shortcut icon" href="{{ asset('images/logo/40.png') }}" />
    <link rel="apple-touch-icon-precomposed" href="{{ asset('images/logo/40.png') }}" />

    <title>Profile - EasyPay</title>
</head>

<body class="page-scroll">

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

    <div class="header header-fix mb-12">
        <div class="tf-container">
            <div class="header-content d-flex align-items-center justify-content-between">
                <a href="javascript:history.back()" class="tf-btn-arrow back-btn">
                    <i class="icon-icon-arrow-narrow-left-2"></i>
                </a>
                <h5 class="title fw-5">Profile</h5>
                <div class="d-flex align-items-center g-5">
                    <a href="{{ asset('chat.html') }}" class="mess-btn btn-icon style-white">
                        <i class="icon-message"></i>
                        <span></span>
                    </a>
                    @auth
                    <a href="{{ route('logout') }}" class="btn-icon style-white" title="Logout">
                        <i class="icon-logout"></i>
                        <span></span>
                    </a>
                    @endauth
                    <a href="{{ url('/') }}" class="tf-btn-arrow">
                        <i class="icon-home-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="tf-container">
        <div class="wg-menu-setting pb-100">
            <div class="box-profile mb-16">
                <div class="image">
                    <img loading="lazy" width="56" height="56" src="{{ auth()->user()->profile_image ? asset(auth()->user()->profile_image) : asset('images/avatar/avatar-personal-details.jpg') }}"
                        alt="Image">
                </div>
                <div class="content">
                    <p class="title fw-6">{{ auth()->user()->name }}</p>
                    <a href="javascript:void(0)" class="number-phone text-small fw-5">{{ auth()->user()->email }}</a>
                </div>
            </div>

            @if(session('status'))
                <div class="alert alert-success mb-4">{{ session('status') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger mb-4">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="list-profile-item mb-16">

                <a href="{{ route('profile.details') }}" class="profile-item">
                    <span class="left-item">
                        <i class="icon-profile"></i>
                        <span class="title text-medium fw-5">Personal Details</span>
                    </span>
                    <i class="icon-chevron-right"></i>
                </a>

                <div class="line"></div>

                <a href="#" class="profile-item">
                    <span class="left-item">
                        <i class="icon-lock-closed-outline"></i>
                        <span class="title text-medium fw-5">Security</span>
                    </span>
                    <i class="icon-chevron-right"></i>
                </a>

                <div class="line"></div>

                <a href="#" class="profile-item">
                    <span class="left-item">
                        <i class="icon-link-outline"></i>
                        <span class="title text-medium fw-5">Linked Accounts</span>
                    </span>
                    <i class="icon-chevron-right"></i>
                </a>

            </div>


             <div class="list-profile-item mb-16">

                @if(auth()->user()->is_verified)
                <a href="/verification" class="btn btn-success">
                    <span class="left-item">
                        <i class="icon-finger-print-outline"></i>
                        <span class="title text-medium fw-5">Verified Account</span>
                    </span>
                    <i class="icon-chevron-right"></i>
                </a>
                @else
                <a href="/verification" class="btn btn-info">
                    <span class="left-item">
                        <i class="icon-finger-print-outline"></i>
                        <span class="title text-medium fw-5">Verify Account</span>
                    </span>
                    <i class="icon-chevron-right"></i>
                </a>
                @endif

            </div>

            <div class="list-profile-item mb-16">

                <a href="#" class="profile-item">
                    <span class="left-item">
                        <i class="icon-finger-print-outline"></i>
                        <span class="title text-medium fw-5">Smart Login</span>
                    </span>
                    <i class="icon-chevron-right"></i>
                </a>

                <div class="line"></div>

                <div class="profile-item">
                    <div class="left-item">
                        <i class="icon-moon-outline"></i>
                        <span class="title text-medium fw-5">Dark Mode</span>
                    </div>

                    <input type="checkbox" class="tf-switch-check style-2">

                </div>


            </div>

            <div class="list-profile-item mb-16">

                <a href="#" class="profile-item">
                    <span class="left-item">
                        <i class="icon-help-circle-outline"></i>
                        <span class="title text-medium fw-5">FAQs</span>
                    </span>
                    <i class="icon-chevron-right"></i>
                </a>

                <div class="line"></div>

                <a href="#" class="profile-item">
                    <span class="left-item">
                        <i class="icon-headset"></i>
                        <span class="title text-medium fw-5">Help Center</span>
                    </span>
                    <i class="icon-chevron-right"></i>
                </a>

            </div>

            <div class="list-profile-item mb-16">

                <a href="#" class="profile-item">
                    <span class="left-item">
                        <i class="icon-globe-outline"></i>
                        <span class="title text-medium fw-5">Language</span>
                    </span>
                    <i class="icon-chevron-right"></i>
                </a>

                <div class="line"></div>

                <a href="#" class="profile-item">
                    <span class="left-item">
                        <i class="icon-shield-checkmark-outline"></i>
                        <span class="title text-medium fw-5">Privacy</span>
                    </span>
                    <i class="icon-chevron-right"></i>
                </a>

                <div class="line"></div>

                <a href="#" class="profile-item">
                    <span class="left-item">
                        <i class="icon-notifications-outline"></i>
                        <span class="title text-medium fw-5">Notifications</span>
                    </span>
                    <i class="icon-chevron-right"></i>
                </a>

            </div>

            <div class="list-profile-item mb-16">
                <a href="#" class="profile-item">
                    <span class="left-item">
                        <i class="icon-star-outline"></i>
                        <span class="title text-medium fw-5">Rate App</span>
                    </span>
                    <i class="icon-chevron-right"></i>
                </a>
            </div>

            <div class="list-profile-item style-bg-error mb-16">
                <a href="{{ route('logout') }}" class="profile-item style-logout">
                    <span class="left-item">
                        <i class="icon-exit-outline"></i>
                        <span class="title text-medium fw-5">Log Out</span>
                    </span>
                    <i class="icon-chevron-right"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="menubar-footer footer-fixed d-flex justify-content-between align-items-center">
        <div class="left inner-bar position-relative">
            <a href="{{ url('/') }}" class="inner-bar-item">
                <i class="icon-home-2"></i>
            </a>
            <a href="#" class="inner-bar-item">
                <i class="icon-receipt-item"></i>
            </a>
        </div>
        <div class="middle">
            <a href="#more-services" class="inner-bar-item v2" data-bs-toggle="modal">
                <i class="icon-scan"></i>
            </a>
        </div>
        <div class="left inner-bar position-relative">
            <a href="#" class="inner-bar-item">
                <i class="icon-bill"></i>
            </a>
            <a href="{{ route('wallet.dashboard') }}" class="inner-bar-item active">
                <i class="icon-profile-circle"></i>
            </a>
        </div>
    </div>

    <a href="#menu-mobile" data-bs-toggle="modal" class="btn-nenu"><i class="icon-menu-2"></i></a>

    <div class="modal fade modalRight pop-up-menu-mobile" id="menu-mobile">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-sidebar">
                <span class="icon-close icon-close-popup" data-bs-dismiss="modal"></span>
                <div class="sidebar-header">
                    <a href="{{ url('/') }}" class="sidebar-logo"><img src="{{ asset('images/logo/144.png') }}" alt="img"></a>
                    <p class="text-medium fw-7">Wallet to wallet Finance App</p>
                </div>
                <div class="sidebar-content">
                    <div class="d-flex g-10 align-items-center mb-20">
                        <div class="avatar avt-40"><img src="{{ auth()->user()->profile_image ? asset(auth()->user()->profile_image) : asset('images/avatar/avatar-1.jpg') }}" alt="img"></div>
                        <div class="content-right">
                            <p class="text-1">Good morning</p>
                            <h6 class="fw-7">Hello! {{ auth()->user()->name }}</h6>
                        </div>
                    </div>
                    <ul class="pt-20 pb-20">
                        <li class="text-xlarge fw-7">Main menu</li>
                        <li class="mt-18 sub-menu" id="accordionExampleDashboard">
                            <a href="#menu-home-dashboard" class="nav-link-item collapsed" data-bs-toggle="collapse"><span>Home</span></a>
                            <div id="menu-home-dashboard" class="nav-content collapse" data-bs-parent="#accordionExampleDashboard">
                                <ul>
                                    <li><a href="{{ url('/') }}" class="nav-link-item no-page"><span>Home</span></a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="mt-18">
                            <a href="{{ route('wallet.dashboard') }}" class="inner-bar-item active">
                        </li>
                        <li class="mt-18">
                            <a href="{{ route('logout') }}" class="nav-link-item"><span>Logout</span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modalDown pop-up-more-services" id="more-services">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="wg-more-services">
                    <div class="tf-container">
                        <div class="divider mb-24"></div>
                        <h5 class="title mb-24">More Services</h5>
                        <div class="list-box-icon d-flex align-items-center justify-content-between mb-24">
                            <a href="#top-up-methods" class="box-icon v3" data-bs-toggle="modal">
                                <div class="icon">
                                    <i class="icon-top-up"></i>
                                </div>
                                <span class="text text-medium fw-5">Top Up</span>
                            </a>
                            <a href="#" class="box-icon v3">
                                <div class="icon">
                                    <i class="icon-transfer"></i>
                                </div>
                                <span class="text text-medium fw-5">Transfer</span>
                            </a>
                            <a href="#" class="box-icon v3">
                                <div class="icon">
                                    <i class="icon-withdraw"></i>
                                </div>
                                <span class="text text-medium fw-5">Withdraw</span>
                            </a>
                        </div>
                        <div class="list-box-icon d-flex align-items-center justify-content-between">
                            <a href="#" class="box-icon v3">
                                <div class="icon">
                                    <i class="icon-mobile-pay"></i>
                                </div>
                                <span class="text text-medium fw-5">Mobile Pay</span>
                            </a>
                            <a href="#" class="box-icon v3">
                                <div class="icon">
                                    <i class="icon-scan-2"></i>
                                </div>
                                <span class="text text-medium fw-5">Scan</span>
                            </a>
                            <a href="#" class="box-icon v3">
                                <div class="icon">
                                    <i class="icon-pay-bill"></i>
                                </div>
                                <span class="text text-medium fw-5">Pay Bill</span>
                            </a>
                        </div>
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
                            <a href="#" class="btn-add-new-card">
                                <span class="icon">
                                    <i class="icon-plus"></i>
                                </span>
                                <span class="fw-5">Add New Card</span>
                            </a>
                        </div>
                        <div>
                            <div class="title color-text-4 text-medium color-text-6 mb-16">Bank Transfer</div>

                            <a href="#" class="bank-item mb-16">
                                <img loading="lazy" width="24" height="24" src="{{ asset('images/icon/dbs.png') }}" alt="Image">
                                <span>DBS Bank</span>
                            </a>

                            <a href="#" class="bank-item mb-16">
                                <img loading="lazy" width="24" height="24" src="{{ asset('images/icon/bca.png') }}" alt="Image">
                                <span>Bank Central Asia</span>
                            </a>

                            <a href="#" class="bank-item mb-16">
                                <img loading="lazy" width="24" height="24" src="{{ asset('images/icon/bri.png') }}" alt="Image">
                                <span>BRI</span>
                            </a>

                            <a href="#" class="bank-item style-arrow">
                                <img loading="lazy" width="24" height="24" src="{{ asset('images/icon/other-banks.png') }}"
                                    alt="Image">
                                <span>Other Banks</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('js/count-down.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/rangle-slider.js') }}"></script>
    <script src="{{ asset('js/nouislider.min.js') }}"></script>
    <script src="{{ asset('js/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('js/carousel.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>

</body>

</html>
