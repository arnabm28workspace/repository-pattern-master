@extends('site.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
<section class="page_intro">
</section>
<section class="container admin-panel mt-4 xs-top-spc">
	<div class="admin-panel__bar mt-4">
			<h4 class="text-white">My Account</h4>
	</div>
	<div class="admin-panel__body">
		<div class="row">
			@include('site.partials.sidebar')
			<div class="col-md-12 col-xl-9 admin-panel__content">
	            <table class="table table-hover custom-data-table-style table-striped" id="sampleTable_msg">
	                <thead>
	                <tr>
	                    <th>Ad Title</th>
                        <th class="align-center"> Amount </th>
                        <th> Paid On </th>
                        <th>View</th>
	                </tr>
	                </thead>
	                <tbody>
	                    @foreach($payments as $payment)
						@php
						$total = collect($payment)->sum(function($payment) {
							return $payment->amount;
						})
						@endphp
	                        <tr>
	                            <td>{{ !empty($payment[0]->ad->title) ? $payment[0]->ad->title : '' }}</td>
	                            <td><span>{{ \App\Models\Setting::get('currency_symbol') }}</span>{{ $total }}</td>
	                            <td>{{ Carbon\Carbon::parse($payment[0]->paid_on)->format('m-d-Y h:i A')  }}</td>
	                            <td>
	                                <a href="javascript:void(0)" data-divid="paymentDetails{{$payment[0]->id}}" class="btn btn-sm btn-primary edit-btn msgdiv"><i class="fa fa-eye"></i></a>
	                            </td>
	                        </tr>
	                    @endforeach
	                </tbody>
	            </table>
			    @foreach($payments as $key => $payment)
				@php
				$total = collect($payment)->sum(function($payment) {
					return $payment->amount;
				})
				@endphp
			    <div class="" id="paymentDetails{{$payment[0]->id}}" style="display:none">   
					<div class="row" role="document">
						<div class="container">
							<div class="col-12 my-5">
								<div class="row">
									<div class="col-8">
										<h3>
										{{ !empty($payment[0]->ad->title) ? $payment[0]->ad->title : '' }}
										</h3>
									</div>
									<div class="col-4 text-right">
										<a href="javascript:void(0)" class="close_div back-msg" data-close_div="paymentDetails{{$payment[0]->id}}">
										<i class="fas fa-chevron-left"></i>Back
										</a>
									</div>
								</div>
								<div class="row">
									<div class="col-12">
										<div class="sender-details mt-3 mb-4">
											<strong>Ad Id:</strong> {{ $payment[0]->ad->unique_id }}
											<i class="bullet-circle"></i>
											<strong>Total:</strong> {{ \App\Models\Setting::get('currency_symbol').$total }}
										</div>
										<div class="sender-msg pb-0 pb-md-4 pr-0 pr-md-4">
											<table style="border:1px solid #b7b7b7;" class="table payment-table table-hover responsive custom-data-table-style table-striped table-col-width" id="sampleTable">
												<thead>
													<tr>
														<th><strong>Package(s)</strong></th>
														<th><strong>Amount</strong></th>
														<th><strong>Paid On</strong></th>
													</tr>
												</thead>
												<tbody>
												<?php
													foreach ($payment as $ad_payment) {
												?>
													<tr>
														<?php
														$payment_info = json_decode($ad_payment->payment_info);
														$package_array = array();
														foreach ($payment_info as $key => $value) {
															if($key == "basic_package")
															{
																$basic_package = empty($value->package_name)? null:$value->package_name;
																if(!empty($basic_package))
																{
																array_push($package_array, $basic_package);  
																}
																
															}else if($key == "add_ons")
															{
																if(!empty($value))
																{
																	foreach ($value as $add_on) {
																	array_push($package_array, $add_on->package_name);
																	}
																}
															}
														}
														$package_name = implode(", ",$package_array);
														?>
														<td>{{$package_name}}</td>
														<td><span>{{ \App\Models\Setting::get('currency_symbol') }}</span>{{$ad_payment->amount}}</td>
														<td>{{ Carbon\Carbon::parse($ad_payment->paid_on)->format('m-d-Y h:i A') }}</td>
													</tr>
													<?php
													}
													?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			    @endforeach        
			</div>
		</div>
	</div>
</section>
@endsection

@push('scripts')
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css">
    <script type="text/javascript" src="{{ asset('backend/js/plugins/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/js/plugins/dataTables.bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script type="text/javascript">
    	$('#sampleTable_msg').DataTable({
    		"ordering": false,
            "responsive": true,
			"columnDefs": [
				{ "responsivePriority": 1, "targets": 0 },
				{ "responsivePriority": 2, "targets": -1 }
			]
    	});
    	   	$('#sampleTable_msg').on( 'click', '.msgdiv', function () {
    	   	 		
    	   	 		var div_name = $(this).data('divid');
    	   	 		console.log(div_name);
    	   	 			$('#sampleTable_msg_wrapper').hide();
    	                   $("#"+div_name).show();
    	   	     	
    	   	    } );
    	   	$(document).on('click','.close_div',function(){
    	   		var close_div_name = $(this).data('close_div');
    				$('#sampleTable_msg_wrapper').show();
    	           $("#"+close_div_name).hide();
    	   	});
    	
	</script>
@endpush
