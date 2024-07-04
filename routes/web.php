<?php
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Auth::routes();
Route::get('command-fresh', function () {
    /* php artisan migrate */
    \Artisan::call('migrate:fresh --seed');
    dd("Done");
});

Route::get('command', function () {
    /* php artisan migrate */
    \Artisan::call('migrate');
    dd("Done");
});

Route::group(['middleware' => ['auth','verified', 'userStatus']], function () {
    Route::get('profile', 'Site\ProfileController@index')->name('user.profile');
    Route::post('profile', 'Site\ProfileController@profileUpdate')->name('user.updateprofile');
    Route::get('checkout', 'Site\PackageController@index')->name('checkout');
    Route::post('make-payment', 'Site\AdsController@makePayment')->name('makepayment');
    //Route::get('upgrade/{id}', 'Site\PackageController@upgrade');
    Route::post('upgrade', 'Site\PackageController@upgrade')->name('adsUpgrade');
    Route::post('package', 'Site\PackageController@packageUpdate')->name('user.updatepackage');
    Route::get('logout', 'Site\ProfileController@logout')->name('user.logout');
    Route::get('my-ads/{type?}','Site\ProfileController@fetchUserAds')->name('user.myads');
    Route::get('messages/{type?}','Site\ProfileController@fetchUserMessages')->name('user.mymessages');
    Route::post('updatemessage','Site\ProfileController@updateMessageStatus')->name('user.profile.updateMessageStatus');
    Route::get('payments','Site\ProfileController@fetchUserPayments')->name('user.payments');

    Route::get('post-ads','Site\AdsController@craeteAds')->name('user.post.ad');
    Route::post('getCategoryFields', 'Site\AdsController@getCategoryFields')->name('user.customform.getCategoryFields');
    Route::post('getCategoryDetails', 'Site\AdsController@getCategoryDetails')->name('user.customform.getCategoryDetails');
    Route::post('ad-submit','Site\AdsController@storeAds')->name('adsubmit');
    
    Route::post('getCategoryFieldValues', 'Site\AdsController@getCategoryFieldValues')->name('ads.customform.getValues');
    Route::post('getRateValues', 'Site\AdsController@getRateValues')->name('ads.customform.getRateValues');
    Route::get('edit-ads/{id}','Site\AdsController@editAds')->name('user.post.edit.ad');
    Route::post('updateads','Site\AdsController@updateAds')->name('updateads');
    Route::post('replyadmessage','Site\AdsController@replyAdMessage')->name('replyadmessage');
    Route::post('storeadmessage','Site\AdsController@storeAdMessage')->name('storeadmessage');
    Route::post('storereportabuse','Site\AdsController@storeReportAbuse')->name('storereportabuse');
    Route::get('update-free-package/{ad_id}/{id}','Site\PaymentController@updateFreePackage');
});
    

//user password reset routes
Route::post('password/email','Auth\ForgotPasswordController@sendResetLinkEmail')->name('user.password.email');
Route::get('password/reset','Auth\ForgotPasswordController@showLinkRequestForm')->name('user.password.request');
Route::post('password/reset','Auth\ResetPasswordController@reset');
Route::get('password/reset/{token}','Auth\ResetPasswordController@showResetForm')->name('password.reset');

Route::post ( '/stripe', 'Site\PaymentController@paymentProcess' )->name('paypost');
Route::post ( '/upgradepayment', 'Site\PaymentController@upgradeProcess' )->name('upgradepayment');

Auth::routes(['verify' => true]);

require 'admin.php';
//Route::view('/admin', 'admin.dashboard.index');

//Sitemap
Route::get('sitemap.xml', 'Site\SitemapController@index');

/*=======================web-site============================*/
Route::get('/location_info', function(){
    $data = \Location::get(\Request::ip());
    dd($data);
});
Route::get('/','Site\HomeController@index')->name('home-page');
Route::post('process-search', 'Site\AdsController@processSearchForm')->name('process-search');
Route::get('ad-list/{category?}/{location?}','Site\AdsController@index')->name('ad-list');
Route::get('search/{category?}/{country?}/{city?}','Site\AdsController@search')->name('ad.search');
Route::get('details/{key}','Site\AdsController@details')->name('ad.detail');
Route::get('preview/{key}','Site\ProfileController@preview');
Route::get('get-images/{id}','Site\AdsController@getImages');
Route::post('dropzone-store','Site\AdsController@dropzoneStore');
Route::post('dropzone-update','Site\AdsController@dropzoneUpdate');
Route::post('update-image','Site\AdsController@updateImage');
Route::post('delete-image','Site\AdsController@deleteImage');
Route::get('report-bug', 'Site\HomeController@bugReport')->name('report-bug');
Route::post('report-bug-post', 'Site\HomeController@postBugReport')->name('report-bug-post');
Route::get('/{page}','Site\PageController@index');
Route::get('{country}/{city?}/{category?}','Site\PageController@search')->name('page.search');
