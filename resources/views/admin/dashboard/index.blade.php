@extends('admin.app')
@section('title') Dashboard @endsection
@section('content')
    <div class="fixed-row">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-dashboard"></i> Dashboard</h1>
            </div>
        </div>
    </div>
    <div class="row section-mg row-md-body">
        <div class="col-md-6 col-lg-3">
            <div class="widget-small primary coloured-icon">
                <i class="icon fa fa-files-o fa-3x"></i>
                <div class="info">
                    <p>Inactivated Ads</p>
                    <p><b>{{$inactive_ads}}</b></p>
                    <a href="{{URL::to('admin/ads/inactive')}}">View More <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="widget-small info coloured-icon">
                <i class="icon fa fa-files-o fa-3x"></i>
                <div class="info">
                    <p>Activated Ads</p>
                    <p><b>{{$active_ads}}</b></p>
                    <a href="{{URL::to('admin/ads/active')}}">View More <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="widget-small warning coloured-icon">
                <i class="icon fa fa-users fa-3x"></i>
                <div class="info">
                    <p>Users</p>
                    <p><b>{{$users}}</b></p>
                    <a href="{{URL::to('admin/users')}}">View More <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></a>
                </div>
            </div>
        </div>
    </div>
@endsection