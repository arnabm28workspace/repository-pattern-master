@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/bootstrap-tagsinput.css') }}" />
@endpush

    <div class="app-title">
        <div>
            <h1><i class="fa fa-tags"></i> {{ $pageTitle }}</h1>
        </div>
    </div>
    @include('admin.partials.flash')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="tile">
                <h3 class="tile-title">{{ $subTitle }}</h3>
                <form action="{{ route('admin.cities.store') }}" method="POST" role="form" enctype="multipart/form-data" id="form1">
                    @csrf
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="name">Country <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control @error('country_id') is-invalid @enderror" name="country_id" id="country_id">
                            @if(count($countries))
                            @foreach($countries as $country)
                            <option value="{{$country->id}}">{{$country->name}}</option>
                            @endforeach
                            @endif
                            </select>
                            @error('country_id') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="title">City <span class="m-l-5 text-danger"> *</span></label>
                            <!-- <input class="form-control @error('code') is-invalid @enderror" type="text" name="code" id="code" value="{{ old('code') }}"/> -->
                            <input type="text" value="" data-role="tagsinput" id="tags" class="form-control" name="name">
                             @error('name') {{ $message }} @enderror
                        </div>
                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" id="btnSave" type="button"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Country</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.country.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript" src="{{ asset('backend/js/plugins/bootstrap-tagsinput.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#btnSave").on("click",function(){
                // /$("#tags").val();
                console.log("tags>>"+$("#tags").val());
                if($("#tags").val()!=''){
                    $('#form1').submit();
                }  
            })
            
        })
    </script>
@endpush