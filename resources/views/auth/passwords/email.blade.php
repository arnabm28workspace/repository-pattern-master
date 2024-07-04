@extends('site.app')
@section('title', 'Forgot Password')
@section('content')
<section class="login__hero login__hero--password"> 
    <div class="login__container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8 login__forgot-password">
                <h4 class="text-center text-white font-weight-bold pb-5 text-capitalize">Forgot Password</h4>
                @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
                @endif
                <form id="loginForm" role="form" method="POST" action="{{ route('password.email') }}">
                    @csrf
                    
                    <div class="form-group">
                        <label class="control-label" for="email">Email Address</label>
                        <input class="form-control" type="email" id="email" name="email" placeholder="Email address" autofocus value="{{ old('email') }}" required>
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                    <button type="submit">Send Password Reset Link</button>
                    </div>
                </form>
            </div>
        </div>
    </div> 
</section>
@endsection