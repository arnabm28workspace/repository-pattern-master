<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login - {{ $site_name }}</title>
    <meta name="description" content="">
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/9f69eaf4a1.js" crossorigin="anonymous"></script>
    <!-- Owl Carousel -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Righteous&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:300m400,500,600,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/basic.css" rel="stylesheet" type="text/css" />
    <link rel='stylesheet' href="{{ asset('frontend/css/main.css')}}"/>
</head>
<!-- Header -->
<nav class="navbar navbar-expand-lg">
    <a class="navbar-brand px-4" href="{{URL::to('/')}}">Viggaro</a> 
    <div class="navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            @if (Auth::check())
                @if (Route::currentRouteName() == 'user.post.ad')
                <li class=""><a class="btn btn--xs" href="{{URL::to('profile')}}">My Account</a></li>
                @else
                <li class=""><a class="btn btn--xs" href="{{URL::to('post-ads')}}">Post ad</a></li>
                @endif
                <li class="px-lg-4 py-lg-2 mr-lg-3 logout"><a class="btn btn--xs" href="{{route('user.logout')}}">Logout<i class="fas fa-power-off" style="font-size: 12px;margin: 0 0 0 5px;" aria-hidden="true"></i></a></li>
            @else
                <li class="px-lg-4 py-lg-2 mr-lg-3"><a href="{{URL::to('profile')}}">Login / Register</a></li>
            @endif
        </ul>
    </div>
</nav>
<section class="login__hero" style="background-image:url({!!asset('frontend/images/login-hero_lg.jpg')!!});"> 
        <div class="login__container">
            <div class="row">
                <div class="col-12 col-lg-6 login__register-form js-register-form">
                    <p class="text-sml text-orange text-center font-weight-semibold">Don’t have an account yet?</p>
                    <h4 class="text-center text-black font-weight-bold pb-5 text-capitalize">Create an Account</h4>
                    <form id="signupForm" action="{{ route('register') }}" method="POST" role="form">
                        @if(session()->has('message'))
                            <div class="alert alert-success">
                                {{ session()->get('message') }}
                            </div>
                        @endif
                        @if(session()->has('error'))
                            <div class="alert alert-danger">
                                {{ session()->get('error') }}
                            </div>
                        @endif
                        @csrf
                        <div class="form-group">
                            <label for="register_email" class="text-black mb-0">E-Mail Address</label>
                            <input type="email" class="form-control @error('register_email') is-invalid @enderror rounded-md" name="register_email" id="email" value="{{ old('register_email') }}">
                            @error('register_email')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="register_password" class="text-black mb-0">Password</label>
                            <input type="password" class="form-control @error('register_password') is-invalid @enderror rounded-md" name="register_password" id="register_password">
                            @error('register_password')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group pt-3 mb-0">
                            <label class="check-container">I agree to <a href="{{URL::to('terms-and-conditions')}}">Terms and Conditions</a>
                                <input type="checkbox" id="agree" name="agree" value="agree">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <div class="form-group mb-0">
                            <label class="check-container">I have read and accept <a href="{{URL::to('privacy-policy')}}"> Privacy Policy</a>
                                <input type="checkbox" id="agree1" name="agree1" value="agree">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <div class="form-group"> 
                            <input type="submit" class="mt-5" name="signup" value="Register"> 
                        </div>
<!--                        <small class="text-muted">By clicking the 'Sign Up' button, you confirm that you accept our <br> Terms of use and Privacy Policy.</small>-->
                    </form>
                </div>
                <div class="col-12 col-lg-6 login__login-form js-login-form">
                    <h4 class="text-center text-light font-weight-bold pb-5 text-capitalize">Login</h4>
                    <form id="loginForm" method="post" action="{{ route('login') }}">
                        @if(session()->has('success'))
                            <div class="alert alert-success">
                                {{ session()->get('success') }}
                            </div>
                        @endif
                        @if(session()->has('verify_error'))
                            <div class="alert alert-danger">
                                {{ session()->get('verify_error') }}
                            </div>
                        @endif
                        @csrf
                        <div class="form-group">
                            <label class="text-light mb-0 font-weight-bold">Email address</label>
                            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror  rounded-md border-0" value="{{ old('email') }}">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="text-light mb-0 font-weight-bold">Password</label>
                            <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror rounded-md border-0">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group"> 
                            <input type="submit" class="mt-5" value="Log In">
                            <a class="btn-link forgot-passwor-link" href="{{ route('password.request') }}">Forgot Your Password?</a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="text-center d-lg-none mt-5">
                <p class="options-links mb-5">OR</p>
                <a href="" class="btn btn--md w-100 btn--primary js-show-login">Log in</a>
                <a href="" class="btn btn--md w-100 btn--primary js-show-register">Register</a>
            </div>
        </div> 
</section>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script src="{{ asset('frontend/js/main.js')}}"></script>
</body>
</html>
