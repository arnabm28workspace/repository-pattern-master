<?php

Route::group(['prefix' => 'admin'], function () {

    Route::get('install', 'Admin\InstallController@showInstallForm')->name('admin.install');
    Route::post('install', 'Admin\InstallController@createAdmin')->name('admin.install.post');

    Route::get('login', 'Admin\LoginController@showLoginForm')->name('admin.login');
    Route::post('login', 'Admin\LoginController@login')->name('admin.login.post');
	Route::get('logout', 'Admin\LoginController@logout')->name('admin.logout');
	
	//admin password reset routes
    Route::post('password/email','Admin\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
    Route::get('password/reset','Admin\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
    Route::post('password/reset','Admin\ResetPasswordController@reset');
    Route::get('password/reset/{token}','Admin\ResetPasswordController@showResetForm')->name('admin.password.reset');

	Route::get('/register', 'Admin\RegisterController@showRegistrationForm')->name('admin.register')->middleware('hasInvitation');
	Route::post('/register', 'Admin\RegisterController@register')->name('admin.register.post');

    Route::group(['middleware' => ['auth:admin']], function () {

	    Route::get('/', 'Admin\DashboardController@index')->name('admin.dashboard');

		Route::get('/invite_list', 'Admin\InvitationController@index')->name('admin.invite');
	    Route::get('/invitation', 'Admin\InvitationController@create')->name('admin.invite.create');
		Route::post('/invitation', 'Admin\InvitationController@store')->name('admin.invitation.store');
		Route::get('/adminuser', 'Admin\AdminUserController@index')->name('admin.adminuser');
		Route::post('/adminuser', 'Admin\AdminUserController@updateAdminUser')->name('admin.adminuser.update');
	    Route::get('/settings', 'Admin\SettingController@index')->name('admin.settings');
		Route::post('/settings', 'Admin\SettingController@update')->name('admin.settings.update');
		
		Route::get('/profile', 'Admin\ProfileController@index')->name('admin.profile');
		Route::post('/profile', 'Admin\ProfileController@update')->name('admin.profile.update');
		Route::post('/changepassword', 'Admin\ProfileController@changePassword')->name('admin.profile.changepassword');

		Route::group(['prefix'  =>   'categories'], function() {
			Route::get('/', 'Admin\CategoryController@index')->name('admin.categories.index');
			Route::get('/create', 'Admin\CategoryController@create')->name('admin.categories.create');
			Route::post('/store', 'Admin\CategoryController@store')->name('admin.categories.store');
			Route::get('/{id}/edit', 'Admin\CategoryController@edit')->name('admin.categories.edit');
			Route::post('/update', 'Admin\CategoryController@update')->name('admin.categories.update');
			Route::get('/{id}/delete', 'Admin\CategoryController@delete')->name('admin.categories.delete');
			Route::post('updateStatus', 'Admin\CategoryController@updateStatus')->name('admin.categories.updateStatus');
		});
		Route::group(['prefix'  =>   'page'], function() {
			Route::get('/', 'Admin\PageController@index')->name('admin.pages.index');
			Route::get('/create', 'Admin\PageController@create')->name('admin.pages.create');
			Route::post('/store', 'Admin\PageController@store')->name('admin.pages.store');
			Route::get('/{id}/edit', 'Admin\PageController@edit')->name('admin.pages.edit');
			Route::post('/update', 'Admin\PageController@update')->name('admin.pages.update');
			Route::get('/{id}/delete', 'Admin\PageController@delete')->name('admin.pages.delete');
			Route::post('updateStatus', 'Admin\PageController@updateStatus')->name('admin.pages.updateStatus');
		});
		Route::group(['prefix'  =>   'blog'], function() {
			Route::get('/', 'Admin\BlogController@index')->name('admin.blogs.index');
			Route::get('/create', 'Admin\BlogController@create')->name('admin.blogs.create');
			Route::post('/store', 'Admin\BlogController@store')->name('admin.blogs.store');
			Route::get('/{id}/edit', 'Admin\BlogController@edit')->name('admin.blogs.edit');
			Route::post('/update', 'Admin\BlogController@update')->name('admin.blogs.update');
			Route::get('/{id}/delete', 'Admin\BlogController@delete')->name('admin.blogs.delete');
		});
		Route::group(['prefix'  =>   'customform'], function() {
			Route::get('/', 'Admin\CategoryFormController@index')->name('admin.customform.index');
			Route::get('/create', 'Admin\CategoryFormController@create')->name('admin.customform.create');
			Route::post('/store', 'Admin\CategoryFormController@store')->name('admin.customform.store');
			Route::get('/{id}/edit', 'Admin\CategoryFormController@edit')->name('admin.customform.edit');
			Route::post('/update', 'Admin\CategoryFormController@update')->name('admin.customform.update');
			Route::get('/{id}/delete', 'Admin\CategoryFormController@delete')->name('admin.customform.delete');
			Route::get('/{id}/preview', 'Admin\CategoryFormController@preview')->name('admin.customform.preview');
			Route::post('getCategoryFields', 'Admin\CategoryFormController@getCategoryFormFields')->name('admin.customform.getCategoryFields');
			Route::post('updateStatus', 'Admin\CategoryFormController@updateStatus')->name('admin.customform.updateStatus');
		});
		Route::group(['prefix'  =>   'pagetype'], function() {
			Route::get('/', 'Admin\PageTypeController@index')->name('admin.pagetypes.index');
			Route::get('/create', 'Admin\PageTypeController@create')->name('admin.pagetypes.create');
			Route::post('/store', 'Admin\PageTypeController@store')->name('admin.pagetypes.store');
			Route::get('/{id}/edit', 'Admin\PageTypeController@edit')->name('admin.pagetypes.edit');
			Route::post('/update', 'Admin\PageTypeController@update')->name('admin.pagetypes.update');
			Route::get('/{id}/delete', 'Admin\PageTypeController@delete')->name('admin.pagetypes.delete');
		});

		Route::group(['prefix'  =>   'payment'], function() {
			Route::get('/', 'Admin\PaymentController@index')->name('admin.payment.index');
		});
		Route::group(['prefix'  =>   'users'], function() {
			Route::get('/', 'Admin\UserManagementController@listUsers')->name('admin.users.index');
			Route::post('/', 'Admin\UserManagementController@updateUser')->name('admin.users.post');
			Route::get('/{id}/view', 'Admin\UserManagementController@viewDetail')->name('admin.users.detail');
			Route::get('/{id}/paymentdetails', 'Admin\UserManagementController@viewPaymentDetails')->name('admin.users.paymentdetails');
		});
		/* Route::group(['prefix'  =>   'location'], function() {
			Route::get('/', 'Admin\PageTypeController@index')->name('admin.locations.index');
			Route::get('/create', 'Admin\PageTypeController@create')->name('admin.locations.create');
			Route::post('/store', 'Admin\LocationController@store')->name('admin.locations.store');
			Route::get('/{id}/edit', 'Admin\LocationController@edit')->name('admin.locations.edit');
			Route::post('/update', 'Admin\LocationController@update')->name('admin.locations.update');
			Route::get('/{id}/delete', 'Admin\LocationController@delete')->name('admin.locations.delete');
		}); */
		Route::group(['prefix'  =>   'country'], function() {
			Route::get('/', 'Admin\CountryController@index')->name('admin.country.index');
			Route::get('/create', 'Admin\CountryController@create')->name('admin.country.create');
			Route::post('/store', 'Admin\CountryController@store')->name('admin.country.store');
			Route::get('/{id}/edit', 'Admin\CountryController@edit')->name('admin.country.edit');
			Route::post('/update', 'Admin\CountryController@update')->name('admin.country.update');
			Route::get('/{id}/delete', 'Admin\CountryController@delete')->name('admin.country.delete');
			Route::get('/getcountry', 'Admin\CountryController@getCountry');
			Route::post('/getcitiesbycountry', 'Admin\CountryController@getCitiesByCountry');
			Route::post('updateStatus', 'Admin\CountryController@updateStatus')->name('admin.country.updateStatus');
		});
		Route::group(['prefix'  =>   'packages'], function() {
			Route::get('/', 'Admin\PackageController@index')->name('admin.package.index');
			Route::get('/create', 'Admin\PackageController@create')->name('admin.package.create');
			Route::post('/store', 'Admin\PackageController@store')->name('admin.package.store');
			Route::get('/{id}/edit', 'Admin\PackageController@edit')->name('admin.package.edit');
			Route::post('/update', 'Admin\PackageController@update')->name('admin.package.update');
			Route::get('/{id}/delete', 'Admin\PackageController@delete')->name('admin.package.delete');
			Route::post('/update_status', 'Admin\PackageController@updateStatus')->name('admin.package.updatestatus');
		});
		Route::group(['prefix'  =>   'customfield'], function() {
			Route::get('/', 'Admin\CustomFieldController@index')->name('admin.customfield.index');
			Route::get('/create', 'Admin\CustomFieldController@create')->name('admin.customfield.create');
			Route::post('/store', 'Admin\CustomFieldController@store')->name('admin.customfield.store');
			Route::get('/{id}/edit', 'Admin\CustomFieldController@edit')->name('admin.customfield.edit');
			Route::post('/update', 'Admin\CustomFieldController@update')->name('admin.customfield.update');
			Route::get('/{id}/delete', 'Admin\CustomFieldController@delete')->name('admin.customfield.delete');
		
			Route::get('/{id}/options/', 'Admin\CustomFieldValueController@index')->name('admin.customfield.options');
			Route::get('/{id}/options/create', 'Admin\CustomFieldValueController@create')->name('admin.customfield.options.create');
			Route::post('/options/store', 'Admin\CustomFieldValueController@store')->name('admin.customfield.options.store');
			Route::get('/{id}/options/{value}/edit', 'Admin\CustomFieldValueController@edit')->name('admin.customfield.options.edit');
			Route::post('/options/update', 'Admin\CustomFieldValueController@update')->name('admin.customfield.options.update');
			Route::get('/{id}/options/{value}/delete', 'Admin\CustomFieldValueController@delete')->name('admin.customfield.options.delete');
		});

		Route::group(['prefix'  =>   'attribute'], function() {
			Route::get('/', 'Admin\AttributeController@index')->name('admin.attribute.index');
			Route::get('/create', 'Admin\AttributeController@create')->name('admin.attribute.create');
			Route::post('/store', 'Admin\AttributeController@store')->name('admin.attribute.store');
			Route::get('/{id}/edit', 'Admin\AttributeController@edit')->name('admin.attribute.edit');
			Route::post('/update', 'Admin\AttributeController@update')->name('admin.attribute.update');
			Route::get('/{id}/delete', 'Admin\AttributeController@delete')->name('admin.attribute.delete');
		});

		Route::group(['prefix'  =>   'ads'], function() {
			Route::get('/gallery', 'Admin\AdsController@showAdImages')->name('admin.ads.gallery');
			Route::get('/messages', 'Admin\AdsController@getAllAdsMessages')->name('admin.ads.getAllAdsMessages');
			Route::get('/reports', 'Admin\AdsController@getAllAdsReports')->name('admin.ads.getAllAdsReports');
			Route::post('updateStatus', 'Admin\AdsController@updateStatus')->name('admin.ads.updateStatus');
			Route::get('/{id}/view', 'Admin\AdsController@viewAd')->name('admin.ads.view');
			Route::get('/{id}/view/message', 'Admin\AdsController@viewAdMessage')->name('admin.ads.view_msg');
			Route::get('/{id}/view/report', 'Admin\AdsController@viewAdReport')->name('admin.ads.view_report');
			Route::get('/{type?}', 'Admin\AdsController@index')->name('admin.ads.index');
		});

		Route::group(['prefix'  =>   'cities'], function() {
			Route::get('/', 'Admin\CityController@index')->name('admin.cities.index');
			Route::get('/create', 'Admin\CityController@create')->name('admin.cities.create');
			Route::post('/store', 'Admin\CityController@store')->name('admin.cities.store');
			Route::get('/{id}/edit', 'Admin\CityController@edit')->name('admin.cities.edit');
			Route::post('/update', 'Admin\CityController@update')->name('admin.cities.update');
			Route::get('/{id}/delete', 'Admin\CityController@delete')->name('admin.cities.delete');
		});

		Route::get('report-bug', 'Admin\AdminUserController@bugReport')->name('admin.report-bug');
		Route::post('report-bug-post', 'Admin\AdminUserController@postBugReport')->name('admin.report-bug-post');
	});

});
?>