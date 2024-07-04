<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/main.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/font-awesome/4.7.0/css/font-awesome.min.css') }}"/>
    <title>Install - {{ config('app.name') }}</title>
</head>
<body>
<section class="container">
    <div class="row section-mg row-md-body">
        <div class="col-12 text-center">
            <div class="logo navbar-brand px-4">
                <h1>{{ config('app.name') }}</h1>
            </div>
            <p>Please fill up the following details to become an admin</p>
        </div>
    </div>
    <div class="row">
    <div class="col-md-8 mx-auto">
    @if($total_admin)
        <strong>Super Admin already created go to <a href="{{route('admin.login')}}">Login Page</a> </strong>
    @else
    <div class="tile">
        <form action="{{ route('admin.install.post') }}" method="POST" role="form">
            @csrf
            <div class="tile-body form-body">
                <div class="form-group">
                    <label class="control-label" for="email">Email Address</label>
                    <input class="form-control" type="email" id="email" name="email" placeholder="Email address" autofocus value="{{ old('email') }}">
                </div>
                <div class="form-group">
                    <label class="control-label" for="name">Name</label>
                    <input class="form-control" type="text" id="name" name="name" placeholder="Name" autofocus value="{{ old('name') }}">
                </div>
                <div class="form-group">
                    <label class="control-label" for="password">Password</label>
                    <input class="form-control" type="password" id="password" name="password" placeholder="Password">
                </div>
                <div class="form-group">
                    <label class="control-label" for="name">Site Name</label>
                    <input class="form-control" type="text" id="site_name" name="site_name" placeholder="e.g. Viggaro" autofocus value="{{ old('site_name') }}">
                </div>
                <div class="form-group">
                    <label class="control-label" for="name">Site Title</label>
                    <input class="form-control" type="text" id="site_title" name="site_title" placeholder="e.g. Viggaro Classified" autofocus value="{{ old('site_title') }}">
                </div>
                <div class="form-group">
                    <label class="control-label" for="currency_code">Currency Code</label>
                    <input class="form-control" type="text" id="currency_code" name="currency_code" placeholder="e.g. GBP" autofocus value="{{ old('currency_code') }}">
                </div>
                <div class="form-group">
                    <label class="control-label" for="currency_symbol">Currency Symbol</label>
                    <input class="form-control" type="text" id="currency_symbol" name="currency_symbol" placeholder="e.g. £" autofocus value="{{ old('currency_symbol') }}">
                </div>
                <div class="form-group btn-container">
                    <button class="btn btn-primary" type="submit"><i class="fa fa-sign-in fa-lg fa-fw"></i>SAVE</button>
                </div>
            </div>
        </form>
    </div>
    @endif
    </div>
    </div>
</section>
<script src="{{ asset('backend/js/jquery-3.2.1.min.js') }}"></script>
<script src="{{ asset('backend/js/popper.min.js') }}"></script>
<script src="{{ asset('backend/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('backend/js/main.js') }}"></script>
<script src="{{ asset('backend/js/plugins/pace.min.js') }}"></script>
</body>
</html>