<div class="col-xl-3 pr-0">
	<ul class="c-admin-navigation">
<!--		<li class="{{ Route::currentRouteName() == 'user.profile' ? 'active' : '' }}"><a href="{{URL::to('profile')}}"><i class="fal fa-user"></i>Details</a></li>-->
		<li class="{{ Route::currentRouteName() == 'user.myads' ? 'active' : '' }}"><a href="{{URL::to('my-ads')}}"><i class="fal fa-pencil"></i>Ads</a>
		    <!-- <ul class="listing-sub">
		        <li class="{{-- Request::segment(2) == 'live' ? 'active-sub' : '' --}}"><a href="{{URL::to('my-ads/live')}}"><i class="fas fa-circle active-ad"></i>Live</a></li>
		        <li class="{{-- Request::segment(2) == 'expired' ? 'active-sub' : '' --}}"><a href="{{URL::to('my-ads/expired')}}"><i class="fas fa-circle expired-ad"></i>Expired</a></li>
		    </ul> -->
		</li>
		<li class="{{ Route::currentRouteName() == 'user.mymessages' ? 'active' : '' }}"><a href="{{URL::to('messages')}}"><i class="fal fa-envelope"></i>Messages<!-- (<span id="count_unread_messages">{{$count_unread_messages}}</span>) --></a></li>
		<li class="{{ Route::currentRouteName() == 'user.payments' ? 'active' : '' }}"><a href="{{URL::to('payments')}}"><i class="fal fa-money-bill"></i>Payments</a></li>

	</ul>
</div>