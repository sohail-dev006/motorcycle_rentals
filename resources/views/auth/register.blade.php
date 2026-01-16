<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Register | GXON HR Management</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Optional: Fonts & Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    
    <!-- Custom CSS (your GXON template styles) -->
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
                                <p>Our HR Management & Administration ensures your organization runs smoothly.</p>
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
                            <h5 class="mb-1">Welcome to GXON</h5>
                            <p>Sign up to create your secure admin account.</p>
                        </div>

                        <!-- Registration Form -->
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <!-- Name -->
                            <div class="mb-4">
                                <label class="form-label" for="name">{{ __('Name') }}</label>
                                <input id="name" type="text" name="name" value="{{ old('name') }}"
                                       class="form-control @error('name') is-invalid @enderror"
                                       required autofocus autocomplete="name">
                                @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>

                            <!-- Email -->
                            <div class="mb-4">
                                <label class="form-label" for="email">{{ __('Email') }}</label>
                                <input id="email" type="email" name="email" value="{{ old('email') }}"
                                       class="form-control @error('email') is-invalid @enderror"
                                       required autocomplete="username">
                                @error('email')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-4">
                                <label class="form-label" for="password">{{ __('Password') }}</label>
                                <input id="password" type="password" name="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       required autocomplete="new-password">
                                @error('password')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-4">
                                <label class="form-label" for="password_confirmation">{{ __('Confirm Password') }}</label>
                                <input id="password_confirmation" type="password" name="password_confirmation"
                                       class="form-control @error('password_confirmation') is-invalid @enderror"
                                       required autocomplete="new-password">
                                @error('password_confirmation')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>

                            <!-- Terms Checkbox -->
                            <div class="mb-4">
                                <div class="form-check mb-0">
                                    <input class="form-check-input" type="checkbox" id="termsConditions" name="terms">
                                    <label class="form-check-label" for="termsConditions">
                                        I agree to <a href="#">privacy policy & terms</a>
                                    </label>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary waves-effect waves-light w-100">
                                    {{ __('Register') }}
                                </button>
                            </div>

                            <!-- Already registered -->
                            <p class="mb-5 text-center">
                                {{ __('Already registered?') }} <a href="{{ route('login') }}">Sign in here</a>
                            </p>

                            <!-- Social Login -->
                            <div class="border-bottom position-relative my-3 text-center">
                                <span class="px-3 position-absolute translate-middle top-50 start-50 bg-body">Or Continue With</span>
                            </div>
                            <div class="d-flex gap-2 justify-content-center mt-3">
                                <a href="#" class="btn btn-icon btn-subtle-facebook rounded-circle waves-effect waves-light">
                                    <i class="fa-brands fa-facebook-f"></i>
                                </a>
                                <a href="#" class="btn btn-icon btn-subtle-twitter rounded-circle waves-effect waves-light">
                                    <i class="fa-brands fa-x-twitter"></i>
                                </a>
                                <a href="#" class="btn btn-icon btn-subtle-github rounded-circle waves-effect waves-light">
                                    <i class="fa-brands fa-github"></i>
                                </a>
                            </div>
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
