@extends('site.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
<section class="page_intro">
</section>
<section class="container admin-panel mt-4 xs-top-spc">
	<div class="admin-panel__bar mt-4">
        <h4 class="text-white">My Profile</h4>
	</div>
	<div class="admin-panel__body">
		<div class="row">
			
			<div class="col-xl-12">
				@include('site.partials.flash')
				<form class="label-bold" action="{{route('user.updateprofile')}}" method="post">
					@csrf
					<div class="row px-4 px-md-5 pt-5 pb-3">
						<div class="col-12 py-2 form-field">
							<label><strong>Company Name</strong></label>
							<input type="text" name="company_name" value="{{ !empty($currentUserProfile['company_name'])?$currentUserProfile['company_name']:'' }}">
						</div>
						<div class="col-12 py-2 form-field">
							<label><strong>Company Registration Number</strong></label>
							<input type="text" name="company_registration_number" value="{{ !empty($currentUserProfile['company_registration_number'])?$currentUserProfile['company_registration_number']:''}}">
						</div>
						<div class="col-12 py-2 form-field">
							<label><strong>Company VAT Number</strong></label>
							<input type="text" name="company_vat_number" value="{{ !empty($currentUserProfile['company_vat_number'])?$currentUserProfile['company_vat_number']:''}}">
						</div>
						<div class="col-12 py-2 form-field">
							<label><strong>Post Code</strong></label>
							<input type="text" name="post_code" value="{{ !empty($currentUserProfile['post_code'])?$currentUserProfile['post_code']:'' }}">
						</div>
						<div class="col-12 py-2 form-field">
							<label><strong>Phone Number</strong></label>
							<input type="text" name="phone_number" value="{{ !empty($currentUserProfile['phone_number'])?$currentUserProfile['phone_number']:'' }}">
						</div>
						<div class="col-12 py-2 form-field">
							<label><strong>Email Address</strong></label>
							<input type="text" value="{{ !empty($user_email)?$user_email:'' }}" readonly>
						</div>
						<div class="col-12 py-2 form-field">
							<label><strong>Contact Name</strong></label>
							<input type="text" name="contact_name" value="{{ !empty($user_name)?$user_name:'' }}">
						</div>
						<div class="col-12 py-2 form-field">
							<label><strong>Website URL</strong></label>
							<input type="text" name="website_url" value="{{ !empty($currentUserProfile['website_url'])?$currentUserProfile['website_url']:'' }}">
						</div>
						<div class="col-12 py-2 mt-4">
							<label style="width:100%" class=" mw-100 check-container">I wish to receive newsletters from Viggaro</a>
								<input type="checkbox" name="notification_newsletter" {{ !empty($currentUserProfile['notification_newsletter'])?($currentUserProfile['notification_newsletter'] == 1 ? 'checked' : ''):'' }}>
								<span class="checkmark"></span>
							</label>
						</div>
						<div class="col-12 py-2">
							<label style="width:100%" class="mw-100 check-container">I wish to receive the Repost Notification email</a>
								<input type="checkbox" name="notification_repost" {{ !empty($currentUserProfile['notification_repost'])?($currentUserProfile['notification_repost'] == 1 ? 'checked' : ''):'' }}>
								<span class="checkmark"></span>
							</label>
						</div>
						<div class="col">
							<input class="mt-0 mt-md-5 mb-3" type="submit" value="Save">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
@endsection