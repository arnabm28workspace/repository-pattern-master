<?php

// Home
Breadcrumbs::for('home', function ($trail) {
    $trail->push('Home', URL::to('/'));
});

// Home > Ads
Breadcrumbs::for('my-ads', function ($trail) {
    $trail->parent('home');
    $trail->push('My Account', URL::to('my-ads'));
});

// Home > Post Ad
Breadcrumbs::for('post-ad', function ($trail) {
    
    if(URL::previous() === URL::route('home-page')."/")
    {
        $trail->parent('home');
        $trail->push('Post Ad', route('user.post.ad'));
    }else{
        $trail->parent('my-ads');
        $trail->push('Post Ad', route('user.post.ad'));
    }      
    
});

// Home > Ad List
Breadcrumbs::for('ad-list', function ($trail) {
    $trail->parent('home');
    $trail->push('All Ads', url()->previous());
});

// Home > Top Page
Breadcrumbs::for('top-page', function ($trail,$data) {
    $trail->parent('home');
    $trail->push($data->cms_title, URL::to(last(request()->segments())));    
    
    
});

// Home > Ad List > Edit
Breadcrumbs::for('edit-ad', function ($trail,$data) {
    $trail->parent('my-ads');
    $ad_slug = $data['ad']->slug;
    $trail->push('Edit', URL::to('edit-ads/'.$ad_slug));
});

// Home > Ad List > Ad Title
Breadcrumbs::for('ad-detail', function ($trail,$data) {
    $trail->parent('ad-list');
    $ad_title = $data['ad']->title;
    $ad_slug = $data['ad']->slug;
    $trail->push($ad_title, URL::to('ad-details/'.$ad_slug));
});