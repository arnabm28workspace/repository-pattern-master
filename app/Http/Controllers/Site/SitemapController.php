<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ads;
use App\Models\Page;

class SitemapController extends Controller
{
    public function index()
	{
		$ads = Ads::where(['is_blocked' => 0, 'is_payment' => 1])->orderBy('updated_at', 'desc')->get();		
        
        $pages = Page::where('status', 1)->orderBy('updated_at', 'desc')->get();
	  	
		$otherpages = array('', 'login', 'profile', 'my-ads', 'messages', 'payments', 'post-ads', 'ad-list', 'search');

	  	return response()->view('site.sitemap', [
	      'ads'   => $ads,
	      'pages'       =>	$pages,
	      'otherpages'	=>	$otherpages,
	  	])->header('Content-Type', 'text/xml');
	}
}
