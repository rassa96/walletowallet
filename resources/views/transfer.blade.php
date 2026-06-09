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

    <title>Transfer - EasyPay</title>
</head>

<body>

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
                <a href="{{ url('/') }}" class="tf-btn-arrow back-btn">
                    <i class="icon-icon-arrow-narrow-left-2"></i>
                </a>
                <h5 class="title fw-5">Transfer</h5>
                <div class="d-flex align-items-center g-5">
                    <a href="{{ url('/') }}" class="tf-btn-arrow">
                        <i class="icon-home-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="tf-container">
        <div class="mt-24 pb-100">
            
            @if(session('error'))
                <div class="alert alert-danger mb-16">{{ session('error') }}</div>
            @endif
            
            @if(session('success'))
                <div class="alert alert-success mb-16">{{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger mb-16">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Current Balance -->
            <div class="wg-total-asset-card mb-24">
                <div class="top-card">
                    <div class="text text-small fw-5">Available Balance</div>
                    <div class="price-asset-card h4">
                        <span class="price">${{ $wallet ? number_format($wallet->balance, 2) : '0.00' }}</span>
                    </div>
                </div>
            </div>

            <!-- Transfer Form -->
            <form action="{{ route('wallet.transfer') }}" method="POST">
                @csrf
                
                <!-- Receiver Wallet Address -->
                <div class="mb-24">
                    <label class="text-medium fw-6 mb-8 d-block">Recipient Wallet Address</label>
                    <input type="text" name="receiver_address" 
                        placeholder="Enter wallet address" value="{{ old('receiver_address') }}"
                        class="form-control" style="width:100%; padding:16px; border-radius:12px; border:1px solid #e0e0e0; font-size:16px;" required>
                </div>

                <!-- Amount -->
                <div class="mb-24">
                    <label class="text-medium fw-6 mb-8 d-block">Amount ($)</label>
                    <input type="number" name="amount" step="0.01" min="0.01" 
                        max="{{ $wallet ? $wallet->balance : 0 }}"
                        placeholder="Enter amount" value="{{ old('amount') }}"
                        class="form-control" style="width:100%; padding:16px; border-radius:12px; border:1px solid #e0e0e0; font-size:18px;" required>
                </div>

                <!-- Quick Amount Buttons -->
                <div class="mb-24">
                    <label class="text-medium fw-6 mb-8 d-block">Quick Select</label>
                    <div class="d-flex flex-wrap g-8">
                        <button type="button" class="tf-btn style-2 py-10 style-white quick-amount" data-amount="5">$5</button>
                        <button type="button" class="tf-btn style-2 py-10 style-white quick-amount" data-amount="10">$10</button>
                        <button type="button" class="tf-btn style-2 py-10 style-white quick-amount" data-amount="25">$25</button>
                        <button type="button" class="tf-btn style-2 py-10 style-white quick-amount" data-amount="50">$50</button>
                        <button type="button" class="tf-btn style-2 py-10 style-white quick-amount" data-amount="100">$100</button>
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-24">
                    <label class="text-medium fw-6 mb-8 d-block">Note (optional)</label>
                    <input type="text" name="description" 
                        placeholder="What's this for?" value="{{ old('description') }}"
                        class="form-control" style="width:100%; padding:16px; border-radius:12px; border:1px solid #e0e0e0; font-size:16px;">
                </div>

                <!-- Submit -->
                <button type="submit" class="tf-btn lg" style="width:100%; padding:16px; border-radius:12px; background:#007bff; color:white; border:none; font-size:16px; font-weight:600; cursor:pointer;">
                    Send Transfer
                </button>
            </form>
        </div>
    </div>

    <!-- Bottom Navigation -->
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
            <a href="#" class="inner-bar-item v2">
                <i class="icon-scan"></i>
            </a>
        </div>
        <div class="left inner-bar position-relative">
            <a href="#" class="inner-bar-item">
                <i class="icon-bill"></i>
            </a>
            <a href="{{ route('wallet.dashboard') }}" class="inner-bar-item">
                <i class="icon-profile-circle"></i>
            </a>
        </div>
    </div>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script>
        document.querySelectorAll('.quick-amount').forEach(function(btn) {
            btn.addEventListener('click', function() {
                document.querySelector('input[name="amount"]').value = this.dataset.amount;
            });
        });
    </script>

</body>

</html>
