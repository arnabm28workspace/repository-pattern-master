@extends('site.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
<section class="container page_intro xs-top-spc xs-top-spc-breadcrumbs">
	{{ Breadcrumbs::render('top-page',$page) }}
</section>
<section class="container admin-panel">
    <div class="admin-panel__bar">
        <h4 class="text-white">{!!$page->cms_title!!}</h4>
    </div>
</section>
<section class="container">
	{!!$page->cms_description!!}
</section>
@endsection