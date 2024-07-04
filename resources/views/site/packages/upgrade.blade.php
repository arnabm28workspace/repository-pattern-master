@extends('site.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
<section class="page_intro">
</section>
<section class="container admin-panel mt-4 xs-top-spc">
  <div class="admin-panel__bar mt-4">
	  <h4 class="text-white">Upgrade</h4>
  </div>
  @include('site.partials.flash')  
	<!--New payment start-->
   <div class="admin-panel__body1 mt-4">
	  <span id="span_ad_id" style="display: none;">{{$ad_id}}</span>
	  <span id="type" style="display: none;">{{$type}}</span>
	  <span id="last_package_price" style="display: none;">{{$last_package_price}}</span>
	  <span id="last_package_id" style="display: none;">{{$last_package_id}}</span>
		<div class="row">
		<div class="col-lg-8">
			<div class="mt-4">
			    @include('site.ads.navbar')
			</div>
			<div class="row mt-4 mt-md-5">
			  @php $pos=0; @endphp
			  @foreach ($packages as $package)
			  @if($package->package_type=='basic_package')
			  <div class="col-lg-6 mb-5 mb-md-0">
				<div class="card">
                  <div class="profile_new_chk"></div>
				  <div class="card-body shadow-bx">
					<div class="row">
					   <div class="col-md-12 align-self-center">
							<img src="{{ asset('storage/'.$package->image) }}" class="rounded mx-auto d-block" alt="...">
						</div>
						<div class="col-md-12">
							<div class="card-inner pr-3 pl-3">
								<h3 class="text-uppercase text-center mt-5 mb-4">{{$package->name}}</h3>
								<div class="text-desc text-center">
								{!!$package->description!!}
								</div>
								<div class="package text-center mt-5">
									<span class="package-txt d-block"><strong>Package Cost</strong></span>
									@if($last_package_price>0 && $last_package_id==$package->id)
									<span class="package-price d-block font-bt price-span-{{$package->id}}">£{{$last_package_price}}</span>
									@else
									<span class="package-price d-block font-bt price-span-{{$package->id}}">£{{ !empty($package->package_duration_price[0]->price)?$package->package_duration_price[0]->price:0 }}</span>
									@endif
								</div>
								<div class="row">
                                    <div class="col-4">
                                       <div class="duration text-center mt-4">
                                        <div class="form-group">
                                           <div class="s-select">
                                            <select class="sel-basic-pack" id="sel-pack-{{$package->id}}">
                                             @foreach($package->package_duration_price as $price)
                                              <option value="{{$price->price}}" duration="{{$price->duration}}" package-id="{{$package->id}}" @if($last_package_id==$package->id && $last_package_price==$price->price) {{"selected"}} @endif >{{$price->duration}} Days</option>
                                              @endforeach
                                            </select>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="col-8">
                                        <div class="form-bx select-feature text-center">
                                          <input type="checkbox" id="chk-lbl-{{$package->id}}" class="package-chk" value="{{$package->id}}" @if($last_package_id==$package->id) {{"checked"}} @endif pack-name="{{$package->name}}" pack-img="{{ asset('storage/'.$package->image) }}" pack-desc="{!!$package->description!!}">
								          <label for="chk-lbl-{{$package->id}}"><i>Select this package</i></label>
                                        </div>
                                    </div>
                                </div>
							</div>
						</div>
					</div>
				  </div>
				</div>
			  </div>
			  @endif
				@php $pos++; @endphp
			  @endforeach
			</div>
			<div class="mt-lg-5 mb-4">
			   <h3>ADD ONS</h3>
			</div>
			@php $pos=0; @endphp
		@foreach ($packages as $package)
		@if($package->package_type=='add_on')
		@php $pos++; @endphp
		<div class="row">
            <div class="col-12">
                <div class="card {{ $pos%2 == 0 ? 'even':'' }} adverts_single mb-4 rounded-0">
                
                    <div class="row">
                        <div class="col-lg-3 adv-image">
                             <div style="background-image:url('{{ asset('storage/'.$package->image) }}');" class="adv-image-full">
<!--                                <img src="{{ asset('storage/'.$package->image) }}" alt="" class="addone-img"> -->
                             </div>
                            
                        </div>
                        <div class="col-lg-9 pt-3 pb-3">
                           <div class="addone-cont">
                            <div class="row">
                                <div class="col-8"><h3 class="text-uppercase">{{$package->name}}</h3></div>
                                <div class="col-4">
                                     <div class="form-bx-adone text-left float-right mr-3 mt-2">
                                      <input type="checkbox" id="chk-add-on-lbl-{{$package->id}}" class="add-on-chk" value="{{$package->id}}" add-on-name="{{$package->name}}" add-on-img="{{ asset('storage/'.$package->image) }}" add-on-desc="{!!$package->description!!}">
									  <label for="chk-add-on-lbl-{{$package->id}}"><i>Select</i></label>
                                     </div>
                                </div>
                            </div>
                            
                            <div class="addone-desc">{!!$package->description!!}</div>
                            
                            <div class="package pt-4">
                                <div class="package-txt d-block">
                                Package Cost: <span class="package-price add-on-price-span-{{$package->id}}"> £{{ !empty($package->package_duration_price[0]->price)?$package->package_duration_price[0]->price:0 }}</span>
                                   <div class="adone-duration pt-3">
                                       <span>Duration:</span>
                                       <div class="s-select adone-select">
                                            <select class="duration-select sel-add-on-pack" id="add-on-pack-{{$package->id}}">
                                              @foreach($package->package_duration_price as $price)
                                              <option value="{{$price->price}}" add-on-duration="{{$price->duration}}" add-on-id="{{$package->id}}">{{$price->duration}} Days</option>
                                              @endforeach
                                            </select>
                                        </div>
                                    </div>
<!--
                                    <div class="form-bx text-left float-right mr-3 mt-2">
                                      <input type="checkbox" id="bta-{{$package->id}}" class="add-on-chk" value="{{$package->id}}" add-on-name="{{$package->name}}" add-on-img="{{ asset('storage/'.$package->image) }}" add-on-desc="{!!$package->description!!}">
                                      <label for="bta-{{$package->id}}"><i>Select this package</i></label>
                                    
                                    </div>
-->
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
		    </div>
        </div>
		@endif
		  @endforeach
		</div>
			<div class="col-lg-4 mt-5">
			   <!--single row-->
			   <div id="added-package-show">
				 
			   </div>
			   
			   <!--grandtotal-->
			   <div class="col-sm-12 grandtotal pb-3">
				   <div class="row mt-4">
					   <div class="col-6"><strong>Grand Total</strong></div>
					   <div class="col-6 text-right" id="grand-total"><strong>£0</strong></div>
				   </div>
			   </div>
			   <!--Checkout-->
			   <div class="checkout-btn mt-2 pb-3">
				   <button type="button" class="btn btn-primary btn-block border-none" id="payment_btn">Checkout</button>
			   </div>
			</div>
		</div>
	   
	</div>
	<div class="mt-0 mt-md-5 pt-5"></div>
		@if($setting_option_payment == 1)
		  @include('site.packages.upgradepayment')
		@endif
  <!--New payment start end-->
</section>

<script>
/* $(document).on('click', '.form-bx label', function (e) {
  var value = $('.form-bx input').is(':checked');

  if (value ==false) {
	$(this).html("<input type='checkbox'><i>Selected</i>");
  } else {

	$(this).html("<input type='checkbox' ><i>Select this package</i>");
  }


}); */


</script>

@endsection
@push('scripts')
<script type="text/javascript" src="{{ asset('frontend/js/upgrade.js') }}"></script>
<script type="text/javascript">
	<?php
		if($setting_option_payment == 0)
		{
	?>
			$("#payment_btn"). attr('disabled', true);
			/* $(document).on('click','#payment_btn',function(){
				alert("Currently the payment mode is disabled! Please try again later");
			}); */
	<?php	
		}
	?>
</script>
@endpush
