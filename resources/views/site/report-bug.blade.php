@extends('site.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')

<section class="container page_intro xs-top-spc xs-top-spc-breadcrumbs">
</section>
<section class="container admin-panel mt-4">
    <div class="admin-panel__bar mt-4"><h4 class="text-white">Report a bug</h4></div>
    <div class="admin-panel__body1 mt-4">
        <form class="label-bold" action="{{route('report-bug-post')}}" method="post">
            @csrf
            <div class="admin-panel__body__form">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 px-0">
                            <div class="pt-3 pb-3 px-1 py-5 px-md-4 py-5 section-border">
                                <div class="row px-3">
                                    <div class="col-12 py-2 form-field">
                                        <label><strong>Name</strong></label>
                                        <input type="text" name="name" id="name" value="{{ auth()->user() ? auth()->user()->name:''}}">
                                    </div>
                                    <div class="col-12 pt-2 form-field">
                                        <label><strong>Description</strong></label>
                                        <textarea name="description" id="desc"></textarea>
                                        <p class="error-cls desc-error">Please enter ad description</p>
                                    </div>
                                    <div class="col-12">
                                        <input class="mt-3" type="submit" value="Report" id="report">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
@endsection