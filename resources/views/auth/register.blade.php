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
    <link rel="stylesheet" type="text/css" href="{{ asset('css/styles.css') }}">

    <!-- Favicon and Touch Icons  -->
    <link rel="shortcut icon" href="{{ asset('images/logo/40.png') }}">
    <link rel="apple-touch-icon-precomposed" href="{{ asset('images/logo/40.png') }}">

    <title>EasyPay - Sign Up</title>
</head>

<body>
    <div class="tf-container">
        <form action="{{ route('register.submit') }}" method="POST" class="form-login form-sign-up">
            @csrf
            <div class="top-form mb-32">
                <div class="header-form mb-32">
                    <h4 class="title mb-8 fw-8">
                        Create a your Account
                    </h4>
                    <p class="sub-title">
                        You can easily sign up, explore and share your wallet with <span class="color-green fw-8">100M</span> User
                    </p>
                </div>
                <div class="groud-input">
                    <fieldset class="mb-16 icon-absolute">
                        <i class="icon-user"></i>
                        <input type="text" name="name" placeholder="Full Name" value="{{ old('name') }}">
                        @if(
                            $errors->has('name')
                        )
                            <div class="text-danger">{{ $errors->first('name') }}</div>
                        @endif
                    </fieldset>

                    <fieldset class="mb-16 icon-absolute">
                        <i class="icon-mail"></i>
                        <input type="email" name="email" placeholder="Email" value="{{ old('email') }}">
                        @if($errors->has('email'))
                            <div class="text-danger">{{ $errors->first('email') }}</div>
                        @endif
                    </fieldset>

                    <fieldset class="box-auth-pass icon-absolute mb-24">
                        <i class="icon-lock"></i>
                        <input type="password" name="password" placeholder="Password" class="password-field1 tf-input">
                        @if($errors->has('password'))
                            <div class="text-danger">{{ $errors->first('password') }}</div>
                        @endif
                        <span class="show-pass1 show-pass">
                            <span class="icon-eye"></span>
                            <span class="icon-eye-off"></span>
                        </span>
                    </fieldset>

                    <button type="submit" class="tf-btn w-100 mb-24">Sign Up</button>
                </div>
            </div>

            <div class="bottom-form">
                <p class="text color-greyscale-400 text-center mb-24">
                    Or continue with social account
                </p>
                <div class="grid-2 g-16 mb-32">
                    <a href="{{ url('/') }}" class="tf-btn style-border border-greyscale-200 btn-login-app fw-6">
                        <span class="icon">
                            <img src="{{ asset('images/icon/gg.svg') }}" alt="Google">
                        </span>
                        Google
                    </a>
                    <a href="{{ url('/') }}" class="tf-btn style-border border-greyscale-200 btn-login-app fw-6">
                        <span class="icon">
                            <img src="{{ asset('images/icon/fb.svg') }}" alt="Facebook">
                        </span>
                        Facebook
                    </a>
                </div>
                <p class="color-greyscale-400 text-center">Already have an account? <a href="{{ url('/login') }}" class="fw-6 color-green">Sign In</a></p>
            </div>
        </form>
    </div>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/count-down.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
</body>

</html>
