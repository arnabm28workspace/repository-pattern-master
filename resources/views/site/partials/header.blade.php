<!-- Header -->
<div class="container">
    <div class="row">
        <nav class="navbar navbar-expand-lg">
    <a class="navbar-brand px-4" href="{{URL::to('/')}}">Viggaro</a> 
    <div class="navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
        @if (Auth::check())
            @if (Route::currentRouteName() != 'user.post.ad')
            <li class="post-add-btn"><a class="btn btn--xs" href="{{URL::to('post-ads')}}">Post Ad</a></li>
            @endif
            <li class="logout dropdown">
            <a class="btn btn--xs dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
             {{ Auth::user()->name }}
            </a>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <li>
                    <a class="dropdown-item" href="{{URL::to('my-ads')}}"><i class="fal fa-user" aria-hidden="true"></i>My Account</a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{URL::to('profile')}}"><i class="fal fa-users" aria-hidden="true"></i>Profile</a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{route('user.logout')}}"><i class="fas fa-power-off" aria-hidden="true"></i>Logout</a>
                </li>
            </ul>
    <!--                <a class="btn btn--xs" href="{{route('user.logout')}}">Logout<i class="fas fa-power-off" style="font-size: 12px;margin: 0 0 0 5px;" aria-hidden="true"></i></a>-->
            </li>
        @else
            <li class="px-lg-4 py-lg-2 mr-lg-3"><a href="{{URL::to('profile')}}">Login / Register</a></li>
        @endif
    </ul>
    </div>
    </nav>
    </div>
</div>
<!-- ~./ Header -->