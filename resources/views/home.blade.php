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
    <link rel="shortcut icon" href="{{ asset('images/icon/wallet-icon.ico') }}" />
    <link rel="apple-touch-icon-precomposed" href="{{ asset('images/icon/wallet-icon.ico') }}" />

    <title>EasyPay - Wallet</title>
</head>

<body class="bg-color-primary-100 page-scroll">

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
                        <a href="{{ route('chat.index') }}" class="mess-btn btn-icon style-white" style="position:relative;">
                            <i class="icon-message"></i>
                            @php
                                $chatUnread = 0;
                                if (\Illuminate\Support\Facades\Schema::hasTable('chat_messages')) {
                                    $chatUnread = \App\Models\ChatMessage::where('user_id', auth()->id())
                                        ->where('is_from_admin', true)
                                        ->where('is_read', false)
                                        ->count();
                                }
                            @endphp
                            @if($chatUnread > 0)
                                <span style="position:absolute; top:-4px; right:-4px; background:#dc3545; color:#fff; font-size:11px; font-weight:700; min-width:18px; height:18px; border-radius:9px; display:flex; align-items:center; justify-content:center; padding:0 5px; border:2px solid #fff; line-height:1;">{{ $chatUnread > 99 ? '99+' : $chatUnread }}</span>
                            @endif
                        </a>
                        <a href="#notification" class="btn-icon style-white" data-bs-toggle="modal" style="position:relative;">
                            <i class="icon-bell"></i>
                            @php
                                $unreadCount = ($notifications ?? collect())->where('is_read', false)->count();
                            @endphp
                            @if($unreadCount > 0)
                                <span style="position:absolute; top:-4px; right:-4px; background:#dc3545; color:#fff; font-size:11px; font-weight:700; min-width:18px; height:18px; border-radius:9px; display:flex; align-items:center; justify-content:center; padding:0 5px; border:2px solid #fff; line-height:1;">{{ $unreadCount > 99 ? '99+' : $unreadCount }}</span>
                            @endif
                        </a>
                        
                    </div>
                </div>
            </div>
        </div>

        <!-- Wallet Balance Card -->
        <div class="tf-container">
            <div class="asset-card-row mb-24">
                <div class="wg-total-asset-card">
                    <div class="top-card" style="display:flex; justify-content:space-between; align-items:flex-start;">
                        <div>
                            <div class="text text-small fw-5">Total Balance</div>
                            <div class="price-asset-card h4 d-flex align-items-center g-8 box-auth-pass">
                                <input type="text" value="{{ isset($wallet) ? '$' . number_format($wallet->balance, 2) : '$0.00' }}" class="price password-field2" size="5" readonly>
                                <a href="#" class="show-pass2 active"><i class="icon-eye-outline"></i></a>
                            </div>
                            @php
                                $weeklyChange = $weeklyBalanceChange ?? 0;
                                $weeklyPercent = $weeklyBalanceChangePercent ?? 0;
                                $weeklySign = $weeklyChange >= 0 ? '+' : '-';
                            @endphp
                            <p class="d-flex align-items-center g-4">
                                <i class="{{ $weeklyChange >= 0 ? 'icon-arrow-circle-up' : 'icon-arrow-circle-down' }}"></i>
                                <span class="text-xsmall">
                                    {{ number_format(abs($weeklyPercent), 2) }}% ({{ $weeklySign }}${{ number_format(abs($weeklyChange), 2) }}) vs Last week
                                </span>
                            </p>
                        </div>
                        <div style="text-align:right;">
                            <p class="d-flex align-items-center justify-content-end g-4">
                                <i class="icon-bag-dollar" style="font-size:18px;"></i>
                                <span class="text-small fw-6">Wallet Address</span>
                            </p>
                            <p style="margin-top:4px;">
                                <span class="text-small fw-6">{{ isset($wallet) ? $wallet->wallet_address : 'No wallet' }}</span>
                            </p>
                        </div>
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
                <a href="{{ route('wallet.transfer.form') }}" class="tf-btn style-2 py-17 style-white">
                    <i class="icon-icon-send"></i>
                    <span>Send</span>
                </a>
                <a href="{{ route('wallet.topup') }}" class="tf-btn style-2 py-17 style-white">
                    <i class="icon-top-up"></i>
                    <span>Top Up</span>
                </a>
            </div>

            <div class="grid-2 g-8 mb-24">
                <a href="#" class="tf-btn style-2 py-17 style-white">
                    <i class="icon-withdraw"></i>
                    <span>Withdraw</span>
                </a>
                <a href="{{ route('wallet.transfer.form') }}" class="tf-btn style-2 py-17 style-white">
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

    @if(isset($popupNotification) && $popupNotification)
        <div id="money-notification-popup" style="position:fixed; top:18px; left:16px; right:16px; z-index:2000; max-width:420px; margin:0 auto; background:#ffffff; border-radius:12px; box-shadow:0 14px 40px rgba(17, 24, 39, 0.18); padding:14px 16px; display:flex; align-items:flex-start; gap:12px;">
            <span style="width:40px; height:40px; border-radius:50%; display:flex; align-items:center; justify-content:center; background:#e8f8ef; color:#19a463; flex:0 0 auto;">
                @if($popupNotification->type === 'money_received' || $popupNotification->type === 'wallet_top_up')
                    <i class="icon-import"></i>
                @else
                    <i class="icon-icon-send"></i>
                @endif
            </span>
            <span style="flex:1; min-width:0;">
                <span class="text-medium fw-6" style="display:block; color:#111827;">{{ $popupNotification->title }}</span>
                <span class="text-small" style="display:block; color:#4b5563; margin-top:2px;">{{ $popupNotification->message }}</span>
            </span>
            <button type="button" id="close-money-notification-popup" aria-label="Close notification" style="border:0; background:transparent; color:#6b7280; font-size:20px; line-height:1; padding:0;">&times;</button>
        </div>
    @endif

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
                    @forelse(($notifications ?? collect()) as $notification)
                        <a href="#" class="notifications-item">
                            <span class="icon">
                                @if($notification->type === 'money_received' || $notification->type === 'wallet_top_up')
                                    <i class="icon-import"></i>
                                @else
                                    <i class="icon-icon-send"></i>
                                @endif
                            </span>
                            <span class="content">
                                <span class="title text-medium fw-6 lsp--05">{{ $notification->title }}</span>
                                <span class="text text-small lsp--05">{{ $notification->message }}</span>
                                <span class="date-time text-xsmall">
                                    <span class="date">{{ $notification->created_at->format('M d') }}</span>,
                                    <span class="time">{{ $notification->created_at->format('h:i A') }}</span>
                                </span>
                            </span>
                        </a>
                    @empty
                        <div class="notifications-item">
                            <span class="icon"><i class="icon-bell"></i></span>
                            <span class="content">
                                <span class="title text-medium fw-6 lsp--05">No notifications yet</span>
                                <span class="text text-small lsp--05">Money sent and received alerts will appear here.</span>
                            </span>
                        </div>
                    @endforelse
                </div>
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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var popup = document.getElementById('money-notification-popup');
            var closeButton = document.getElementById('close-money-notification-popup');

            if (!popup) {
                return;
            }

            function hidePopup() {
                popup.style.opacity = '0';
                popup.style.transform = 'translateY(-12px)';
                setTimeout(function () {
                    popup.remove();
                }, 220);
            }

            popup.style.transition = 'opacity 220ms ease, transform 220ms ease';
            if (closeButton) {
                closeButton.addEventListener('click', hidePopup);
            }
            setTimeout(hidePopup, 5000);
        });
    </script>

</body>

</html>
