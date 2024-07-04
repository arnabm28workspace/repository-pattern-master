@extends('site.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
<section class="page_intro">
</section>
<section class="container admin-panel mt-4 xs-top-spc">
	<div class="admin-panel__bar mt-4">
			<h4 class="text-white">My Account</h4>
	</div>
	@if(session()->has('success-message'))
	    <div class="alert alert-success">
	        {{ session()->get('success-message') }}
	    </div>
	@endif
	@if(session()->has('error-message'))
	    <div class="alert alert-danger">
	        {{ session()->get('error-message') }}
	    </div>
	@endif
	<div class="admin-panel__body">
		<div class="row">
			@include('site.partials.sidebar')
			<div class="col-xl-9 admin-panel__content">
                <!--top value bar-->
                @include('site.profile.navbar')
                <!--top value bar end-->
        		<div class="container">
                    <div class="row pr-15 mt-5"></div>
                   <!--single row-->
                    @foreach($ads as $ad)
                    <div class="mt-1">
                        <div class="row pr-15">
                            <div class="col my-ad-card">
                                <div class="col-12 single-ad mb-5">
                                 <div class="row">
                                     <div style="background-image:url('{{ asset('storage/'.$ad->images[0]->getResizeImage('medium')) }}');" class="col-md-4 ad-list-img">
                                     </div>
                                     <div class="col-md-8">
                                         <div class="card-body">
                                            <div class="row mb-3">
                                                <div class="col-6">
                                                    <div class="ad-statusbx">
                                                        <i class="fas fa-circle draft-ad"></i> Draft
                                                    </div>
                                                </div>
                                            </div>
                                            <h4 class="pb-2">
                                            @php 
                                                $title = (strlen($ad->title)>33)? substr(strip_tags($ad->title),0,33)."...": $ad->title;
                                                echo $title;
                                            @endphp </h4>
                                            
                                            <div class="row ad-price row-view mb-3 blk-pkj">
                                                <div class="col">
                                                    <strong>End:</strong> NA
                                                    <i class="fas fa-circle ad-ico" aria-hidden="true"></i>
                                                    <strong>Price:</strong> -
                                                </div>
                                            </div>
                                            <!-- <p class="card-text">{{substr(strip_tags($ad->description),0,150)}}.</p> -->
                                            <div class="blk-pkj">
                                                <div class="row ad-price row-view mb-5">
                                                    <div class="col">
                                                        <strong>Packages:</strong> Not Choosen Yet
                                                    </div>
                                                </div> 
                                            </div>
                                            
                                            <div class="ed-pv">
                                                <a href="{!! URL::to('edit-ads/'.$ad->slug) !!}" class="edit-ad">Edit</a>
                                                <a href="{!! URL::to('preview/'.$ad->slug) !!}" class="preview-ad" target="_blank">Preview</a>
                                                <form action="{{ route('makepayment') }}" method="post" id="checkout-form-{{$ad->id}}" style="display: none;">
                                                    @csrf
                                                    <input type="hidden" name="ad_id" value="{{$ad->id}}">
                                                </form>
                                                <a href="javascript:void(0);" class="checkout draft-payment-ad" ad-id="{{$ad->id}}">Make Payment</a>
                                            </div>
                                          </div>
                                     </div>
                                 </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                  <!---->
                </div>
			</div>
			
		</div>
		
	</div>
</section>
@endsection
@push('styles')
<style>
.ad-status{
    width: 20px;
    height: 20px;
    display: inline-block;
    vertical-align: middle;
    margin: 0 10px 0 9px;
}
.live{
	background: #1cd810;
}
.expired{
	background: #d81910;
}
</style>
@endpush
@push('scripts')
<script type="text/javascript">
    $('.checkout').on('click', function(){
        var val = $(this).attr('ad-id');
        $('#checkout-form-'+val).submit();
    });
</script>
@endpush