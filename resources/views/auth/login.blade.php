<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login | GXON HR Management</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Optional: Fonts & Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
</head>

<body data-bs-theme="dark">
    <div class="page-layout">
        <div class="auth-cover-wrapper">
            <div class="row g-0">

                <!-- Left Cover -->
                <div class="col-lg-6">
                    <div class="auth-cover" style="background-image: url({{ asset('assets/images/auth/auth-cover-bg.png') }});">
                        <div class="clearfix">
                            <img src="{{ asset('assets/images/auth/auth.png') }}" alt="" class="img-fluid cover-img ms-5">
                            <div class="auth-content">
                                <h1 class="display-6 fw-bold">Welcome Back!</h1>
                                <p>Login to access your admin dashboard and manage your HR operations efficiently.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Form -->
                <div class="col-lg-6 align-self-center">
                    <div class="p-3 p-sm-5 maxw-450px m-auto auth-inner" data-simplebar>

                        <div class="mb-4 text-center">
                            <a href="{{ url('/') }}">
                                <img class="visible-light" src="{{ asset('assets/images/logo-full.svg') }}" alt="GXON logo">
                                <img class="visible-dark" src="{{ asset('assets/images/logo-full-white.svg') }}" alt="GXON logo">
                            </a>
                        </div>

                        <div class="text-center mb-5">
                            <h5 class="mb-1">Welcome Back</h5>
                            <p>Sign in to your account</p>
                        </div>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        {{-- Email --}}
                        <div class="mb-4">
                            <label class="form-label" for="email">{{ __('Email') }}</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}"
                                   class="form-control @error('email') is-invalid @enderror"
                                   required autofocus autocomplete="username">
                            @error('email')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        {{-- Password --}}
                        <div class="mb-4">
                            <label class="form-label" for="password">{{ __('Password') }}</label>
                            <input id="password" type="password" name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   required autocomplete="current-password">
                            @error('password')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        {{-- Remember Me --}}
                        <div class="mb-4 form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                            <label class="form-check-label" for="remember">{{ __('Remember Me') }}</label>
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary waves-effect waves-light w-100">
                                {{ __('Login') }}
                            </button>
                        </div>

                        <p class="mb-5 text-center">
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}">{{ __('Forgot your password?') }}</a>
                            @endif
                        </p>
                        <p class="mb-3 text-center">
                            {{ __("Don't have an account?") }}
                            <a href="{{ route('register') }}">
                                {{ __('Register here') }}
                            </a>
                        </p>

                    </form>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
