<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, viewport-fit=cover">

    <link rel="stylesheet" href="{{ asset('fonts/fonts.css') }}">
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

    <link rel="shortcut icon" href="{{ asset('images/logo/40.png') }}" />
    <link rel="apple-touch-icon-precomposed" href="{{ asset('images/logo/40.png') }}" />

    <title>Personal Details - EasyPay</title>
</head>

<body class="page-scroll">
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

    <div class="header header-fix mb-12">
        <div class="tf-container">
            <div class="header-content d-flex align-items-center justify-content-between">
                <a href="{{ route('wallet.dashboard') }}" class="tf-btn-arrow back-btn">
                    <i class="icon-icon-arrow-narrow-left-2"></i>
                </a>
                <h5 class="title fw-5">Personal Details</h5>
                <a href="{{ url('/') }}" class="tf-btn-arrow">
                    <i class="icon-home-2"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="tf-container">
        <div class="wg-menu-setting pb-100">
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

            <div class="box-profile mb-16">
                <div class="image">
                    <img loading="lazy" width="56" height="56" src="{{ $user->profile_image ? asset($user->profile_image) : asset('images/avatar/avatar-personal-details.jpg') }}" alt="Image">
                </div>
                <div class="content">
                    <p class="title fw-6">{{ $user->name }}</p>
                    <p class="number-phone text-small fw-5">{{ $user->email }}</p>
                </div>
            </div>

            <div class="list-profile-item mb-16">
                <div class="profile-item">
                    <span class="left-item">
                        <i class="icon-profile"></i>
                        <span class="title text-medium fw-5">Name</span>
                    </span>
                    <span class="text-small fw-5">{{ $user->name }}</span>
                </div>
                <div class="line"></div>
                <div class="profile-item">
                    <span class="left-item">
                        <i class="icon-message"></i>
                        <span class="title text-medium fw-5">Email</span>
                    </span>
                    <span class="text-small fw-5">{{ $user->email }}</span>
                </div>
                <div class="line"></div>
                <div class="profile-item">
                    <span class="left-item">
                        <i class="icon-bag-dollar"></i>
                        <span class="title text-medium fw-5">Wallet Address</span>
                    </span>
                    <span class="text-small fw-5" style="overflow-wrap:anywhere; text-align:right;">{{ $wallet->wallet_address ?? 'No wallet' }}</span>
                </div>
                <div class="line"></div>
                <div class="profile-item">
                    <span class="left-item">
                        <i class="icon-coin"></i>
                        <span class="title text-medium fw-5">Balance</span>
                    </span>
                    <span class="text-small fw-5">${{ number_format($wallet->balance ?? 0, 2) }}</span>
                </div>
                <div class="line"></div>
                <div class="profile-item">
                    <span class="left-item">
                        <i class="icon-finger-print-outline"></i>
                        <span class="title text-medium fw-5">Verification</span>
                    </span>
                    <span class="text-small fw-5">{{ $user->is_verified ? 'Verified' : 'Not verified' }}</span>
                </div>
            </div>

            <form action="{{ route('profile.avatar.update') }}" method="POST" enctype="multipart/form-data" class="mb-16">
                @csrf
                <div class="box-profile mb-16 p-3 d-block">
                    <div class="mb-3">
                        <label class="form-label fw-6" for="profile-name">Name</label>
                        <input type="text" id="profile-name" name="name" value="{{ old('name', $user->name) }}" required class="form-control mt-2">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-6" for="profile-avatar">Profile picture</label>
                        <input type="file" id="profile-avatar" name="avatar" accept="image/*" class="form-control mt-2">
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">Save Profile</button>
                </div>
            </form>
            
            <!-- Change Password Form -->
            <form action="{{ route('profile.password.update') }}" method="POST" class="mb-16">
                @csrf
                <div class="box-profile mb-16 p-3 d-block">
                    <h5 class="fw-6 mb-3"><i class="icon-lock-closed-outline"></i> Change Password</h5>
                    <div class="mb-3">
                        <label class="form-label fw-6" for="new-password">New Password</label>
                        <input type="password" id="new-password" name="new_password" required minlength="8" class="form-control mt-2" placeholder="At least 8 characters">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-6" for="new-password-confirm">Re-type New Password</label>
                        <input type="password" id="new-password-confirm" name="new_password_confirmation" required minlength="8" class="form-control mt-2" placeholder="Re-type new password">
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">Change Password</button>
                </div>
            </form>
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

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('js/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('js/carousel.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
</body>

</html>
