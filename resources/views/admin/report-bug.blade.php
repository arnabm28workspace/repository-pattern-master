@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <div class="fixed-row">
        <div class="app-title">
            <div class="active-wrap">
                <h1><i class="fa fa-tags"></i> {{ $pageTitle }}</h1>
            </div>
        </div>
    </div>
    @include('admin.partials.flash')
    <div class="row section-mg row-md-body no-nav">
        <div class="col-md-12 mx-auto">
            <div class="tile">
                <form action="{{ route('admin.report-bug-post') }}" method="POST" role="form" id="form">
                    @csrf
                    <div class="tile-body form-body">
                        <div class="form-group">
                            <label class="control-label" for="name">Name <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name" value="{{ auth()->user() ? auth()->user()->name:''}}"/>
                            @error('name') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="description">Description <span class="m-l-5 text-danger"> *</span></label>
                            <textarea class="form-control  @error('description') is-invalid @enderror report_bug" rows="4" name="description" id="description">{{ old('description') }}</textarea>
                            @error('description') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit" id="btnSave"><i class="fa fa-fw fa-lg fa-check-circle"></i>Report</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection