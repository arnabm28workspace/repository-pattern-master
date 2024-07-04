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
                    <div class="row pr-15 mt-5">
                        <!--single row-->
                     @php $pos=0; @endphp
                    @foreach($ads as $key=>$ad)
                        @if($key < 2)
                        <div class="col-md-6 mb-5 my-ad-card">
                            <div class="card listing-card">
                            <div style="background-image:url('{{ asset('storage/'.$ad->images[0]->image) }}');" class="add-image-full">
                            </div>
                              <!-- <img class="card-img-top" src="{{-- asset('storage/'.$ad->images[0]->getResizeImage('medium')) --}}" alt="Card image cap"> -->
                              <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <div class="ad-statusbx">
                                            @if (!$ad->expired)
                                            <i class="fas fa-circle active-ad"></i> Live
                                            @else
                                            <i class="fas fa-circle expired-ad"></i> Expired
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-6 text-right">
                                        <span class="total-view d-inline pr-3">
                                            <a href="{{URL::to('messages/')}}/{{$ad->id}}">
                                                <i class="fas fa-envelope" aria-hidden="true"></i> {{ $ad->messages->count() }}
                                            </a>
                                        </span>
                                        <span class="total-view d-inline">
                                        <i class="fal fa-eye" aria-hidden="true"></i> {{$ad->views}}
                                        </span>
                                    </div>
                                </div>
                                <h4 class="pb-2">
                                    @php 
                                    $title = (strlen($ad->title)>33)? substr(strip_tags($ad->title),0,33)."...": $ad->title;
                                    echo $title;
                                    @endphp </h4>
                                <div class="row ad-price row-view mb-3 blk-pkj">
                                    <div class="col">
                                        <strong>End:</strong> {{ Carbon\Carbon::parse($ad->package_expire_date)->format('m-d-Y') }}
                                        <form action="{{route('adsUpgrade')}}" method="post" id="renew-form-{{$ad->id}}" style="display: none;">
                                            @csrf
                                            <input type="hidden" name="ad_id" value="{{$ad->id}}">
                                            <input type="hidden" name="type" value="renew">
                                        </form>
                                        @if (Carbon\Carbon::parse($ad->package_expire_date)->diffInDays(Carbon\Carbon::now()) <= 3)
                                        <a href="javascript:void(0);" class="renew" ad-id="{{$ad->id}}">RENEW</a>
                                        @endif

                                        <i class="fas fa-circle ad-ico" aria-hidden="true"></i>

                                        <strong>Price:</strong> £@if(isset($ad->package_total)){{$ad->package_total}}@endif
                                        <!-- To do condition for multiple package-->
                                        <a href="javascript:void(0);" data-toggle="modal" data-target="#myad{{$ad->id}}" class="">DETAILS</a>
                                    </div>
                                </div>
                                <!-- <p class="card-text">{{substr(strip_tags($ad->description),0,98)}}..</p> -->
                                <div class="blk-pkj">
                                    <div class="row ad-package row-view mb-5">
                                        <div class="col">
                                            <strong>Package:</strong> {{ $ad->basic_package->name }}
                                            <form action="{{route('adsUpgrade')}}" method="post" id="upgrade-form-{{$ad->id}}" style="display: none;">
                                                @csrf
                                                <input type="hidden" name="ad_id" value="{{$ad->id}}">
                                                <input type="hidden" name="type" value="upgrade">
                                            </form>
                                            <a href="javascript:void(0);" class="upgrade" ad-id="{{$ad->id}}">UPGRADE</a>
                                        </div>
                                    </div> 
                                </div>
                                
                                <div class="ed-pv">
                                    <a href="{!! URL::to('edit-ads/'.$ad->slug) !!}" class="edit-ad">EDIT</a>
                                    <a href="{!! URL::to('preview/'.$ad->slug) !!}" class="preview-ad" target="_blank">PREVIEW</a>
                                </div>
                              </div>
                            </div>
                        </div>
                        @endif
                    
                    
                    @endforeach

                    

                        
                    </div>
