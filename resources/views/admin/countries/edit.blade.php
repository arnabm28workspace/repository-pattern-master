@extends('admin.app')
@push('styles')
	<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/css/bootstrap-theme.min.css"> -->
	<link rel="stylesheet" type="text/css" href="{{ asset('backend/css/bootstrap-tagsinput.css') }}" />
	<!-- <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/amsify.suggestags.css') }}"> -->
	<style>
	/*the container must be positioned relative:*/

	.bootstrap-tagsinput{
		display: block !important;
	}
	.bootstrap-tagsinput .tag {
		margin-right: 2px;
		padding: 2px 7px;
		background: #d8d8d8;
		color: black;
		display: inline-block;
	}
	.is-invalid {
		border-color:#dc3545 !important;
	}
	</style>
@endpush
@section('title') {{ $pageTitle }} @endsection
@section('content')
	<div class="fixed-row">
		<div class="app-title">
			<div class="active-wrap">
				<h1><i class="fa fa-tags"></i> {{ $pageTitle }}</h1>
				<div class="form-group">
		  			<button class="btn btn-primary" type="button" id="btnSave"><i class="fa fa-check-circle"></i>Update Country</button>
					<a class="btn btn-secondary" href="{{ route('admin.country.index') }}"><i style="vertical-align: baseline;" class="fa fa-chevron-left"></i>Back</a>
				</div>
			</div>
		</div>
	</div>
	@include('admin.partials.flash')
	<div class="alert alert-success" id="success-msg" style="display: none;">
		<span id="success-text"></span>
	</div>
	<div class="alert alert-danger" id="error-msg" style="display: none;">
		<span id="error-text"></span>
	</div>
	<div class="row section-mg row-md-body no-nav">
		<div class="col-md-12 mx-auto">
			<div class="tile">
				<form action="{{ route('admin.country.update') }}" method="POST" role="form" id="form1" enctype="multipart/form-data">
					@csrf
					<div class="tile-body form-body">
						<div class="form-group">
							<label class="control-label" for="name">Name <span class="m-l-5 text-danger"> *</span></label>
							<input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name" value="{{ old('name', $targetCountry->name) }}" readonly="readonly" />
							<input type="hidden" name="id" value="{{ $targetCountry->id }}">
							@error('name') {{ $message }} @enderror
						</div>
						<div class="form-group">
							<label class="control-label" for="title">City <span class="m-l-5 text-danger"> *</span></label>
							<input type="text" data-role="tagsinput" id="tags" class="form-control @error('cities') is-invalid @enderror" name="cities" placeholder="Add City">
							@error('cities') {{ $message }} @enderror
						</div>
						<div class="form-group">
							<label class="control-label" for="order">Order</label>
							<input type="text" id="order" class="form-control @error('order') is-invalid @enderror" name="order" value="{{ $targetCountry->order }}">
							@error('order') {{ $message }} @enderror
					  	</div>
						<div class="form-group toogle-lg">
							<label class="control-label">Status</label>
							<div class="toggle-button-cover">
								<div class="button-cover">
									<div class="button-togglr b2" id="button-11">
										<input id="toggle-block" type="checkbox" data-country_id="{{$targetCountry->id}}" name="status" class="checkbox" {{ $targetCountry->status == 1 ? 'checked' : '' }}>
										<div class="knobs"><span>Inactive</span></div>
										<div class="layer"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- <div class="tile-footer">
						<button class="btn btn-primary" type="button" id="btnSave"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update Country</button>
						&nbsp;&nbsp;&nbsp;
						<a class="btn btn-secondary" href="{{ route('admin.country.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
					</div> -->
				</form>
			</div>
		</div>
	</div>
@endsection
@push('scripts')
	<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<script type="text/javascript" src="{{ asset('backend/js/plugins/bootstrap-tagsinput.js') }}"></script>
	<!-- <script type="text/javascript" src="{{ asset('backend/js/plugins/jquery.amsify.suggestags.js') }}"></script> -->
	<script type="text/javascript">

		var countries = [];
		var all_cities = [];
		var cities = [];
		var country_cca2 = '{{$targetCountry->code}}';

		$(document).ready(function(){

			var cities = "<?php echo $cities; ?>";

			$('#tags').tagsinput({
				confirmKeys: [13, 32, 44]
			});
			$('#tags').tagsinput('add',cities);
			
			$("#btnSave").on("click",function(){
				
				if (!$("#tags").val().trim()) {
					$('.bootstrap-tagsinput').addClass('is-invalid');
					$('.bootstrap-tagsinput').next('p').remove();
					$('.bootstrap-tagsinput').after('<p>The cities field is required.</p>');
				} else{
					$('.bootstrap-tagsinput').removeClass('is-invalid');
					$('.bootstrap-tagsinput').next('p').remove();
					$('#form1').submit();
				}
			})
			
		})
	</script>
	
@endpush