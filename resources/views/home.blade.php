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
    <link rel="stylesheet" type="text/css" href="{{ asset('css/styles.css') }}" />

    <!-- Favicon and Touch Icons  -->
    <link rel="shortcut icon" href="{{ asset('images/logo/40.png') }}" />
    <link rel="apple-touch-icon-precomposed" href="{{ asset('images/logo/40.png') }}" />

    <title>EasyPay - Wallet</title>
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
        <!-- Header -->
        <div class="header-home">
            <div class="tf-container">
                <div class="header-content">
                    <div class="left d-flex align-items-center g-10 wg-user style-white">
                        <div class="image">
                            <img loading="lazy" width="45" height="45" src="{{ auth()->user()->profile_image ? asset(auth()->user()->profile_image) : asset('images/avatar/avatar-1.jpg') }}" alt="Image">
                        </div>
                        <div class="content">
                            <p class="title fw-5">Hi, {{ auth()->user()->name }} 👋</p>
                            <p class="sub-title text-small">Welcome back to EasyPay</p>
                        </div>
                    </div>
                    <div class="right d-flex align-items-center g-5">
                        <a href="{{ asset('chat.html') }}" class="mess-btn btn-icon style-white">
                            <i class="icon-message"></i>
                            <span></span>
                        </a>
                        <a href="#notification" class="btn-icon style-white" data-bs-toggle="modal">
                            <i class="icon-bell"></i>
                            <span></span>
                        </a>
                        
                    </div>
                </div>
            </div>
        </div>

        <!-- Wallet Balance Card -->
        <div class="tf-container">
            <div class="asset-card-row mb-24">
                <div class="wg-total-asset-card">
                    <div class="top-card">
                        <div class="text text-small fw-5">Total Balance</div>
                        <div class="price-asset-card h4 d-flex align-items-center g-8 box-auth-pass">
                            <input type="text" value="{{ isset($wallet) ? '$' . number_format($wallet->balance, 2) : '$0.00' }}" class="price password-field2" size="5" readonly>
                            <a href="#" class="show-pass2 active"><i class="icon-eye-outline"></i></a>
                        </div>
                        <p class="d-flex align-items-center g-4"><i class="icon-arrow-circle-up"></i> <span class="text-xsmall">Account active</span></p>
                    </div>
                    <div class="list-image-logo">
                        <img loading="lazy" width="32" height="32" src="{{ asset('images/icon/amazon.jpg') }}" alt="Image" class="img-logo">
                        <img loading="lazy" width="32" height="32" src="{{ asset('images/icon/airbnb.jpg') }}" alt="Image" class="img-logo">
                        <img loading="lazy" width="32" height="32" src="{{ asset('images/icon/amd.jpg') }}" alt="Image" class="img-logo">
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="tf-container">
            <div class="grid-2 g-8 mb-24">
                <a href="#" class="tf-btn style-2 py-17 style-white">
                    <i class="icon-icon-send"></i>
                    <span>Send</span>
                </a>
                <a href="#" class="tf-btn style-2 py-17 style-white">
                    <i class="icon-top-up"></i>
                    <span>Top Up</span>
                </a>
            </div>

            <div class="grid-2 g-8 mb-24">
                <a href="#" class="tf-btn style-2 py-17 style-white">
                    <i class="icon-withdraw"></i>
                    <span>Withdraw</span>
                </a>
                <a href="#" class="tf-btn style-2 py-17 style-white">
                    <i class="icon-transfer"></i>
                    <span>Transfer</span>
                </a>
            </div>
        </div>

        <!-- Recent Transactions -->
        <div class="tf-container">
            <div class="wg-card-detail mb-24">
                <div class="header-card">
                    <h5 class="title">Recent Activity</h5>
                    <a href="#" class="sub-title">View all</a>
                </div>

                @forelse($transactions as $transaction)
                    <div class="item-card-detail">
                        <div class="left">
                            <div class="icon-box">
                                @if($transaction->type === 'deposit')
                                    <i class="icon-icon-send text-success"></i>
                                @elseif($transaction->type === 'withdrawal')
                                    <i class="icon-withdraw text-danger"></i>
                                @else
                                    <i class="icon-transfer text-primary"></i>
                                @endif
                            </div>
                            <div>
                                <p class="title fw-6">{{ ucfirst($transaction->type) }}</p>
                                <p class="text-small">{{ $transaction->description ?? ucfirst($transaction->type) . ' transaction' }}</p>
                            </div>
                        </div>
                        <p class="title fw-6 {{ $transaction->type === 'deposit' ? 'text-success' : 'text-danger' }}">
                            {{ $transaction->type === 'deposit' ? '+' : '-' }}${{ number_format($transaction->amount, 2) }}
                        </p>
                    </div>
                    <div class="line"></div>
                @empty
                    <div class="item-card-detail">
                        <div class="left">
                            <div class="icon-box">
                                <i class="icon-inbox text-muted"></i>
                            </div>
                            <div>
                                <p class="title fw-6">No transactions yet</p>
                                <p class="text-small">Your transaction history will appear here</p>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Bottom Navigation -->
    <div class="menubar-footer footer-fixed d-flex justify-content-between align-items-center">
        <div class="left inner-bar position-relative">
            <a href="{{ url('/') }}" class="inner-bar-item active">
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
                        <li class="mt-18 sub-menu" id="accordionExample">
                            <a href="#menu-home" class="nav-link-item collapsed" data-bs-toggle="collapse"><span>Home</span></a>
                            <div id="menu-home" class="nav-content collapse" data-bs-parent="#accordionExample">
                                <ul>
                                    <li><a href="{{ url('/') }}" class="nav-link-item no-page"><span>Home</span></a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="mt-18">
                           <a href="/dashboard" class="inner-bar-item">
                        </li>
                        <li class="mt-18">
                            <a href="{{ route('logout') }}" class="nav-link-item"><span>Logout</span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- More Services Modal -->
    <div class="modal fade modalDown pop-up-more-services" id="more-services">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="wg-more-services">
                    <div class="tf-container">
                        <div class="divider mb-24"></div>
                        <h5 class="title mb-24">More Services</h5>
                        <div class="list-box-icon d-flex align-items-center justify-content-between mb-24">
                            <a href="#" class="box-icon v3">
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

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('js/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('js/carousel.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>

</body>

</html>