<!--                    add list-->
                   <!--single row-->
                    @php $pos=0; @endphp
                    @foreach($ads as $key => $ad)
                    @if ($key > 1)
                    <div class="mt-1">
                        <div class="row pr-15">
                            <div class="col my-ad-card">
                                <div class="col-12 single-ad mb-5">
                                 <div class="row">
                                     <div style="background-image:url('{{ asset('storage/'.$ad->images[0]->image) }}');" class="col-md-4 ad-list-img">
                                     </div>
                                     <div class="col-md-8">
                                         <div class="card-body">
                                            <div class="row mb-3">
                                                <div class="col-6">
                                                    <div class="ad-statusbx">
                                                        @if (!$ad->expired)
                                                        <i class="fas fa-circle active-ad"></i> Live
                                                        @else
                                                        <i class="fas fa-circle expired-ad"></i> Expired
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-6 text-right">
                                                    <span class="total-view d-inline pr-3">
                                                        <a href="{{URL::to('messages/')}}/{{$ad->id}}">
                                                            <i class="fas fa-envelope" aria-hidden="true"></i>  {{ $ad->messages->count() }}
                                                        </a>
                                                    </span>
                                                    <span class="total-view d-inline">
                                                    <i class="fal fa-eye" aria-hidden="true"></i> {{$ad->views}}
                                                    </span>
                                                </div>
                                            </div>
                                            <h4 class="pb-2">
                                            @php 
                                                $title = (strlen($ad->title)>33)? substr(strip_tags($ad->title),0,33)."...": $ad->title;
                                                echo $title;
                                            @endphp </h4>
                                            <div class="row ad-price row-view mb-3 blk-pkj">
                                                <div class="col">
                                                    <strong>End:</strong> {{ Carbon\Carbon::parse($ad->package_expire_date)->format('m-d-Y') }}
                                                    <form action="{{route('adsUpgrade')}}" method="post" id="renew-form-{{$ad->id}}" style="display: none;">
                                                        @csrf
                                                        <input type="hidden" name="ad_id" value="{{$ad->id}}">
                                                        <input type="hidden" name="type" value="renew">
                                                    </form>
                                                    @if (Carbon\Carbon::parse($ad->package_expire_date)->diffInDays(Carbon\Carbon::now()) <= 3)
                                                    <a href="javascript:void(0);" class="renew" ad-id="{{$ad->id}}">RENEW</a>
                                                    @endif

                                                    <i class="fas fa-circle ad-ico" aria-hidden="true"></i>

                                                    <strong>Price:</strong> £@if(isset($ad->package_total)){{$ad->package_total}}@endif
                                                    <!-- To do condition for multiple package-->
                                                    <a href="javascript:void(0);"  data-toggle="modal" data-target="#myad{{$ad->id}}" class="">DETAILS</a>
                                                </div>
                                            </div>
                                            <!-- <p class="card-text">{{substr(strip_tags($ad->description),0,150)}}.</p> -->
                                            <div class="blk-pkj">
                                                <div class="row ad-price row-view mb-5">
                                                    <div class="col">
                                                        <strong>Package:</strong> {{ $ad->basic_package->name }}
                                                        <form action="{{route('adsUpgrade')}}" method="post" id="upgrade-form-{{$ad->id}}" style="display: none;">
                                                            @csrf
                                                            <input type="hidden" name="ad_id" value="{{$ad->id}}">
                                                            <input type="hidden" name="type" value="upgrade">
                                                        </form>
                                                        <a href="javascript:void(0);" class="upgrade" ad-id="{{$ad->id}}">UPGRADE</a>
                                                    </div>
                                                </div> 
                                            </div>
                                            <div class="ed-pv">
                                                <a href="{!! URL::to('edit-ads/'.$ad->slug) !!}" class="edit-ad">EDIT</a>
                                                <a href="{!! URL::to('preview/'.$ad->slug) !!}" class="preview-ad" target="_blank">PREVIEW</a>
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

                    @foreach($ads as $ad)
                        <div class="modal fade gallery_modal" id="myad{{$ad->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                          <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-body full-bx">
                                <div class="modal-header modal--popup">
                                    <h4 class="modal-title" id="exampleModalLabel">
                                    {{ $ad->title }}
                                    </h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                    <div class="modal-block modal-popup-inner">
                                      <div class="package-row">
                                          <table class="table details-table inner-table">
                                            <thead>
                                                <tr>
                                                    <th><strong>Package Name</strong></th>
                                                    <th><strong>Price</strong></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                  $i=0;
                                                @endphp
                                                @foreach ($ad->packages as $key => $package)
                                                    <tr>
                                                        <td><strong>{{$ad->package_name_array[$i]}}</strong></td>
                                                        <td>£{{$package->price}}</td>
                                                    </tr>
                                                    @php
                                                     $i++;
                                                    @endphp
                                                @endforeach
                                                <tr>
                                                    <td><strong>Total Price:</strong></td>
                                                    <td><strong>£{{$ad->package_total}}</strong></td>
                                                </tr>
                                            </tbody>
                                        </table>
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
    $('.upgrade').on('click',function(){
        var val = $(this).attr('ad-id');
        $('#upgrade-form-'+val).submit();
    })

    $('.renew').on('click',function(){
        var val = $(this).attr('ad-id');
        $('#renew-form-'+val).submit();
    })
</script>
@endpush