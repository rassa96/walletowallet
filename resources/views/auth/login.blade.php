<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('fonts/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('icons/icomoon/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <title>Login</title>
</head>
<body>
    <div class="tf-container">
        <form action="{{ route('login.submit') }}" method="POST" class="form-login">
            @csrf
            <div class="top-form mb-32">
                <div class="header-form mb-32">
                    <h4 class="title mb-8 fw-8">Sign In</h4>
                    <p class="sub-title">Welcome back — please sign in to continue</p>
                </div>
                <fieldset class="mb-16 icon-absolute">
                    <i class="icon-mail"></i>
                    <input type="email" name="email" placeholder="Email" value="{{ old('email') }}">
                    @if($errors->has('email'))<div class="text-danger">{{ $errors->first('email') }}</div>@endif
                </fieldset>
                <fieldset class="box-auth-pass icon-absolute mb-24">
                    <i class="icon-lock"></i>
                    <input type="password" name="password" placeholder="Password" class="password-field1 tf-input">
                    @if($errors->has('password'))<div class="text-danger">{{ $errors->first('password') }}</div>@endif
                </fieldset>

                <button type="submit" class="tf-btn w-100 mb-24">Sign In</button>
            </div>
            <p class="color-greyscale-400 text-center">Don't have an account? <a href="{{ route('register') }}">Sign Up</a></p>
        </form>
    </div>
</body>
</html>
